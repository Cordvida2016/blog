<!--#include virtual="/extranet/classes/dataBase.asp" -->
<!--#include virtual="/extranet/classes/queryStatement.asp" -->
<!--#include virtual="/extranet/inc/dateFunctions.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<%
function Login()
{
   //propriedades
   this.userID      = null
   this.login       = null
   
   //metodos de captura dos dados
   this.getUserID       = _getLoggedUserID
   this.getLogin        = _getLoggedUserLogin
   this.validateActionAccess  = _validateActionAccess
   this.validatePageAccess    = _validatePageAccess
   this.canSee                = _canSee
   this.logUserIn             = _logUserIn
}

function _getLoggedUserID()
{
   return this.getUserID
}

function _getLoggedUserLogin()
{
   return this.getLogin
}


function _logUserIn()
{
   userLogin = getRequestParameterAsString("username")
   userPass  = getRequestParameterAsString("pass")
     
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery   = new loadConfigFiles(CONFIG_QUERIES_FILE)
   loginQuery = new queryStatement(cfgQuery.getKeyValue("LOGIN"))
   
   //definindo os valores dos campos na query
   loginQuery.setStr(1,userLogin.replace("'","\\'"))
   loginQuery.setStr(2,userPass.replace("'","\\'"))

   userData    = new searchDB()

   loginResult = userData.execute(loginQuery.toString())

   if(userData.getErrorMessage() != null)
   {
      errMessage = "Username ou Senha N�o encontrados, por favor tente novamente."
      Session("errorMessage") = errMessage
      Response.Redirect("errorLogin.asp");
   }
 
   if(userData.EOF() || userLogin == "" || userPass == "")
   {
      errMessage = "Username ou Senha N�o encontrados, por favor tente novamente."
      if(userData.getErrorMessage() != null)
      {
         errMessage += "\n<!--DB Error:" +userData.getErrorMessage()+ "-->"
      }
      
      Session("errorMessage") = errMessage
      userData = null
      Response.Redirect("errorLogin.asp");
   }
   else 
   {
      //setando as variaveis globais com infomacos do usuario
      Session("userID")       = userData.getValue("clientID")
      Session("login")        = userData.getValue("extranetUsername")
      Session("accessLevel") = userData.getValue("extranetPassword")
      
      this.userID              = userData.getValue("clientID")
      this.login               = userData.getValue("extranetUsername")
      this.accessLevel         = userData.getValue("extranetPassword")      
      
      Response.Redirect("/extranet/cad.asp");

   }//if
}

//Recebe array de Levels ID para definir permissao de acesso a uma pagina
function _validatePageAccess(area)
{
   cfgLevels = new loadConfigFiles(CONFIG_ACCESS_FILE)
   arrAllowedLevels = cfgLevels.getKeyValue(area.toUpperCase()).split(",")
   
   cfgLevels = null
   for(z = 0; z < arrAllowedLevels.length; z++)
   {
      if(this.getSessionAccessLevel() == arrAllowedLevels[z])
      {         
         intLogin = null
         return true
      }
   }
   
   Session("errorMessage") = "� PRECISO TER UM PRIVIL�GIO ESPECIAL PARA TER ACESSO A ESTA P�GINA"
   Response.Redirect("errorLogin.asp");
}

//Recebe array de Levels ID para definir permissao de acesso a um link ou determinado recurso na interface
function _canSee(area)
{
   cfgLevels = new loadConfigFiles(CONFIG_ACCESS_FILE)
   arrAllowedLevels = cfgLevels.getKeyValue(area.toUpperCase()).split(",")

   cfgLevels = null
   for(z = 0; z < arrAllowedLevels.length; z++)
   {
      if(this.getSessionAccessLevel() == arrAllowedLevels[z])
      {
         intLogin = null
         return true
      }
   }
   return false  
}

//Recebe array de Levels ID para definir permissao de execucao de uma acao
function _validateActionAccess(area)
{
   cfgLevels = new loadConfigFiles(CONFIG_ACCESS_FILE)
   arrAllowedLevels = cfgLevels.getKeyValue(area.toUpperCase()).split(",")
   
   cfgLevels = null
   for(z = 0; z < arrAllowedLevels.length; z++)
   {
      if(this.getSessionAccessLevel() == arrAllowedLevels[z])
      {
         intLogin = null
         return true
      }
   }
   
   Session("errorMessage") = "� PRECISO TER UM PRIVIL�GIO ESPECIAL PARA TER EXECUTAR ESTA A��O"
   Response.Redirect("errorLogin.asp");
}

//Valida acesso de usuarios a p�ginas especificas usando o metodo da classe login
function allowPageAccess(area)
{
   intLogin = new Login()
   intLogin.validatePageAccess(area)
}

//Valida acesso de usuarios a p�ginas especificas usando o metodo da classe login
function allowSee(area)
{
   intLogin = new Login()
   return intLogin.canSee(area)
}
%>
