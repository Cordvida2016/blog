<?php die("Access Denied"); ?>#x#a:4:{s:4:"body";s:8259:"
<div id="system">

	
	<article class="item" data-permalink="http://cordvida.com.br/new/planos-servicos/condicoes-comerciais">

		
				<header>

										
								
			<h1 class="title">Condições Comerciais</h1>

			
		</header>
			
		
		<div class="content clearfix">

		
<script type="text/javascript">

jQuery(document).ready(function(){



  jQuery("input[name='tipo'],input[name='tecnologia'],input[name='periodo']").change(function(){

    atualizaValores();

  });



  atualizaValores = function(){





    var tipo = jQuery("input[name='tipo']:checked").val();

    var periodo = jQuery("input[name='periodo']:checked").val();

    var tecnologia = jQuery("input[name='tecnologia']:checked").val();

    

    if (tipo == 'tecidocordao'){

      tecnologia = 'altaeficiencia';

       jQuery("input[name='tecnologia'][value='altaeficiencia']").attr('checked', 'checked');

       jQuery("input[name='tecnologia'][value='bioarquivo']").attr('disabled', true);

      

      }else{

             jQuery("input[name='tecnologia'][value='bioarquivo']").attr('disabled', false);

        }

  

    var valores = {

      sanguecordao: {

        altaeficiencia: ['R$ 2.800,00*','R$ 2.800,00*','R$ 2.800,00*','R$ 2.800,00*'],

        bioarquivo: ['R$ 4.400,00*','R$ 4.400,00*','R$ 4.400,00*','R$ 4.400,00*']

      },

      tecidocordao: {

        altaeficiencia: ['R$ 3.150,00*','R$ 3.150,00*','R$ 3.150,00*','R$ 3.150,00*'],

        bioarquivo: ['Indisponível.','Indisponível.','Indisponível.','Indisponível.']

      },

      sanguetecidocordao: {

        altaeficiencia: ['R$ 5.400,00*','R$ 5.400,00*','R$ 5.400,00*','R$ 5.400,00*'],

        bioarquivo: ['R$ 7.000,00*','R$ 7.000,00*','R$ 7.000,00*','R$ 7.000,00*']

      }

      

    };



    var valores_arm = {

      sanguecordao: {

        altaeficiencia: ['R$ 650,00','R$ 2.925,00','R$ 5.525,00','R$ 9.360,00'],

        bioarquivo: ['R$ 850,00','R$ 3.825,00','R$ 7.225,00','R$ 12.240,00']

      },

      tecidocordao: {

        altaeficiencia: ['R$ 650,00','R$ 2.925,00','R$ 5.525,00','R$ 9.360,00'],

        bioarquivo: ['Indisponível','Indisponível','Indisponível','Indisponível']

      },

      sanguetecidocordao: {

        altaeficiencia: ['R$ 1.300,00','R$ 5.850,00','R$ 11.050,00','R$ 18.720,00'],

        bioarquivo: ['R$ 1.500,00','R$ 6.750,00','R$ 12.750,00','R$ 21.600,00']

      }



    };



    var valores_tot = {

      sanguecordao: {

        altaeficiencia: ['R$ 3.450,00','R$ 5.725,00','R$ 8.325,00','R$ 12.160,00'],

        bioarquivo: ['R$ 5.250,00','R$ 8.225,00','R$ 11.625,00','R$ 16.640,0']

      },

      tecidocordao: {

        altaeficiencia: ['R$ 3.800,00','R$ 6.075,00','R$ 8.675,00','R$ 12.510,00'],

        bioarquivo: ['Indisponível','Indisponível','Indisponível','Indisponível']

      },

      sanguetecidocordao: {

        altaeficiencia: ['R$ 6.700,00','R$ 11.250,00','R$ 16.450,00','R$ 24.120,00'],

        bioarquivo: ['R$ 8.500,00','R$ 13.750,00','R$ 19.750,00','R$ 28.600,00']

      }

    };





    jQuery('#valor-final').html(valores[tipo][tecnologia][periodo]);

    jQuery('#valor-final-arm').html(valores_arm[tipo][tecnologia][periodo]);

    jQuery('#valor-final-tot').html(valores_tot[tipo][tecnologia][periodo]);

  };



  atualizaValores();

});



