<!--#include file="dataBase.asp" -->
<!--#include file="queryStatement.asp" -->
<!--#include virtual="/extranet/inc/dateFunctions.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<!--#include virtual="/extranet/classes/login.asp" -->
<%
//extends clientData
function clientSCUP()
{
   //propriedades
   this.clientID = null
   this.dataCrioPreservacao = null
   this.procPesoInicialUnidade = null
   this.procVolumeRealScup = null
   this.procViabilidadeCelular = null
   this.procCd45Cd34Ini        = null
   this.procCd45Cd34Fim        = null
   this.bioArchiveID           = null
   this.cult_micro_bacteria    = null   
   this.cult_micro_fungo       = null
   this.name                   = null
   this.errorMessage           = null

   //metodos de captura dos dados
   this.getDataCrioPreservacao = _getDataCrioPreservacao
   this.getClientID            = _getClientID
   this.getName                = _getName
   this.getProcPesoInicialUnidade = _getProcPesoInicialUnidade
   this.getprocVolumeRealScup = _getprocVolumeRealScup
   this.getProcViabilidadeCelular = _getProcViabilidadeCelular
   this.getProcCd45Cd34Ini        = _getProcCd45Cd34Ini
   this.getProcCd45Cd34Fim        = _getProcCd45Cd34Fim
   this.getBioArchiveID           = _getBioArchiveID
   this.getCult_micro_bacteria    = _getCult_micro_bacteria
   this.getCult_micro_fungo       = _getCult_micro_fungo

   //metodos de tratamentos de dados
   this.getClientScupFromID = _getClientScupFromID
   this.getClientScup = _getClientScup
}

function _getClientID()
{
   return this.clientID
}

function _getName()
{
   return this.name
}

function _getDataCrioPreservacao()
{
   return this.dataCrioPreservacao
}

function _getProcPesoInicialUnidade()
{
   return this.procPesoInicialUnidade
}

function _getprocVolumeRealScup()
{
   return this.procVolumeRealScup
}

function _getProcViabilidadeCelular()
{
   return this.procViabilidadeCelular
}

function _getProcCd45Cd34Ini()
{
   return this.procCd45Cd34Ini
}

function _getProcCd45Cd34Fim()
{
   return this.procCd45Cd34Fim
}

function _getBioArchiveID()
{
   return this.bioArchiveID
}

function _getCult_micro_bacteria()
{
   return this.cult_micro_bacteria
}

function _getCult_micro_fungo()
{ 
   return this.cult_micro_fungo
}

function _getClientScupFromID(ci)
{
   this.clientID = ci
   this.getClientScup()
}


function _getClientScup()
{
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   clientQuery = new queryStatement(cfgQuery.getKeyValue("SELECT_CLIENT_SCUP"))
   
   clientQuery.setInt(1,this.clientID)
   
   clientData   = new searchDB()
   clientResult = clientData.execute(clientQuery.toString())


   if(!clientData.EOF())
   {
      this.dataCrioPreservacao    = clientData.getValue("dataCrioPreservacao")
      this.procPesoInicialUnidade = clientData.getValue("procPesoInicialUnidade")
	  this.procVolumeRealScup = clientData.getValue("procVolumeRealScup")
      this.procViabilidadeCelular = clientData.getValue("procViabilidadeCelular")
      this.procCd45Cd34Ini = clientData.getValue("procCd45Cd34Ini")    
      this.procCd45Cd34Fim = clientData.getValue("procCd45Cd34Fim")    
      
      this.bioArchiveID = clientData.getValue("bioArchiveID")
      this.cult_micro_bacteria = clientData.getValue("cult_micro_bacteria")
      this.cult_micro_fungo = clientData.getValue("cult_micro_fungo")

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
