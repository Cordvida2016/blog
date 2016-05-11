<%@Language=JavaScript%>
<%Response.Buffer = true%>
<html>
<head>
<title>CordVida</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>self.status = "CordVida - Extranet"</script>
<link href="main.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#DCE6A1" leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
<table width="740" border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td width="190" valign="top"><p><img src="img/ui/intlogo.gif" width="120" height="152"></p>
<p><br>
<br>
<br>
</p></td>
<td rowspan="2" align="center" valign="top"><p>&nbsp;</p><table width="400" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#E7F0C3">
<td width="8" height="9" valign="top"><img src="img/ui/boxcurvetl.gif" width="8" height="9"></td>
<td height="9"><img src="img/ui/dot.gif" width="1" height="9"></td>
<td width="8" height="9" align="right" valign="top"><img src="img/ui/boxcurvetr.gif" width="8" height="9"></td>
</tr>
<tr bgcolor="#E7F0C3">
<td>&nbsp;</td>
<td align="center">
<table width="100%" border="0" cellpadding="2" cellspacing="1">
<tr> 
<td width="35" align="center"><img src="img/ui/stopGlow.gif" width="32" height="32"><br> 
</td>
<td><br>
<b><%=Session("errorMessage")%></b><br>
<a href="javascript:history.back()">Voltar</a></td>
</tr>
</table>
</td>
<td>&nbsp;</td>
</tr>
<tr bgcolor="#E7F0C3">
<td width="8" height="9"><img src="img/ui/boxcurvedl.gif" width="8" height="9"></td>
<td height="9"><img src="img/ui/dot.gif" width="1" height="9"></td>
<td width="8" height="9"><img src="img/ui/boxcurvedr.gif" width="8" height="9"></td>
</tr>
</table></td>
<td width="100" rowspan="2" align="right" valign="top"><p>&nbsp;
</p>
<p><img src="img/ui/sidelogo.gif" width="59" height="340"></p>
<p><img src="img/ui/ball.gif" width="70" height="70"></p></td>
</tr>
<tr>
<td valign="bottom">&nbsp;</td>
</tr>
</table>
<!--#include virtual="/include/tag.asp" -->
</body>
</html>