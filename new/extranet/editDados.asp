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
<script language="JavaScript">
function clearemail(){
	document.signin.email.value = "";
	document.signin.setfocus;
}

function isEmailAddr(email)
{
  var result = false
  var theStr = new String(email)
  var index = theStr.indexOf("@");
  if (index > 0)
  {
    var pindex = theStr.indexOf(".",index);
    if ((pindex > index+1) && (theStr.length > pindex+1))
	result = true;
  }
  return result;
}

function FormValidator(theForm)
{

  if (theForm.endereco.value == "")
  {
    alert("Por favor nos informe seu endereço");
    theForm.endereco.focus();
    return (false);
  }

  if (theForm.bairro.value == "")
  {
    alert("Por favor nos informe seu bairro");
    theForm.bairro.focus();
    return (false);
  }

  if (theForm.cidade.value == "")
  {
    alert("Por favor nos informe sua cidade");
    theForm.cidade.focus();
    return (false);
  }

  if (theForm.estado.value == "")
  {
    alert("Por favor nos informe seu estado");
    theForm.estado.focus();
    return (false);
  }

  if (theForm.cep.value == "")
  {
    alert("Por favor nos informe seu cep");
    theForm.cep.focus();
    return (false);
  }

  if (theForm.email.value == "")
  {
    alert("Por favor nos informe o seu email.");
    theForm.email.focus();
    return (false);
  }

  if (!isEmailAddr(theForm.email.value))
  {
    alert("Por favor insira o seu endereço de e-mail no formato apropriado: \n\n seunome@dominio.com.br \n");
    theForm.email.focus();
    return (false);
  }
   
  if (theForm.email.value.length < 3)
  {
    alert("Por favor insira o seu endereço de e-mail no formato apropriado: \n\n seunome@dominio.com.br \n");
    theForm.email.focus();
    return (false);
  }

  if (theForm.telefone.value == "")
  {
    alert("Por favor nos informe seu numero de telefone");
    theForm.telefone.focus();
    return (false);
  }


  return (true);
}
</script>
</head>
<body bgcolor="#DCE6A1" leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
<table width="740" border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td width="190" valign="top"><p>
<img src="../extranet/img/ui/intlogo.gif" width="120" height="152"></p>
<p>
<img src="../extranet/ui/menu/cads.gif" width="170" height="22" vspace="5"><br>
<a href="scup.asp">
<!--webbot bot="ImageMap" text=" (54,0) (116, 22) {} {Times New Roman} 12 B #000000 CT 0  " src="col.gif" vspace="5" border="0" u-originalsrc="col.gif" u-overlaysrc="file:///C:/Pessoal/Rene/Akabativas/Alteracoes Site Cordvida/Fale com a Cordvida.asp_txt_col.gif" startspan --><img src="../../Imagens%20SiteCordvida/Imagens%20SiteCordvida/ui/menu/col.gif" width="170" height="22" vspace="5" border="0"><!--webbot bot="ImageMap" endspan i-checksum="61943" --></a><br>
<a href="cordLive.asp">
<img src="../extranet/img/ui/menu/lab.gif" width="170" height="22" vspace="5" border="0"></a><br>
<img src="FaleCordvidaSeta1.png" width="198" height="22" vspace="5" border="0">
<a href="logout.asp">
<img src="../extranet/img/ui/menu/logout.gif" width="170" height="22" vspace="5" border="0"></a></p></td>
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
<form name="frmEditAdress" id="frmEditAdress" method="post" action="endereco_up.asp" onsubmit="return FormValidator(this)">
			<table border=0 cellpadding=2 cellspacing=0 width=100%>
			    <tr> 
			    	<td colspan=2>&nbsp;</td>
			    </tr>
				<tr>
					<td colspan=2 valign=top class="titleind">
						<strong>&nbsp;1. Informa&ccedil;&otilde;es pessoais</strong>
					</td>
				</tr>
			    <tr> 
			    	<td colspan=2>&nbsp;</td>
			    </tr>
			    <tr> 
			    	<td valign=middle align=right width="25%"><b class="red">Endere&ccedil;o </b></td>
			        	<td width="75%"> 
			                  <input type=text name=endereco value="" size="80" class="inputy">
			            </td>
				</tr>
			    <tr> 
			    	<td valign=middle align=right width="10%"><b class="red">Bairro </b></td>
   			        	<td width="90%"> 
                             <input type=text name=bairro size=30 value="" class="inputy">
						</td>
				</tr>
			    <tr> 
			    	<td valign=middle align=right width="10%"><b class="red">Cidade </b></td>
			        	<td width="90%"> 
			                  <input type=text name=cidade value="" size="40" class="inputy">
			            </td>
				</tr>
			    <tr> 
			    	<td valign=middle align=right width="10%"><b class="red">Estado </b></td>
			        	<td width="90%"> 
							<select name="estado" class="inputy">
							   <option> 
							   <option value="AC">AC 
							   <option value="AL">AL 
							   <option value="AM">AM 
							   <option value="AP">AP 
							   <option value="BA">BA 
							   <option value="CE">CE 
							   <option value="DF">DF 
							   <option value="ES">ES 
							   <option value="GO">GO 
							   <option value="MA">MA 
							   <option value="MG">MG 
							   <option value="MS">MS 
							   <option value="MT">MT 
							   <option value="PA">PA 
							   <option value="PB">PB 
							   <option value="PE">PE 
							   <option value="PI">PI 
							   <option value="PR">PR 
							   <option value="RJ">RJ 
							   <option value="RN">RN 
							   <option value="RO">RO 
							   <option value="RR">RR 
							   <option value="RS">RS 
							   <option value="SC">SC 
							   <option value="SE">SE 
							   <option value="SP">SP 
							   <option value="TO">TO 
							</select>
			            </td>
				</tr>
			    <tr> 
			    	<td valign=middle align=right width="10%"><b class="red">Cep </b></td>
			        	<td width="90%"> 
			                  <input type=text name=cep value="" size="10" class="inputy">
			            </td>
				</tr>
				<tr> 
			    	<td valign=middle align=right width="10%"><b class="red">E-mail </b></td>
			        	<td width="90%"> 
			                  <input type=text name=email value="" size="40" class="inputy">
			            </td>
				</tr>
			    <tr> 
			    	<td valign=middle align=right width="10%"><b class="red">Telefone</b></td>
			        	<td width="90%"> 
			                  <input type=text name=ddd      value="" size="5" class="inputy">
			                  <input type=text name=telefone value="" size="20" maxlength=7  class="inputy">
			            </td>
				</tr>
			    <tr> 
			    	<td colspan=2>&nbsp;</td>
			    </tr>
			    <tr> 
			    	<td colspan=2>&nbsp;</td>
			    </tr>
				<tr>
					<td colspan=2 valign=top class="titleind">
						<strong>&nbsp;<b class="red">2. Informações do parto</b> </strong>
 				    </td>
				</tr>
			    <tr> 
			    	<td colspan=2>&nbsp;</td>
			    </tr>
			    <tr> 
			    	<td align=right valign="top"><b class="red">Data prov&aacute;vel do parto </b></td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><select name="dia" class="inputy">
										<option value="01">01<option value="02">02<option value="03">03<option value="04">04<option value="05">05
										<option value="06">06<option value="07">07<option value="08">08<option value="09">09<option value="10">10
										<option value="11">11<option value="12">12<option value="13">13<option value="14">14<option value="15">15
										<option value="16">16<option value="17">17<option value="18">18<option value="19">19<option value="20">20
										<option value="21">21<option value="22">22<option value="23">23<option value="24">24<option value="25">25
										<option value="26">26<option value="27">27<option value="28">28<option value="29">29<option value="30">30
										<option value="31">31
									</select>
									<select name="mes" class="inputy">
										<option value="Jan" <% if datePart("m", date()) = "11" then response.write("selected") end if%>Janeiro
										<option value="Fev" <% if datePart("m", date()) = "12" then response.write("selected") end if%>Fevereiro
										<option value="Mar" <% if datePart("m", date()) = "1" then response.write("selected") end if%>Mar&ccedil;o
										<option value="Abr" <% if datePart("m", date()) = "2" then response.write("selected") end if%>Abril
										<option value="Mai" <% if datePart("m", date()) = "3" then response.write("selected") end if%>Maio
										<option value="Jun" <% if datePart("m", date()) = "4" then response.write("selected") end if%>Junho
										<option value="Jul" <% if datePart("m", date()) = "5" then response.write("selected") end if%>Julho
										<option value="Ago" <% if datePart("m", date()) = "6" then response.write("selected") end if%>Agosto
										<option value="Set" <% if datePart("m", date()) = "7" then response.write("selected") end if%>Setembro
										<option value="Out" <% if datePart("m", date()) = "8" then response.write("selected") end if%>Outubro
										<option value="Nov" <% if datePart("m", date()) = "9" then response.write("selected") end if%>Novembro
										<option value="Dez" <% if datePart("m", date()) = "10" then response.write("selected") end if%>Dezembro
									</select>
									<select name="ano" class="inputy">
										<option value="2005">2005
										<option value="2006">2006
									</select>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			    <tr> 
			    	<td valign=middle align=right><b class="red">Materninade: </b></td>
			        <td> 
			        	<input type=text name=maternidade size=40 value="" class="inputy">
					</td>
				</tr>
			    <tr> 
			    	<td valign=middle align=right><b class="red">Obstetra: </b></td>
			        <td> 
			        	<input type=text name=obstetra size=40 value="" class="inputy">
					</td>
				</tr>
			    <tr> 
			    	<td colspan=2>&nbsp;</td>
				</tr>
			    <tr> 
			    	<td colspan=2 align="center"> 
			        	<input type="Submit" value="ENVIAR" name="Submit" class="submit">
					</td>
				</tr>
			</table>
			
			</form></td>
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