</script>



<p><span class="tit_planoseservicos">O valor do investimento &eacute; composto por:</span></p>

<ul class="checkpetroleo">

  <li>Uma taxa para cobrir os custos da coleta e do processamento, incluindo o procedimento no hospital, o material, o transporte, o processamento em nosso laborat&oacute;rio e todos os testes.</li>

  <li>Uma taxa de armazenamento das c&eacute;lulas que pode ser paga anualmente ou a cada 5, 10 ou 18 anos, com respectivos descontos.</li>

</ul>

<div class="condcomerc">

<div class="blocofull">

<div class="tit_condcom"> Tipo de Serviço: <a data-lightbox="group:maisinfo1" href="tipodeservico.html" title="Tipo de Serviço"><img src="images/cordvida/icones/maisinfo.png" alt="Mais informações" border="0" align="absmiddle" /></a></div>

<div class="bloco"><input type="radio" name="tipo" value="sanguecordao" checked="CHECKED" /><span class="alinhabloco"> 

Células-tronco do <strong>sangue do cordão</strong></span></div>

<div class="bloco"> <input type="radio" name="tipo" value="tecidocordao" /><span class="alinhabloco">

C&eacute;lulas-tronco do <strong>tecido do cord&atilde;o</strong></span></div>

<div class="bloco"> <input type="radio" name="tipo" value="sanguetecidocordao" /><span class="alinhabloco">

C&eacute;lulas-tronco do sangue + <strong>tecido do cord&atilde;o</strong></span></div>

</div>





<div class="blocofull">

<div class="tit_condcom"> Tecnologia de Armazenamento: <a data-lightbox="on" href="tecnologiadearmazenamento.html" title="Tecnologia de Armazenamento"><img src="images/cordvida/icones/maisinfo.png" alt="Tecnologia de Armazenamento" border="0" align="absmiddle"  /></a></div>

<div class="bloco"> 

  <input type="radio" name="tecnologia" value="altaeficiencia" checked="checked" /><span class="alinhabloco">

  Alta efici&ecirc;ncia</span></div>

<div class="bloco"> 

  <input type="radio" name="tecnologia" value="bioarquivo" /><span class="alinhabloco">

  BioArquivo (<strong>somente sangue do cord&atilde;o</strong>)</span></div>

 </div>



<div class="blocofull">

  <div class="tit_condcom">Planos de Armazenamento: <a data-lightbox="on" href="planosdearmazenamento.html" title="Planos de Armazenamento"><img src="images/cordvida/icones/maisinfo.png" alt="Planos de Armazenamento" border="0" align="absmiddle"  /></a></div>

<div class="bloco"> 

  <input type="radio" name="periodo" value="0" checked="checked" /><span class="alinhabloco">

Anual</span></div>

<div class="bloco"> 

  <input type="radio" name="periodo" value="1" />
  <span class="alinhabloco">

  5 anos&nbsp; - 10% de desconto</span></div>

<div class="bloco"> 

  <input type="radio" name="periodo" value="2" />
  <span class="alinhabloco">

  10 anos &ndash; 15% de desconto</span></div>

<div class="bloco"> 

  <input type="radio" name="periodo" value="3" />
  <span class="alinhabloco">

  18 anos &ndash; 20% de desconto</span></div>

 </div> 



</div>

<div class="condcomerc tit_val">

<div class="emlinha">

  <div class="tit_condcom">Valores:</div>

</div>

<div class="emlinha">

  <div class="blocototal"><span id="valor-final" class="totalcond">R$ 2.650,00</span> Tx coleta e processamento <a data-lightbox="on" href="planobasico.html" title="Plano Básico"><img src="images/cordvida/icones/maisinfo.png" alt="Plano Básico" border="0" align="absmiddle"  /></a></div>

</div>

<div class="blocototal">

  <div><span class="totalcond" id="valor-final-arm">R$ 650,00</span> Tx  armazenamento <a data-lightbox="on" href="anuidade.html" title="Anuidade"><img src="images/cordvida/icones/maisinfo.png" alt="Anuidade" border="0" align="absmiddle" /></a></div>

