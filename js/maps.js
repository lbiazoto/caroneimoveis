var mapaobj;
var geocoder;
var fantasiaGlobal;
var enderecoGlobal;
var gdir;

function inicializa(width, height) {
    mapaobj = new GMap2(document.getElementById("mapa"),{size:new GSize(width, height)});
    mapaobj.setCenter(new GLatLng(-16, -55), 13);
    //mapaobj.setMapType(G_HYBRID_MAP);
    geocoder = new GClientGeocoder();
}

function realizaConsulta(end,fantasia) {
    var endereco = end;
	enderecoGlobal = end;
	fantasiaGlobal = fantasia;
    geocoder.getLocations(endereco, resolverEnderecos);
}

function resolverEnderecos(resposta) {
    fantasia = fantasiaGlobal;
    if (!resposta || resposta.Status.code != G_GEO_SUCCESS)
	{
        alert("Nao foi possivel localizar o endereco solicitado");
    } else {
        var num_resultados = resposta.Placemark.length;
		var alvo = document.getElementById("locais");
		listarLocais(alvo, resposta.Placemark);
        // Caso haja m�ltiplos resultados, informa o fato ao usu�rio
        if (num_resultados > 1) {
			   alert('A sua consulta retornou resultados amb�g�os.' +
                    '\nEscolha a localidade mais adequada � consulta.');
        } else {
          // Obt�m uma refer�ncia ao endere�o retornado
          var local = resposta.Placemark[0];
          // Extrai o um objeto GLatLng representando as coordenadas
          var ponto = local.Point.coordinates;
          // Extrai a precis�o do endere�o. Accuracy � um n�mero que
          // indica se o endere�o retornado corresponde a um pa�s,
          // provincial, estado, cidade, bairro, rua, etc. Depende da
          // consulta que foi realizada. Com essa informa��o em m�os,
          // podemos decidir qual o n�vel de zoom mais adequado
          var acc = resposta.Placemark[0].AddressDetails.Accuracy;
		  centralizaMapa(ponto[1],ponto[0],resposta.Placemark[0].address, acc,fantasia);
       }
    }
}

function listarLocais(alvo, placemark) {

}



/*********************************************/
function showAddress(address, info, cont)
{
	if (geocoder)
	{
    	geocoder.getLatLng(
      		address,
      		function(point)
			{
        		if (!point)
				{
          			//alert(address + " not found");
        		}
				else
				{
          			var zoom = 15;
                    mapaobj.setCenter(point,zoom);
                    marcador = new GMarker(point);
                    mapaobj.addOverlay(marcador);
                    marcador.openInfoWindowHtml("<b align='left'> "+info+"</b><br>" + "" + "");
        		}
      		}
    	);
  	}
}