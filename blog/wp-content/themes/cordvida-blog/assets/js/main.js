$(document).ready(function(){
    
    // Link para site principal
    $("#menu-item-15 a").attr('target','_blank');
    
    //Placeholder para a busca no menu
    $("#menu #s").attr("placeholder","Pesquisar:");

    $(window).load(function() {
    	var $campo = $('.hs-input'),
            $imagemBio = $('.minibio .foto'),
            $imagemCol = $('#colunaDoEspecialista a');

        $imagemBio.css('height', $imagemBio.width());
        $imagemCol.css('height', $imagemCol.width());
    	
		$campo.keyup(function() {
			if ($(this).val() != '') {
				$(this).css({borderColor : '#93D0CF', margin : '6px 0 14px', boxShadow : '0 4px 0 #4D7977'});
				$('.hs-button').css({marginTop : '6px', boxShadow : '0 4px #4D7977', backgroundColor : '#93D0CF', color : '#4D7977', border : '#93D0CF'});
			}
		});
    });

    
});

