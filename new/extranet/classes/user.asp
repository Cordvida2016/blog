<!--#include file="dataBase.asp" -->
<!--#include file="queryStatement.asp" -->
<!--#include virtual="/extranet/inc/dateFunctions.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<%
function user()
{
   //propriedades
   this.userID        = null
   this.login         = null
   this.name          = null
   this.email         = null
   this.password      = null
   this.level         = null
   this.status        = null
   
   
   //metodos
   this.getUser      = _getUser
   this.getAllUsers  = _getAllUsers
   this.insertUser   = _insertUser
   this.updateUser   = _updateUser
   this.getLogin     = _getUserLogin
   this.getUserID    = _getUserID
   this.getName      = _getUserName
   this.getEmail     = _getUserEmail
   this.getPassword  = _getUserPassword
   this.getLevel     = _getUserLevel
   this.getStatus    = _getUserStatus
   this.getUserByID  = _getUserByID
   this.setUserID    = _setUserID
   this.removeUser   = _removeUser
   this.getUserLevelName  = _getUserLevelName
   this.updateUserDetails = _updateUserDetails
}

function _setUserID(newUserID)
{
   this.userID = newUserID
}

function _getUserID()
{
   return this.userID
}

function _getUserLogin()
{
   return this.login
}

function _getUserName()
{
   return this.name
}

function _getUserEmail()
{
   return this.email
}

function _getUserPassword()
{
   return this.password
}

function _getUserLevel()
{
   return this.level
}

function _getUserStatus()
{
   return this.status
}

function _getUserByID(userID)
{
   this.userID = userID
   this.getUser()
}

function _getUser()
{
   e = new Error()
   try
   {   
      //capturando do arquivo de configuracao a query a ser usada
      cfgQuery   = new loadConfigFiles(CONFIG_QUERIES_FILE)
      userQuery  = new queryStatement(cfgQuery.getKeyValue("USER_DATA"))
      
      //definindo os valores dos campos na query
      userQuery.setInt(1,this.userID)
      
      userData    = new searchDB()
      userResult  = userData.execute(userQuery.toString())   

      if(!userData.EOF())
      {
         this.name     = userData.getValue("user")
         this.email    = userData.getValue("email") 
         this.login    = userData.getValue("login") 
         this.password = userData.getValue("password")
         this.level    = parseInt(userData.getValue("accessLevel"))
         this.status   = parseInt(userData.getValue("status"))
      }
      else
      {
         errMessage = "Usuário não encontrado"
         if(userData.getErrorMessage() != null)
         {
            errMessage += "\n<!--DB Error:" +userData.getErrorMessage()+ "-->"
         }
         S
         ession("errorMessage") = errMessage
         userData = null
         Response.Redirect("/extranet/error.asp");     
      }
      
      cfgQuery  = null
      userQuery = null
      userData  = null
   }
   catch(e)
   {
      return e
   }      
}

function _getAllUsers()
{
   e = new Error()
   try
   {   
      //capturando do arquivo de configuracao a query a ser usada
      cfgQuery   = new loadConfigFiles(CONFIG_QUERIES_FILE)
      
      userData    = new searchDB()
      userResult  = userData.execute(cfgQuery.getKeyValue("ALL_USER_DATA"))   

      tempCounter = 0 
      if(userData.EOF())
      {
         return tempCounter
      }
      
      this.name     = new Array()
      this.email    = new Array()
      this.login    = new Array()
      this.password = new Array()
      this.level    = new Array()
      this.userID   = new Array()
      this.status   = new Array()
      
      while(!userData.EOF())
      {
         this.name.push(userData.getValue("user"))
         this.email.push(userData.getValue("email"))
         this.login.push(userData.getValue("login"))
         this.password.push(userData.getValue("password"))
         this.level.push(parseInt(userData.getValue("accessLevel")))
         this.userID.push(parseInt(userData.getValue("userID")))
         this.status.push(parseInt(userData.getValue("status")))
         
         userData.nextValue()
         tempCounter++
      }
      
      return tempCounter
      
      cfgQuery  = null
      userData  = null
   }
   catch(e)
   {
      return e.description
   }      
}

function _insertUser()
{
   userName  = getRequestParameterAsString("user")
   userEmail = getRequestParameterAsString("email")
   userLogin = getRequestParameterAsString("login")
   userPass  = getRequestParameterAsString("password")
   userLevel = getRequestParameterAsInt("level")
  
   
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   insertQuery = new queryStatement(cfgQuery.getKeyValue("INSERT_USER"))   
   
   insertQuery.setStr(1,userName)
   insertQuery.setStr(2,userEmail)
   insertQuery.setStr(3,userLogin)
   insertQuery.setStr(4,userPass)
   insertQuery.setInt(5,userLevel)

   //Lock da aplicacao uma vez que se deseja persistencia de dados
   Application.lock()
   
   userData = new insertionDB()
   userData.execute(insertQuery.toString())

   if(userData.getErrorMessage() == null)
   {
      //captura id do ultimo objeto adcionado para inserir na auditoria
      clientData   = new searchDB()
      clientResult = clientData.execute("SELECT MAX(userID) FROM user")       
      
      lastUserID = clientData.getValue(0)   
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_INSERT_USER,lastUserID)
      
      Application.unlock()
      
      Session("successMessage") = "Novo Usuário inserido com sucesso!"
      Response.Redirect("/extranet/message.asp");
   }
   else
   {
      Application.unlock()
      errMessage = "Erro ao tentar inserir novo usuário"
      errMessage += "\n<!--\nDB Error:" +userData.getErrorMessage()+ "\n"+insertQuery.toString()+"-->"
      
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/extranet/error.asp");   
   }
}

