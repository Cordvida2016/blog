<%@Language=JavaScript%>
<%Response.Buffer = true%>
<!--#include virtual="/extranet/classes/login.asp" -->
<!--#include virtual="/extranet/classes/client.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<!--#include virtual="/extranet/inc/login.asp" -->
<%
clientID = Session("userID")
client = new clientData()
client.getClientFromID(clientID)  
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
<form method="post" action="falecordvidafinalteste.asp" id="add_sugestao" name="add_sugestao">
<input type=hidden name="clientID" value="<%=clientID%>">
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td><b class="red">O que deseja nos enviar? </b>
</td>
<td>&nbsp;
</td>
<td><select name="cb_tipo" id="cb_tipo" class="form_text" size="">
				<option value="1">D&uacute;vidas</option>
				<option value="2" >Sugest&otilde;es</option>
			</select></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td><b class="red">Digite aqui suas d&uacute;vidas/sugest&otilde;es: </b></td>
<td>&nbsp;
</td>
<td bgcolor="#FFFFFF"><textarea class="form_text" name="obs" id="obs" cols="40" rows="14" maxlength="700" ></textarea></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td colspan="3" align="center"><input id='botao_submit_add_item' type="submit" class="form_button" name="enviarduvida" value="Enviar"></td>

</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
</table>
</form>
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