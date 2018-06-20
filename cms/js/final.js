// Função para iniciarmos o Ajax no browser do cliente.
function openAjax() {
	var ajax;
	try{
		ajax = new XMLHttpRequest(); // XMLHttpRequest para browsers decentes, como: Firefox, Safari, dentre outros.
	}catch(ee){
		try{
			ajax = new ActiveXObject("Msxml2.XMLHTTP"); // Para o IE da MS
		}catch(e){
			try{
				ajax = new ActiveXObject("Microsoft.XMLHTTP"); // Para o IE da MS
			}catch(E){
				ajax = false;
			}
		}
	}
	return ajax;
}

function carregaProdutoCombobox(campo) {
	campo=campo.value;
	alert(campo);
}

function calculaPorcentagem(){
	var precoVenda = document.getElementById("valorVenda").value.replace('.' , '');
	precoVenda = precoVenda.replace(',' , '.');

	var percentagem = document.getElementById("percentualCobranca").value.replace('.' , '');
	percentagem = percentagem.replace(',' , '.');

	if(precoVenda!=0)
	{
		var retornoRetido=(precoVenda*percentagem/100);
		var retorno=precoVenda-retornoRetido;
		if(retorno!=0)
		{
			document.getElementById("valorRepasse").value = float2Moeda(retorno);
			document.getElementById("valorRetido").value = float2Moeda(retornoRetido);
		}
		else
		{
			document.getElementById("valorRepasse").value = "0,00";
			document.getElementById("valorRetido").value = "0,00";
		}
	}
}
function float2Moeda(num) {
   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));   ret = num + ',' + cents;   if (x == 1) ret = ' - ' + ret; return ret;

}