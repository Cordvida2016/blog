<%
function xmlParser(XMLString)
{
   this.xml          = Server.CreateObject("Microsoft.XMLDOM")
   this.xml.async    = false
   this.errorMessage = null
   
   this.xmlLoaded = this.xml.loadXML(XMLString)

   this.getTagValue          = _getTagValue
   this.getAllAttibuteValues = _getAllAttibuteValues
   this.getNumberOfItems     = _getNumberOfItems
}

function _getTagValue(tagName)
{
  if(this.xmlLoaded)
  {
      arrValues = new Array()
      tags = this.xml.getElementsByTagName(tagName)
      
      for(i = 0 ; i < tags.length; i++)
      {
         if(tags[i].firstChild.nodeValue != null)
         {
            arrValues.push(tags[i].firstChild.nodeValue)
         }
         else
         {
            arrValues.push("")
         }
      }
      
      return arrValues
   }
   else
   {
      this.errorMessage = "XML not loaded!"
      return null
   }
}

function _getAllAttibuteValues(tagName,attributteName)
{ 
  if(this.xmlLoaded)
  {
      tags = this.xml.getElementsByTagName(tagName)
      arrValues = new Array()
      
      for(var i = 0 ; i < tags.length; i++)
      {
         arrValues.push(tags[i].getAttribute(attributteName))
      }      
      
      return arrValues      
   }
   else
   {
      this.errorMessage = "XML not loaded!"
      return null
   }   
}

function _getNumberOfItems(tagName)
{
   if(this.xmlLoaded)
   {
      tags = this.xml.getElementsByTagName(tagName) 
      return tags.length
   }
   else
   {
      this.errorMessage = "XML not loaded!"
      return null
   }   
}
%>
