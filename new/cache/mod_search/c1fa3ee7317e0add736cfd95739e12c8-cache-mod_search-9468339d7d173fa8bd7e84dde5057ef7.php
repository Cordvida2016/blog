<?php die("Access Denied"); ?>#x#a:2:{s:6:"output";a:2:{s:4:"body";s:0:"";s:4:"head";a:0:{}}s:6:"result";s:815:"
<form id="searchbox-40" class="searchbox" action="/new/obrigado3" method="post" role="search">
	<input type="text" value="" name="searchword" placeholder="pesquisar..." />
	<button type="reset" value="Reset"></button>
	<input type="hidden" name="task"   value="search" />
	<input type="hidden" name="option" value="com_search" />
	<input type="hidden" name="Itemid" value="435" />	
</form>

<script src="/new/templates/yoo_venture/warp/js/search.js"></script>
<script>
jQuery(function($) {
	$('#searchbox-40 input[name=searchword]').search({'url': '/new/component/search/?tmpl=raw&amp;type=json&amp;ordering=&amp;searchphrase=all', 'param': 'searchword', 'msgResultsHeader': 'Resultados da Pesquisa', 'msgMoreResults': 'Mais Resultados', 'msgNoResults': 'Nenhum resultado encontrado'}).placeholder();
});
</script>";}