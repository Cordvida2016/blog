<%
//Class to create a SQL statment for a query
//Receives a String where each field value is defined as "?"
//example: "select x,y,z from table where x = ?"
//then we use it to change the values according the data type
//and return the query string ready to be executed

function queryStatement(str)
{
   //methods
   if(str == undefined || str == null || str == "")
   {
      Session("errorMessage") = "Query não definida, Contacte o Administrador"
      Response.Redirect("/extranet/error.asp");       
   }

   this.toString     = getQueryString
   this.errorMessage = getError
   this.setQuery     = changeQuery
   this.setInt       = setIntValue
   this.setDouble    = setDoubleValue
   this.setStr       = setStringValue
   this.setColumm    = setGenValue
   this.setTable     = setGenValue
   this.setOrderBy   = setGenValue
   this.setGenericValue = setGenValue   
   this.setDynamicQuery = setSpecialQuery
   
   //properties
   this.queryString      = str //the string of the query 
   this.queryLength      = str.length
   this.clearQuery       = str.replace(/\?/gi,"")
   this.numberOfFields   = (this.queryLength - this.clearQuery.length) //number of "?" on the query
   this.arrOfFields      = [] //values of each field  
   this.queryCommands    = str.split("?") //arr of the commands between the values
   this.formatedQueryString = "" //the query string to be returned
   this.error           = null 
}

//Set a int value to a specific position of the marker on the query
function setIntValue(pos,value)
{
   e = new Error()
   try
   {
      if(arguments.length < 2)
      {
         this.error = "Missing paramenters on setIntValue() :"; 
         if(arguments[0] == null)
         {
            this.error += " ->pos"
         }
         if(arguments[1] == null)
         {
            this.error += " ->value"
         }         
      }
      else
      {      
         if(this.error == null)
         {
            if(isNaN(value))
            {
               this.error = "Wrong Argument on setIntValue(), must receive a Number"+value 
            }
            else
            {
               this.arrOfFields[(pos-1)] = value
            }
         }
      }
   }
   catch(e)
   {
      Response.Write(e.description)
      this.error = e.description
   }         
}

//Set a double value to a specific position of the marker on the query
function setDoubleValue(pos,value)
{
   e = new Error()
   try
   {
      if(arguments.length < 2)
      {
         this.error = "Missing paramenters on setIntValue() :"; 
         if(arguments[0] == null)
         {
            this.error += " ->pos"
         }
         if(arguments[1] == null)
         {
            this.error += " ->value"
         }         
      }
      else
      {      
         if(this.error == null)
         {
            if(isNaN(value))
            {
               this.error = "Wrong Argument on setIntValue(), must receive a Number"+value 
            }
            else
            {
               this.arrOfFields[(pos-1)] = value
            }
         }
      }
   }
   catch(e)
   {
   Response.Write(e.description)
      this.error = e.description
   }         
}

//Set a string value to a specific position of the marker on the query
function setStringValue(pos,value)
{
   e = new Error()
   try
   {
      if(arguments.length < 2)
      {
         this.error = "Missing paramenters on setStringValue() :"; 
         if(arguments[0] == null)
         {
            this.error += " ->pos"
         }
         if(arguments[1] == null)
         {
            this.error += " ->value"
         }         
      }
      else
      {      
         if(this.error == null)
         {
            this.arrOfFields[(pos-1)] = " '" + value + "' "
         }
      }
   }
   catch(e)
   {
   Response.Write(e.description)
      this.error = e.description
   }          
}

//Set a string value to a row or table
function setGenValue(pos,value)
{
   e = new Error()
   try
   {     
      if(this.error == null)
      {
         this.arrOfFields[(pos-1)] = value 
      }
   }
   catch(e)
   {
   Response.Write(e.description)
      this.error = e.description
   }          
}

//monta query dinamicamente de acordo com uma hash passada onde
//hash[] = new Array("operator","value","field","conditional")
function setSpecialQuery(pos,hash)
{
   tempStr = ""
   for(k = 0 ; k < hash.length; k++)
   {    
      if(isNaN(hash[k][1]) && hash[k][0] != "IN(") 
      {
         hash[k][1] = " '" + hash[k][1] + "' "
      }
      
      tempStr += hash[k][3] + " " + hash[k][2] + " " + hash[k][0] + hash[k][1] + " "
   }
   
   this.arrOfFields[(pos-1)] = tempStr
}

//Returns the query string of the object 
function getQueryString()
{
   for(var intemp = 0; intemp < this.queryCommands.length ; intemp++)
   {
      if(this.arrOfFields[intemp] != null || this.arrOfFields[intemp] != undefined) //looking for the pair of arrOfFields Values and the commands before it
      {
          this.formatedQueryString += this.queryCommands[intemp] + "" + this.arrOfFields[intemp]
      }
      else
      {
         this.formatedQueryString += this.queryCommands[intemp] + " " //if we have finsihed the list of values we add the rest of commands to the string
      }
   }
   return this.formatedQueryString
}

//Changes the query string if need and Returns the new query string of the object 
function changeQuery(str)
{
   this.queryString      = str
   this.queryLength      = str.length
   this.clearQuery       = str.replace(/\?/gi,"")
   this.numberOfFields   = (this.queryLength - this.clearQuery.length)
   this.arrOfFields      = new Array()   
   this.queryCommands    = str.split("?")
   this.formatedQueryString = ""   
}

//Returns any error message during the proccess
function getError()
{
   return this.error
}
%>
