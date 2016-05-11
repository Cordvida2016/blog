<!--#include virtual="/extranet/classes/client.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<%
function ExportData()
{
   this.exportContent = null
   this.XMLHEADER     = "<?xml version=\"1.0\"?>" 
   
   
   this.exportClientData = _exportClientData
   
   this.sendData    = _sendData
   this.getResponse = _getResponse
   this.encodeXMLData = _encodeXMLData
}

function _encodeXMLData(str)
{
   return Server.HTMLEncode((str != null && str != "") ? str : "NULL")
}

function _exportClientData()
{
   client = new clientData()
   allClients = client.getAllClients()
   
   if(allClients > 0)
   {
      this.exportContent = this.XMLHEADER + '<CLIENTS>'
      for(i = 0; i < allClients; i++)
      {
         this.exportContent += '<CLIENT id="'+client.getClientID()[i]+'">'
         this.exportContent += '<NAME>'+this.encodeXMLData(client.getName()[i])+'</NAME>'
         this.exportContent += '<SEX>'+this.encodeXMLData(client.getSex()[i])+'</SEX>'
         this.exportContent += '<NAMEFATHER>'+this.encodeXMLData(client.getNameFather()[i])+'</NAMEFATHER>'
         this.exportContent += '<EMAILFATHER>'+this.encodeXMLData(client.getEmailFather()[i])+'</EMAILFATHER>'
         this.exportContent += '<DOCFATHER>'+this.encodeXMLData(client.getDocFather()[i])+'</DOCFATHER>'
         this.exportContent += '<CPFFATHER>'+this.encodeXMLData(client.getCPFFather()[i])+'</CPFFATHER>'
         this.exportContent += '<NAMEMOTHER>'+this.encodeXMLData(client.getNameMother()[i])+'</NAMEMOTHER>'
         this.exportContent += '<EMAILMOTHER>'+this.encodeXMLData(client.getEmailMother()[i])+'</EMAILMOTHER>'
         this.exportContent += '<DOCMOTHER>'+this.encodeXMLData(client.getDocMother()[i])+'</DOCMOTHER>'
         this.exportContent += '<CPFMOTHER>'+this.encodeXMLData(client.getCPFMother()[i])+'</CPFMOTHER>'
         this.exportContent += '<ADDRESS>'+this.encodeXMLData(client.getAddress()[i])+'</ADDRESS>'
         this.exportContent += '<PHONE1>'+this.encodeXMLData(client.getPhone1()[i])+'</PHONE1>'
         this.exportContent += '<PHONE2>'+this.encodeXMLData(client.getPhone2()[i])+'</PHONE2>'
         this.exportContent += '<PHONE3>'+this.encodeXMLData(client.getPhone3()[i])+'</PHONE3>'
         this.exportContent += '<CITY>'+this.encodeXMLData(client.getCity()[i])+'</CITY>'
         this.exportContent += '<STATE>'+this.encodeXMLData(client.getState()[i])+'</STATE>'
         this.exportContent += '<ZIP>'+this.encodeXMLData(client.getZip()[i])+'</ZIP>'
         this.exportContent += '<BIRTHMOTHER>'+this.encodeXMLData(client.getBirthMother()[i])+'</BIRTHMOTHER>'
         this.exportContent += '</CLIENT>'
      }
      this.exportContent += '</CLIENTS>'
      
      return this.exportContent
   }
   else
   {
      return null
   }
}

function _sendData()
{
}

function _getResponse()
{
}

function getexportContent()
{
   return this.exportContent
}
%>
