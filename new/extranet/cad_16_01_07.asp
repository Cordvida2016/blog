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
<link href="main.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#DCE6A1" leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
<table width="740" border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td width="190" valign="top"><p><img src="img/ui/intlogo.gif" width="120" height="152"></p>
<p><img src="../extranet/img/ui/novoMenu/DadosCadastroSeta.gif" width="184" height="22" vspace="5"><br>
<a href="scup.asp"><img src="../extranet/img/ui/novoMenu/DadosColeta.gif" width="170" height="22" vspace="5" border="0"></a><br>
<a href="cordLive.asp"><img src="../extranet/img/ui/novoMenu/ImagensLaboratorio.gif" width="170" height="22" vspace="5" border="0"></a><br>
<a href="FaleCordvida.asp"><img src="../extranet/img/ui/novoMenu/FaleCordvida.gif" width="170" height="22" vspace="5" border="0"></a><br>
<a href="logout.asp"><img src="../extranet/img/ui/novoMenu/Logout.gif" width="170" height="22" vspace="5" border="0"></a></p></td>
<td rowspan="2"><table width="450" border="0" cellspacing="0" cellpadding="0">
<tr bgcolor="#E7F0C3">
<td width="8" height="9" valign="top"><img src="img/ui/boxcurvetl.gif" width="8" height="9"></td>
<td height="9"><img src="img/ui/dot.gif" width="1" height="9"></td>
<td width="8" height="9" align="right" valign="top"><img src="img/ui/boxcurvetr.gif" width="8" height="9"></td>
</tr>
<tr bgcolor="#E7F0C3">
<td>&nbsp;</td>
<td align="center"><table width="450" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td width="5" bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Cliente: </b><%=client.getName()%></td>
<td width="6" bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Sexo:</b>  <%=(client.getSex() == 1)?"Masculino":"Feminino"%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Nome Completo Pai: </b><%=client.getNameFather()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">E-mail Pai: </b><%=client.getEmailFather()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Documento Pai: </b><%=client.getDocFather()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">CPF do Pai: </b><%=client.getCPFFather()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Nome Completo M&atilde;e: </b><%=client.getNameMother()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">E-mail M&atilde;e: </b><%=client.getEmailMother()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Documento M&atilde;e: </b><%=client.getDocMother()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">CPF da M&atilde;e: </b><%=client.getCPFMother()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Documento M&atilde;e: </b><%=client.getDocMother()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Data Nascimento M&atilde;e: </b><%=genDateFromMySQL(client.getBirthMother())%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Endere&ccedil;o: </b><%=client.getAddress()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Cidade / Estado: </b><%=client.getCity()%> 
<%=client.getState()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">CEP: </b><%=client.getZip()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Telefone 1: </b><%=client.getPhone1()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Telefone 2: </b><%=client.getPhone2()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Telefone 3: </b><%=client.getPhone3()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
</table></td>
<td>&nbsp;</td>
</tr>
<tr bgcolor="#E7F0C3">
<td width="8" height="9"><img src="img/ui/boxcurvedl.gif" width="8" height="9"></td>
<td height="9"><img src="img/ui/dot.gif" width="1" height="9"></td>
<td width="8" height="9"><img src="img/ui/boxcurvedr.gif" width="8" height="9"></td>
</tr>
</table></td>
<td width="100" rowspan="2" align="right" valign="top"><p><img src="img/ui/backs.gif" width="80" height="36" border="0" usemap="#Map">
<map name="Map">
<area shape="rect" coords="42,3,76,17" href="javascript:history.back()">
<area shape="rect" coords="2,3,36,17" href="welcome.asp">
</map>
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