function _updateUser()
{
   userName   = getRequestParameterAsString("user")
   userEmail  = getRequestParameterAsString("email")
   userLogin  = getRequestParameterAsString("login")
   userPass   = getRequestParameterAsString("password")
   userLevel  = getRequestParameterAsInt("level")
   userStatus = getRequestParameterAsInt("status")
   userID     = getRequestParameterAsInt("userID")
   
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   insertQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_USER"))   
   
   insertQuery.setStr(1,userName)
   insertQuery.setStr(2,userEmail)
   insertQuery.setStr(3,userLogin)
   insertQuery.setStr(4,userPass)
   insertQuery.setInt(5,userLevel)
   insertQuery.setInt(6,userStatus)
   insertQuery.setInt(7,userID)

   userData = new updateDB()
   userData.execute(insertQuery.toString())

   if(userData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_UPDATE_USER,userID)
      
      Session("successMessage") = "Dados do usuario "+userName+" editados com sucesso!"
      Response.Redirect("/extranet/message.asp");
   }
   else
   {
      errMessage = "Erro ao tentar editar"
      errMessage += "\n<!--\nDB Error:" +userData.getErrorMessage()+ "\n"+insertQuery.toString()+"-->"
      
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/extranet/error.asp");   
   }
}

function _updateUserDetails()
{
   userEmail   = getRequestParameterAsString("email")
   userPass    = getRequestParameterAsString("password")
   oldUserPass = getRequestParameterAsString("Oldpassword")
   userID      = getRequestParameterAsInt("userID")
 
   this.getUserByID(userID)
   
   if(this.getPassword() == oldUserPass)
   {
      //capturando do arquivo de configuracao a query a ser usada
      cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
      updateQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_USER_DETAILS"))   

      updateQuery.setStr(1,userPass)
      updateQuery.setInt(2,userID)
   
      userData = new updateDB()
      userData.execute(updateQuery.toString())
   
      if(userData.errorMessage() == null)
      {
         auditRecord = new audit()
         auditRecord.saveAction(ACTION_UPDATE_USER_DETAILS,userID)
         
         user = null
         
         Session("successMessage") = "Seus dados foram editados com sucesso!"
         Response.Redirect("/extranet/message.asp");
      }
      else
      {
         errMessage = "Erro ao tentar editar seus dados. Por favor contacte o Administrador."
         errMessage += "\n<!--\nDB Error:" +userData.getErrorMessage()+ "\n"+updateQuery.toString()+"-->"
         
         Session("errorMessage") = errMessage
         taskData = null
         user = null
         Response.Redirect("/extranet/error.asp");   
      }   
   }
   else
   {
      errMessage = "A Senha atual não confere. Por favor tente novamente."
      
      Session("errorMessage") = errMessage
      taskData = null
      user = null
      Response.Redirect("/extranet/error.asp");          
   }
}

function _removeUser()
{
   userID = getRequestParameterAsInt("id")
   
   //capturando do arquivo de configuracao a query a ser usada
   cfgQuery    = new loadConfigFiles(CONFIG_QUERIES_FILE)
   updateQuery = new queryStatement(cfgQuery.getKeyValue("UPDATE_ISDELETED"))   
   
   updateQuery.setTable(1,"USER")
   updateQuery.setColumm(2,"userID")
   updateQuery.setInt(3,userID)
   
   
   taskData = new updateDB()
   taskData.execute(updateQuery.toString())

   if(taskData.errorMessage() == null)
   {
      auditRecord = new audit()
      auditRecord.saveAction(ACTION_DELETE_USER,userID)
      
      Session("successMessage") = "Usuário removido com sucesso!"
      Response.Redirect("/extranet/message.asp");
   }
   else
   {
      errMessage = "Erro ao tentar remover o usuário"
      errMessage += "\n<!--\nDB Error:" +taskData.getErrorMessage()+ "\n"+updateQuery.toString()+"-->"
      
      Session("errorMessage") = errMessage
      taskData = null
      Response.Redirect("/extranet/error.asp");   
   }   
}

function _getUserLevelName(levelID)
{
   switch(levelID)
   {
      case 1:
         return "Master"
      break
      case 2:
         return "Administrativo"
      break
      case 3:
         return "T&eacute;cnico Laborat&oacute;rio"
      break
      case 4:
         return "Consultor"
      break
      case 5:
         return "Enfermeira"
      break      
   }
}
%>