
function validar(form){
	var expReg = /^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[1-2][0-9]\d{2})$/;
	var msgErro = 'Formato inválido de data.';
	var msgdata = 'A data precisa ser maior que a data atual.';
	//var data_a = getTimestamp();

        if(form[6].value == ''){
            alert("O campo DATA PREVISTA DO PARTO é obrigatório.");
			form[6].focus();
            return false;
			} else {
        	if (form[6].value.match(expReg)) {
				
				var dia = form[6].value.substring(0,2);
				var mes = form[6].value.substring(3,5);
				var ano = form[6].value.substring(6,10);
				hoje = new Date();
				dia_a = hoje.getDate();
				mes_a = hoje.getMonth();
				ano_a = hoje.getFullYear();
				var data_menor = false;
				if (ano < ano_a) {
					data_menor = true;
				} else {
					if ((ano == ano_a) && (mes < mes_a)) {
						data_menor = true;
					} else {
						if ((dia <= dia_a) && (mes == mes_a)) {
							data_menor = true;
							
						}
					}
				}
				
				if (data_menor) {
					alert(msgdata);
					form[6].focus();
					return false;
				}
				return true;
				} else {
					alert(msgErro);
					form[6].focus();
					return false;
				}
			}
		}


/*



function validar(form){
	var expReg = /^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[1-2][0-9]\d{2})$/;
	var msgErro = 'Formato inválido de data.';

        if(form[6].value == ''){
            alert("O campo DATA PREVISTA DO PARTO é obrigatório.");
form[6].focus();
            return false;
        } else {
        	if (form[6].value.match(expReg)) {
		return true;
		} else {
		alert(msgErro);
        form[6].focus();
		return false;
		}
	
	}

}

*/