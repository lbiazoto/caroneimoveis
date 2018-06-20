<script type="text/javascript">
	hs.graphicsDir = 'highslide/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>
<?php
$linha = devolveInfoSite("imoveis", $id);
if($linha['deletado']==1){
	print("<script type='text/javascript'>window.location='index.php';</script>");
}
$valor = "R$ ".devolveValor($linha['valor']);
$_SESSION['id_detalhe']=$linha['id'];
?>

<table width="100%" cellpadding="0" cellspacing="0" style="background:url(images/titulos_site_02.jpg) top right no-repeat;">
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left">
			<a href="javascript:history.go(-1);" style="float:right; margin-top:-3px; margin-right: 10px;"><img src="images/voltar2.jpg" alt="Voltar" title="Voltar"></a>
			<img src="images/imoveis_maisdetalhes_16.jpg" border="0" style="margin-left:20px;">

		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr><!-- bgcolor="#93AD4A"-->
		<td style="padding:10px;">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="35%" align="center" valign="middle">
						<?php
						if($linha['imagem']) {
							print("
							    <a href='imoveis/g_$linha[imagem]' id='thumb$cont' title='$linha[nome]' class='highslide' onclick=\"return hs.expand(this)\">
									<img src='imoveis/g_$linha[imagem]' border='0' style='width:310px; max-height:280px; border:1px solid #93AD4A;'>
								</a>
							");
						}
						print("
							    <table align='left' width='100%' cellpadding='2' cellspacing='2' border='0' id='detalhes'><!--  bgcolor='#C3D88B' -->
							    	<tr><td>&nbsp;</td></tr>
									<tr><td align='right' style='background:url(images/titulos_site_26.jpg) left no-repeat;'><span class='valorImovel'>$valor</span></td></tr>
								</table>
							");
						?>
            		</td>
                    <td width="65%" align="center" valign="top">
						<?php
						$categoria=devolveInfo("categorias", $linha['idCategoria']);
						print("
							    <table align='left' width='100%' cellpadding='2' cellspacing='2' border='0' id='detalhes' style='margin-top:0px;'><!--  bgcolor='#C3D88B' -->
									<tr><td valign='top' align='left'><span class='referencia'>$categoria[nome]</span></td></tr>
									<tr><td valign='top' align='left'><span class='referencia' style='font-size:10pt;'>CI: $linha[referencia]</span></td></tr>
								</table>
							");
						if($linha['descricaoCompleta']) {
							print("
							<BR>
							    <table align='left' width='100%' cellpadding='2' cellspacing='2' border='0' id='detalhes' style='margin-top:30px;'><!--  bgcolor='#C3D88B' -->
									<tr><td valign='top' align='left'>$linha[descricaoCompleta]</td></tr>
								</table>
							");
						}
						?>
            		</td>
        		</tr>
        		<tr>
        			<td>
						<script src='http://connect.facebook.net/en_US/all.js'></script>
						<input type="button" value="Compartilhar" onclick='postToFeed();' style="float:left; cursor: pointer; background-color:#5f78ab; color:#fff; font-family: 'lucida grande',tahoma,verdana,arial,sans-serif; font-size: 11px; font-weight: bold; line-height: 22px; padding:2px 4px; margin:0 13px 0 0;" />
						<?php
						include("cms/config.php");
						$caption = "";
						if($linha['idCidade']!=""){
							$cidade = devolveInfoSite("cidades", $linha['idCidade']);
							$caption .= $cidade['nome'];
						}
						if($linha['idRegiao']!=""){
							$regiao = devolveInfoSite("regiao", $linha['idRegiao']);
							$caption .= " / ".$regiao['nome'];
						}
						if($linha['idBairro']!=""){
							$bairro = devolveInfoSite("bairros", $linha['idBairro']);
							$caption .= " / ".$bairro['nome'];
						}
						print("
							<script>
								FB.init({appId: \"131679043655559\", status: true, cookie: true});

								function postToFeed() {

									// calling the API ...
									var obj = {
										method: \"feed\",
										redirect_uri: \"$enderecoCompleto/close.html\",
										link: \"$enderecoCompleto/index.php?site=detalhes&id=$id\",
										picture: \"$enderecoCompleto/imoveis/p_$linha[imagem]\",
										name: \"Carone Corretora de Imóveis\",
										caption: \"$caption\",
										description: \"". urldecode(str_replace("%0D%0A", "%20", urlencode($linha['descricaoCurta'])))."\"
									};

									function callback(response) {
										document.getElementById(\"msg\").innerHTML = \"Post ID: \" + response[\"post_id\"];
									}

									FB.ui(obj, callback);
								}
							</script>
						");
						?>
						<a href="https://twitter.com/share" class="twitter-share-button" data-related="jasoncosta" data-lang="pt" data-size="large" data-count="none">Tweetar</a>
						<script>
							!function(d,s,id){
								var js,fjs=d.getElementsByTagName(s)[0];
								if(!d.getElementById(id)){
									js=d.createElement(s);
									js.id=id;
									js.src="https://platform.twitter.com/widgets.js";
									fjs.parentNode.insertBefore(js,fjs);
								}
							}
							(document,"script","twitter-wjs");
						</script>
        			</td>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						    <tr>
						    	<td>
									<table align="right" border="0" cellspacing="5" cellpadding="5" style="float:right;">
									    <tr>
									      <td align="right" valign="top"><a href="index.php?site=pesquisa"><img src="images/imoveis-detalhados_13.jpg" alt="Pesquisar" width="150" height="25" border="0" /></a></td>
										  <td align="right" valign="top"><a href="detalhesImpressao.php?id=<?php echo $id; ?>" target="_blank"><img src="images/imoveis-detalhados_15.jpg" alt="Imprimir" width="71" height="25" border="0" /></a></td>
									      <td align="right" valign="top"><a href="index.php?site=indique&id=<?php echo $id; ?>"><img src="images/imoveis-detalhados_17.jpg" alt="Indicar este Im&oacute;vel" width="131" height="25" border="0"/></a></td>
									      <td align="right" valign="top"><a href="index.php?site=solicite&id=<?php echo $id; ?>"><img src="images/imoveis-detalhados_19.jpg" alt="Solicitar Mais Informa&ccedil;&otilde;es" width="174" height="25" border="0" /></a></td>
								        </tr>
							        </table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
            </table>
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" id="detalhes">
				<?php
				if(existeFotos($linha['id']))
				{/*$linha[video]&amp;autoplay=1&amp;rel=0&amp;wmode=transparent*/
					if($linha['video']!="")
						$img_titulo="<img src='images/titulos_site_11.jpg'>";
					else
						$img_titulo="<img src='images/_titulos_site_11.jpg'>";
					print("
						<tr><th align='left'><h2>$img_titulo</h2></td></tr>
		                <tr>
		                	<td align='center'>
		                		<div class='highslide-gallery'>
									"); devolveVideo($linha[id]); print("
									");
									devolveFotos2($linha['id']); print("
								</div>
							</td>
		                </tr>
					");
				}
				?>
            </table>
            <table align="center" width="90%" cellpadding="0" cellspacing="0" border="0" id="detalhes">
				<?php
				if(existeComposicao($linha['id']))
				{
					print("
						<tr><th align='left'><h2><img src='images/titulos_site_12.jpg'></h2></td></tr>
		                <tr><td>"); devolveComposicao($linha['id']); print("</td></tr>
					");
				}
				if($linha['maisInformacoes'])
				{
					$info=nl2br($linha['maisInformacoes']);
					print("
						<tr><th align='left' style='margin-top:30px; float:left; width:100%;'><h2><img src='images/titulos_site_14.jpg'></h2></td></tr>
		                <tr>
		                	<td>$info</td>
		                </tr>
					");
				}
				?>
            </table>
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" id="detalhes" style="margin-top:40px; float:left; width:100%;">
				<tr><th align="left"><img src="images/titulos_site_08.jpg"></td></tr>
				<tr>
			    	<td style="padding:10px;" align="left" valign="middle">
			    		<?php
			    		$localizacao="";
			    		$localizacaoSite="";
			    		if($linha['idCidade']!="")
			    		{
			    			$cidade = devolveInfoSite("cidades", $linha['idCidade']);
			    			$localizacao.=" $cidade[nome] ";
			    			$localizacaoSite.=" $cidade[nome] ";
			    		}
			    		if($linha['idRegiao']!="" && $linha['idRegiao']!="0")
			    		{
			    			$regiao = devolveInfoSite("regiao", $linha['idRegiao']);
			    			$localizacao.=" / Região $regiao[nome] ";
			    			$localizacaoSite.=" / Região $regiao[nome] ";
			    		}
			    		if($linha['idBairro']!="" && $linha['idBairro']!="0")
			    		{
			    			$bairro = devolveInfoSite("bairros", $linha['idBairro']);
			    			$localizacao.=" / $bairro[nome] ";
			    			$localizacaoSite.=" / $bairro[nome] ";
			    		}
			    		if($linha['endereco']!="")
			    		{
			    			$localizacao.=" / $linha[endereco] ";
			    		}
			    		print("$localizacaoSite");
			    		?>
					</td>
				</tr>
				<tr>
			    	<td style="text-align:center;">
						<?php $endereco = "BR, $cidade[nome], $bairro[nome], $linha[endereco]"; ?>
						<div id="mapa" style="widht: 100%; height:350px; margin: 0px; padding: 0px; border:1px solid #999;overflow:hidden"></div>
						<!--caroneimoveis.com.br - ABQIAAAAiIZRoZbslJAsDBGkEn9GbBT2n4v0MHtMSW_vrbvpJZ7Lu3LsyBSj84pq9__Y9_9ysPqi-EO3XfvDcQ-->
						<!--server: ABQIAAAAp6ATGQuwk18B6iDfzxqlKRQaOzcbF5ealenFI9Pv5eWXfr2UbRSDRuGF67P9wNsN0x9l3y1i9bXLWg-->
						<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAiIZRoZbslJAsDBGkEn9GbBT2n4v0MHtMSW_vrbvpJZ7Lu3LsyBSj84pq9__Y9_9ysPqi-EO3XfvDcQ" type="text/javascript"></script>
						<script type="text/javascript">
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
						        // Caso haja múltiplos resultados, informa o fato ao usuário
						        if (num_resultados > 1) {
									   alert('A sua consulta retornou resultados ambígüos.' +
						                    '\nEscolha a localidade mais adequada à consulta.');
						        } else {
						          // Obtém uma referência ao endereço retornado
						          var local = resposta.Placemark[0];
						          // Extrai o um objeto GLatLng representando as coordenadas
						          var ponto = local.Point.coordinates;
						          // Extrai a precisão do endereço. Accuracy é um número que
						          // indica se o endereço retornado corresponde a um país,
						          // provincial, estado, cidade, bairro, rua, etc. Depende da
						          // consulta que foi realizada. Com essa informação em mãos,
						          // podemos decidir qual o nível de zoom mais adequado
						          var acc = resposta.Placemark[0].AddressDetails.Accuracy;
								  centralizaMapa(ponto[1],ponto[0],resposta.Placemark[0].address, acc,fantasia);
						       }
						    }
						}

						function listarLocais(alvo, placemark) {

						}
						function centralizaMapa(x, y, info, acc, fantasia)
						{
						    // Cria um ponto GLatLng
						    var p = new GLatLng(x,y);
						    // Obtém o nível de zoom conforme a precisão do endereço
						    var zoom = 15;
						    //var zoom = nivelZoom[acc];
						    // Define o novo centro do mapa e o seu novo nível de zoom
						    mapaobj.setCenter(p,zoom);
						    <?php
						    if($linha[marcador]==1){
						    	print("
								    // Cria um novo marcador que sera exibido no ponto p solicitado
								    marcador = new GMarker(p);
								    // Adiciona o marcador ao mapa
								    mapaobj.addOverlay(marcador);
								    // Exibe uma caixa de informação com o texto informado
								    marcador.openInfoWindowHtml(\"<b align='left'> \"+fantasia+\"</b><br>\" + \"\" + \"\");
								");
						    }
						    ?>
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
										    <?php
										    if($linha[marcador]==1){
										    	print("
								                    marcador = new GMarker(point);
								                    mapaobj.addOverlay(marcador);
								                    marcador.openInfoWindowHtml(\"<b align='left'> \"+info+\"</b><br>\" + \"\" + \"\");
												");
										    }
										    ?>
						        		}
						      		}
						    	);
						  	}
						}

						var widthMapa = 850;
						var heightMapa = 350;
						inicializa(widthMapa, heightMapa);

						<?php
						if($linha['localizacao_mapa']!=""){
							print("showAddress(\"$linha[localizacao_mapa]\", \"<img src='imoveis/m_$linha[imagem]' $height border='0'>\", \"$cont\");");
						}
						else{
							print("realizaConsulta(\"$endereco\", \"<img src='imoveis/m_$linha[imagem]' $height border='0'>\");");
						}
						?>
						</script>

					</td>
			    </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>