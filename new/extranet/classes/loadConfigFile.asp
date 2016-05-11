<!--#include virtual="/extranet/inc/fileSystemFunctions.asp" -->
<%
function loadConfigFiles(XMLFile)
{
   this.xml       = Server.CreateObject("Microsoft.XMLDOM")
   this.xml.async = false
   this.error    = null
   
   thisFileLoaded = this.xml.loadXML(readDatainFile(Server.MapPath("/extranet/config/" + XMLFile), false))
  
   this.getAttributeValue = getXMLAttributeValueByTag
   this.getKeyByAttribute = getXMLTagValueByAttribute
   this.getKeyValue       = getXMLTagValue
   this.setNewConfig      = setNewConfigFile  
}

//Get a XML file, parses it and get a value of a tag based on one attribute of it 
function getXMLTagValueByAttribute(tagName,attributteName,keyValue)
{
   if(thisFileLoaded)
   {
      tags = this.xml.getElementsByTagName(tagName)
      for(var intemp = 0; intemp < tags.length; intemp++)
      {
         if(tags[intemp].getAttribute(attributteName) == keyValue)
         {
            return tags[intemp].firstChild.nodeValue
            break
         }
      }
   }
   else
   {
     this.error = "Config file not found"
   }
   
   this.xml = null
}

//Get a XML file, parses it and get a value of a tag based
function getXMLTagValue(tag)
{
  if(thisFileLoaded)
  {
      tags = this.xml.getElementsByTagName("*")
      for(var intemp = 0 ; intemp < tags.length; intemp++)
      {
         if(tags[intemp].tagName == tag)
         {
            return tags[intemp].firstChild.nodeValue
            break 
         }
      }
   }
   else
   {
      this.error = "Config file not found"
      return -999
   }
}

//Get a XML file, parses it and get a value of a attribute based on the tag 
function getXMLAttributeValueByTag(tagName,attributteName)
{ 
  if(thisFileLoaded)
  {
      tags = this.xml.getElementsByTagName(tagName)
      this.xml = null
      return tags[0].getAttribute(attributteName)
   }
   else
   {
      this.error = "Config file not found"
   }   
}

//set a new config file if need
function setNewConfigFile(file)
{
   Application("fileCache" + file) = readDatainFile(Server.MapPath("/extranet/config/" + file), true)
   thisFileLoaded = this.xml.loadXML(Application("fileCache" + file))
}
%>
