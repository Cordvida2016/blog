<%@Language="JScript"%>
<!--#include virtual="/extranet/inc/login.asp" -->
<%
Response.Buffer = true; Response.Expires = -1441;

var objStream = new ActiveXObject("ADODB.Stream");
objStream.Type = 1;
objStream.Open(); 
objStream.loadFromFile(Server.MapPath('/seg/cam3.jpg'));

Response.ContentType = 'image/gif';
Response.BinaryWrite(objStream.Read());

objStream.close();
objStream = null;

%>