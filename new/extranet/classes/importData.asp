<!--#include file="dataBase.asp" -->
<!--#include file="queryStatement.asp" -->
<!--#include virtual="/extranet/inc/dateFunctions.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<%
function importData()
{
   this.data = null
   
   this.insertDataMonitoracao   = _insertDataMonitoracao
   this.clearBadMonitoracaoData = _clearBadMonitoracaoData
   
   this.setData = _setData
   this.getData = _getData
}

function _setData(value)
{
   this.data = value
}

function _getData()
{
   return this.data
}

function _insertDataMonitoracao()
{
   cfgQuery   = new loadConfigFiles(CONFIG_QUERIES_FILE)

   queryKey = cfgQuery.getKeyValue("INSERT_MONITORACAO_DATA") 

   loginQuery = new queryStatement(queryKey)

   clientID = getRequestParameterAsInt("clientID")
   dataToImport = getRequestParameterAsString("dataToImport")

   dataToImport = dataToImport.substring(dataToImport.indexOf("\n") + 1 ,dataToImport.length )
   dataToImport = dataToImport.substring(0, dataToImport.indexOf("Gráfico") - 7)

   dataToImport = dataToImport.replace(/\s\n/g,"|") //coloca tudo na mesma linha separado por | para geracao de array
   dataToImport = dataToImport.replace(/\| Data ...\|/g,"|")//remove os registros de header de tabelas
   dataToImport = dataToImport.replace(/,/g,".")
   
   arrOfData = dataToImport.split("|")
   
   //capturando ano atual para incluir no DB ja que os dados de monitoracao não vem com a informacao ano
   currDate = new Date()
   year = currDate.getFullYear()
   
   userData = new insertionDB()

   for(i = 0; i < arrOfData.length; i++)
   {
      monitoracaData = arrOfData[i].split(/\s+/)
      
      if(monitoracaData.length != 3)
      {      
          this.clearBadMonitoracaoData(1)
      }
      
      if(!isNaN(monitoracaData[0].substring(3,5)) && monitoracaData[1] != undefined && monitoracaData[2] != undefined)
      {
         formatedDate = year + "-" + monitoracaData[0].substring(3,5) + "-" + monitoracaData[0].substring(0,2) + " " + monitoracaData[1] + ":00"
            
         loginQuery.setQuery(queryKey)   
            
         loginQuery.setStr(1,formatedDate)
         loginQuery.setInt(2,monitoracaData[2].replace(",","."))
         loginQuery.setInt(3,clientID)
   
         importResult = userData.execute(loginQuery.toString())

         if(userData.getErrorMessage() != null)
         {    
            this.clearBadMonitoracaoData(clientID)        
         }
      }
      else
      {
         this.clearBadMonitoracaoData(clientID)
      }
   }
   
   auditRecord = new audit()
   auditRecord.saveAction(ACTION_IMPORT_DATA_MONITORACAO,clientID)
   
   Session("clientID") = clientID
   Session("successMessage") = "Dados de Monitoracao Inseridos com sucesso!"
   Response.Redirect("/extranet/success.asp");   

}

function _clearBadMonitoracaoData(clientID)
{
   errMessage = "Falha ao tentar Importar os dados de monitoração! Contacte o Administrador"
   
   cfgQuery   = new loadConfigFiles(CONFIG_QUERIES_FILE)
   loginQuery = new queryStatement(cfgQuery.getKeyValue("DELETE_BAD_MONITORACAO_DATA"))

   userData = new deletionDB()
   
   loginQuery.setInt(1,clientID)
   userData.execute(loginQuery.toString())
   
   Session("errorMessage") = errMessage
   Response.Redirect("/extranet/error.asp");     
}
%>
