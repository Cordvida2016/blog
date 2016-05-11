<!--#include file="loadConfigFile.asp" -->
<!--#include file="queryStatement.asp" -->
<%
openConn = null
function searchDB()
{
   //methods
   this.execute        = runSelectQuery
   this.getErrorMessage = getError
   this.EOF             = eofQuery
   this.BOF             = bofQuery
   this.nextValue       = nextRs
   this.getValue        = getFieldValue
   this.getRowName      = getFieldName
   this.getRowNames     = getAllRowNames
   this.closeDB         = closeConnection
   
   //properties
   this.error   = null
   this.rsResult = null   
}

function updateDB()
{
   this.execute        = runUpdateQuery
   this.closeDB         = closeConnection
   this.getErrorMessage = getError
   this.errorMessage    = getError
   
   this.error          = null
   this.rsResult        = null
}

function insertionDB()
{
   this.execute        = runInsertQuery
   this.closeDB         = closeConnection
   this.getErrorMessage = getError
   this.errorMessage    = getError
   
   this.error   = null
   //this.rsResult = null   
}

function deletionDB()
{
   this.execute        = runDeleteQuery
   this.closeDB         = closeConnection
   this.errorMessage    = getError
   this.getErrorMessage = getError
   
   this.error   = null
   this.rsResult = null  
}

//get the values and set to an array and then get them to be used
function runSelectQuery(queryString)
{
   e = new Error()
   try
   {   
      openConnection()
      this.rsResult = openConn.Execute(queryString)
      return this.rsResult
      closeConnection()
   }
   catch(e)
   {
      this.error = e.description
   }   
}

function runUpdateQuery(queryString)
{
   e = new Error()
   try
   {   
      openConnection()
      this.rsResult = openConn.Execute(queryString)
      return this.rsResult
      closeConnection()
   }
   catch(e)
   {
      this.error = e.description
   }   
}

function runInsertQuery(queryString)
{
   e = new Error()
   try
   {   
      openConnection()
      this.rsResult = openConn.Execute(queryString)
      return true
      closeConnection()
   }
   catch(e)
   {
      this.error = e.description
   }   
}

function runDeleteQuery(queryString)
{
   e = new Error()
   try
   {   
      openConnection()
      this.rsResult = openConn.Execute(queryString)
      return this.rsResult
      closeConnection()
   }
   catch(e)
   {
      this.error = e.description
   }   
}

function openConnection()
{
   e = new Error()
   try
   {
      cfg = new loadConfigFiles(CONFIG_DB_FILE)
      connString = "DRIVER={MySQL ODBC 3.51 Driver};" + 
                   "SERVER=" + cfg.getKeyValue("SERVER") + ";" +
                   "DATABASE=" + cfg.getKeyValue("DBNAME") + ";" +
                   "UID=" + cfg.getKeyValue("USER") + ";" +
                   "PASSWORD=" + cfg.getKeyValue("PASS") + ";" +
                   "OPTION=3;"
      openConn = Server.CreateObject("ADODB.Connection")
      openConn.open(connString)
      
   }
   catch(e)
   {
      Session("errorMessage") = "Falha na conexão com o banco de dados do sistema, verifique as configurações de acesso!" + "<!--"+e.description+"-->"
      Response.Redirect("error.asp")
   }
}

function getError()
{
   return this.error
}

function closeConnection()
{
   e = new Error()
   try
   {
      openConn.close()
      openConn = null
   }
   catch(e)
   {
      Session("errorMessage") = e.description
      Response.Redirect("error.asp")
   }
}

function eofQuery()
{
   return this.rsResult.Eof;
}

function bofQuery()
{
   return this.rsResult.Bof; 
}

function nextRs()
{
   return this.rsResult.MoveNext()
}

function getFieldValue(i)
{
   return this.rsResult(i).Value
}

function getFieldName(i)
{
   return this.rsResult(i).Name
}

function getAllRowNames()
{
   arrOfFields = new Array()
   for(i = 0; i < this.rsResult.Fields.Count; i++)
   {
      arrOfFields[i] = this.rsResult(i).Name
   }
   return arrOfFields
}
%>
