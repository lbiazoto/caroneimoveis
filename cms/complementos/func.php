<?php
function existeComplemento($idImovel){
    include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comando = "SELECT * FROM complementos WHERE idImovel=$idImovel";
		debug("XXXXX".$comando);
		$dados = mysql_db_query($bancoDados, $comando);
		$num = mysql_num_rows($dados);
		if ($dados && $num>0)	return true;
	}
	return false;
}
function cadastraInfoTerreno($tipo, $idImovel, $cep, $referencia, $complemento, $vizinho, $foneVizinho,$idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $classificacao,$indice, $venda, $locacao, $condominio, $tlu, $iptuIncra,$areaTotal, $areaTerreno, $areaPreservacao, $areaHectares,$metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda,$finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $finCondPagamento, $finPendencias, $finPermuta,$edificado,$obsTerreno, $zoneamento, $numPavimentos,$croqui,$conContato, $conEmail, $conTelefone1, $conTelefone2, $conOutroContato, $conTelefoneOutro,$anuncio, $anuncioPontosFortes){
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comando = "INSERT INTO complementos(tipo, idImovel, cep, referencia, complemento, vizinho, foneVizinho, idade, tipoArea, ocupado, chaves, matricula, circunscricao, inscricaoImobiliaria, contrato, averbado, conservacao, pavimentacao, horaVisita, entrega, estilo, tipoForro, placa, posicaoSol, classificacao, indice, venda, locacao, condominio, tlu, iptu, areaTotal, areaTerreno, areaPreservacao, areaHectares, metragemFrente, metragemFundo, metragemDireita, metragemEsquerda, finPoupanca, finSaldoDevedor, finValorPrestacao, finParcelasPagas, finParcelasRestantes, finBanco, finCondPagamento, finPendencias, finPermuta,edificado,obsTerreno, zoneamento, numPavimentos,croqui,conContato, conEmail, conTelefone1, conTelefone2, conOutroContato, conTelefoneOutro,anuncio, anuncioPontosFortes, idUsuarioCadastro, dataCadastro)
					VALUES('$tipo', '$idImovel', '$cep', '$referencia', '$complemento', '$vizinho', '$foneVizinho','$idade', '$tipoArea', '$ocupado', '$chaves', '$matricula', '$circunscricao', '$inscricaoImobiliaria', '$contrato', '$averbado', '$conservacao', '$pavimentacao', '$horaVisita', '$entrega', '$estilo', '$tipoForro', '$placa', '$posicaoSol', '$classificacao','$indice', '$venda', '$locacao', '$condominio', '$tlu', '$iptuIncra','$areaTotal', '$areaTerreno', '$areaPreservacao', '$areaHectares','$metragemFrente', '$metragemFundo', '$metragemDireita', '$metragemEsquerda','$finPoupanca', '$finSaldoDevedor', '$finValorPrestacao', '$finParcelasPagas', '$finParcelasRestantes', '$finBanco', '$finCondPagamento', '$finPendencias', '$finPermuta','$edificado','$obsTerreno', '$zoneamento', '$numPavimentos','$croqui','$conContato', '$conEmail', '$conTelefone1', '$conTelefone2', '$conOutroContato', '$conTelefoneOutro','$anuncio', '$anuncioPontosFortes', '$_SESSION[idUsuario]', now())";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)	return true;
	}
	return false;
}

