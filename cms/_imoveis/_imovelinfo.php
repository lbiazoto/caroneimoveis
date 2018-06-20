<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['imoveis'])
{
	include("func.php");

	$linha = devolveInfo("imoveis", $id);

	if($linha[deletado]==1)
		$tipo="removido";

	if($tipo=="detalhes" || $tipo=="")	$tituloH1="Imóveis - Detalhes";
	elseif($tipo=="editar")	$tituloH1="Imóveis - Editar";
	elseif($tipo=="removido")	$tituloH1="Imóveis - Excluir";
	elseif($tipo=="galeria")	$tituloH1="Imóveis - Galeria";
	elseif($tipo=="complementos")	$tituloH1="Imóveis - Complementos";


	if($modo == "alterarDestaque")
	{
		alterarDestaque($status, $idImagem);
	}

	if($modo=="adicionarFoto")
	{
		$campoimagem ="imagem";
		$valorcampo  = $_FILES[$campoimagem][name];
		if($valorcampo)
		{
			$imagem = uploadImagem("imagem", "../imoveis", 0, "");
			imageResize($imagem, "../imoveis", "p_", "120", "120");
			imageResize($imagem, "../imoveis", "m_", "230", "230");
			imageResize($imagem, "../imoveis", "g_", "800", "600");
			$imagem = end(explode('/', $imagem));
			unlink("../imoveis/$imagem");
		}
		$retorno=adicionarFotoImovel($imagem, $linha['id']);
		if($retorno)
		{
			$msg = "Imagem cadastrada com sucesso";
		}
		else
		{
			$msg = "Ocorreu uma falha durante o cadastro da imagem!";
		}
	}
	if($modo=="editarFoto")
	{
		if($imagem!="")
		{
			$linhaFoto = devolveInfo("galeriafotos", $idImagem);
			if($linhaFoto[imagem]!="")
			{
				$upload = explode(".", $linhaFoto[imagem]);
				$upload = substr($upload[0], 6, strlen($upload[0]));
				$imagem = uploadImagem("imagem", "../imoveis", $upload, $upload);
			}
			else
			{
				$imagem = uploadImagem("imagem", "../imoveis", 0, "");
			}
			imageResize($imagem, "../imoveis", "p_", "120", "120");
			imageResize($imagem, "../imoveis", "m_", "230", "230");
			imageResize($imagem, "../imoveis", "g_", "800", "600");
			$imagem = end(explode('/', $imagem));
			unlink("../imoveis/$imagem");
		}
		$retorno=editaFotoImovel($imagem, $idImagem);
		if($retorno)
		{
			$msg = "Imagem atualizada com sucesso";
		}
		else
		{
			$msg = "Ocorreu uma falha durante a atualização da imagem!";
		}
	}
	if($modo=="excluirFoto")
	{
		if(file_exists("../imoveis/$linha[imagem]"))	unlink("../imoveis/$linha[imagem]");
		$retorno=removeArquivoGaleria("galeriafotos", $idImagem);
		if($retorno==true)
			$msg="Imagem removida com sucesso!";
		else
			$msg="Erro ao remover Imagem!";
	}

	if($modo=="removerImagem")
	{
		if(file_exists("../imoveis/$linha[imagem]"))	unlink("../imoveis/$linha[imagem]");
		$retorno=removeImagem("imoveis", "imagem", $id);
		if($retorno==true)
			$msg="Imagem removida com sucesso!";
		else
			$msg="Erro ao remover Imagem!";
	}

	if($modo=="removerCroqui")
	{
		if(file_exists("../imoveis/m_$croqui"))	unlink("../imoveis/m_$croqui");
		if(file_exists("../imoveis/g_$croqui"))	unlink("../imoveis/g_$croqui");
		$retorno=removeCroqui($idComplemento);
		if($retorno==true)
			$msg="Imagem removida com sucesso!";
		else
			$msg="Erro ao remover Imagem!";
	}

	if($modo=="remover")
	{
		if(file_exists("../imoveis/$linha[imagem]"))	unlink("../imoveis/$linha[imagem]");
		$retorno=remove($id, $_SESSION['idUsuario']);
		if($retorno==true)
			$msg="Imóveis removida com sucesso!";
		else
			$msg="Erro ao remover Imóveis!";

		$tipo = "removido";
	}
	if($tipo=="removido")
	{
		print("<h1>Imóveis - Excluir</h1>");
		devolveMensagem("Imóveis removida com sucesso", $retorno);
		print("<br><br><div align='center'><p>Selecione a opção desejada no menu ao lado.</p></div>");
		$codigo="";
		return false;
	}
	if($modo=="editar")
	{
		$composicao=$_POST['composicao'];
		$linha = devolveInfo("imoveis", $id);
		$campoimagem ="imagem";
		$valorcampo  = $_FILES[$campoimagem];
		if($_FILES["imagem"]["name"]!="")
		{
			if($linha[imagem]!="")
			{
				$upload = explode(".", $linha[imagem]);
				$upload = substr($upload[0], 6, strlen($upload[0]));
				$imagem = uploadImagem("imagem", "../imoveis", $upload, $upload);
			}
			else
			{
				$imagem = uploadImagem("imagem", "../imoveis", 0, "");
			}
			imageResize($imagem, "../imoveis", "p_", "120", "120");
			imageResize($imagem, "../imoveis", "m_", "230", "230");
			imageResize($imagem, "../imoveis", "g_", "800", "600");
			$imagem = end(explode('/', $imagem));
			unlink("../imoveis/$imagem");
		}
		$valor=formataValor($valor);
		if(isset($destaque))	$destaque=1;	else	$destaque=0;
		if(isset($exclusivo))	$exclusivo=1;	else	$exclusivo=0;
		$retorno=editaImovel($referencia, $idCliente, $idCategoria, $idSubCategoria, $valor, $imagem, $estado, $opcaoCategoria, $listaSubCategoria, $listaSubCategoria2, $endereco, $descricaoCurta, $descricaoCompleta, $maisInformacoes, $destaque, $exclusivo, converteDataToMysql($dataTerminoExclusividade), converteDataToMysql($dataAviso), $composicao, $id);
		if($retorno)
			$msg = "Dados do Imóvel atualizados com sucesso!";
		else
			$msg = "Ocorreu uma falha durante a atualização do Imóvel!";
	}

	if($modo=="editarComplementos")
	{
		$complementoForm=$complemento;

		$complemento=devolveInformacoesComplementares($id);

		$venda=formataValor($venda);
		$locacao=formataValor($locacao);
		$condominio=formataValor($condominio);
		$tlu=formataValor($tlu);
		$iptu=formataValor($iptu);

		$finPoupanca=formataValor($finPoupanca);
		$finSaldoDevedor=formataValor($finSaldoDevedor);
		$finValorPrestacao=formataValor($finValorPrestacao);

		$campoimagem ="croqui";
		$valorcampo  = $_FILES[$campoimagem]['tmp_name'];
		if($valorcampo){
			if($complemento[croqui]!="")
			{
				unlink("../imoveis/m_$complemento[croqui]");
				unlink("../imoveis/g_$complemento[croqui]");
				$croqui = uploadImagem("croqui", "../imoveis", 0, "");
			}
			else
			{
				$croqui = uploadImagem("croqui", "../imoveis", 0, "");
			}
			imageResize($croqui, "../imoveis", "m_", "200", "200");
			imageResize($croqui, "../imoveis", "g_", "800", "600");
			$croqui = end(explode('/', $croqui));
			unlink("../imoveis/$croqui");
		}

		if($complemento['tipo']=="terrenos")
		{
			$retorno=atualizaInfoTerreno("terrenos", $id, $cep, $referencia, $complementoForm, $vizinho, $foneVizinho, $idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $classificacao,$indice, $venda, $locacao, $condominio, $tlu, $iptu, $areaTotal, $areaTerreno, $areaPreservacao, $areaHectares, $metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda, $finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $finCondPagamento, $finPendencias, $finPermuta, $edificado, $obsTerreno, $zoneamento, $numPavimentos, $croqui, $conContato, $conEmail, $conTelefone1, $conTelefone2, $conOutroContato, $conTelefoneOutro,$anuncio, $anuncioPontosFortes, $idComplemento);
		}
		elseif($complemento['tipo']=="residencias")
		{
			$valorLuz=formataValor($valorLuz);
			$valorAgua=formataValor($valorAgua);
			$retorno=atualizaInfoResidencias("residencias", $id, $cep, $referencia, $complementoForm, $condominioFechado, $numCasasCondominio, $idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $comissao, $indice, $venda, $locacao, $condominio, $tlu, $iptu, $valorLuz, $luzIndividual, $luzIdentificador, $valorAgua, $aguaIndividual, $aguaIdentificador, $areaTotal, $areaTerreno, $metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda, $finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $aptoUsoFgts, $finCondPagamento, $finPendencias, $finPermuta, $edificado, $obsTerreno, $acabamentos, $pintura, $piso, $mobilia, $anuncio, $anuncioPontosFortes, $idComplemento);
		}
		elseif($complemento['tipo']=="apartamentos")
		{
			$valorLuz=formataValor($valorLuz);
			$valorAgua=formataValor($valorAgua);
			$valorPoolLocacao=formataValor($poolLocacao);
			$valorRendimento=formataValor($rendimento);
			$valorTaxaMudanca=formataValor($taxaMudanca);
			$retorno=atualizaInfoApartamentos("apartamentos", $id, $cep, $referencia, $complementoForm, $edificio, $andar, $apartamento, $bloco, $construtora, $numPavimentos, $aptosAndar, $taxaMudanca, $portariaFone, $admCondominio, $admCondominioFone, $idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $comissao, $indice, $venda, $locacao, $valorPoolLocacao, $valorRendimento, $condominio, $tlu, $iptu, $valorLuz, $luzIndividual, $luzIdentificador, $valorAgua, $aguaIndividual, $aguaIdentificador, $areaTotal, $areaPrivativo, $areaGaragem, $areaComum, $metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda, $finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $aptoUsoFgts, $finCondPagamento, $finPendencias, $finPermuta, $acabamentos, $pintura, $piso, $mobilia, $anuncio, $anuncioPontosFortes, $idComplemento);
		}

		if($retorno)
			$msg = "Dados do Imóvel atualizados com sucesso!";
		else
			$msg = "Ocorreu uma falha durante a atualização do Imóvel!";
	}

	print("
		<h1>
			$tituloH1
		</h1>
	");

	if($msg!="")	devolveMensagem($msg, $retorno);

	$linha = devolveInfo("imoveis", $id);
	$usuarioCadastrou = devolveInfo("usuario", $linha[idUsuarioCadastro]);
	$usuarioAtualizou = devolveInfo("usuario", $linha[idUsuarioAtualizacao]);
	$dataCadastro = converteDataFromMysql($linha[dataCadastro]);
	$dataAtualizacao = converteDataHoraFromMysql($linha[dataAtualizacao]);

	if($linha[dataAtualizacao]=="")	$dataAtualizacao="Sem atualizações.";
	if($linha[idUsuarioAtualizacao]=="") $usuarioAtualizou="Sem atualizações."; else $usuarioAtualizou=$usuarioAtualizou[nome];

	if($tipo=="" || $tipo=="detalhes")
	{
		?>
		<script type="text/javascript">
		// remove the registerOverlay call to disable the controlbar
		hs.registerOverlay({
			thumbnailId: null,
			overlayId: 'controlbar',
			position: 'top right',
			hideOnMouseOut: true
		});
		hs.graphicsDir = 'highslide/graphics/';
		hs.outlineType = 'rounded-white';
		// Tell Highslide to use the thumbnail's title for captions
		hs.captionEval = 'this.thumb.title';
		</script>
		<?php
		if($linha['imagem'])
		{
			$verimagem = "<a href='../imoveis/g_$linha[imagem]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0' class='icone_botao'> $linha[imagem]</a>";
		}
		else
		{
			$verimagem="Não Cadastrada";
		}
		$estado=devolveEstado($linha['idEstado']);
		$cidade=devolveInfo("cidades", $linha['idCidade']);
		$regiao=devolveInfo("regiao", $linha['idRegiao']);
		$bairro=devolveInfo("bairros", $linha['idBairro']);
		$linha[descricaoCurta]=nl2br($linha[descricaoCurta]);
		$linha[maisInformacoes]=nl2br($linha[maisInformacoes]);
		$linha[valor]=devolveValor($linha[valor]);

		if($linha[destaque])	$destaque="Sim";	else	$destaque="Não";
		if($linha[exclusivo])
		{
			$dataTermino = converteDataFromMysql($linha['dataTerminoExclusividade']);
			$databd=$linha['dataTerminoExclusividade']; // coloque a data vinda do banco de dados
			$databd= explode("-",$databd);
			$data = mktime(0,0,0,$databd[1],$databd[2],$databd[0]);
			$data_atual = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$dias = ($data - $data_atual)/86400;
			$dias = ceil($dias);
			$exclusivo="Sim / Data Término: $dataTermino, restam $dias dias";
		}
		else
		{
			$exclusivo="Não";
		}

		$cliente=devolveInfo("cliente", $linha['idCliente']);

		$nomeCategoria=devolveInfoCampo("nome", "categorias", $linha['idCategoria']);
		$nomeSubcategoria=devolveInfoCampo("nome", "subcategorias", $linha['idSubCategoria']);

		if($cliente['tipoCliente']==1)	$tipoCliente="Comprador";
		elseif($cliente['tipoCliente']==2)	$tipoCliente="Vendedor";
		else	$tipoCliente="Não definido";

		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='60%'>&nbsp;</td>
					<td align='right'>
						<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&id=$id' title='Informações Complementares'>
							<div class='app_botao' style='margin:0px;'><img src='imagens/complementos.png' border='0' class='icone_botao'> Complementos</div>
						</a>
					</td>
					<td align='right'>
						<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=galeria&tipo2=fotos&id=$id' title='Fotos'>
							<div class='app_botao'><img src='imagens/fotos.png' border='0' class='icone_botao'> Fotos</div>
						</a>
					</td>
					<td align='right'>
						<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=editar&id=$id' title='Editar'>
							<div class='app_botao'><img src='imagens/editar.png' border='0' class='icone_botao'> Editar</div>
						</a>
					</td>
					<td align='right'>
						<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=&modo=remover&id=$id' onclick='return confirmaExclusao();' title='Excluir'>
							<div class='app_botao'><img src='imagens/delete.png' border='0' class='icone_botao'> Excluir</div>
						</a>
					</td>
				</tr>
			</table>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th align='left' width='50%'>Referência</th>
					<th align='left' width='50%'>Imagem</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$linha[referencia]</td>
					<td align='left'>&nbsp;$verimagem</td>
				</tr>
				<tr>
					<th align='left'>Categoria</th>
					<th align='left'>Sub Categoria</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$nomeCategoria</td>
					<td align='left'>&nbsp;$nomeSubcategoria</td>
				</tr>
				<tr>
					<th align='left'>Cliente</th>
					<th align='left'>Tipo de Cliente</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$cliente[nome]</td>
					<td align='left'>&nbsp;$tipoCliente</td>
				</tr>
				<tr>
					<th align='left'>Destaque</th>
					<th align='left'>Exclusivo</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$destaque</td>
					<td align='left'>&nbsp;$exclusivo</td>
				</tr>
				<tr>
					<th align='left' width='50%'>Estado</th>
					<th align='left' width='50%'>Cidade | Região</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$estado</td>
					<td align='left'>&nbsp;$cidade[nome] <b>|</b> $regiao[nome]</td>
				</tr>
				<tr>
					<th align='left'>Bairro</th>
					<th align='left'>Valor</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$bairro[nome]</td>
					<td align='left'>&nbsp;R$ $linha[valor]</td>
				</tr>
				<tr>
					<th align='left' colspan='2'>Endereço</th>
				</tr>
				<tr>
					<td align='left' colspan='2'>&nbsp;$linha[endereco]</td>
				</tr>
				<tr>
					<th align='left' colspan='2'>Descrição Curta</th>
				</tr>
				<tr>
					<td align='left' colspan='2'>&nbsp;$linha[descricaoCurta]</td>
				</tr>
				<tr>
					<th align='left' colspan='2'>Descrição Completa</th>
				</tr>
				<tr>
					<td align='left' colspan='2'>&nbsp;$linha[descricaoCompleta]</td>
				</tr>
				<tr>
					<th align='left' colspan='2'>Mais Informações</th>
				</tr>
				<tr>
					<td align='left' colspan='2'>&nbsp;$linha[maisInformacoes]</td>
				</tr>
			</table>
			");
			devolveListaComposicao($linha[id]);
			print("
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th align='left' width='50%'>Data de Cadastro</th>
					<th align='left' width='50%'>Data de Atualização</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$dataCadastro</td>
					<td align='left'>&nbsp;$dataAtualizacao</td>
				</tr>
				<tr>
					<th align='left'>Usuário que cadastrou</th>
					<th align='left'>Usuário que atualizou</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$usuarioCadastrou[nome]</td>
					<td align='left'>&nbsp;$usuarioAtualizou</td>
				</tr>
			</table>
		");
	}
	elseif($tipo=="galeria")
	{
		?>
		<script type="text/javascript">
		// remove the registerOverlay call to disable the controlbar
		hs.registerOverlay({
			thumbnailId: null,
			overlayId: 'controlbar',
			position: 'top right',
			hideOnMouseOut: true
		});
		hs.graphicsDir = 'highslide/graphics/';
		hs.outlineType = 'rounded-white';
		// Tell Highslide to use the thumbnail's title for captions
		hs.captionEval = 'this.thumb.title';
		</script>
		<?php
		if($linha[imagem])
		{
			$verimagem = "<a href='../imoveis/g_$linha[imagem]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0' class='icone_botao'> $linha[imagem]</a>";
		}
		else
		{
			$verimagem="Não Cadastrada";
		}
		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='90%' align='right'>
						<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=galeria&tipo2=fotos&id=$id' title='Fotos'>
							<div class='app_botao'><img src='imagens/fotos.png' border='0' class='icone_botao'> Fotos</div>
						</a>
					</td>
					<td align='right'>
						<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=&id=$id' title='Ver detalhes'>
							<div class='app_botao'><img src='imagens/ver_detalhes.png' border='0' class='icone_botao'> Ver detalhes</div>
						</a>
					</td>
				</tr>
			</table>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th align='left' width='50%'>Referência</th>
					<th align='left' width='50%'>Imagem</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$linha[referencia]</td>
					<td align='left'>&nbsp;$verimagem</td>
				</tr>
			</table>
		");
		if($tipo2=="fotos")
		{
			print("<h1>Galeria de Fotos</h1>");
			?>
			<form name="formCadastro" id="formCadastro" action="index.php?modulo=imoveis&acao=imovelinfo&tipo=galeria&tipo2=fotos&modo=adicionarFoto&id=<?php print("$id");?>" method="post" enctype="multipart/form-data">
			  	<fieldset>
			    	<legend>Adicionar Foto</legend>
			    	<table align="center" border="0" cellspacing="3" cellpadding="3">
						<tr>
							<th>Imagem:</th>
							<td><input type="file" name="imagem" id="imagem"></td>
						</tr>
						<tr valign="baseline">
							<td nowrap align="center" colspan="2">
								<input name="cadastrar" type="submit" id="form_submit" value="Cadastrar" onclick="return(campoObrigatorio(imagem));">
							</td>
						</tr>
					</table>
				</fieldset>
			</form>
			<script language="javascript">
				document.formCadastro.imagem.focus();
			</script>
			<?php
			devolveListaFotosImovel($linha[id]);
		}
		elseif($tipo2=="editarFoto")
		{
			$linhaFoto=devolveInfo("galeriafotos", $idImagem);
			?>
			<form name="formCadastro" id="formCadastro" action="index.php?modulo=imoveis&acao=imovelinfo&tipo=galeria&tipo2=fotos&modo=editarFoto&id=<?php print("$id&idImagem=$idImagem");?>" method="post" enctype="multipart/form-data">
			  	<fieldset>
			    	<legend>Editar Foto</legend>
			    	<table align="center" border="0" cellspacing="3" cellpadding="3">
						<tr>
							<th>Imagem:</th>
							<td><input type="file" name="imagem" id="imagem"></td>
						</tr>
						<tr>
						<th>Imagem atual:</th>
						<td>
							<?php
								if($linhaFoto[imagem]!="")
								{
									print("
									<a href='../imoveis/m_$linhaFoto[imagem]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0' title='Visualizar' class='icone_botao'> $linhaFoto[imagem]</a>
									");
								}
								else
								{
									print("Imagem não cadastrada");
								}
							?>
							</div>
						</td>
					</tr>
						<tr valign="baseline">
							<td nowrap align="center" colspan="2">
								<input name="cadastrar" type="submit" id="form_submit" value="Salvar" onclick="return(campoObrigatorio(imagem));">
							</td>
						</tr>
					</table>
				</fieldset>
			</form>
			<script language="javascript">
				document.formCadastro.imagem.focus();
			</script>
			<?php
		}
	}
	elseif($tipo=="editar")
	{
		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td align='right'>
						<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=&id=$id' title='Ver detalhes'>
							<div class='app_botao'><img src='imagens/ver_detalhes.png' border='0' class='icone_botao'> Ver detalhes</div>
						</a>
					</td>
				</tr>
			</table>
		");
		$linha = devolveInfo("imoveis", $id);

		$linha[valor]=devolveValor($linha[valor]);

		$bairro=devolveInfo("bairros", $linha['idBairro']);
		$regiao=devolveInfo("regiao", $bairro['idRegiao']);
		$cidade=devolveInfo("cidades", $regiao['idCidade']);

		$dataTerminoExclusividade = converteDataFromMysql($linha['dataTerminoExclusividade']);
		$dataAviso = converteDataFromMysql($linha['dataAviso']);

		?>
		<script type="text/javascript" src="mce/tiny_mce.js"></script>
		<script language="javascript" type="text/javascript">
		tinyMCE.init({
				mode : "specific_textareas",
				editor_selector : "mceEditor",
				theme : "simple",
				plugins : "style,layer,table,save,advhr,advimage,advlink,iespell,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,fullpage",
				theme_advanced_buttons2_add : "preview,separator,forecolor,backcolor,styleprops",
				theme_advanced_buttons3_add_before : "tablecontrols,separator",
				theme_advanced_buttons3_add : "emotions",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_path_location : "top",
				content_css : "example_full.css",
			    external_link_list_url : "example_link_list.js",
				external_image_list_url : "example_image_list.js",
				flash_external_list_url : "example_flash_list.js",
				media_external_list_url : "example_media_list.js",
				template_external_list_url : "example_template_list.js",
				file_browser_callback : "fileBrowserCallBack",
				theme_advanced_resize_horizontal : false,
				theme_advanced_resizing : true,
				nonbreaking_force_tab : true,
				apply_source_formatting : true,
				inline_styles : true,
				relative_urls : false,
				remove_script_host : false,
				valid_elements : ""
		+"a[accesskey|charset|class|coords|dir<ltr?rtl|href|hreflang|id|lang|name"
		  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rel|rev"
		  +"|shape<circle?default?poly?rect|style|tabindex|title|target|type],"
		+"abbr[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"acronym[class|dir<ltr?rtl|id|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"address[class|align|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"applet[align<bottom?left?middle?right?top|alt|archive|class|code|codebase"
		  +"|height|hspace|id|name|object|style|title|vspace|width],"
		+"area[accesskey|alt|class|coords|dir<ltr?rtl|href|id|lang|nohref<nohref"
		  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup"
		  +"|shape<circle?default?poly?rect|style|tabindex|title|target],"
		+"base[href|target],"
		+"basefont[color|face|id|size],"
		+"bdo[class|dir<ltr?rtl|id|lang|style|title],"
		+"big[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"blockquote[dir|style|cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
		  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
		  +"|onmouseover|onmouseup|style|title],"
		+"body[alink|background|bgcolor|class|dir<ltr?rtl|id|lang|link|onclick|url"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|onunload|style|title|text|vlink],"
		+"br[class|clear<all?left?none?right|id|style|title],"
		+"button[accesskey|class|dir<ltr?rtl|disabled<disabled|id|lang|name|onblur"
		  +"|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|tabindex|title|type"
		  +"|value],"
		+"caption[align<bottom?left?right?top|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"center[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"cite[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"code[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"col[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
		  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
		  +"|valign<baseline?bottom?middle?top|width],"
		+"colgroup[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl"
		  +"|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
		  +"|valign<baseline?bottom?middle?top|width],"
		+"dd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"del[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"dfn[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"dir[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"div[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"dl[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"dt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"em/i[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"fieldset[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"font[class|color|dir<ltr?rtl|face|id|lang|size|style|title],"
		+"form[accept|accept-charset|action|class|dir<ltr?rtl|enctype|id|lang"
		  +"|method<get?post|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onreset|onsubmit"
		  +"|style|title|target],"
		+"frame[class|frameborder|id|longdesc|marginheight|marginwidth|name"
		  +"|noresize<noresize|scrolling<auto?no?yes|src|style|title],"
		+"frameset[class|cols|id|onload|onunload|rows|style|title],"
		+"h1[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h2[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h3[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h4[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h5[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"h6[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"head[dir<ltr?rtl|lang|profile],"
		+"hr[align<center?left?right|class|dir<ltr?rtl|id|lang|noshade<noshade|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|size|style|title|width],"
		+"html[dir<ltr?rtl|lang|version],"
		+"iframe[align<bottom?left?middle?right?top|class|frameborder|height|id"
		  +"|longdesc|marginheight|marginwidth|name|scrolling<auto?no?yes|src|style"
		  +"|title|width],"
		+"img[align<bottom?left?middle?right?top|alt|border|class|dir<ltr?rtl|height"
		  +"|hspace|id|ismap<ismap|lang|longdesc|name|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|src|style|title|usemap|vspace|width],"
		+"input[accept|accesskey|align<bottom?left?middle?right?top|alt"
		  +"|checked<checked|class|dir<ltr?rtl|disabled<disabled|id|ismap<ismap|lang"
		  +"|maxlength|name|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
		  +"|readonly<readonly|size|src|style|tabindex|title"
		  +"|type<button?checkbox?file?hidden?image?password?radio?reset?submit?text"
		  +"|usemap|value],"
		+"ins[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"isindex[class|dir<ltr?rtl|id|lang|prompt|style|title],"
		+"kbd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"label[accesskey|class|dir<ltr?rtl|for|id|lang|onblur|onclick|ondblclick"
		  +"|onfocus|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
		  +"|onmouseover|onmouseup|style|title],"
		+"legend[align<bottom?left?right?top|accesskey|class|dir<ltr?rtl|id|lang"
		  +"|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"li[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type"
		  +"|value],"
		+"link[charset|class|dir<ltr?rtl|href|hreflang|id|lang|media|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|rel|rev|style|title|target|type],"
		+"map[class|dir<ltr?rtl|id|lang|name|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"menu[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"meta[content|dir<ltr?rtl|http-equiv|lang|name|scheme],"
		+"noframes[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"noscript[class|dir<ltr?rtl|id|lang|style|title],"
		+"object[align<bottom?left?middle?right?top|archive|border|class|classid"
		  +"|codebase|codetype|data|declare|dir<ltr?rtl|height|hspace|id|lang|name"
		  +"|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|standby|style|tabindex|title|type|usemap"
		  +"|vspace|width],"
		+"ol[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|start|style|title|type],"
		+"optgroup[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"option[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick|ondblclick"
		  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
		  +"|onmouseover|onmouseup|selected<selected|style|title|value],"
		+"p[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|style|title],"
		+"param[id|name|type|value|valuetype<DATA?OBJECT?REF],"
		+"pre/listing/plaintext/xmp[align|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
		  +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
		  +"|onmouseover|onmouseup|style|title|width],"
		+"q[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"s[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"samp[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"script[charset|defer|language|src|type],"
		+"select[class|dir<ltr?rtl|disabled<disabled|id|lang|multiple<multiple|name"
		  +"|onblur|onchange|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|size|style"
		  +"|tabindex|title],"
		+"small[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"span[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"strike[class|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title],"
		+"strong/b[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"style[dir<ltr?rtl|lang|media|title|type],"
		+"sub[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"sup[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title],"
		+"table[align<center?left?right|bgcolor|border|cellpadding|cellspacing|background|class"
		  +"|dir<ltr?rtl|frame|height|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rules"
		  +"|style|summary|title|width],"
		+"tbody[align<center?char?justify?left?right|char|class|charoff|dir<ltr?rtl|id"
		  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
		  +"|valign<baseline?bottom?middle?top],"
		+"td[abbr|align<center?char?justify?left?right|axis|bgcolor|background|char|charoff|class"
		  +"|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
		  +"|style|title|valign<baseline?bottom?middle?top|width],"
		+"textarea[accesskey|class|cols|dir<ltr?rtl|disabled<disabled|id|lang|name"
		  +"|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
		  +"|readonly<readonly|rows|style|tabindex|title],"
		+"tfoot[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
		  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
		  +"|valign<baseline?bottom?middle?top],"
		+"th[abbr|align<center?char?justify?left?right|axis|bgcolor|background|char|charoff|class"
		  +"|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
		  +"|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
		  +"|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
		  +"|style|title|valign<baseline?bottom?middle?top|width],"
		+"thead[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
		  +"|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
		  +"|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
		  +"|valign<baseline?bottom?middle?top],"
		+"title[dir<ltr?rtl|lang],"
		+"tr[abbr|align<center?char?justify?left?right|bgcolor|char|background|charoff|class"
		  +"|rowspan|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title|valign<baseline?bottom?middle?top],"
		+"tt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"u[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
		  +"|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
		+"ul[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
		  +"|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
		  +"|onmouseup|style|title|type],"
		+"var[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
		  +"|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
		  +"|title]"

			});
		</script>
		<form name="formCadastro" id="formCadastro" action="index.php?modulo=imoveis&acao=imovelinfo&modo=editar&id=<?php print("$id");?>" method="post" enctype="multipart/form-data">
		  	<table align="center" width="500" border="0" cellspacing="3" cellpadding="3">
				<tr>
					<td align="right" colspan="2" style="color:787878; letter-spacing:1px; font-size:85%;">* Campos Obrigat&oacute;rios</td>
				</tr>
				<tr>
					<th align="left">Refer&ecirc;ncia:</th>
					<td align="left"><input type="text" name="referencia" id="referencia" maxlength="150" value="<?php print($linha['referencia']);?>"></td>
				</tr>
		 		<tr>
			  		<th align="left">Cliente:</th>
			  		<td align="left">
						<select id="idCliente" name="idCliente" style="width:95%;">
							<?php montaSelect("cliente", $linha['idCliente']); ?>
						</select> *
					</td>
		 		</tr>
		 		<tr>
					<th align="left" colspan="2">Op&ccedil;&otilde;es de Controle</th>
				</tr>
				<tr>
					<th align="left" colspan="2" valign="top">
						<input type="checkbox" name="destaque" id="destaque" <?php if($linha['destaque'])	print("checked");?>> Selecione para marcar este im&oacute;vel como destaque.
					</th>
				</tr>
				<tr>
					<th align="left" colspan="2" valign="top">
						<input type="checkbox" name="exclusivo" id="exclusivo" <?php if($linha['exclusivo'])	print("checked");?>
							onclick="
								el = document.getElementById( 'trExclusivo' );
								if( el.style.display == 'none' )
								{
									el.style.display = 'block';
								}
								else
								{
									el.style.display = 'none';
								}
							"
						> Selecione para marcar este im&oacute;vel como exclusivo.
					</th>
				</tr>
				<tr id="trExclusivo">
					<td align="center" colspan="2">
						<table width="100%" align="center" border="0" cellspacing="2" cellpadding="2">
							<tr>
								<th align="left">Data T&eacute;rmino:</th>
								<td align="left">
									<input type="text" name="dataTerminoExclusividade" id="dataTerminoExclusividade" style="width:100px;" value="<?php print($dataTerminoExclusividade);?>" onchange="document.formCadastro.dataAviso.value=SomarData(document.formCadastro.dataTerminoExclusividade.value, 10);"  onblur="document.formCadastro.dataAviso.value=SomarData(document.formCadastro.dataTerminoExclusividade.value, 10);" tipo="numerico" mascara="##/##/####">
									<img src="imagens/calendario.gif" id="f_trigger_a" style="cursor: pointer;" width="20" height="20" title="Clique para selecionar a data"/>
									<script type="text/javascript">
										Calendar.setup({
											inputField     :    "dataTerminoExclusividade",      // id of the input field
											ifFormat       :    "%d/%m/%Y",       // format of the input field
											showsTime      :    false,            // will display a time selector
											button         :    "f_trigger_a",   // trigger for the calendar (button ID)
											singleClick    :    true,           // double-click mode
											step           :    1                // show all years in drop-down boxes (instead of every other year as default)
										});
									</script>
								</td>
							</tr>
							<tr>
								<th align="left">Data Aviso:</th>
								<td align="left">
									<input type="text" name="dataAviso" id="dataAviso" style="width:100px;" value="<?php print($dataAviso);?>" tipo="numerico" mascara="##/##/####">
									<img src="imagens/calendario.gif" id="f_trigger_b" style="cursor: pointer;" width="20" height="20" title="Clique para selecionar a data"/>
									<script type="text/javascript">
										Calendar.setup({
											inputField     :    "dataAviso",      // id of the input field
											ifFormat       :    "%d/%m/%Y",       // format of the input field
											showsTime      :    false,            // will display a time selector
											button         :    "f_trigger_b",   // trigger for the calendar (button ID)
											singleClick    :    true,           // double-click mode
											step           :    1                // show all years in drop-down boxes (instead of every other year as default)
										});
									</script>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
			  		<th align="left">Categoria:</th>
			  		<td align="left">
						<select id="idCategoria" name="idCategoria" style="width:95%;" onChange="DadosCategoria(this.value, 'subCategoriaXML', 'idSubCategoria', 'subCatOpcoes');">
							<option value="">-- Selecione uma das opções</option>
							<?php montaSelect("categorias", $linha[idCategoria]); ?>
						</select> *
					</td>
		 		</tr>
				<tr>
			  		<th align="left">Sub Categoria: </th>
			  		<td align="left">
		 				<select id="idSubCategoria" name="idSubCategoria" style="width:95%;">
						  <option id="subCatOpcoes" value="">-- Selecione uma das opções</option>
						  <?php montaSelect("subcategorias", $linha[idSubCategoria]); ?>
						</select> *
		  	  		</td>
				</tr>
				<tr>
					<th align="left">Valor:</th>
					<td align="left"><input type="text" name="valor" id="valor" value="<?php print($linha['valor']);?>" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
				</tr>
				<tr>
					<th align="left">Imagem:</th>
					<td align="left"><input type="file" name="imagem" id="imagem"> *</td>
				</tr>
				<tr>
					<th align="left">Imagem atual:</th>
					<td align="left">
						<?php
							if($linha[imagem]!="")
							{
								print("
								<table cellpadding='2' cellspacing='2'>
									<tr>
										<td>
											<div style='float:left'>
												<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=editar&modo=removerImagem&id=$linha[id]' title='Excluir imagem' onclick='return confirmaExclusao();'>
										 			<img src='imagens/delete.png' border='0' class='icone_botao'> Excluir imagem
												</a>
											</div>

										</td>
										<td>
											<div>
												<a href='../imoveis/g_$linha[imagem]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0' title='Visualizar' class='icone_botao'> $linha[imagem]</a>
											</div>
										</td>
									</tr>
								</table>
								");
							}
							else
							{
								print("Imagem não cadastrada");
							}
						?>
					</td>
				</tr>
				<tr>
					<th align="left">Estado:</th>
					<td align="left"><?php montaComboEstado($linha['idEstado'], false, false);?> *</td>
				</tr>
				<tr>
			  		<th align="left">Cidade:</th>
			  		<td align="left">
						<select id="opcaoCategoria" name="opcaoCategoria" style="width:95%;" onChange="listaSubCategoria2.value=''; Dados(this.value, 'regioesXML', 'listaSubCategoria', 'opcaoSubCategoria');">
							<option value="">-- Selecione uma das opções</option>
							<?php montaSelect("cidades", $linha['idCidade']); ?>
						</select> *
					</td>
		 		</tr>
				<tr>
			  		<th align="left">Regi&atilde;o: </th>
			  		<td align="left">
		 				<select id="listaSubCategoria" name="listaSubCategoria" style="width:95%;" onChange="Dados2(this.value, 'bairrosXML', 'listaSubCategoria2', 'opcaoSubCategoria2');">
						  <option id="opcaoSubCategoria" value="">-- Selecione uma das opções</option>
						  <?php montaSelect("regiao", $linha['idRegiao']); ?>
						</select> *
		  	  		</td>
				</tr>
				<tr>
			  		<th align="left">Bairro: </th>
			  		<td align="left">
		 				<select id="listaSubCategoria2" name="listaSubCategoria2" style="width:95%;">
						  <option id="opcaoSubCategoria2" value="">-- Selecione uma das opções</option>
						  <?php montaSelect("bairros", $linha['idBairro']); ?>
						</select> *
		  	  		</td>
				</tr>
				<tr>
					<th align="left">Endere&ccedil;o:</th>
					<td align="left"><input type="text" name="endereco" id="endereco" maxlength="150" value="<?php print($linha['endereco']);?>"></td>
				</tr>
				<tr>
					<th align="left" colspan="2">Descri&ccedil;&atilde;o Curta:</th>
				</tr>
				<tr>
					<th align="left" colspan="2"><textarea name="descricaoCurta" id="descricaoCurta" style="width:100%; height:120px;"><?php print($linha['descricaoCurta']);?></textarea></td>
				</tr>
				<tr>
					<th align="left" colspan="2">Descri&ccedil;&atilde;o Completa:</th>
				</tr>
				<tr>
					<th align="left" colspan="2"><textarea name="descricaoCompleta" class="mceEditor" id="descricaoCompleta" style="width:100%;"><?php print($linha['descricaoCompleta']);?></textarea></td>
				</tr>
				<tr>
					<th align="left" colspan="2">Mais Informa&ccedil;&otilde;es:</th>
				</tr>
				<tr>
					<th align="left" colspan="2"><textarea name="maisInformacoes" id="maisInformacoes" style="width:100%; height:120px;"><?php print($linha['maisInformacoes']);?></textarea></td>
				</tr>
				<tr>
					<th align="left" colspan="2">Composi&ccedil;&atilde;o:</th>
				</tr>
				<tr>
					<th align="left" colspan="2"><?php listaComposicoesEditar($id); ?></th>
				</tr>
				<tr valign="baseline">
					<td align="center" colspan="2">
						<input name="cadastrar" type="submit" id="form_submit" value="Salvar" onclick="tinyMCE.triggerSave();">
					</td>
				</tr>
			</table>
		</form>
		<script language="javascript">

			<?php
				if($linha['exclusivo'])
				{
					?>
					el = document.getElementById( 'trExclusivo' );
					el.style.display = 'block';
					<?php
				}
				else
				{
					?>
					el = document.getElementById( 'trExclusivo' );
					el.style.display = 'none';
					<?php
				}
			?>


			document.formCadastro.valor.focus();

			function DadosCategoria(valor, arquivo, proximoCampo, opcoes)
			{
				var ajax;
				if(window.XMLHttpRequest) // Mozilla, Safari...
			    {
			        ajax = new XMLHttpRequest();
			    }
			    else if(window.ActiveXObject) // IE
			    {
					try{
			            ajax = new ActiveXObject('Msxml2.XMLHTTP');
			        }
			        catch(e)
			        {
			            try{
			                ajax = new ActiveXObject('Microsoft.XMLHTTP');
			            }
			            catch(e){}
			        }
			    }
				if(ajax) {
					document.formCadastro.idSubCategoria.options.length=1;
					idOpcao=document.getElementById(opcoes);
					ajax.open('POST', arquivo+'.php', true);
					ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					ajax.onreadystatechange=function() {
						if(ajax.readyState==1) {
							idOpcao.innerHTML='Carregando...';
						}
						if(ajax.readyState==4) {
							if(ajax.responseXML)
								processXMLCategoria(ajax.responseXML, arquivo, proximoCampo, opcoes);
							else
								idOpcao.innerHTML='';
						}
					}
				}
				var params = 'codigo='+valor;
				ajax.send(params);

			}
			function processXMLCategoria(obj, arquivo, proximoCampo, opcoes){
				var dataArray = obj.getElementsByTagName('subCategoria');
				if(dataArray.length > 0) {
					for(var i = 0 ; i < dataArray.length ; i++) {
						var item = dataArray[i];
						var codigo = item.getElementsByTagName('codigo')[0].firstChild.nodeValue;
						var nome =  item.getElementsByTagName('nome')[0].firstChild.nodeValue;
						idOpcao.innerHTML = '-- Selecione uma das opções >>';
						var novo = document.createElement('option');
						novo.setAttribute('id', opcoes);
						novo.value = codigo;
						novo.text  = nome;
						document.formCadastro.idSubCategoria.options.add(novo);
					}
				}
				else {
					idOpcao.innerHTML = '';
				}
			}

			function Dados(valor, arquivo, proximoCampo, opcoes)
			{
				var ajax;
				if(window.XMLHttpRequest) // Mozilla, Safari...
			    {
			        ajax = new XMLHttpRequest();
			    }
			    else if(window.ActiveXObject) // IE
			    {
					try{
			            ajax = new ActiveXObject('Msxml2.XMLHTTP');
			        }
			        catch(e)
			        {
			            try{
			                ajax = new ActiveXObject('Microsoft.XMLHTTP');
			            }
			            catch(e){}
			        }
			    }
				if(ajax) {
					document.formCadastro.listaSubCategoria.options.length=1;
					idOpcao=document.getElementById(opcoes);
					ajax.open('POST', arquivo+'.php', true);
					ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					ajax.onreadystatechange=function() {
						if(ajax.readyState==1) {
							idOpcao.innerHTML='Carregando...';
						}
						if(ajax.readyState==4) {
							if(ajax.responseXML)
								processXML(ajax.responseXML, arquivo, proximoCampo, opcoes);
							else
								idOpcao.innerHTML='';
						}
					}
				}
				var params = 'codigo='+valor;
				ajax.send(params);

			}
			function processXML(obj, arquivo, proximoCampo, opcoes){
				var dataArray = obj.getElementsByTagName('regiao');
				if(dataArray.length > 0) {
					for(var i = 0 ; i < dataArray.length ; i++) {
						var item = dataArray[i];
						var codigo = item.getElementsByTagName('codigo')[0].firstChild.nodeValue;
						var nome =  item.getElementsByTagName('nome')[0].firstChild.nodeValue;
						idOpcao.innerHTML = '-- Selecione uma das opções >>';
						var novo = document.createElement('option');
						novo.setAttribute('id', opcoes);
						novo.value = codigo;
						novo.text  = nome;
						document.formCadastro.listaSubCategoria.options.add(novo);
					}
				}
				else {
					idOpcao.innerHTML = '';
				}
			}

			function Dados2(valor, arquivo, proximoCampo, opcoes)
			{
				var ajax;
				if(window.XMLHttpRequest) // Mozilla, Safari...
			    {
			        ajax = new XMLHttpRequest();
			    }
			    else if(window.ActiveXObject) // IE
			    {
					try{
			            ajax = new ActiveXObject('Msxml2.XMLHTTP');
			        }
			        catch(e)
			        {
			            try{
			                ajax = new ActiveXObject('Microsoft.XMLHTTP');
			            }
			            catch(e){}
			        }
			    }
				if(ajax) {
					document.formCadastro.listaSubCategoria2.options.length=1;
					idOpcao2=document.getElementById(opcoes);
					ajax.open('POST', arquivo+'.php', true);
					ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					ajax.onreadystatechange=function() {
						if(ajax.readyState==1) {
							idOpcao2.innerHTML='Carregando...';
						}
						if(ajax.readyState==4) {
							if(ajax.responseXML)
								processXML2(ajax.responseXML, arquivo, proximoCampo, opcoes);
							else
								idOpcao2.innerHTML='';
						}
					}
				}
				var params2 = 'codigo='+valor;
				ajax.send(params2);

			}
			function processXML2(obj, arquivo, proximoCampo, opcoes){
				var dataArray = obj.getElementsByTagName('bairro');
				if(dataArray.length > 0) {
					idOpcao2.innerHTML = '-- Selecione uma das opções >>';
					for(var i = 0 ; i < dataArray.length ; i++) {
						var item = dataArray[i];
						var codigo = item.getElementsByTagName('codigo')[0].firstChild.nodeValue;
						var nome =  item.getElementsByTagName('nome')[0].firstChild.nodeValue;
						var novo = document.createElement('option');
						novo.setAttribute('id', opcoes);
						novo.value = codigo;
						novo.text  = nome;
						document.formCadastro.listaSubCategoria2.options.add(novo);
					}
				}
				else {
					idOpcao2.innerHTML = '';
				}
			}
		</script>
		<?php
	}
	if($tipo=="complementos")
	{
		if($aviso==true){
            devolveMensagem("Já foram cadastrados complementos para este imóvel. Se deseja alterá-los, clique em \"Editar\".", true);
        }

        $imovel = devolveInfo("imoveis", $id);

		$complemento=devolveInformacoesComplementares($id);

		if($tipo2=="editarComplementos"){
			if($complemento['tipo']=="terrenos"){
				print("
					<table width='100%' cellpadding='2' cellspacing='2'>
						<tr>
							<td width='90%'>&nbsp;</td>
							<td align='right'>
								<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&id=$id' title='Informações Complementares'>
									<div class='app_botao'><img src='imagens/complementos.png' border='0' class='icone_botao'>Complementos</div>
								</a>
							</td>
						</tr>
					</table>
				");
				?>
					<table align="center" width="450" border="0" cellspacing="3" cellpadding="3">
						<tr>
							<td align="right" style="color:787878; letter-spacing:1px; font-size:85%;">* Campos Obrigat&oacute;rios</td>
						</tr>
						<tr valign="baseline">
							<td nowrap align="center">
								<form style="width:450px;" name="formCadastro" id="formCadastro" action="index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&tipo2=editar&modo=editarComplementos<?php print("&idComplemento=$complemento[id]&id=$id");?>" method="post" enctype="multipart/form-data">
								  	<fieldset style="width:450px;">
										<legend>Localiza&ccedil;&atilde;o</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Estado:</th>
												<td align="left"><?php print(devolveEstado($imovel['idEstado'])); ?></td>
											</tr>
											<tr>
										  		<th align="left">Cidade:</th>
										  		<td align="left"><?php print(devolveInfoCampo("nome", "cidades", $imovel['idCidade']));?>
												</td>
									 		</tr>
									 		<tr>
										  		<th align="left">Regi&atilde;o:</th>
										  		<td align="left"><?php print(devolveInfoCampo("nome", "regiao", $imovel['idRegiao']));?>
												</td>
									 		</tr>
									 		<tr>
										  		<th align="left">Bairro:</th>
										  		<td align="left"><?php print(devolveInfoCampo("nome", "bairros", $imovel['idBairro']));?>
												</td>
									 		</tr>
									 		<tr>
										  		<th align="left">Endere&ccedil;o:</th>
										  		<td align="left"><?php print($imovel['endereco']);?>
												</td>
									 		</tr>
									 		<tr>
												<th align="left">CEP:</th>
												<td align="left"><input type="text" value="<?php print($complemento['cep']);?>" name="cep" id="cep" maxlength="9" mascara="#####-###" tipo="numerico"></td>
											</tr>
											<tr>
												<th align="left">Refer&ecirc;ncia:</th>
												<td align="left"><input type="text" value="<?php print($complemento['referencia']);?>" name="referencia" id="referencia" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Complemento:</th>
												<td align="left"><input type="text" value="<?php print($complemento['complemento']);?>" name="complemento" id="complemento" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Vizinho:</th>
												<td align="left"><input type="text" value="<?php print($complemento['vizinho']);?>" name="vizinho" id="vizinho" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Fone Vizinho:</th>
												<td align="left"><input type="text" value="<?php print($complemento['foneVizinho']);?>" name="foneVizinho" id="foneVizinho" maxlength="14" mascara="(##) ####-####" tipo="numerico"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Informa&ccedil;&otilde;es</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Idade:</th>
												<td align="left"><input type="text" value="<?php print($complemento['idade']);?>" name="idade" id="idade" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Tipo de &Aacute;rea:</th>
												<td align="left"><input type="text" value="<?php print($complemento['tipoArea']);?>" name="tipoArea" id="tipoArea" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Ocupado:</th>
												<td align="left"><input type="text" value="<?php print($complemento['ocupado']);?>" name="ocupado" id="ocupado" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Chaves:</th>
												<td align="left"><input type="text" value="<?php print($complemento['chaves']);?>" name="chaves" id="chaves" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Matr&iacute;cula:</th>
												<td align="left"><input type="text" value="<?php print($complemento['matricula']);?>" name="matricula" id="matricula" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Circunscri&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['circunscricao']);?>" name="circunscricao" id="circunscricao" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Inscri&ccedil;&atilde;o Imobili&aacute;ria:</th>
												<td align="left"><input type="text" value="<?php print($complemento['inscricaoImobiliaria']);?>" name="inscricaoImobiliaria" id="inscricaoImobiliaria" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Contrato:</th>
												<td align="left"><input type="text" value="<?php print($complemento['contrato']);?>" name="contrato" id="contrato" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Averbado:</th>
												<td align="left"><input type="text" value="<?php print($complemento['averbado']);?>" name="averbado" id="averbado" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Conserva&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['conservacao']);?>" name="conservacao" id="conservacao" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Pavimenta&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['pavimentacao']);?>" name="pavimentacao" id="pavimentacao" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Hor&aacute;rio de Visita:</th>
												<td align="left"><input type="text" value="<?php print($complemento['horaVisita']);?>" name="horaVisita" id="horaVisita" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Entrega:</th>
												<td align="left"><input type="text" value="<?php print($complemento['entrega']);?>" name="entrega" id="entrega" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Estilo:</th>
												<td align="left"><input type="text" value="<?php print($complemento['estilo']);?>" name="estilo" id="estilo" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Tipo de Forro:</th>
												<td align="left"><input type="text" value="<?php print($complemento['tipoForro']);?>" name="tipoForro" id="tipoForro" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Placa:</th>
												<td align="left"><input type="text" value="<?php print($complemento['placa']);?>" name="placa" id="placa" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Posi&ccedil;&atilde;o do Sol:</th>
												<td align="left"><input type="text" value="<?php print($complemento['posicaoSol']);?>" name="posicaoSol" id="posicaoSol" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Classifica&ccedil;&atilde;o:</th>
												<td align="left">
													<select name="classificacao" id="classificacao">
														<option value="A" <?php if($complemento['classificacao']=="A") print("selected");?>>A</option>
														<option value="B" <?php if($complemento['classificacao']=="B") print("selected");?>>B</option>
														<option value="C" <?php if($complemento['classificacao']=="C") print("selected");?>>C</option>
														<option value="D" <?php if($complemento['classificacao']=="D") print("selected");?>>D</option>
													</select>
												</td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Valor</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Total:</th>
												<td align="left"><?php print("R$ ".devolveValor($imovel['valor']));?></td>
											</tr>
											<tr>
												<th align="left">&Iacute;ndice:</th>
												<td align="left"><input type="text" value="<?php print($complemento['indice']);?>" name="indice" id="indice" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Venda:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['venda']));?>" name="venda" id="venda" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Loca&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['locacao']));?>" name="locacao" id="locacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Condom&iacute;nio:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['condominio']));?>" name="condominio" id="condominio" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">TLU:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['tlu']));?>" name="tlu" id="tlu" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">IPTU/INCRA:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['iptu']));?>" name="iptu" id="iptu" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>&Aacute;rea</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Total:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaTotal']);?>" name="areaTotal" id="areaTotal" maxlength="50"></td>
											</tr>
											<tr>
												<th align="left">Terreno:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaTerreno']);?>" name="areaTerreno" id="areaTerreno" maxlength="50"></td>
											</tr>
											<tr>
												<th align="left">Preserva&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaPreservacao']);?>" name="areaPreservacao" id="areaPreservacao" maxlength="50"></td>
											</tr>
											<tr>
												<th align="left">Hectares:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaHectares']);?>" name="areaHectares" id="areaHectares" maxlength="50"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Metragem</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Frente:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemFrente']);?>" name="metragemFrente" id="metragemFrente" maxlength="50"></td>
											</tr>
											<tr>
												<th width="30%" align="left">Fundo:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemFundo']);?>" name="metragemFundo" id="metragemFundo" maxlength="50"></td>
											</tr>
											<tr>
												<th width="30%" align="left">Lateral &agrave; Direita:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemDireita']);?>" name="metragemDireita" id="metragemDireita" maxlength="50"></td>
											</tr>
											<tr>
												<th width="30%" align="left">Lateral &agrave; Esquerda:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemEsquerda']);?>" name="metragemEsquerda" id="metragemEsquerda" maxlength="50"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Financiamento</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">VL. Poupan&ccedil;a:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['finPoupanca']));?>" name="finPoupanca" id="finPoupanca" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Saldo Devedor:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['finSaldoDevedor']));?>" name="finSaldoDevedor" id="finSaldoDevedor" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">VL. Presta&ccedil;&otilde;es:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['finValorPrestacao']));?>" name="finValorPrestacao" id="finValorPrestacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Parcelas Pagas:</th>
												<td align="left"><input type="text" value="<?php print($complemento['finParcelasPagas']);?>" name="finParcelasPagas" id="finParcelasPagas" maxlength="100" tipo="numerico"></td>
											</tr>
											<tr>
												<th align="left">Parcelas Restantes:</th>
												<td align="left"><input type="text" value="<?php print($complemento['finParcelasRestantes']);?>" name="finParcelasRestantes" id="finParcelasRestantes" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Banco:</th>
												<td align="left"><input type="text" value="<?php print($complemento['finBanco']);?>" name="finBanco" id="finBanco" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Condi&ccedil;&atilde;o de Pagamento</th>
												<td align="left"><input type="text" value="<?php print($complemento['finCondPagamento']);?>" name="finCondPagamento" id="finCondPagamento" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Pend&ecirc;ncias</th>
												<td align="left"><input type="text" value="<?php print($complemento['finPendencias']);?>" name="finPendencias" id="finPendencias" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Permuta</th>
												<td align="left"><input type="text" value="<?php print($complemento['finPermuta']);?>" name="finPermuta" id="finPermuta" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Edificado</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">Edificado:</th>
												<td align="left"><textarea name="edificado" id="edificado" rows="3" style="height:120px;"><?php print($complemento['edificado']);?></textarea></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Observa&ccedil;&atilde;o Terreno</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">Observa&ccedil;&atilde;o:</th>
												<td align="left"><textarea name="obsTerreno" id="obsTerreno" rows="3" style="height:120px;"><?php print($complemento['obsTerreno']);?></textarea></td>
											</tr>
											<tr>
												<th valign="top" align="left">Zoneamento:</th>
												<td align="left"><input type="text" value="<?php print($complemento['zoneamento']);?>" name="zoneamento" id="zoneamento" maxlength="100"></td>
											</tr>
											<tr>
												<th valign="top" align="left">N&ordm; Pavimentos:</th>
												<td align="left"><input type="text" value="<?php print($complemento['numPavimentos']);?>" name="numPavimentos" id="numPavimentos" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Croqui</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">Croqui:</th>
												<td align="left"><input type="file" name="croqui" id="croqui"></td>
											</tr>
											<tr>
												<th align="left">Imagem Atual</th>
												<td align="left">
													<?php
														if($complemento['croqui']!="")
														{
															print("
															<table cellpadding='2' cellspacing='2'>
																<tr>
																	<td>
																		<div style='float:left'>
																			<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&tipo2=editarComplementos&modo=removerCroqui&idComplemento=$complemento[id]&croqui=$complemento[croqui]&id=$linha[id]' title='Excluir croqui' onclick='return confirmaExclusao();'>
																	 			<img src='imagens/delete.png' border='0' class='icone_botao'> Excluir croqui
																			</a>
																		</div>

																	</td>
																	<td>
																		<div>
																			<a href='../imoveis/g_$complemento[croqui]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0' title='Visualizar' class='icone_botao'> $complemento[croqui]</a>
																		</div>
																	</td>
																</tr>
															</table>
															");
														}
														else
														{
															print("Imagem não cadastrada");
														}
													?>
												</td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Contato</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">Contato:</th>
												<td align="left"><input type="text" value="<?php print($complemento['conContato']);?>" name="conContato" id="conContato" maxlength="150"></td>
											</tr>
											<tr>
												<th valign="top" align="left">Email:</th>
												<td align="left"><input type="text" value="<?php print($complemento['conEmail']);?>" name="conEmail" id="conEmail" maxlength="150"></td>
											</tr>
											<tr>
												<th valign="top" align="left">Telefone 1:</th>
												<td align="left"><input type="text" value="<?php print($complemento['conTelefone1']);?>" name="conTelefone1" id="conTelefone1" maxlength="14" mascara="(##) ####-####" tipo="numerico"></td>
											</tr>
											<tr>
												<th valign="top" align="left">Telefone 2:</th>
												<td align="left"><input type="text" value="<?php print($complemento['conTelefone2']);?>" name="conTelefone2" id="conTelefone2" maxlength="14" mascara="(##) ####-####" tipo="numerico"></td>
											</tr>
											<tr>
												<th valign="top" align="left">Outro Contato:</th>
												<td align="left"><input type="text" value="<?php print($complemento['conOutroContato']);?>" name="conOutroContato" id="conOutroContato" maxlength="150"></td>
											</tr>
											<tr>
												<th valign="top" align="left">Telefone Outro:</th>
												<td align="left"><input type="text" value="<?php print($complemento['conTelefoneOutro']);?>" name="conTelefoneOutro" id="conTelefoneOutro" maxlength="14" mascara="(##) ####-####" tipo="numerico"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>An&uacute;ncio</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">An&uacute;ncio:</th>
												<td align="left">
													<select name="anuncio" id="anuncio">
														<option value="Jornal" <?php if($complemento['anuncio']=="Jornal")	print("selected");?>">Jornal</option>
														<option value="Site" <?php if($complemento['anuncio']=="Site")	print("selected");?>>Site</option>
														<option value="Rede" <?php if($complemento['anuncio']=="Rede")	print("selected");?>>Rede</option>
														<option value="Revista" <?php if($complemento['anuncio']=="Revista")	print("selected");?>>Revista</option>
														<option value="N&atilde;o Enviar" <?php if($complemento['anuncio']=="Não Enviar")	print("selected");?>>N&atilde;o Enviar</option>
													</select>
												</td>
											</tr>
											<tr>
												<th valign="top" align="left">Pontos Fortes:</th>
												<td align="left"><textarea name="anuncioPontosFortes" id="anuncioPontosFortes" rows="3" style="height:120px;"><?php print($complemento['anuncioPontosFortes']);?></textarea></td>
											</tr>
										</table>
									</fieldset>
									<table align="center" border="0" cellspacing="3" cellpadding="3">
										<tr valign="baseline">
											<td nowrap align="center">
												<input name="cadastrar" type="submit" id="form_submit" value="Salvar">
											</td>
										</tr>
									</table>
								</form>
							</td>
						</tr>
					</table>
				<?php
			}
			elseif($complemento['tipo']=="residencias"){
				print("
					<table width='100%' cellpadding='2' cellspacing='2'>
						<tr>
							<td width='90%'>&nbsp;</td>
							<td align='right'>
								<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&id=$id' title='Informações Complementares'>
									<div class='app_botao'><img src='imagens/complementos.png' border='0' class='icone_botao'>Complementos</div>
								</a>
							</td>
						</tr>
					</table>
				");
				?>
					<table align="center" width="450" border="0" cellspacing="3" cellpadding="3">
						<tr>
							<td align="right" style="color:787878; letter-spacing:1px; font-size:85%;">* Campos Obrigat&oacute;rios</td>
						</tr>
						<tr valign="baseline">
							<td nowrap align="center">
								<form style="width:450px;" name="formCadastro" id="formCadastro" action="index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&tipo2=editar&modo=editarComplementos<?php print("&idComplemento=$complemento[id]&id=$id");?>" method="post" enctype="multipart/form-data">
								  	<fieldset style="width:450px;">
										<legend>Identifica&ccedil;&atilde;o</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Tipo:</th>
												<td align="left">
													<select name="tipoImovel" id="tipoImovel">
														<option value="Alvenaria" <?php if($complemento['tipoImovel']=="Alvenaria")	print("selected");?>>Alvenaria</option>
														<option value="Madeira" <?php if($complemento['tipoImovel']=="Alvenaria")	print("selected");?>>Madeira</option>
														<option value="Mista" <?php if($complemento['tipoImovel']=="Alvenaria")	print("selected");?>>Mista</option>
														<option value="Em Constru&ccedil;&atilde;o" <?php if($complemento['tipoImovel']=="Em Construção")	print("selected");?>>Em Constru&ccedil;&atilde;o</option>
														<option value="Outros" <?php if($complemento['tipoImovel']=="Outros")	print("selected");?>>Outros</option>
													</select>
												</td>
											</tr>
											<tr>
												<th align="left">Outro Tipo:</th>
												<td align="left"><input type="text" value="<?php print($complemento['outroTipoImovel']);?>" name="outroTipoImovel" id="outroTipoImovel" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Localiza&ccedil;&atilde;o</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Estado:</th>
												<td align="left"><?php print(devolveEstado($imovel['idEstado'])); ?></td>
											</tr>
											<tr>
										  		<th align="left">Cidade:</th>
										  		<td align="left"><?php print(devolveInfoCampo("nome", "cidades", $imovel['idCidade']));?>
												</td>
									 		</tr>
									 		<tr>
										  		<th align="left">Regi&atilde;o:</th>
										  		<td align="left"><?php print(devolveInfoCampo("nome", "regiao", $imovel['idRegiao']));?>
												</td>
									 		</tr>
									 		<tr>
										  		<th align="left">Bairro:</th>
										  		<td align="left"><?php print(devolveInfoCampo("nome", "bairros", $imovel['idBairro']));?>
												</td>
									 		</tr>
									 		<tr>
										  		<th align="left">Endere&ccedil;o:</th>
										  		<td align="left"><?php print($imovel['endereco']);?>
												</td>
									 		</tr>
									 		<tr>
												<th align="left">CEP:</th>
												<td align="left"><input type="text" value="<?php print($complemento['cep']);?>" name="cep" id="cep" maxlength="9" mascara="#####-###" tipo="numerico"></td>
											</tr>
											<tr>
												<th align="left">Refer&ecirc;ncia:</th>
												<td align="left"><input type="text" value="<?php print($complemento['referencia']);?>" name="referencia" id="referencia" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Complemento:</th>
												<td align="left"><input type="text" value="<?php print($complemento['complemento']);?>" name="complemento" id="complemento" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Condom&iacute;nio Fechado:</th>
												<td align="left"><input type="text" value="<?php print($complemento['condominioFechado']);?>" name="condominioFechado" id="condominioFechado" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">N&ordm; de Casas:</th>
												<td align="left"><input type="text" value="<?php print($complemento['numCasasCondominio']);?>" name="numCasasCondominio" id="numCasasCondominio" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Informa&ccedil;&otilde;es</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Idade:</th>
												<td align="left"><input type="text" value="<?php print($complemento['idade']);?>" name="idade" id="idade" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Tipo de &Aacute;rea:</th>
												<td align="left"><input type="text" value="<?php print($complemento['tipoArea']);?>" name="tipoArea" id="tipoArea" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Ocupado:</th>
												<td align="left"><input type="text" value="<?php print($complemento['ocupado']);?>" name="ocupado" id="ocupado" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Chaves:</th>
												<td align="left"><input type="text" value="<?php print($complemento['chaves']);?>" name="chaves" id="chaves" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Matr&iacute;cula:</th>
												<td align="left"><input type="text" value="<?php print($complemento['matricula']);?>" name="matricula" id="matricula" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Circunscri&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['circunscricao']);?>" name="circunscricao" id="circunscricao" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Inscri&ccedil;&atilde;o Imobili&aacute;ria:</th>
												<td align="left"><input type="text" value="<?php print($complemento['inscricaoImobiliaria']);?>" name="inscricaoImobiliaria" id="inscricaoImobiliaria" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Contrato:</th>
												<td align="left"><input type="text" value="<?php print($complemento['contrato']);?>" name="contrato" id="contrato" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Averbado:</th>
												<td align="left"><input type="text" value="<?php print($complemento['averbado']);?>" name="averbado" id="averbado" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Conserva&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['conservacao']);?>" name="conservacao" id="conservacao" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Pavimenta&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['pavimentacao']);?>" name="pavimentacao" id="pavimentacao" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Hor&aacute;rio de Visita:</th>
												<td align="left"><input type="text" value="<?php print($complemento['horaVisita']);?>" name="horaVisita" id="horaVisita" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Entrega:</th>
												<td align="left"><input type="text" value="<?php print($complemento['entrega']);?>" name="entrega" id="entrega" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Estilo:</th>
												<td align="left"><input type="text" value="<?php print($complemento['estilo']);?>" name="estilo" id="estilo" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Tipo de Forro:</th>
												<td align="left"><input type="text" value="<?php print($complemento['tipoForro']);?>" name="tipoForro" id="tipoForro" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Placa:</th>
												<td align="left"><input type="text" value="<?php print($complemento['placa']);?>" name="placa" id="placa" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Posi&ccedil;&atilde;o do Sol:</th>
												<td align="left"><input type="text" value="<?php print($complemento['posicaoSol']);?>" name="posicaoSol" id="posicaoSol" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Comiss&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['comissao']);?>" name="comissao" id="comissao" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Valor</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Total:</th>
												<td align="left"><?php print("R$ ".devolveValor($imovel['valor']));?></td>
											</tr>
											<tr>
												<th align="left">&Iacute;ndice:</th>
												<td align="left"><input type="text" value="<?php print($complemento['indice']);?>" name="indice" id="indice" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Venda:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['venda']));?>" name="venda" id="venda" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Loca&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['locacao']));?>" name="locacao" id="locacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Pool Loca&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['condominio']));?>" name="poolLocacao" id="poolLocacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Rendimento:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['rendimento']));?>" name="rendimento" id="rendimento" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Condom&iacute;nio:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['condominio']));?>" name="condominio" id="condominio" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">TLU:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['tlu']));?>" name="tlu" id="tlu" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">IPTU:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['iptu']));?>" name="iptu" id="iptu" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Luz:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['valorLuz']));?>" name="valorLuz" id="valorLuz" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Luz &eacute; individual:</th>
												<td align="left"><?php montaCheckSimNao($complemento['luzIndividual'], "luzIndividual", "style='width:15px;'"); ?></td>
											</tr>
											<tr>
												<th align="left">N&ordm; Rel&oacute;gio / Conta:</th>
												<td align="left"><input type="text" value="<?php print($complemento['luzIdentificador']);?>" name="luzIdentificador" id="luzIdentificador" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">&Aacute;gua:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['valorAgua']));?>" name="valorAgua" id="valorAgua" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">&Aacute;gua &eacute; individual:</th>
												<td align="left"><?php montaCheckSimNao($complemento['aguaIndividual'], "aguaIndividual", "style='width:15px;'"); ?></td>
											</tr>
											<tr>
												<th align="left">N&ordm; Hidr&ocirc;metro / Localiz.:</th>
												<td align="left"><input type="text" value="<?php print($complemento['aguaIdentificador']);?>" name="aguaIdentificador" id="aguaIdentificador" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>&Aacute;rea</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Total:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaTotal']);?>" name="areaTotal" id="areaTotal" maxlength="50"></td>
											</tr>
											<tr>
												<th align="left">Terreno:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaTerreno']);?>" name="areaTerreno" id="areaTerreno" maxlength="50"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Metragem</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Frente:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemFrente']);?>" name="metragemFrente" id="metragemFrente" maxlength="50"></td>
											</tr>
											<tr>
												<th width="30%" align="left">Fundo:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemFundo']);?>" name="metragemFundo" id="metragemFundo" maxlength="50"></td>
											</tr>
											<tr>
												<th width="30%" align="left">Lateral &agrave; Direita:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemDireita']);?>" name="metragemDireita" id="metragemDireita" maxlength="50"></td>
											</tr>
											<tr>
												<th width="30%" align="left">Lateral &agrave; Esquerda:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemEsquerda']);?>" name="metragemEsquerda" id="metragemEsquerda" maxlength="50"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Financiamento</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">VL. Poupan&ccedil;a:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['finPoupanca']));?>" name="finPoupanca" id="finPoupanca" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Saldo Devedor:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['finSaldoDevedor']));?>" name="finSaldoDevedor" id="finSaldoDevedor" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">VL. Presta&ccedil;&otilde;es:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['finValorPrestacao']));?>" name="finValorPrestacao" id="finValorPrestacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Parcelas Pagas:</th>
												<td align="left"><input type="text" value="<?php print($complemento['finParcelasPagas']);?>" name="finParcelasPagas" id="finParcelasPagas" maxlength="100" tipo="numerico"></td>
											</tr>
											<tr>
												<th align="left">Parcelas Restantes:</th>
												<td align="left"><input type="text" value="<?php print($complemento['finParcelasRestantes']);?>" name="finParcelasRestantes" id="finParcelasRestantes" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Banco:</th>
												<td align="left"><input type="text" value="<?php print($complemento['finBanco']);?>" name="finBanco" id="finBanco" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Apto para uso de FGTS:</th>
												<td align="left"><?php montaCheckSimNao($complemento['aptoUsoFgts'], "aptoUsoFgts", "style='width:15px;'");?></td>
											</tr>
											<tr>
												<th align="left">Condi&ccedil;&atilde;o de Pagamento</th>
												<td align="left"><input type="text" value="<?php print($complemento['finCondPagamento']);?>" name="finCondPagamento" id="finCondPagamento" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Pend&ecirc;ncias</th>
												<td align="left"><input type="text" value="<?php print($complemento['finPendencias']);?>" name="finPendencias" id="finPendencias" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Permuta</th>
												<td align="left"><input type="text" value="<?php print($complemento['finPermuta']);?>" name="finPermuta" id="finPermuta" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Observa&ccedil;&atilde;o Terreno</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">Observa&ccedil;&atilde;o:</th>
												<td align="left"><textarea name="obsTerreno" id="obsTerreno" rows="3" style="height:120px;"><?php print($complemento['obsTerreno']);?></textarea></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Acabamentos</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">Observa&ccedil;&atilde;o:</th>
												<td align="left"><textarea name="acabamentos" id="acabamentos" rows="3" style="height:120px;"><?php print($complemento['acabamentos']);?></textarea></td>
											</tr>
											<tr>
												<th align="left">Pintura:</th>
												<td align="left"><input type="text" value="<?php print($complemento['pintura']);?>" name="pintura" id="pintura" maxlength="150"></td>
											</tr>
											<tr>
												<th align="left">Piso:</th>
												<td align="left"><input type="text" value="<?php print($complemento['piso']);?>" name="piso" id="piso" maxlength="150"></td>
											</tr>
											<tr>
												<th align="left">Mob&iacute;lia:</th>
												<td align="left"><input type="text" value="<?php print($complemento['mobilia']);?>" name="mobilia" id="mobilia" maxlength="150"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>An&uacute;ncio</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">An&uacute;ncio:</th>
												<td align="left">
													<select name="anuncio" id="anuncio">
														<option value="Jornal" <?php if($complemento['anuncio']=="Jornal")	print("selected");?>">Jornal</option>
														<option value="Site" <?php if($complemento['anuncio']=="Site")	print("selected");?>>Site</option>
														<option value="Rede" <?php if($complemento['anuncio']=="Rede")	print("selected");?>>Rede</option>
														<option value="Revista" <?php if($complemento['anuncio']=="Revista")	print("selected");?>>Revista</option>
														<option value="N&atilde;o Enviar" <?php if($complemento['anuncio']=="Não Enviar")	print("selected");?>>N&atilde;o Enviar</option>
													</select>
												</td>
											</tr>
											<tr>
												<th valign="top" align="left">Pontos Fortes:</th>
												<td align="left"><textarea name="anuncioPontosFortes" id="anuncioPontosFortes" rows="3" style="height:120px;"><?php print($complemento['anuncioPontosFortes']);?></textarea></td>
											</tr>
										</table>
									</fieldset>
									<table align="center" border="0" cellspacing="3" cellpadding="3">
										<tr valign="baseline">
											<td nowrap align="center">
												<input name="cadastrar" type="submit" id="form_submit" value="Salvar">
											</td>
										</tr>
									</table>
								</form>
							</td>
						</tr>
					</table>
				<?php
			}
			elseif($complemento['tipo']=="apartamentos"){
				print("
					<table width='100%' cellpadding='2' cellspacing='2'>
						<tr>
							<td width='90%'>&nbsp;</td>
							<td align='right'>
								<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&id=$id' title='Informações Complementares'>
									<div class='app_botao'><img src='imagens/complementos.png' border='0' class='icone_botao'>Complementos</div>
								</a>
							</td>
						</tr>
					</table>
				");
				?>
					<table align="center" width="450" border="0" cellspacing="3" cellpadding="3">
						<tr>
							<td align="right" style="color:787878; letter-spacing:1px; font-size:85%;">* Campos Obrigat&oacute;rios</td>
						</tr>
						<tr valign="baseline">
							<td nowrap align="center">
								<form style="width:450px;" name="formCadastro" id="formCadastro" action="index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&tipo2=editar&modo=editarComplementos<?php print("&idComplemento=$complemento[id]&id=$id");?>" method="post" enctype="multipart/form-data">
								  	<fieldset style="width:450px;">
										<legend>Identifica&ccedil;&atilde;o</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Tipo:</th>
												<td align="left">
													<select name="tipoImovel" id="tipoImovel">
														<option value="Alvenaria" <?php if($complemento['tipoImovel']=="Alvenaria")	print("selected");?>>Alvenaria</option>
														<option value="Madeira" <?php if($complemento['tipoImovel']=="Alvenaria")	print("selected");?>>Madeira</option>
														<option value="Mista" <?php if($complemento['tipoImovel']=="Alvenaria")	print("selected");?>>Mista</option>
														<option value="Em Constru&ccedil;&atilde;o" <?php if($complemento['tipoImovel']=="Em Construção")	print("selected");?>>Em Constru&ccedil;&atilde;o</option>
														<option value="Outros" <?php if($complemento['tipoImovel']=="Outros")	print("selected");?>>Outros</option>
													</select>
												</td>
											</tr>
											<tr>
												<th align="left">Outro Tipo:</th>
												<td align="left"><input type="text" value="<?php print($complemento['outroTipoImovel']);?>" name="outroTipoImovel" id="outroTipoImovel" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Localiza&ccedil;&atilde;o</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Estado:</th>
												<td align="left"><?php print(devolveEstado($imovel['idEstado'])); ?></td>
											</tr>
											<tr>
										  		<th align="left">Cidade:</th>
										  		<td align="left"><?php print(devolveInfoCampo("nome", "cidades", $imovel['idCidade']));?>
												</td>
									 		</tr>
									 		<tr>
										  		<th align="left">Regi&atilde;o:</th>
										  		<td align="left"><?php print(devolveInfoCampo("nome", "regiao", $imovel['idRegiao']));?>
												</td>
									 		</tr>
									 		<tr>
										  		<th align="left">Bairro:</th>
										  		<td align="left"><?php print(devolveInfoCampo("nome", "bairros", $imovel['idBairro']));?>
												</td>
									 		</tr>
									 		<tr>
										  		<th align="left">Endere&ccedil;o:</th>
										  		<td align="left"><?php print($imovel['endereco']);?>
												</td>
									 		</tr>
									 		<tr>
												<th align="left">CEP:</th>
												<td align="left"><input type="text" value="<?php print($complemento['cep']);?>" name="cep" id="cep" maxlength="9" mascara="#####-###" tipo="numerico"></td>
											</tr>
											<tr>
												<th align="left">Refer&ecirc;ncia:</th>
												<td align="left"><input type="text" value="<?php print($complemento['referencia']);?>" name="referencia" id="referencia" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Complemento:</th>
												<td align="left"><input type="text" value="<?php print($complemento['complemento']);?>" name="complemento" id="complemento" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Edif&iacute;cio:</th>
												<td align="left"><input type="text" value="<?php print($complemento['edificio']);?>" name="edificio" id="edificio" maxlength="150"></td>
											</tr>
									 		<tr>
												<th align="left">Apartamento:</th>
												<td align="left"><input type="text" value="<?php print($complemento['apartamento']);?>" name="apartamento" id="apartamento" maxlength="30"></td>
											</tr>
									 		<tr>
												<th align="left">Andar:</th>
												<td align="left"><input type="text" value="<?php print($complemento['andar']);?>" name="andar" id="andar" maxlength="30"></td>
											</tr>
											<tr>
												<th align="left">Bloco:</th>
												<td align="left"><input type="text" value="<?php print($complemento['bloco']);?>" name="bloco" id="bloco" maxlength="30"></td>
											</tr>
											<tr>
												<th align="left">Construtora:</th>
												<td align="left"><input type="text" value="<?php print($complemento['construtora']);?>" name="construtora" id="construtora" maxlength="150"></td>
											</tr>
											<tr>
												<th align="left">N&ordm; Pavimentos:</th>
												<td align="left"><input type="text" value="<?php print($complemento['numPavimentos']);?>" name="numPavimentos" id="numPavimentos" maxlength="30"></td>
											</tr>
											<tr>
												<th align="left">Ap&acute;tos. por Andar:</th>
												<td align="left"><input type="text" value="<?php print($complemento['aptosAndar']);?>" name="aptosAndar" id="aptosAndar" maxlength="30"></td>
											</tr>
											<tr>
												<th align="left">Taxa Mudan&ccedil;a:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['taxaMudanca']));?>" name="taxaMudanca" id="taxaMudanca" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Portaria Fone:</th>
												<td align="left"><input type="text" value="<?php print($complemento['portariaFone']);?>" name="portariaFone" id="portariaFone" maxlength="14" mascara="(##) ####-####" tipo="numerico"></td>
											</tr>
											<tr>
												<th align="left">Adm. Condom&iacute;nio:</th>
												<td align="left"><input type="text" value="<?php print($complemento['admCondominio']);?>" name="admCondominio" id="admCondominio" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Fone:</th>
												<td align="left"><input type="text" value="<?php print($complemento['admCondominioFone']);?>" name="admCondominioFone" id="admCondominioFone" maxlength="14" mascara="(##) ####-####" tipo="numerico"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Informa&ccedil;&otilde;es</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Idade:</th>
												<td align="left"><input type="text" value="<?php print($complemento['idade']);?>" name="idade" id="idade" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Tipo de &Aacute;rea:</th>
												<td align="left"><input type="text" value="<?php print($complemento['tipoArea']);?>" name="tipoArea" id="tipoArea" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Ocupado:</th>
												<td align="left"><input type="text" value="<?php print($complemento['ocupado']);?>" name="ocupado" id="ocupado" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Chaves:</th>
												<td align="left"><input type="text" value="<?php print($complemento['chaves']);?>" name="chaves" id="chaves" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Matr&iacute;cula:</th>
												<td align="left"><input type="text" value="<?php print($complemento['matricula']);?>" name="matricula" id="matricula" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Circunscri&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['circunscricao']);?>" name="circunscricao" id="circunscricao" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Inscri&ccedil;&atilde;o Imobili&aacute;ria:</th>
												<td align="left"><input type="text" value="<?php print($complemento['inscricaoImobiliaria']);?>" name="inscricaoImobiliaria" id="inscricaoImobiliaria" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Contrato:</th>
												<td align="left"><input type="text" value="<?php print($complemento['contrato']);?>" name="contrato" id="contrato" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Averbado:</th>
												<td align="left"><input type="text" value="<?php print($complemento['averbado']);?>" name="averbado" id="averbado" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Conserva&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['conservacao']);?>" name="conservacao" id="conservacao" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Pavimenta&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['pavimentacao']);?>" name="pavimentacao" id="pavimentacao" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Hor&aacute;rio de Visita:</th>
												<td align="left"><input type="text" value="<?php print($complemento['horaVisita']);?>" name="horaVisita" id="horaVisita" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Entrega:</th>
												<td align="left"><input type="text" value="<?php print($complemento['entrega']);?>" name="entrega" id="entrega" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Estilo:</th>
												<td align="left"><input type="text" value="<?php print($complemento['estilo']);?>" name="estilo" id="estilo" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Tipo de Forro:</th>
												<td align="left"><input type="text" value="<?php print($complemento['tipoForro']);?>" name="tipoForro" id="tipoForro" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Placa:</th>
												<td align="left"><input type="text" value="<?php print($complemento['placa']);?>" name="placa" id="placa" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Posi&ccedil;&atilde;o do Sol:</th>
												<td align="left"><input type="text" value="<?php print($complemento['posicaoSol']);?>" name="posicaoSol" id="posicaoSol" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Comiss&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print($complemento['comissao']);?>" name="comissao" id="comissao" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Valor</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Total:</th>
												<td align="left"><?php print("R$ ".devolveValor($imovel['valor']));?></td>
											</tr>
											<tr>
												<th align="left">&Iacute;ndice:</th>
												<td align="left"><input type="text" value="<?php print($complemento['indice']);?>" name="indice" id="indice" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Venda:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['venda']));?>" name="venda" id="venda" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Loca&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['locacao']));?>" name="locacao" id="locacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Poll Loca&ccedil;&atilde;o:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['poolLocacao']));?>" name="poolLocacao" id="poolLocacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Rendimento:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['rendimento']));?>" name="rendimento" id="rendimento" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Condom&iacute;nio:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['condominio']));?>" name="condominio" id="condominio" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">TLU:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['tlu']));?>" name="tlu" id="tlu" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">IPTU:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['iptu']));?>" name="iptu" id="iptu" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Luz:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['valorLuz']));?>" name="valorLuz" id="valorLuz" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Luz &eacute; individual:</th>
												<td align="left"><?php montaCheckSimNao($complemento['luzIndividual'], "luzIndividual", "style='width:15px;'"); ?></td>
											</tr>
											<tr>
												<th align="left">N&ordm; Rel&oacute;gio / Conta:</th>
												<td align="left"><input type="text" value="<?php print($complemento['luzIdentificador']);?>" name="luzIdentificador" id="luzIdentificador" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">&Aacute;gua:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['valorAgua']));?>" name="valorAgua" id="valorAgua" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">&Aacute;gua &eacute; individual:</th>
												<td align="left"><?php montaCheckSimNao($complemento['aguaIndividual'], "aguaIndividual", "style='width:15px;'"); ?></td>
											</tr>
											<tr>
												<th align="left">N&ordm; Hidr&ocirc;metro / Localiz.:</th>
												<td align="left"><input type="text" value="<?php print($complemento['aguaIdentificador']);?>" name="aguaIdentificador" id="aguaIdentificador" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>&Aacute;rea</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Total:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaTotal']);?>" name="areaTotal" id="areaTotal" maxlength="50"></td>
											</tr>
											<tr>
												<th align="left">Privativo:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaPrivativo']);?>" name="areaPrivativo" id="areaPrivativo" maxlength="50"></td>
											</tr>
											<tr>
												<th align="left">Garagem:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaGaragem']);?>" name="areaGaragem" id="areaGaragem" maxlength="50"></td>
											</tr>
											<tr>
												<th align="left">Comum.:</th>
												<td align="left"><input type="text" value="<?php print($complemento['areaComum']);?>" name="areaComum" id="areaComum" maxlength="50"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Metragem</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">Frente:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemFrente']);?>" name="metragemFrente" id="metragemFrente" maxlength="50"></td>
											</tr>
											<tr>
												<th width="30%" align="left">Fundo:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemFundo']);?>" name="metragemFundo" id="metragemFundo" maxlength="50"></td>
											</tr>
											<tr>
												<th width="30%" align="left">Lateral &agrave; Direita:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemDireita']);?>" name="metragemDireita" id="metragemDireita" maxlength="50"></td>
											</tr>
											<tr>
												<th width="30%" align="left">Lateral &agrave; Esquerda:</th>
												<td align="left"><input type="text" value="<?php print($complemento['metragemEsquerda']);?>" name="metragemEsquerda" id="metragemEsquerda" maxlength="50"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Financiamento</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" align="left">VL. Poupan&ccedil;a:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['finPoupanca']));?>" name="finPoupanca" id="finPoupanca" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Saldo Devedor:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['finSaldoDevedor']));?>" name="finSaldoDevedor" id="finSaldoDevedor" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">VL. Presta&ccedil;&otilde;es:</th>
												<td align="left"><input type="text" value="<?php print(devolveValor($complemento['finValorPrestacao']));?>" name="finValorPrestacao" id="finValorPrestacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
											</tr>
											<tr>
												<th align="left">Parcelas Pagas:</th>
												<td align="left"><input type="text" value="<?php print($complemento['finParcelasPagas']);?>" name="finParcelasPagas" id="finParcelasPagas" maxlength="100" tipo="numerico"></td>
											</tr>
											<tr>
												<th align="left">Parcelas Restantes:</th>
												<td align="left"><input type="text" value="<?php print($complemento['finParcelasRestantes']);?>" name="finParcelasRestantes" id="finParcelasRestantes" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Banco:</th>
												<td align="left"><input type="text" value="<?php print($complemento['finBanco']);?>" name="finBanco" id="finBanco" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Apto para uso de FGTS:</th>
												<td align="left"><?php montaCheckSimNao($complemento['aptoUsoFgts'], "aptoUsoFgts", "style='width:15px;'");?></td>
											</tr>
											<tr>
												<th align="left">Condi&ccedil;&atilde;o de Pagamento</th>
												<td align="left"><input type="text" value="<?php print($complemento['finCondPagamento']);?>" name="finCondPagamento" id="finCondPagamento" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Pend&ecirc;ncias</th>
												<td align="left"><input type="text" value="<?php print($complemento['finPendencias']);?>" name="finPendencias" id="finPendencias" maxlength="100"></td>
											</tr>
											<tr>
												<th align="left">Permuta</th>
												<td align="left"><input type="text" value="<?php print($complemento['finPermuta']);?>" name="finPermuta" id="finPermuta" maxlength="100"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>Acabamentos</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">Observa&ccedil;&atilde;o:</th>
												<td align="left"><textarea name="acabamentos" id="acabamentos" rows="3" style="height:120px;"><?php print($complemento['acabamentos']);?></textarea></td>
											</tr>
											<tr>
												<th align="left">Pintura:</th>
												<td align="left"><input type="text" value="<?php print($complemento['pintura']);?>" name="pintura" id="pintura" maxlength="150"></td>
											</tr>
											<tr>
												<th align="left">Piso:</th>
												<td align="left"><input type="text" value="<?php print($complemento['piso']);?>" name="piso" id="piso" maxlength="150"></td>
											</tr>
											<tr>
												<th align="left">Mob&iacute;lia:</th>
												<td align="left"><input type="text" value="<?php print($complemento['mobilia']);?>" name="mobilia" id="mobilia" maxlength="150"></td>
											</tr>
										</table>
									</fieldset>
									<br>
									<fieldset style="width:450px;">
										<legend>An&uacute;ncio</legend>
								    	<table align="center" border="0" cellspacing="3" cellpadding="3">
											<tr>
												<th width="30%" valign="top" align="left">An&uacute;ncio:</th>
												<td align="left">
													<select name="anuncio" id="anuncio">
														<option value="Jornal" <?php if($complemento['anuncio']=="Jornal")	print("selected");?>">Jornal</option>
														<option value="Site" <?php if($complemento['anuncio']=="Site")	print("selected");?>>Site</option>
														<option value="Rede" <?php if($complemento['anuncio']=="Rede")	print("selected");?>>Rede</option>
														<option value="Revista" <?php if($complemento['anuncio']=="Revista")	print("selected");?>>Revista</option>
														<option value="N&atilde;o Enviar" <?php if($complemento['anuncio']=="Não Enviar")	print("selected");?>>N&atilde;o Enviar</option>
													</select>
												</td>
											</tr>
											<tr>
												<th valign="top" align="left">Pontos Fortes:</th>
												<td align="left"><textarea name="anuncioPontosFortes" id="anuncioPontosFortes" rows="3" style="height:120px;"><?php print($complemento['anuncioPontosFortes']);?></textarea></td>
											</tr>
										</table>
									</fieldset>
									<table align="center" border="0" cellspacing="3" cellpadding="3">
										<tr valign="baseline">
											<td nowrap align="center">
												<input name="cadastrar" type="submit" id="form_submit" value="Salvar">
											</td>
										</tr>
									</table>
								</form>
							</td>
						</tr>
					</table>
				<?php
			}
		}
		else{
			$verimagem="Não Cadastrada";
			if($linha[imagem])
				$verimagem = "<a href='../imoveis/g_$linha[imagem]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0' class='icone_botao'> $linha[imagem]</a>";

			$nomeCategoria=devolveInfoCampo("nome", "categorias", $linha['idCategoria']);
			$nomeSubcategoria=devolveInfoCampo("nome", "subcategorias", $linha['idSubCategoria']);

			$estado=devolveEstado($linha['idEstado']);
			$nomeCidade=devolveInfoCampo("nome", "cidades", $linha['idCidade']);
			$nomeRegiao=devolveInfoCampo("nome", "regiao", $linha['idRegiao']);
			$nomeBairro=devolveInfoCampo("nome", "bairros", $linha['idBairro']);

			$valorTotal="R$ ".devolveValor($linha['valor']);
			$valorVenda="R$ ".devolveValor($complemento['venda']);
			$valorLocacao="R$ ".devolveValor($complemento['locacao']);
			$valorCondominio="R$ ".devolveValor($complemento['condominio']);
			$valorTlu="R$ ".devolveValor($complemento['tlu']);
			$valorIptu="R$ ".devolveValor($complemento['iptu']);

			$valorPoupanca="R$ ".devolveValor($complemento['finPoupanca']);
			$valorSaldoDevedor="R$ ".devolveValor($complemento['finSaldoDevedor']);
			$valorPrestacoes="R$ ".devolveValor($complemento['finValorPrestacao']);

			$trIdentificacao="";
			$trInfoLocalizacao="";
			$trInfoInformacoes="";
			$trInfoValor="";
			$trInfoArea="";
			$trInfoFinanciamento="";
			$metragem="";
			$edficado="";
			$terreno="";
			$croqui="";
			$acabamentos="";
			$contato="";

			if($complemento['tipo']=="terrenos"){
				$trInfoLocalizacao="
					<tr>
						<th align='left'>Contato Vizinho</th>
						<th align='left'>Fone Vizinho</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[vizinho]</td>
						<td align='left'>&nbsp;$complemento[foneVizinho]</td>
					</tr>
				";

				$trInfoInformacoes="
					<tr>
						<th align='left'>Posição Sol</th>
						<th align='left'>Classificação</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[tipoForro]</td>
						<td align='left'>&nbsp;$complemento[classificacao]</td>
					</tr>
				";

				$trInfoArea="
					<tr>
						<th align='left' width='50%'>Área Total</th>
						<th align='left' width='50%'>Área Terreno</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[areaTotal]</td>
						<td align='left'>&nbsp;$complemento[areaTerreno]</td>
					</tr>
					<tr>
						<th align='left'>Área Preservação</th>
						<th align='left'>Área Hectares</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[areaPreservacao]</td>
						<td align='left'>&nbsp;$complemento[areaHectares]</td>
					</tr>
				";

				$metragem="
					<table width='100%' align='center' id='gradient-style-detalhes'>
						<tr>
							<th align='left' width='50%'>Metragem Frente</th>
							<th align='left' width='50%'>Metragem Fundo</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[metragemFrente]</td>
							<td align='left'>&nbsp;$complemento[metragemFundo]</td>
						</tr>
						<tr>
							<th align='left'>Metragem Direita</th>
							<th align='left'>Metragem Esquerda</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[metragemDireita]</td>
							<td align='left'>&nbsp;$complemento[metragemEsquerda]</td>
						</tr>
					</table>
				";

				$trInfoFinanciamento="
					<tr>
						<th align='left'>Permuta</th>
						<th align='left'>&nbsp;</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[finPermuta]</td>
						<td align='left'>&nbsp;</td>
					</tr>
				";

				$edificado="
					<table width='100%' align='center' id='gradient-style-detalhes'>
						<tr>
							<th align='left' colspan='2'>Edificado</th>
						</tr>
						<tr>
							<td colspan='2' align='left'>&nbsp;$complemento[edificado]</td>
						</tr>
					</table>
				";

				$terreno="
					<table width='100%' align='center' id='gradient-style-detalhes'>
						<tr>
							<th align='left' colspan='2'>Terreno</th>
						</tr>
						<tr>
							<td colspan='2' align='left'>&nbsp;$complemento[obsTerreno]</td>
						</tr>
						<tr>
							<th align='left'>Zoneamento</th>
							<th align='left'>Nº Pavimentos</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[zoneamento]</td>
							<td align='left'>&nbsp;$complemento[numPavimentos]</td>
						</tr>
					</table>
				";

				$vercroqui="Não Cadastrado";
				if($complemento['croqui'])
					$vercroqui = "<a href='../imoveis/g_$complemento[croqui]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0' class='icone_botao'> $complemento[croqui]</a>";
				$croqui="
					<table width='100%' align='center' id='gradient-style-detalhes'>
						<tr>
							<th align='left' colspan='2'>Croqui</th>
						</tr>
						<tr>
							<td colspan='2' align='left'>&nbsp;$vercroqui</td>
						</tr>
					</table>
				";

				$contato="
					<table width='100%' align='center' id='gradient-style-detalhes'>
						<tr>
							<th align='left'>Contato</th>
							<th align='left'>E-mail</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[conContato]</td>
							<td align='left'>&nbsp;$complemento[conEmail]</td>
						</tr>
						<tr>
							<th align='left'>Telefone #1</th>
							<th align='left'>Telefone #2</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[conTelefone1]</td>
							<td align='left'>&nbsp;$complemento[conTelefone2]</td>
						</tr>
						<tr>
							<th align='left'>Outro Contato</th>
							<th align='left'>Fone Outro Contato</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[conOutroContato]</td>
							<td align='left'>&nbsp;$complemento[conTelefoneOutro]</td>
						</tr>
					</table>
				";

			} // fim terrenos

			if($complemento['tipo']=="residencias"){
				$trIdentificacao="
					<tr>
						<th align='left'>Tipo</th>
						<th align='left'>Outro Tipo</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[tipoImovel]</td>
						<td align='left'>&nbsp;$complemento[outroTipoImovel]</td>
					</tr>
				";

				$trInfoLocalizacao="
					<tr>
						<th align='left'>Condomínio Fechado</th>
						<th align='left'>Nº Total de Casas</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[condominioFechado]</td>
						<td align='left'>&nbsp;$complemento[numCasasCondominio]</td>
					</tr>
				";

				$trInfoInformacoes="
					<tr>
						<th align='left'>Posição Sol</th>
						<th align='left'>Comissão (%)</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[tipoForro]</td>
						<td align='left'>&nbsp;$complemento[comissao]</td>
					</tr>
				";

				$valorLuz="R$ ".devolveValor($complemento['valorLuz']);
				$luzIndividual=devolveSimNao($complemento['luzIndividual']);
				$valorAgua="R$ ".devolveValor($complemento['valorAgua']);
				$aguaIndividual=devolveSimNao($complemento['aguaIndividual']);
				$trInfoValor="
					<tr>
						<th align='left'>Valor Luz</th>
						<th align='left'>Luz é individual | Nº Relógio/Conta</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorLuz</td>
						<td align='left'>&nbsp;$luzIndividual | $complemento[luzIdentificador]</td>
					</tr>
					<tr>
						<th align='left'>Valor Água</th>
						<th align='left'>Água é individual | Nº Hidrômetro/Localização</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorAgua</td>
						<td align='left'>&nbsp;$aguaIndividual | $complemento[aguaIdentificador]</td>
					</tr>
				";

				$trInfoArea="
					<tr>
						<th align='left' width='50%'>Área Total</th>
						<th align='left' width='50%'>Área Terreno</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[areaTotal]</td>
						<td align='left'>&nbsp;$complemento[areaTerreno]</td>
					</tr>
				";

				$metragem="
					<table width='100%' align='center' id='gradient-style-detalhes'>
						<tr>
							<th align='left' width='50%'>Metragem Frente</th>
							<th align='left' width='50%'>Metragem Fundo</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[metragemFrente]</td>
							<td align='left'>&nbsp;$complemento[metragemFundo]</td>
						</tr>
						<tr>
							<th align='left'>Metragem Direita</th>
							<th align='left'>Metragem Esquerda</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[metragemDireita]</td>
							<td align='left'>&nbsp;$complemento[metragemEsquerda]</td>
						</tr>
					</table>
				";
				$aptoUsoFgts=devolveSimNao($complemento['aptoUsoFgts']);
				$trInfoFinanciamento="
					<tr>
						<th align='left'>Apto Uso Fgts</th>
						<th align='left'>Permuta</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$aptoUsoFgts</td>
						<td align='left'>&nbsp;$complemento[finPermuta]</td>
					</tr>
				";

				$terreno="
					<table width='100%' align='center' id='gradient-style-detalhes'>
						<tr>
							<th align='left' colspan='2'>Terreno</th>
						</tr>
						<tr>
							<td colspan='2' align='left'>&nbsp;$complemento[obsTerreno]</td>
						</tr>
					</table>
				";

				$acabamentos="
					<table width='100%' align='center' id='gradient-style-detalhes'>
						<tr>
							<th width='50%' align='left'>Acabamentos</th>
							<th width='50%' align='left'>Pintura</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[acabamentos]</td>
							<td align='left'>&nbsp;$complemento[pintura]</td>
						</tr>
						<tr>
							<th align='left'>Piso</th>
							<th align='left'>Mobília</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[piso]</td>
							<td align='left'>&nbsp;$complemento[mobilia]</td>
						</tr>
					</table>
				";
			}// fim residencias

			if($complemento['tipo']=="apartamentos"){
				$trIdentificacao="
					<tr>
						<th align='left'>Tipo</th>
						<th align='left'>Outro Tipo</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[tipoImovel]</td>
						<td align='left'>&nbsp;$complemento[outroTipoImovel]</td>
					</tr>
				";

				$taxaMudanca="R$ ".devolveValor($complemento['taxaMudanca']);
				$trInfoLocalizacao="
					<tr>
						<th align='left'>Edifício</th>
						<th align='left'>Andar | Apartamento | Bloco</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[edificio]</td>
						<td align='left'>&nbsp;$complemento[andar] | $complemento[apartamento] | $complemento[bloco]</td>
					</tr>
					<tr>
						<th align='left'>Construtora</th>
						<th align='left'>Nº Pavimentos | Aptos./Andar</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[construtora]</td>
						<td align='left'>&nbsp;$complemento[numPavimentos] | $complemento[aptosAndar]</td>
					</tr>
					<tr>
						<th align='left'>Taxa Mudança</th>
						<th align='left'>Portaria Fone</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$taxaMudanca</td>
						<td align='left'>&nbsp;$complemento[portariaFone]</td>
					</tr>
					<tr>
						<th align='left'>Adm. Condomínio</th>
						<th align='left'>Adm. Condomínio Fone</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[admCondominio]</td>
						<td align='left'>&nbsp;$complemento[admCondominioFone]</td>
					</tr>
				";

				$trInfoInformacoes="
					<tr>
						<th align='left'>Posição Sol</th>
						<th align='left'>Comissão (%)</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[tipoForro]</td>
						<td align='left'>&nbsp;$complemento[comissao]</td>
					</tr>
				";

				$valorPoolLocacao="R$ ".devolveValor($complemento['poolLocacao']);
				$valorRendimento="R$ ".devolveValor($complemento['rendimento']);
				$valorLuz="R$ ".devolveValor($complemento['valorLuz']);
				$luzIndividual=devolveSimNao($complemento['luzIndividual']);
				$valorAgua="R$ ".devolveValor($complemento['valorAgua']);
				$aguaIndividual=devolveSimNao($complemento['aguaIndividual']);
				$trInfoValor="
					<tr>
						<th align='left'>Valor Pool Locação</th>
						<th align='left'>Valor Rendimento</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorPoolLocacao</td>
						<td align='left'>&nbsp;$valorRendimento</td>
					</tr>
					<tr>
						<th align='left'>Valor Luz</th>
						<th align='left'>Luz é individual | Nº Relógio/Conta</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorLuz</td>
						<td align='left'>&nbsp;$luzIndividual | $complemento[luzIdentificador]</td>
					</tr>
					<tr>
						<th align='left'>Valor Água</th>
						<th align='left'>Água é individual | Nº Hidrômetro/Localização</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorAgua</td>
						<td align='left'>&nbsp;$aguaIndividual | $complemento[aguaIdentificador]</td>
					</tr>
				";

				$trInfoArea="
					<tr>
						<th align='left' width='50%'>Área Total</th>
						<th align='left' width='50%'>Área Privativo</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[areaTotal]</td>
						<td align='left'>&nbsp;$complemento[areaPrivativo]</td>
					</tr>
					<tr>
						<th align='left'>Área Garagem</th>
						<th align='left'>Área Comum.</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[areaGaragem]</td>
						<td align='left'>&nbsp;$complemento[areaComum]</td>
					</tr>
				";
				$aptoUsoFgts=devolveSimNao($complemento['aptoUsoFgts']);
				$trInfoFinanciamento="
					<tr>
						<th align='left'>Apto Uso Fgts</th>
						<th align='left'>Permuta</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$aptoUsoFgts</td>
						<td align='left'>&nbsp;$complemento[finPermuta]</td>
					</tr>
				";
				$acabamentos="
					<table width='100%' align='center' id='gradient-style-detalhes'>
						<tr>
							<th width='50%' align='left'>Acabamentos</th>
							<th width='50%' align='left'>Pintura</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[acabamentos]</td>
							<td align='left'>&nbsp;$complemento[pintura]</td>
						</tr>
						<tr>
							<th align='left'>Piso</th>
							<th align='left'>Mobília</th>
						</tr>
						<tr>
							<td align='left'>&nbsp;$complemento[piso]</td>
							<td align='left'>&nbsp;$complemento[mobilia]</td>
						</tr>
					</table>
				";
			}//fim apartamentos

			print("
				<table width='100%' cellpadding='2' cellspacing='2'>
					<tr>
						<td width='80%'>&nbsp;</td>
						<td align='right'>
							<a href='index.php?modulo=imoveis&acao=imovelinfo&&tipo=complementos&tipo2=editarComplementos&id=$id' title='Editar Complementos'>
								<div class='app_botao'><img src='imagens/editar.png' border='0' class='icone_botao'> Editar</div>
							</a>
						</td>
						<td align='right'>
							<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$id' title='Ver Detalhes'>
								<div class='app_botao'><img src='imagens/ver_detalhes.png' border='0' class='icone_botao'> Ver Detalhes</div>
							</a>
						</td>
					</tr>
				</table>
				<table width='100%' align='center' id='gradient-style-detalhes'>
					<tr>
						<th align='left' width='50%'>Referência</th>
						<th align='left' width='50%'>Imagem</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$linha[referencia]</td>
						<td align='left'>&nbsp;$verimagem</td>
					</tr>
					<tr>
						<th align='left'>Categoria</th>
						<th align='left'>Sub Categoria</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$nomeCategoria</td>
						<td align='left'>&nbsp;$nomeSubcategoria</td>
					</tr>
					$trIdentificacao
				</table>
				<table width='100%' align='center' id='gradient-style-detalhes'>
					<tr>
						<th align='left' width='50%'>Estado</th>
						<th align='left' width='50%'>Cidade</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$estado</td>
						<td align='left'>&nbsp;$nomeCidade</td>
					</tr>
					<tr>
						<th align='left'>Região | Bairro</th>
						<th align='left'>CEP</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$nomeRegiao <b>|</b> $nomeBairro</td>
						<td align='left'>&nbsp;$complemento[cep]</td>
					</tr>
					<tr>
						<th align='left'>Endereco</th>
						<th align='left'>Complemento</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$linha[endereco]</td>
						<td align='left'>&nbsp;$complemento[complemento]</td>
					</tr>
					<tr>
						<th align='left' colspan='2'>Referência</th>
					</tr>
					<tr>
						<td algin='left' colspan='2'>$complemento[referencia]</td>
					</tr>
					$trInfoLocalizacao
				</table>
				<table width='100%' align='center' id='gradient-style-detalhes'>
					<tr>
						<th align='left' width='50%'>Idade</th>
						<th align='left' width='50%'>Tipo de Área</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[idade]</td>
						<td align='left'>&nbsp;$complemento[tipoArea]</td>
					</tr>
					<tr>
						<th align='left'>Ocupado</th>
						<th align='left'>Chaves</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[ocupado]</td>
						<td align='left'>&nbsp;$complemento[chaves]</td>
					</tr>
					<tr>
						<th align='left'>Matrícula</th>
						<th align='left'>Circunscrição</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[matricula]</td>
						<td align='left'>&nbsp;$complemento[circunscricao]</td>
					</tr>
					<tr>
						<th align='left'>Inscrição Imobiliária</th>
						<th align='left'>Contrato</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[inscricaoImobiliaria]</td>
						<td align='left'>&nbsp;$complemento[contrato]</td>
					</tr>
					<tr>
						<th align='left'>Averbado</th>
						<th align='left'>Conservação</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[averbado]</td>
						<td align='left'>&nbsp;$complemento[conservacao]</td>
					</tr>
					<tr>
						<th align='left'>Pavimentação</th>
						<th align='left'>Hora de Visita</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[pavimentacao]</td>
						<td align='left'>&nbsp;$complemento[horaVisita]</td>
					</tr>
					<tr>
						<th align='left'>Entrega</th>
						<th align='left'>Estilo</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[entrega]</td>
						<td align='left'>&nbsp;$complemento[estilo]</td>
					</tr>
					<tr>
						<th align='left'>Tipo de Forro</th>
						<th align='left'>Placa</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[tipoForro]</td>
						<td align='left'>&nbsp;$complemento[placa]</td>
					</tr>
					$trInfoInformacoes
				</table>
				<table width='100%' align='center' id='gradient-style-detalhes'>
					<tr>
						<th colspan='2' align='left'>Índice</th>
					</tr>
					<tr>
						<td colspan='2' align='left'>$complemento[indice]</td>
					</tr>
					<tr>
						<th align='left' width='50%'>Valor Total</th>
						<th align='left' width='50%'>Valor Venda</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorTotal</td>
						<td align='left'>&nbsp;$valorVenda</td>
					</tr>
					<tr>
						<th align='left'>Valor Locação</th>
						<th align='left'>Valor Condomínio</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorLocacao</td>
						<td align='left'>&nbsp;$valorCondominio</td>
					</tr>
					<tr>
						<th align='left'>Valor TLU</th>
						<th align='left'>Valor IPTU $incra</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorTlu</td>
						<td align='left'>&nbsp;$valorIptu</td>
					</tr>
					$trInfoValor
				</table>
				<table width='100%' align='center' id='gradient-style-detalhes'>
					$trInfoArea
				</table>
				$metragem
				<table width='100%' align='center' id='gradient-style-detalhes'>
					<tr>
						<th align='left' width='50%'>Poupança</th>
						<th align='left' width='50%'>Saldo Devedor</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorPoupanca</td>
						<td align='left'>&nbsp;$valorSaldoDevedor</td>
					</tr>
					<tr>
						<th align='left'>Valor Prestações</th>
						<th align='left'>Nº Parcelas Pagas</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$valorPrestacoes</td>
						<td align='left'>&nbsp;$complemento[finParcelasPagas]</td>
					</tr>
					<tr>
						<th align='left'>Banco</th>
						<th align='left'>Nº Parcelas Restantes</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[finBanco]</td>
						<td align='left'>&nbsp;$complemento[finParcelasRestantes]</td>
					</tr>
					<tr>
						<th align='left'>Condição de Pagamento</th>
						<th align='left'>Pendências</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$complemento[finCondPagamento]</td>
						<td align='left'>&nbsp;$complemento[finPendencias]</td>
					</tr>
					$trInfoFinanciamento
				</table>
				");
				devolveListaComposicao($linha['id']);
				print("
				$edificado
				$terreno
				$croqui
				$contato
				$acabamentos
				<table width='100%' align='center' id='gradient-style-detalhes'>
					<tr>
						<th align='left' colspan='2'>Anúncio</th>
					</tr>
					<tr>
						<td colspan='2' align='left'>&nbsp;$complemento[anuncio]</td>
					</tr>
					<tr>
						<th align='left' colspan='2'>Anúncio/Pontos Fortes</th>
					</tr>
					<tr>
						<td colspan='2' align='left'>&nbsp;$complemento[anuncioPontosFortes]</td>
					</tr>
				</table>
				<table width='100%' id='gradient-style-detalhes'>
					<tr>
						<th align='left' width='50%'>Data de Cadastro</th>
						<th align='left' width='50%'>Data de Atualização</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$dataCadastro</td>
						<td align='left'>&nbsp;$dataAtualizacao</td>
					</tr>
					<tr>
						<th align='left'>Usuário que cadastrou</th>
						<th align='left'>Usuário que atualizou</th>
					</tr>
					<tr>
						<td align='left'>&nbsp;$usuarioCadastrou[nome]</td>
						<td align='left'>&nbsp;$usuarioAtualizou</td>
					</tr>
				</table>
			");
		}
	}
	elseif($linha[deletado]==1)
	{
		devolveMensagem("Imóveis removida!", $retorno);
		print("<br><br><div align='center'><p>Selecione a opção desejada no menu ao lado.</p></div>");
		return false;
	}
}
else
{
	print("
		<br><br>
		<h1>
			");
			if(devolveUsuarioLogado())	devolveMensagem(NAO_AUTORIZADO, false);
			print("
		</h1>
		<br><br>
	");
}
?>