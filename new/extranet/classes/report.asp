<!--#include file="dataBase.asp" -->
<!--#include file="queryStatement.asp" -->
<!--#include virtual="/extranet/inc/dateFunctions.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<%
//extends clientData
function report()
{
   //propriedades
   this.clientID           = null
   this.enfermeiraID       = null
   this.obstetraID         = null
   this.hospitalID         = null
   this.nameHospital       = null
   this.dataPrevisaoColeta = null
   this.horaPrevisaoColeta = null
   this.dataColeta         = null
   this.horaColeta         = null
   this.dataProcessamento  = null
   this.horaProcessamento  = null
   this.name               = null
   this.errorMessage       = null

   //metodos de captura dos dados
   this.getClientID           = _getClientID
   this.getName               = _getName
   this.getEnfermeiraID       = _getColetaEnfermeiraID
   this.getObstetraID         = _getColetaObstetraID
   this.getHospitalID         = _getColetaHospitalID
   this.getNameHospital       = _getNameHospital
   this.getDataPrevisaoColeta = _getDataPrevisaoColeta
   this.getHoraPrevisaoColeta = _getHoraPrevisaoColeta
   this.getDataColeta         = _getDataColeta
   this.getHoraColeta         = _getHoraColeta
   this.getDataProcessamento  = _getDataProcessamento
   this.getHoraProcessamento  = _getHoraProcessamento
   
   this.getPrevisaoColetas = _getPrevisaoColetas


}

function _getClientID()
{
   return this.clientID
}

function _getName()
{
   return this.name
}

function _getColetaEnfermeiraID()
{
   return this.enfermeiraID
}

function _getColetaObstetraID()
{
   return this.obstetraID
}

function _getColetaHospitalID()
{
   return this.hospitalID
}

function _getNameHospital()
{
   return this.nameHospital
}

function _getDataPrevisaoColeta()
{
   return this.dataPrevisaoColeta
}

function _getHoraPrevisaoColeta()
{
   return this.horaPrevisaoColeta
}

function _getDataColeta()
{
   return this.dataColeta
}

function _getHoraColeta()
{
   return this.horaColeta
}

function _getDataProcessamento()
{
   return this.dataProcessamento
}

function _getHoraProcessamento()
{
   return this.horaProcessamento
}

//Relatorio de previsao de coletas por mes/ano
function _getPrevisaoColetas()
{
   selectedMonth = getRequestParameterAsString("mm")
   selectedYear  = getRequestParameterAsString("y")
   
   formatedPeriod = selectedYear + "-" + selectedMonth;
   
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("REPORT_PREVISAO_COLETAS"))
   
   clientQuery.setGenericValue(1,formatedPeriod)
   
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())

   tempCounter = 0
   if(!clientData.EOF())
   {
      this.clientID           = new Array()
      this.name               = new Array()
      this.dataPrevisaoColeta = new Array()
      this.nameHospital       = new Array()
      
      while(!clientData.EOF())
      {
         this.clientID.push(clientData.getValue(0))
         this.name.push(clientData.getValue(1))
         this.dataPrevisaoColeta.push(clientData.getValue(2))
         this.nameHospital.push(clientData.getValue(3))
         
         tempCounter++
         clientData.nextValue()
      }
   }
   else
   {
      errMessage = "Não há Previsão de Coletas para o período selecionado"
      if(clientData.getErrorMessage() != null)
      {
         errMessage += "\n<!--DB Error:" +clientData.getErrorMessage()+ "-->"
      }
      
      Session("errorMessage") = errMessage
      clientData = null
      Response.Redirect("/extranet/error.asp");     
   }   
   
   return tempCounter
   
   clientData  = null
   cfgQuery    = null
   clientQuery = null   
}
%>