function cadastraInfoResidencia($tipo, $idImovel, $tipoImovel, $outroTipoImovel, $cep, $referencia, $complemento, $condominioFechado, $numCasasCondominio, $idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $comissao, $indice, $venda, $locacao, $condominio, $tlu, $iptuIncra, $valorLuz, $luzIndividual, $luzIdentificador, $valorAgua, $aguaIndividual, $aguaIdentificador, $areaTotal, $areaTerreno, $areaPreservacao, $areaHectares,$metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda,$finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $aptoUsoFgts, $finCondPagamento, $finPendencias, $finPermuta, $obsTerreno, $acabamentos, $pintura, $piso, $mobilia, $anuncio, $anuncioPontosFortes){
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comando = "INSERT INTO complementos(tipo, idImovel, tipoImovel, outroTipoImovel, cep, referencia, complemento, condominioFechado, numCasasCondominio, idade, tipoArea, ocupado, chaves, matricula, circunscricao, inscricaoImobiliaria, contrato, averbado, conservacao, pavimentacao, horaVisita, entrega, estilo, tipoForro, placa, posicaoSol, comissao, indice, venda, locacao, condominio, tlu, iptu, valorLuz, luzIndividual, luzIdentificador, valorAgua, aguaIndividual, aguaIdentificador, areaTotal, areaTerreno, areaPreservacao, areaHectares, metragemFrente, metragemFundo, metragemDireita, metragemEsquerda, finPoupanca, finSaldoDevedor, finValorPrestacao, finParcelasPagas, finParcelasRestantes, finBanco, aptoUsoFgts, finCondPagamento, finPendencias, finPermuta, obsTerreno, acabamentos, pintura, piso, mobilia, anuncio, anuncioPontosFortes, idUsuarioCadastro, dataCadastro)
					VALUES('$tipo', '$idImovel', '$tipoImovel', '$outroTipoImovel', '$cep', '$referencia', '$complemento', '$condominioFechado', '$numCasasCondominio','$idade', '$tipoArea', '$ocupado', '$chaves', '$matricula', '$circunscricao', '$inscricaoImobiliaria', '$contrato', '$averbado', '$conservacao', '$pavimentacao', '$horaVisita', '$entrega', '$estilo', '$tipoForro', '$placa', '$posicaoSol', '$comissao','$indice', '$venda', '$locacao', '$condominio', '$tlu', '$iptuIncra', '$valorLuz', '$luzIndividual', '$luzIdentificador', '$valorAgua', '$aguaIndividual', '$aguaIdentificador', '$areaTotal', '$areaTerreno', '$areaPreservacao', '$areaHectares','$metragemFrente', '$metragemFundo', '$metragemDireita', '$metragemEsquerda','$finPoupanca', '$finSaldoDevedor', '$finValorPrestacao', '$finParcelasPagas', '$finParcelasRestantes', '$finBanco', '$aptoUsoFgts', '$finCondPagamento', '$finPendencias', '$finPermuta','$obsTerreno', '$acabamentos', '$pintura', '$piso', '$mobilia', '$anuncio', '$anuncioPontosFortes', '$_SESSION[idUsuario]', now())";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)	return true;
	}
	return false;
}

function cadastraInfoApartamento($tipo, $idImovel, $tipoImovel, $outroTipoImovel, $edificio, $andar, $apartamento, $bloco, $construtora, $numPavimentos, $aptosAndar, $cep, $referencia, $complemento, $taxaMudanca, $portariaFone, $admCondominio, $admCondominioFone, $idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $comissao, $indice, $venda, $locacao, $poolLocacao, $rendimento, $condominio, $tlu, $iptuIncra, $valorLuz, $luzIndividual, $luzIdentificador, $valorAgua, $aguaIndividual, $aguaIdentificador, $areaTotal, $areaPrivativo, $areaGaragem, $areaComum, $metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda,$finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $aptoUsoFgts, $finCondPagamento, $finPendencias, $finPermuta, $acabamentos, $pintura, $piso, $mobilia, $anuncio, $anuncioPontosFortes){
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comando = "INSERT INTO complementos(tipo, idImovel, tipoImovel, outroTipoImovel, edificio, andar, apartamento, bloco, construtora, numPavimentos, aptosAndar, cep, referencia, complemento, taxaMudanca, portariaFone, admCondominio, admCondominioFone, idade, tipoArea, ocupado, chaves, matricula, circunscricao, inscricaoImobiliaria, contrato, averbado, conservacao, pavimentacao, horaVisita, entrega, estilo, tipoForro, placa, posicaoSol, comissao, indice, venda, locacao, poolLocacao, rendimento, condominio, tlu, iptu, valorLuz, luzIndividual, luzIdentificador, valorAgua, aguaIndividual, aguaIdentificador, areaTotal, areaPrivativo, areaGaragem, areaComum, metragemFrente, metragemFundo, metragemDireita, metragemEsquerda, finPoupanca, finSaldoDevedor, finValorPrestacao, finParcelasPagas, finParcelasRestantes, finBanco, aptoUsoFgts, finCondPagamento, finPendencias, finPermuta, obsTerreno, acabamentos, pintura, piso, mobilia, anuncio, anuncioPontosFortes, idUsuarioCadastro, dataCadastro)
					VALUES('$tipo', '$idImovel', '$tipoImovel', '$outroTipoImovel', '$edificio', '$andar', '$apartamento', '$bloco', '$construtora', '$numPavimentos', '$aptosAndar', '$cep', '$referencia', '$complemento', '$taxaMudanca', '$portariaFone', '$admCondominio', '$admCondominioFone', '$idade', '$tipoArea', '$ocupado', '$chaves', '$matricula', '$circunscricao', '$inscricaoImobiliaria', '$contrato', '$averbado', '$conservacao', '$pavimentacao', '$horaVisita', '$entrega', '$estilo', '$tipoForro', '$placa', '$posicaoSol', '$comissao','$indice', '$venda', '$locacao', '$poolLocacao', '$rendimento', '$condominio', '$tlu', '$iptuIncra', '$valorLuz', '$luzIndividual', '$luzIdentificador', '$valorAgua', '$aguaIndividual', '$aguaIdentificador', '$areaTotal', '$areaPrivativo', '$areaGaragem', '$areaComum','$metragemFrente', '$metragemFundo', '$metragemDireita', '$metragemEsquerda','$finPoupanca', '$finSaldoDevedor', '$finValorPrestacao', '$finParcelasPagas', '$finParcelasRestantes', '$finBanco', '$aptoUsoFgts', '$finCondPagamento', '$finPendencias', '$finPermuta','$obsTerreno', '$acabamentos', '$pintura', '$piso', '$mobilia', '$anuncio', '$anuncioPontosFortes', '$_SESSION[idUsuario]', now())";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)	return true;
	}
	return false;
}

