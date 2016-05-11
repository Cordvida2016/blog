<%@Language=VBScript%>
<!--#include virtual="/extranet/inc/akaConnect.asp" -->
<%Response.Buffer = true%>
<% 
//request.form("clientID")

ClientID = Request.Form("clientID")

//Option Explicit
Dim ConnectString
Dim ResultSet
Dim MyField

//Criar include de conexão
connection = akaConnect()

qrySQL = "SELECT a.NAME AS paciente FROM client a WHERE a.clientID = " + ClientID
response.write(qrySQL)
set ResultSet=Server.CreateObject("ADODB.Recordset")

ResultSet.Open qrySQL, connection

//ResultSet = akaSelectClient()

howmanyfields = ResultSet.fields.count -1

DO UNTIL ResultSet.eof
	FOR i = 0 to howmanyfields
      if i = 0 then
 	    Nome_cliente = ResultSet(i)
	  end if
	  Next
	ResultSet.movenext
LOOP


Set objMail = Server.CreateObject("CDONTS.NewMail")
objMail.To = "patrick@akabativas.com.br"
objMail.Bcc = "rene@akabativas.com.br, rene.akabativas@gmail.com"
objMail.From = "extranet-clientes@cordvida.com.br"

if Request.Form("cb_tipo") = "1" then 
	objMail.Subject = "Extranet - Fale com a CordVida - Duvida - Cliente " + Nome_cliente
else 
	objMail.Subject = "Extranet - Fale com a CordVida - Sugestao - Cliente " + Nome_cliente
end if
objMail.Body = Request.Form("obs")
objMail.Send
Set objMail = Nothing
%><html>
<head>
<title>CordVida</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>self.status = "CordVida - Extranet"</script>
<link href="../extranet/main.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#DCE6A1" leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
<table width="740" border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td width="190" valign="top"><p>
<img src="../extranet/img/ui/intlogo.gif" width="120" height="152"></p>
<p>
<a href="cad.asp">
<img src="../extranet/img/ui/novoMenu/DadosCadastro.gif" width="170" height="22" vspace="5" border="0"></a><br>
<a href="scup.asp">
<img src="../extranet/img/ui/novoMenu/DadosColeta.gif" width="170" height="22" vspace="5" border="0"></a><br>
<a href="cordLive.asp">
<img src="../extranet/img/ui/novoMenu/ImagensLaboratorio.gif" width="170" height="22" vspace="5" border="0"></a><br>
<img src="../extranet/img/ui/novoMenu/FaleCordvidaSeta.gif" width="184" height="22" vspace="5" border="0">
<a href="logout.asp">
<img src="../extranet/img/ui/novoMenu/logout.gif" width="170" height="22" vspace="5" border="0"></a></p></td>
<td rowspan="2" valign="top">
<table width="450" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#E7F0C3">
<td width="8" height="9" valign="top">
<img src="../extranet/img/ui/boxcurvetl.gif" width="8" height="9"></td>
<td height="9" valign="top">
<img src="../extranet/img/ui/dot.gif" width="1" height="9"></td>
<td width="8" height="9" align="right" valign="top">
<img src="../extranet/img/ui/boxcurvetr.gif" width="8" height="9"></td>
</tr>
<tr bgcolor="#E7F0C3">
<td>&nbsp;</td>
<td align="center" valign="top">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td>
</td>
<td colspan="2"><b class="red">A CordVida agradece o seu contato, as suas 
<%if Request.Form("cb_tipo") = "1" then %>
d&uacute;vidas ser&atilde;o analisadas e daremos um retorno o mais breve poss&iacute;vel. 
<%else%>
sugest&otilde;es s&atilde;o muito importantes para n&oacute;s.
<%end if%>
</b></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td>
</td>
<td colspan="2"><b class="red">Voc&ecirc; pode continuar navegando na Extranet CordVida atrav&eacute;s das op&ccedil;&otilde;es de menu.</b></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
</table>
</td>
<td>&nbsp;</td>
</tr>
<tr bgcolor="#E7F0C3">
<td width="8" height="9">
<img src="../extranet/img/ui/boxcurvedl.gif" width="8" height="9"></td>
<td height="9" valign="top">
<img src="../extranet/img/ui/dot.gif" width="1" height="9"></td>
<td width="8" height="9">
<img src="../extranet/img/ui/boxcurvedr.gif" width="8" height="9"></td>
</tr>
</table></td>
<td width="100" rowspan="2" align="right" valign="top"><p>
<img src="../extranet/img/ui/backs.gif" width="80" height="36" border="0" usemap="#Map">
<map name="Map">
<area shape="rect" coords="42,3,76,17" href="javascript:history.back()">
<area shape="rect" coords="2,4,36,18" href="welcome.asp">
</map>
</p>
<p>
<img src="../extranet/img/ui/sidelogo.gif" width="59" height="340"></p>
<p>
<img src="../extranet/img/ui/ball.gif" width="70" height="70"></p></td>
</tr>
<tr>
<td valign="bottom">&nbsp;</td>
</tr>
</table>
<!--#include virtual="/include/tag.asp" -->
</body>
</html>