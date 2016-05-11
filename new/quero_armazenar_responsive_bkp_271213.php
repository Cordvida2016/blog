<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="templates/yoo_venture/warp/css/system.css" rel="stylesheet" type="text/css">
<link href="templates/yoo_venture/styles/dove/css/style.css" rel="stylesheet" type="text/css" />
<link href="templates/yoo_venture/css/font2/yanonekaffeesatz.css" rel="stylesheet" type="text/css" />
<link href="templates/yoo_venture/warp/css/base.css" rel="stylesheet" type="text/css" />
<link href="templates/yoo_venture/css/font1/pt_sans.css" rel="stylesheet" type="text/css" />
<link href="templates/yoo_venture/css/bootstrap.css" rel="stylesheet" type="text/css" />


<title>Quero Armazenar</title>
<style type="text/css">
.titulo { font-family: "YanoneKaffeesatzLight", Arial, Helvetica, sans-serif; }

.txt{	font-family: "pt_sans_narrowregular", Arial, Helvetica, sans-serif;
	font-size: 15px; line-height: 17px;
}

@media (max-width: 400px) {
	.txt {font-size:12px; line-height:12px;}
}
/*.campos {
	font-family:"pt_sans_narrowregular", Arial, Helvetica, sans-serif;
	font-size:12px;
	background-color:#D8EDED !important;
	border:none !important;
	border-radius:7px;
	height:26px;
	margin-bottom:10px;

}*/

/*.campos2 {
	font-family:"pt_sans_narrowregular", Arial, Helvetica, sans-serif;
	font-size:12px;
	background-color:#D8EDED !important;
	border:none !important;
	border-radius:7px;
	padding-bottom:10px;

}*/

.campos {
background-color: #FFFFFF;
border: 1px solid #dedfe2;
border-top-color: #c8cacc;
border: 1px solid rgba(0,14,41,0.1);
border-top-color: rgba(0,14,41,0.2);
/*background-color: #f6f8fa;*/
box-shadow: 0 1px 4px rgba(0,14,41,0.1) inset;
}

</style>

</head>

<body style="background-color: transparent;">
<article class="item">
<!--  ----------------------------------------------------------------------  -->
<!--  NOTA: Adicione o elemento <FORM> a seguir à sua página.                 -->
<!--  ----------------------------------------------------------------------  -->

<form action="https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8" method="POST">

<input type=hidden name="oid" value="00DA0000000Kh5Q">
<input type=hidden name="retURL" value="http://cordvida.com.br/new/obrigado_form.html">

<!--  ----------------------------------------------------------------------  -->
<!--  NOTA: Estes campos são elementos de depuração opcionais. Remova o       -->
<!--  comentário dessas linhas se quiser testar no modo de depuração.         -->
<!--  <input type="hidden" name="debug" value=1>                              -->
<!--  <input type="hidden" name="debugEmail"                                  -->
<!--  value="max.assuncao@cordvida.com.br">                                   -->
<!--  ----------------------------------------------------------------------  -->
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div style="float:left; width:27%;"><label class="txt" for="first_name">Nome:</label></div>
    <div style="float:left; width:60%;"><input name="first_name" type="text" class="campos"  id="first_name" size="30" maxlength="40" /></div>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div style="float:left; width:27%;"><label class="txt" for="last_name">Sobrenome:</label></div>
    <div style="float:left; width:60%;"><input name="last_name" type="text" class="campos"  id="last_name" size="30" maxlength="80" /></div>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div style="float:left; width:27%;"><label class="txt" for="email">Email:</label></div>
    <div style="float:left; width:60%;"><input name="email" type="text" class="campos"  id="email" size="30" maxlength="80" /></div>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div style="float:left; width:27%;"><label class="txt" for="phone">Telefone (com DDD):</label></div>
    <div style="float:left; width:60%;"><input name="phone" type="text" class="campos"  id="phone" size="30" maxlength="40" /></div>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div style="float:left; width:27%;"><label class="txt" for="street">Endereço:</label></div>
    <div style="float:left; width:60%;"><textarea name="street" cols="40" rows="1" class="campos"></textarea></div>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div style="float:left; width:27%;"><label class="txt" for="city">Cidade:</label></div>
    <div style="float:left; width:60%;"><input name="city" type="text" class="campos"  id="city" size="30" maxlength="40" /></div>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div style="float:left; width:27%;">Estado:</div>
    <div style="float:left; width:60%;"><input name="00NA00000047P9Z" type="text" class="campos"  id="00NA00000047P9Z" size="30" maxlength="255" /></div>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div style="float:left; width:27%;"><label class="txt" for="zip">CEP:</label></div>
    <div style="float:left; width:60%;"><input name="zip" type="text" class="campos"  id="zip" size="30" maxlength="20" /></div>
</div>
<br/>

<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div class="txt" style="float:left; width:27%;">Data prevista do parto:</div>
    <div style="float:left; width:60%;"><span class="dateInput dateOnlyInput">
      <input name="name="00NA0000003HnCk" type="text" class="campos"  id="00NA0000003HnCk" size="12" />
    </span></div>
    <label hidden="" for="lead_source">Origem do lead</label>
                                          <select style="visibility: hidden; display: none;" select="" id="lead_source" name="lead_source">
                                            <option value="Site quero armazenar">Site quero armazenar</option>
                                          </select>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div class="txt" style="float:left; width:27%;">Onde ouviu falar da CordVida:</div>
    <div style="float:left; width:60%;"><select class="txt" name="00NA0000007ivVy"  id="00NA0000007ivVy" title="Onde ouviu falar da CordVida"><option value="">-- Nenhum --</option>
      <option value="Indicação">Indicação</option>
      <option value="Internet">Internet</option>
      <option value="Jornal">Jornal</option>
      <option value="Rádio">Rádio</option>
      <option value="Revista">Revista</option>
      <option value="TV">TV</option>
      <option value="Outros">Outros</option>
    </select></div>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div class="txt" style="float:left; width:27%;">Gostaria de visitar a CordVida:</div>
    <div style="float:left; width:60%;"><input  id="00NA0000007ivaG" name="00NA0000007ivaG" type="checkbox" value="1" /></div>
</div>
<br/>
<div style="float:left; width:100%; border:0; min-height:20px; vertical-align:middle; margin-left:0px">
    <div style="float:right; width:30%;"><input name="submit" type="submit" value="Enviar" /></div>
    
</div>
<br/>
</form>
</article>
</body>