</div>

<div class="emlinha">

  <div style="height:10px; margin-top:-20px">

  <hr size="1" />

  </div>

</div>

<div class="emlinha">

  <div class="blocototal"><span class="totalcond" id="valor-final-tot">R$ 3.500,00</span> Total do Investimento</div>

</div>

<div class="emlinha">

  <div>ATEN&Ccedil;&Atilde;O:<br />

    * Pre&ccedil;o sujeito a altera&ccedil;&otilde;es dependendo da localidade da coleta.<br />

* H&aacute; condi&ccedil;&otilde;es especiais para j&aacute; clientes, m&eacute;dicos, gesta&ccedil;&atilde;o de m&uacute;ltiplos, etc. </div>

</div>

<div class="emlinha">

  <div><span style="font-size:11px;">A taxa de armazenamento &eacute; corrigida segundo a varia&ccedil;&atilde;o do IGPM.</span></div>

</div>



</div>

<br/>

  <div><a class="button-default float-right" style="margin-top: 7px;" title="Mais info!" href="http://materiais.cordvida.com.br/fale-com-um-consultor">Quero Falar com um Consultor</a></div> 		</div>

								
		
		
		
			
	</article>

</div>";s:4:"head";a:11:{s:5:"title";s:22:"Condições Comerciais";s:11:"description";s:145:"  O valor do investimento é composto por:   Uma taxa para cobrir os custos da coleta e do processamento, incluindo o procedimento no hospital, o";s:4:"link";s:0:"";s:8:"metaTags";a:2:{s:10:"http-equiv";a:1:{s:12:"content-type";s:24:"text/html; charset=utf-8";}s:8:"standard";a:3:{s:8:"keywords";s:387:"células-tronco, celula tronco,  cordão umbilical, sangue, tecido cordão umbilical, células mesenquimais, criopreservação, celulas tronco, banco de cordão, tanque de armazenamento, coleta de celula tronco, banco de celula tronco, bioarchive, coleta, doenças trataveis, o que é célula tronco, sangue do cordão, diabetes tipo 1, céulas tronco no brasil, tudo sobre celula tronco";s:6:"rights";N;s:6:"author";s:10:"Super User";}}s:5:"links";a:1:{s:75:"http://cordvida.com.br/new/para-a-mamae/historias-de-vida?catid=0&amp;id=44";a:3:{s:8:"relation";s:9:"canonical";s:7:"relType";s:3:"rel";s:7:"attribs";a:0:{}}}s:11:"styleSheets";a:2:{s:57:"/new/plugins/editors/jckeditor/typography/typography2.php";a:3:{s:4:"mime";s:8:"text/css";s:5:"media";N;s:7:"attribs";a:0:{}}s:31:"/new/media/system/css/modal.css";a:3:{s:4:"mime";s:8:"text/css";s:5:"media";N;s:7:"attribs";a:0:{}}}s:5:"style";a:0:{}s:7:"scripts";a:4:{s:37:"/new/media/system/js/mootools-core.js";a:3:{s:4:"mime";s:15:"text/javascript";s:5:"defer";b:0;s:5:"async";b:0;}s:28:"/new/media/system/js/core.js";a:3:{s:4:"mime";s:15:"text/javascript";s:5:"defer";b:0;s:5:"async";b:0;}s:37:"/new/media/system/js/mootools-more.js";a:3:{s:4:"mime";s:15:"text/javascript";s:5:"defer";b:0;s:5:"async";b:0;}s:29:"/new/media/system/js/modal.js";a:3:{s:4:"mime";s:15:"text/javascript";s:5:"defer";b:0;s:5:"async";b:0;}}s:6:"script";a:1:{s:15:"text/javascript";s:142:"
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});
			SqueezeBox.assign($$('a.modal'), {
				parse: 'rel'
			});
		});";}s:6:"custom";a:0:{}s:10:"scriptText";a:0:{}}s:7:"pathway";s:1:"
";s:6:"module";a:0:{}}