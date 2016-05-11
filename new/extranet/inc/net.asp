<%
//Retorna um elemento do request como numero, -999 caso nulo
function getRequestParameterAsInt(param)
{
   if(Request(param).item == null || isNaN(Request(param).item) || Request(param).item == "")
   {
      return -999
   }
   else
   {
      return parseInt(Request(param).item.replace(",","."))
   }
}

//Retorna um elemento do request como numero do tipo double, -999 caso nulo
function getRequestParameterAsDouble(param)
{
   if(Request(param).item == null || isNaN(Request(param).item.replace(",",".")) || Request(param).item == "")
   {
      return -999
   }
   else
   {
      return Request(param).item.replace(",",".")
   }
}

//Retorna um elemento do request como String, -999 caso nulo
function getRequestParameterAsString(param)
{
   if(Request(param).item == null)
   {
      return ""
   }
   else
   {
      return Request(param).item.replace(/\s/gi,"")
   }
}

//Retorna um elemento do request(select, check box etc) como um array
function getRequestParameters(param)
{
   if(Request(param).item == null)
   {
      return -999
   }
   else
   {
      tempRequest = Request(param).item.replace(/\s/gi,"")
      _fieldValues = tempRequest.split(",") 
      return _fieldValues
   }
}
%>