function montaSelect($tabela, $idSelecionado, $where)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comandoSql = "SELECT * FROM $tabela WHERE deletado=0 $where ORDER BY nome ASC";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if(mysql_num_rows($dados) == 0)
			{
				//print("Nenhum registro encontrado.");
			}else
			{
				while ($linha = mysql_fetch_array($dados))
				{
					if($linha[id] == "$idSelecionado") $selected = "selected"; else $selected = "";
					print("<option value='$linha[id]' $selected>$linha[nome]</option>");
				}
			}
		}
	}
}

function devolveListaImoveis($acao, $index, $mark, $where, $orderBy, $post){
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comandoSql = "SELECT imo.id as id, imo.referencia as referencia, imo.idCliente as idCliente, imo.idCategoria as idCategoria, imo.idSubCategoria as idSubCategoria, cli.nome as nomeCliente, cat.nome as nomeCategoria, subcat.nome as nomeSubCategoria, date_format(imo.dataCadastro, '%d/%m/%Y') as dataCadastro FROM imoveis imo, cliente cli, categorias cat, subcategorias subcat $where AND imo.idCliente=cli.id AND imo.idCategoria=cat.id AND imo.idSubCategoria=subcat.id AND cli.deletado=0 AND cat.deletado=0 AND subcat.deletado=0 $orderBy LIMIT $index,25";
		debug($comandoSql);
		if($dados = mysql_db_query($bancoDados, $comandoSql)){
			$numero = mysql_num_rows($dados);
			if($numero!=0){
				devolveNavegacao($index, "index.php?modulo=complementos&acao=terrenos&tipo=listar", $where, $mark, "imoveis", $post);
				print("
				<h2>Selecione um imóvel para acrescentar as informações complementares</h2>
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='17%'>Data de Cadastro</th>
						<th align='left' width='33%'>Cliente</th>
						<th align='left' width='15%'>Referência</th>
						<th align='left' width='35%'>Categoria | SubCategoria</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados)){
					print("
						<tr>
							<td><a href='index.php?modulo=complementos&acao=$acao&tipo=cadastrar&id=$linha[id]' class='linkNormal'>$linha[dataCadastro]</a></td>
							<td><a href='index.php?modulo=complementos&acao=$acao&tipo=cadastrar&id=$linha[id]' class='linkNormal'>$linha[nomeCliente]</a></td>
							<td><a href='index.php?modulo=complementos&acao=$acao&tipo=cadastrar&id=$linha[id]' class='linkNormal'>$linha[referencia]</a></td>
							<td><a href='index.php?modulo=complementos&acao=$acao&tipo=cadastrar&id=$linha[id]' class='linkNormal'>$linha[nomeCategoria] <b>|</b> $linha[nomeSubCategoria]</a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=complementos&acao=terrenos&tipo=listar", $where, $mark, "imoveis", $post);
			}
			else{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='15%'>Data de Cadastro</th>
							<th align='left' width='35%'>Cliente</th>
							<th align='left' width='15%'>Referência</th>
							<th align='left' width='35%'>Categoria/SubCategoria</th>
						</tr>
						<tr>
							<td colspan='4'>
								Nenhum registro de imóveis encontrado para estes filtros.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibiçao dos Imóveis!</strong></center>");
	}
}

function uploadImagem($nome, $pasta, $edit, $codigo)
{
	@$imagem_temp= $_FILES[$nome]['tmp_name'];
	@$imagem_real= $_FILES[$nome]['name'];
	if($edit!=0)
	{
		$imgNum = $edit.".".end(explode('.', $_FILES[$nome]['name']));
		$img="imagem".$imgNum;
	}
	else
	{
		$imgNum = devolveNumUpload() .".".end(explode('.', $_FILES[$nome]['name']));
		$img="imagem".$imgNum;
		$img = strtolower($img);
	}
	$imagem_real = "$img";
	if (!move_uploaded_file($imagem_temp, "$pasta/$imagem_real"))
		print("<BR><center><strong><font color='#FF0000'>Erro no upload!</font></strong></center>");
	return $imagem_real;
}
function imageResize($imagem, $pasta, $extNome, $largura, $altura){
	$endereco = "$pasta/".$imagem;
	//extensão da imagem que foi realizado upload e escolha da função de conversão de imagem
	$ext = explode(".", $imagem);
	if($ext[1]=="jpg" || $ext[1]=="JPG" || $ext[1]=="jpeg")	$imagemAux = imagecreatefromjpeg($endereco);
	elseif($ext[1]=="gif" || $ext[1]=="GIF")				$imagemAux = imagecreatefromgif($endereco);
	elseif($ext[1]=="png" || $ext[1]=="PNG")				$imagemAux = imagecreatefrompng($endereco);
	//dimensões originais
	$width = imagesx($imagemAux);
	$height = imagesy($imagemAux);
	//dimensões desejadas
	$w_MAX = $largura;
	$h_MAX = $altura;
	//calculos de redimensionamento
	$PORCENTAGEM_w = ($w_MAX * 100) / $width;
	$PORCENTAGEM_h = ($h_MAX * 100) / $height;
	if($PORCENTAGEM_w <= 100){
		$_HEIGHT = ($height * $PORCENTAGEM_w) / 100;
		$_WIDTH = $w_MAX;
		if($_HEIGHT > $h_MAX){
			$_HEIGHT = $h_MAX;;
			$_WIDTH = ($width * $PORCENTAGEM_h) / 100;
		}
	}
	elseif($PORCENTAGEM_h <= 100){
		$_HEIGHT = $h_MAX;;
		$_WIDTH = ($width * $PORCENTAGEM_h) / 100;
		if($_HEIGHT > $h_MAX){
			$_WIDTH = $w_MAX;;
			$_HEIGHT = ($height * $PORCENTAGEM_w) / 100;
		}
	}
	else{
		$_HEIGHT = $height;
		$_WIDTH = $width;
	}
	//criação de uma nova imagem com as novas dimensões de acordo com sua extensão original
	$nova_imagem = imagecreatetruecolor($_WIDTH, $_HEIGHT);
	$endereco = "$pasta/$extNome".$imagem;
	imagecopyresampled($nova_imagem, $imagemAux, 0, 0, 0, 0, $_WIDTH, $_HEIGHT, $width, $height);
	if($ext[1]=="jpg" || $ext[1]=="JPG" || $ext[1]=="jpeg")	imagejpeg($nova_imagem, $endereco, 80);
	elseif($ext[1]=="gif" || $ext[1]=="GIF")				imagegif($nova_imagem, $endereco, 80);
	elseif($ext[1]=="png" || $ext[1]=="PNG")				imagepng($nova_imagem, $endereco, 80);

    return true;
}
function devolveNumUpload()
{
  	include("./config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
  	}
  	else
	  {
		$comandoSql = "SELECT numero FROM upload ORDER BY numero DESC LIMIT 1";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				$comandoSql = "UPDATE upload SET numero = numero +1;";
				$dados = mysql_db_query($bancoDados, $comandoSql);

				return $linha['numero'];
			}
			else return false;
		}
		else return false;
	}
}
?>