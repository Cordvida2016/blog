<!--#include file="dataBase.asp" -->
<!--#include file="queryStatement.asp" -->
<!--#include virtual="/extranet/inc/dateFunctions.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<!--#include virtual="/extranet/classes/login.asp" -->
<%
//extends clientData
function clientColeta()
{
   //propriedades
   this.clientID           = null
   this.enfermeira         = null
   this.enfermeiraCoren    = null
   this.obstetra           = null
   this.obstetraCRM        = null
   this.hospital           = null
   this.dataColeta         = null
   this.horaColeta         = null
   this.minutoColeta       = null   
   this.observacoesColeta  = null
   this.coletaFeitaPor     = null
   this.name               = null
   this.errorMessage       = null

   //metodos de captura dos dados
   this.getClientColeta       = _getClientColeta
   this.getClientID           = _getClientID
   this.getName               = _getName
   this.getEnfermeira         = _getColetaEnfermeira
   this.getEnfermeiraCoren    = _getEnfermeiraCoren  
   this.getObstetra           = _getColetaObstetra
   this.getObstetraCRM        = _getObstetraCRM
   this.getHospital           = _getColetaHospital
   this.getDataColeta           = _getDataColeta
   this.getHoraColeta           = _getHoraColeta
   this.getMinutoColeta         = _getMinutoColeta
   this.getObservacoesColeta    = _getObservacoesColeta
   this.getColetaFeitaPor       = _getColetaFeitaPor

   //metodos de tratamentos de dados
   this.updateClientColeta    = _updateClientColeta
   this.getClientColetaFromID = _getClientColetaFromID
}

function _getClientID()
{
   return this.clientID
}

function _getName()
{
   return this.name
}

function _getColetaEnfermeira()
{
   return this.enfermeira
}

function _getColetaObstetra()
{
   return this.obstetra
}

function _getColetaHospital()
{
   return this.hospital
}

function _getDataColeta()
{
   return this.dataColeta
}

function _getHoraColeta()
{
   return this.horaColeta
}

function _getMinutoColeta()
{
   return this.minutoColeta
}

function _getObservacoesColeta()
{
   return this.observacoesColeta
}

function _getColetaFeitaPor()
{
   return this.coletaFeitaPor
}

function _getObstetraCRM()
{
   return this.obstetraCRM
}

function _getEnfermeiraCoren()
{
   return this.enfermeiraCoren
}

function _getClientColetaFromID(ci)
{
   this.clientID = ci
   this.getClientColeta()
}


function _updateClientColeta()
{
   intLogin = new Login()
   intLogin.validateActionAccess("EDICAO_COLETA")
   
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_CLIENT_COLETA"))

   clientID           = getRequestParameterAsInt("clientID")
   enfermeiraID       = getRequestParameterAsInt("enfermeira")
   obstetraID         = getRequestParameterAsInt("obstetra")
   hospitalID         = getRequestParameterAsInt("hospital")
     
   horaColeta         = getRequestParameterAsString("horaColeta")
   minutoColeta       = getRequestParameterAsString("minutoColeta")
   horarioColeta      = horaColeta + ":" + minutoColeta
   dataColeta         = strDateToMySQL(getRequestParameterAsString("dataColeta")) + " "+ horarioColeta + ":00"
   
   coletaFeitaPor    = getRequestParameterAsInt("coletaFeitaPor")
   
   //definindo os valores dos campos na query
   clientQuery.setInt(1,enfermeira)
   clientQuery.setInt(2,obstetra)
   clientQuery.setInt(3,hospital)
   clientQuery.setStr(6,dataColeta)
   clientQuery.setStr(8,coletaFeitaPor)
   clientQuery.setInt(9,clientID)
   
   clientData   = new updateDB()
   clientResult = clientData.execute(clientQuery.toString())   
   
   if(clientData.getErrorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_UPDATE_CLIENT_COLETA,clientID)
      
      Session("clientID") = clientID
      Session("successMessage") = "Dados de Coleta cliente Atualizados com sucesso!"
      Response.Redirect("/extranet/success.asp");
   }
   else
   {
      errMessage = "Erro ao tentar inserir dados de coleta, contacte o Admnistrador.\n<!--DB Error:" +clientData.getErrorMessage()+ "-->"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");   
   }
    
   clientData  = null
   cfgQuery    = null
   clientQuery = null
}

function _getClientColeta()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_CLIENT_COLETA"))
   
   clientQuery.setInt(1,this.clientID)
   
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())

   if(!clientData.EOF())
   {
      this.enfermeira     = clientData.getValue("enfermeira")
      this.enfermeiraCoren = clientData.getValue("enfermeiraCoren")
      this.obstetra       = clientData.getValue("obstetra")
      this.obstetraCRM    = clientData.getValue("obstetraCRM")
      this.hospital       = clientData.getValue("hospital")
      this.coletaFeitaPor = clientData.getValue("coletaFeitaPor")    
      
      this.dataColeta   = clientData.getValue("dataColeta")
      arrDateColeta     = splitDateValues(this.dataColeta)
      this.horaColeta   = arrDateColeta["hour"]
      this.minutoColeta = arrDateColeta["minute"]

      this.name = clientData.getValue("name")
   }
   else
   {
      errMessage = "Nenhum Cliente Encontrado!"
      Session("errorMessage") = errMessage
      Response.Redirect("/extranet/error.asp");       
   }
  
}
%>
