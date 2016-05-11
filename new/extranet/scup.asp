<%@Language=JavaScript%>
<%Response.Buffer = true%>
<!--#include virtual="/extranet/classes/login.asp" -->
<!--#include virtual="/extranet/classes/client.asp" -->
<!--#include virtual="/extranet/classes/clientColeta.asp" -->
<!--#include virtual="/extranet/classes/clientSCUP.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<!--#include virtual="/extranet/inc/login.asp" -->
<!--#include virtual="/extranet/inc/formatFunctions.asp" -->
<%
clientID = Session("userID")
client = new clientData()
client.getClientFromID(clientID)

clientColeta = new clientColeta()
clientColeta.getClientColetaFromID(clientID) 

clientScup = new clientSCUP()
clientScup.getClientScupFromID(clientID)  
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
<p><a href="cad.asp"><img src="../extranet/img/ui/novoMenu/DadosCadastro.gif" width="170" height="22" vspace="5" border="0"></a><br>
<img src="../extranet/img/ui/novoMenu/DadosColetaSeta.gif" width="184" height="22" vspace="5"><br>
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
<td width="100" bgcolor="#FFFFFF"><b class="red">Cliente:</b></td><td width="5" bgcolor="#FFFFFF"></td><td width="100%" bgcolor="#ffffff"> <%=client.getName()%></td>
<td width="6" bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Data Nascimento:</b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"> <%=genDateFromMySQL(clientColeta.getDataColeta())%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Data e hora da coleta:</b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"> <%=genDateFromMySQL(clientColeta.getDataColeta(),true)%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Maternidade: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"><%=clientColeta.getHospital()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Obstetra: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"><%=clientColeta.getObstetra()%> <%if(clientColeta.getObstetraCRM() != "" && clientColeta.getObstetraCRM() != "null"){%> <em>(CRM: <%=clientColeta.getObstetraCRM()%>)</em><%}%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Enfermeira: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"><%=clientColeta.getEnfermeira()%> <%if(clientColeta.getEnfermeiraCoren() != "" && clientColeta.getEnfermeiraCoren() != "null"){%> <em>(Coren: <%=clientColeta.getEnfermeiraCoren()%>)</em><%}%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<%if(clientColeta.getColetaFeitaPor() == 1) {
    coletadoPor = "Enfermeira"
  }
  else if(clientColeta.getColetaFeitaPor() == 2) {
    coletadoPor = "Obstetra"
  }

  else {
    coletadoPor = "Obstetra e Enfermeira"
  }
%>

<td bgcolor="#FFFFFF"><b class="red">Coleta efetuada por: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"><%=coletadoPor%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Volume do SCUP coletado:</b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"> <%=clientScup.getprocVolumeRealScup()%> ml **</td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td nowrap bgcolor="#FFFFFF"><b class="red">Contagem células Nucleadas Inicial: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"><%=formatNumber(clientScup.getProcCd45Cd34Ini()/100.0, 4)%> x 10<sup>8</sup> **</td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td nowrap bgcolor="#FFFFFF"><b class="red">Contagem células Nucleadas Final: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"><%=formatNumber(clientScup.getProcCd45Cd34Fim()/100.0, 4)%> x 10<sup>8</sup> **</td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Esterilidade da amostra: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff">Bactérias:<em> <%=(clientScup.getCult_micro_bacteria() == 1)?"Estéril":(clientScup.getCult_micro_bacteria() == 2)?"Não estéril":" - "%></em> - Fungos: <em><%=(clientScup.getCult_micro_fungo() == 1)?"Estéril":(clientScup.getCult_micro_fungo() == 2)?"Não estéril":" - "%></em></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Viabilidade celular: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"> <%=clientScup.getProcViabilidadeCelular()%> %</td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">Data de congelamento: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"> <%=genDateFromMySQL(clientScup.getDataCrioPreservacao(),true)%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td bgcolor="#FFFFFF"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><b class="red">ID do Bioarchive: </b></td><td width="5" bgcolor="#FFFFFF"></td><td bgcolor="#ffffff"> <%=clientScup.getBioArchiveID()%></td>
<td bgcolor="#FFFFFF"><img src="img/ui/fside2.gif" width="6" height="27"></td>
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
<td width="100" rowspan="2" align="right" valign="top"><p><img src="img/ui/backs.gif" width="80" height="36" border="0" usemap="#Map"></p>
<p><img src="img/ui/sidelogo.gif" width="59" height="340"></p>
<p><img src="img/ui/ball.gif" width="70" height="70"></p></td>
</tr>
<tr>
<td valign="bottom"><table width="150" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="mred">O valor mínimo recomendado pela portaria RDC/ANVISA 56  de 16/12/2010 para o armazenamento de células tronco do sangue de cordão umbilical autólogo é de  um número total de células nucleadas viáveis, determinado após o processamento da unidade e anteriormente a criopreservação de 5 x 10<sup>8</sup> (quinhentos milhões) de células nucleadas.</td>
</tr>
</table></td>
</tr>
</table>
<!--#include virtual="/include/tag.asp" -->
<map name="Map"><area shape="rect" coords="42,3,76,17" href="javascript:history.back()">
<area shape="rect" coords="2,3,36,17" href="welcome.asp">
</map>
</body>
</html>