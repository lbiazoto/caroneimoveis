<?php
function cadastraImovel($tipo, $referencia, $idCliente, $idCategoria, $idSubCategoria, $valor, $video, $imagem, $idEstado, $opcaoCategoria, $listaSubCategoria, $listaSubCategoria2, $endereco, $localizacao_mapa, $marcador, $descricaoCurta, $descricaoCompleta, $maisInformacoes, $destaque, $exclusivo, $dataTerminoExclusividade, $dataAviso, $composicao, $corretor)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$marcador_sql="1";
		if($marcador!="")
			$marcador_sql="0";
		$comandoSql = "
			INSERT INTO imoveis (idCorretor, tipo, referencia, idCliente, idCategoria, idSubCategoria, valor, video, imagem, idEstado, idCidade, idRegiao, idBairro, endereco, localizacao_mapa, marcador, descricaoCurta, descricaoCompleta, maisInformacoes, destaque, exclusivo, dataTerminoExclusividade, dataAviso, idUsuarioCadastro, dataCadastro)
			VALUES ('$corretor','$tipo','$referencia','$idCliente','$idCategoria','$idSubCategoria','$valor','$video','$imagem','$idEstado','$opcaoCategoria','$listaSubCategoria','$listaSubCategoria2','$endereco','$localizacao_mapa', '$marcador_sql','$descricaoCurta','$descricaoCompleta','$maisInformacoes','$destaque','$exclusivo','$dataTerminoExclusividade','$dataAviso','$_SESSION[idUsuario]',now());
		";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$idImovel=mysql_insert_id();
			if($composicao && sizeof($composicao)>0)
			{
				while(list($chave,$linhaArray) = each($composicao))
				{
					if($linhaArray>0)
					{
						$comando2 = "INSERT INTO composicaoimovel(idImovel, idComposicao, qtdeComposicao)	VALUES ('$idImovel', '$chave', '$linhaArray')";
						$dados2 = mysql_db_query($bancoDados, $comando2);
					}
				}
			}
			return $idImovel;
		}
	}
	return false;
}
function editaImovel($idCorretor, $tipo, $referencia, $idCliente, $idCategoria, $idSubCategoria, $valor, $video, $imagem, $idEstado, $idCidade, $idRegiao, $idBairro, $endereco, $localizacao_mapa, $marcador, $descricaoCurta, $descricaoCompleta, $maisInformacoes, $destaque, $exclusivo, $dataTerminoExclusividade, $dataAviso, $composicao, $codigo)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		if($imagem!="")	$imagem=" , imagem='$imagem' ";
		if($exclusivo)
		{
			$datas = " , dataTerminoExclusividade='$dataTerminoExclusividade', dataAviso='$dataAviso' ";
		}
		else
		{
			$datas = " , dataTerminoExclusividade='', dataAviso='' ";
		}
		$marcador_sql="1";
		if($marcador!="")
			$marcador_sql="0";
		$comandoSql = "
			UPDATE imoveis SET idCorretor='$idCorretor', tipo='$tipo', referencia='$referencia', idCliente='$idCliente', idCategoria='$idCategoria', idSubCategoria='$idSubCategoria', valor='$valor', video='$video' $imagem, idEstado='$idEstado', idCidade='$idCidade', idRegiao='$idRegiao', idBairro='$idBairro',
			endereco='$endereco',localizacao_mapa='$localizacao_mapa', marcador='$marcador_sql',descricaoCurta='$descricaoCurta', descricaoCompleta='$descricaoCompleta', maisInformacoes='$maisInformacoes', destaque='$destaque', exclusivo='$exclusivo' $datas, idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id=$codigo
		";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$idImovel = $codigo;
			if($composicao && sizeof($composicao)>0)
			{
				$comando2 = "DELETE FROM composicaoimovel WHERE idImovel=$idImovel";
				$dados2 = mysql_db_query($bancoDados, $comando2);
				if(!$dados2)	return false;
				while(list($chave,$linhaArray) = each($composicao))
				{
					if($linhaArray>0)
					{
						$comando2 = "INSERT INTO composicaoimovel(idImovel, idComposicao, qtdeComposicao)	VALUES ('$idImovel', '$chave', '$linhaArray')";
						$dados2 = mysql_db_query($bancoDados, $comando2);
						if(!$dados2)	return false;
					}
				}
			}
			return true;
		}
	}
	return false;
}
function devolveListaImoveis($tipo, $index, $mark, $where, $post, $status)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");



	else
	{
		$cont=0;
		$comandoSql = "SELECT cli.nome, imo.*, date_format(imo.dataCadastro, '%d/%m/%Y') as dataCadastro FROM imoveis imo, cliente cli WHERE cli.id = imo.idCliente AND $where LIMIT $index,25";

		debug("<b>$comandoSql</b>");
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				devolveNavegacao($index, "index.php?modulo=imoveis&acao=imoveis&tipo=listar", "where cli.id=imo.idCliente AND ".$where, $mark, "imoveis imo, cliente cli", $post);
				print("
				<table width='100%' cellpadding='2' cellspacing='2'>
					<tr>
						<td align='right'>
							$numero encontrado(s)
						</td>
					</tr>
				</table>
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='10%'>Refer�ncia</th>
						<th align='left' width='20%'>Cliente</th>
						<th align='left' width='25%'>Bairro</th>
						<th align='left' width='20%'>Valor</th>
						<th colspan='6'>&nbsp;</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					$bairro=devolveInfo("bairros", $linha[idBairro]);
					$valor="R$ ".devolveValor($linha['valor']);
					if($linha['imagem'])
					{
						$verimagem = "<a href='../imoveis/g_$linha[imagem]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0'></a>";
					}
					else
					{
						$verimagem="&nbsp;";
					}
					$img_status="<img src='imagens/status$linha[status].png' border='0'>";
					if($linha['status']==1)
					{
						$title_status="Liberado. Clique para bloquear.";
					}
					else
					{
						$title_status="Bloquado. Clique para liberar.";
					}
					$status="<a href='index.php?modulo=imoveis&acao=imoveis&tipo=listar&modo=alterarStatus&status=$linha[status]&id=$linha[id]' title='$title_status'>$img_status</a>";
					$img_destaque="<img src='imagens/destaque$linha[destaque].png' border='0'>";
					if($linha['destaque']==1)
					{
						$title_destaque="Marcado como destaque. Clique para desmarcar.";
					}
					else
					{
						$title_destaque="Clique para marcar como destaque.";
					}
					$destaque="<a href='index.php?modulo=imoveis&acao=imoveis&tipo=listar&modo=alterarDestaque&status=$linha[destaque]&id=$linha[id]' title='$title_destaque'>$img_destaque</a>";
					print("
						<tr>
							<td title='$linha[referencia]'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[referencia]</a></td>
							<td title='$linha[nome]'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[nome]</a></td>
							<td title='$bairro[nome]'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$bairro[nome]</a></td>
							<td title='$valor'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$valor</a></td>
							<td width='24'>$verimagem</td>
							<td width='24'>$status</td>
							<td width='24'>$destaque</td>
							<td width='24'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=imoveis&acao=imoveis&tipo=listar&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=imoveis&acao=imoveis&tipo=listar", "where cli.id=imo.idCliente AND ".$where, $mark, "imoveis imo, cliente cli", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='10%'>EC</th>
							<th align='left' width='50%'>Nome</th>
							<th>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='4'>
								Nenhum registro de im�veis cadastrado.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibi�ao dos im�veis!</strong></center>");
	}
}
function listaComposicoes()
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "SELECT * FROM composicao WHERE deletado=0 ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados && mysql_num_rows($dados)>0)
		{
			print("
				<table width='450' celppadding='3' cellspacing='3' border='0' align='center'>
					");
					$composicao = array();
					$cont=0;
					while($linha = mysql_fetch_array($dados))
					{
						$idComposicao=$linha[id];
						if($cont%2==0)	print("<tr>");
						print("
							<td width='10%' align='left'><input type='text' name='composicao[$idComposicao]' id='composicao$idComposicao' style='width:30px;' tipo='numerico'></td>
							<td width='40%' align='left'>$linha[nome]</td>
						");
						if($cont%2!=0)	print("</tr>");
						$cont++;
					}
					print("
				</table>
			");
		}
		if(mysql_num_rows($dados)==0)
		{
			print("
				<table celppadding='3' cellspacing='3' border='0'>
					<tr>
						<th>Nenhuma composi��o cadastrada.</th>
					</tr>
				</table>
			");
		}
	}
	return false;
}
function devolveListaComposicao($idImovel)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "SELECT * FROM composicaoimovel WHERE idImovel=$idImovel";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados && mysql_num_rows($dados)>0)
		{
			print("
				<table width='100%' align='center' id='gradient-style-detalhes'>
					<tr>
						<th align='left' colspan='4'>Composi��o</th>
					</tr>
					");
					$cont=0;
					while($linha = mysql_fetch_array($dados))
					{
						if($cont%2==0)	print("<tr>");
						$composicao = devolveInfo("composicao", $linha[idComposicao]);
						print("
							<td width='20' style='border:none;' align='center'><b>$linha[qtdeComposicao]</b></td>
							<td align='left' style='border:none;'>$composicao[nome]</td>
						");
						if($cont%2!=0)	print("</tr>");
						$cont++;
					}
					if($cont%2!=0)	print("<td colspan='2' style='border:none;'>&nbsp</td></tr>");
					print("
				</table>
			");
		}
		if(mysql_num_rows($dados)==0)
		{
			print("
				<table celppadding='3' cellspacing='3' border='0'>
					<tr>
						<th>Nenhuma composi��o cadastrada.</th>
					</tr>
				</table>
			");
		}
	}
	return false;
}
function devolveVetorComposicaoImovel($idImovel)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "SELECT * FROM composicaoimovel WHERE idImovel=$idImovel";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados && mysql_num_rows($dados)>0)
		{
			$composicao = array();
			while($linha = mysql_fetch_array($dados))
			{
				$composicao[$linha[idComposicao]]=$linha[qtdeComposicao];
			}
			return $composicao;
		}
	}
	return false;
}
function listaComposicoesEditar($idImovel)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$vetor=devolveVetorComposicaoImovel($idImovel);
		//print_r($vetor);
		$comando = "SELECT * FROM composicao WHERE deletado=0 ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados && mysql_num_rows($dados)>0)
		{
			print("
				<table width='450' celppadding='3' cellspacing='3' border='0' align='center'>
					");
					$composicao = array();
					$cont=0;
					while($linha = mysql_fetch_array($dados))
					{
						$idComposicao=$linha[id];
						if($cont%2==0)	print("<tr>");
						if($vetor[$idComposicao]!="")
							$qtde=" value='$vetor[$idComposicao]' ";
						else
							$qtde="";
						//$q=$vetor[$idComposicao];
						print("
							<td width='10%' align='left'><input type='text' name='composicao[$idComposicao]' id='composicao$idComposicao' $qtde style='width:30px;' tipo='numerico'></td>
							<td width='40%' align='left'>$linha[nome] $q</td>
						");
						if($cont%2!=0)	print("</tr>");
						$cont++;
					}
					print("
				</table>
			");
		}
		if(mysql_num_rows($dados)==0)
		{
			print("
				<table celppadding='3' cellspacing='3' border='0'>
					<tr>
						<th>Nenhuma composi��o cadastrada.</th>
					</tr>
				</table>
			");
		}
	}
	return false;
}
function montaSelect($tabela, $idSelecionado)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM $tabela WHERE deletado=0 ORDER BY nome ASC";
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
function remove($id, $idUsuario)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE imoveis SET deletado='1', idUsuarioAtualizacao='$idUsuario', dataAtualizacao=now() WHERE id='$id'";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
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
function removeImagem($tabela, $imagem, $codigo)
{
	include("config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		if($imagem=="imagem") $imagem = " imagem='' ,";
		elseif($imagem=="imagem1") $imagem = " imagem1='' ,";
		elseif($imagem=="imagem2") $imagem = " imagem2='' ,";

		elseif($imagem=="imagem3") $imagem = " imagem3='' ,";
		elseif($imagem=="imagem4") $imagem = " imagem4='' ,";
		elseif($imagem=="imagem5") $imagem = " imagem5='' ,";
		$comando = "UPDATE $tabela SET $imagem idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id = $codigo";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)	{
			return true;
		}
	}
	return false;
}
function imageResize($imagem, $pasta, $extNome, $largura, $altura){
	$endereco = "$pasta/".$imagem;
	//extens�o da imagem que foi realizado upload e escolha da fun��o de convers�o de imagem
	$ext = explode(".", $imagem);
	if($ext[1]=="jpg" || $ext[1]=="JPG" || $ext[1]=="jpeg")	$imagemAux = imagecreatefromjpeg($endereco);
	elseif($ext[1]=="gif" || $ext[1]=="GIF")				$imagemAux = imagecreatefromgif($endereco);
	elseif($ext[1]=="png" || $ext[1]=="PNG")				$imagemAux = imagecreatefrompng($endereco);
	//dimens�es originais
	$width = imagesx($imagemAux);
	$height = imagesy($imagemAux);
	//dimens�es desejadas
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
	//cria��o de uma nova imagem com as novas dimens�es de acordo com sua extens�o original
	$nova_imagem = imagecreatetruecolor($_WIDTH, $_HEIGHT);
	$endereco = "$pasta/$extNome".$imagem;
	imagecopyresampled($nova_imagem, $imagemAux, 0, 0, 0, 0, $_WIDTH, $_HEIGHT, $width, $height);

	//Marca D'agua
	adicionaMarcaDAgua($_WIDTH, $_HEIGHT, $nova_imagem, $extNome);
	//Marca D'agua - FIM

	if($ext[1]=="jpg" || $ext[1]=="JPG" || $ext[1]=="jpeg")	imagejpeg($nova_imagem, $endereco, 80);
	elseif($ext[1]=="gif" || $ext[1]=="GIF")				imagegif($nova_imagem, $endereco, 80);
	elseif($ext[1]=="png" || $ext[1]=="PNG")				imagepng($nova_imagem, $endereco, 80);

	return true;
}
function adicionaMarcaDAgua($foto_w, $foto_h, $foto, $prefix){
	$caminho = "imoveis/";
	$marcaDAgua =  "marca_dagua.png";
	$img = imagecreatefrompng($caminho.$marcaDAgua);
	$x_old = imagesx($img);
	$y_old = imagesy($img);

	$porcentagem_x = ($foto_w * 100) / $x_old;
	$porcentagem_Y = ($foto_h * 100) / $y_old;
	if($porcentagem_x <= 100){
		$width = $foto_w * 0.25;
		$height = (($y_old * $porcentagem_x) / 100) * 0.25;
		if($height > $foto_h){
			$width = (($x_old * $porcentagem_y) / 100) * 0.25;
			$height = $foto_h * 0.25;
		}
	}
	elseif($porcentagem_y <= 100){
		$width = (($x_old * $porcentagem_y) / 100) * 0.25;
		$height = $foto_h * 0.25;
		if($height > $foto_h){
			$width = $foto_h * 0.25;
			$height = (($y_old * $porcentagem_x) / 100) * 0.25;
		}
	}
	else{
		$width = $x_old * 0.25;
		$height = $y_old * 0.25;
	}

	$nova_img = imagecreatetruecolor($width, $height);
	imagealphablending($nova_img, true);
	$transparente = imagecolorallocatealpha($nova_img, 0, 0, 0, 127);
	imagefill($nova_img, 0, 0, $transparente);
	imagecopyresampled($nova_img, $img, 0, 0, 0, 0, $width, $height, $x_old, $y_old);
	imagesavealpha($nova_img, true);
	imagepng($nova_img, $caminho.$prefix.$marcaDAgua);
	imagedestroy($img);
	imagedestroy($nova_img);

	$marca = $caminho.$prefix.$marcaDAgua;
	$imagem_marca =   imagecreatefrompng($marca);

	list($m_width, $m_height) = getimagesize($marca);
	$pos_x = ceil(($foto_w * 0.5) - ($m_width * 0.5));
	$pos_y = ceil(($foto_h * 0.5) - ($m_height * 0.5));

	imagecopy($foto, $imagem_marca, $pos_x, $pos_y, 0, 0, $m_width, $m_height);
	imagedestroy($imagem_marca);
	unlink($marca);
}
/*
function imageResize($imagem, $pasta, $extNome, $largura, $altura){
	$endereco = "$pasta/".$imagem;
	//extens�o da imagem que foi realizado upload e escolha da fun��o de convers�o de imagem
	$ext = explode(".", $imagem);
	if($ext[1]=="jpg" || $ext[1]=="JPG" || $ext[1]=="jpeg")	$imagemAux = imagecreatefromjpeg($endereco);
	elseif($ext[1]=="gif" || $ext[1]=="GIF")				$imagemAux = imagecreatefromgif($endereco);
	elseif($ext[1]=="png" || $ext[1]=="PNG")				$imagemAux = imagecreatefrompng($endereco);
	//dimens�es originais
	$width = imagesx($imagemAux);
	$height = imagesy($imagemAux);


	//dimens�es desejadas
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
	//cria��o de uma nova imagem com as novas dimens�es de acordo com sua extens�o original
	$nova_imagem = imagecreatetruecolor($_WIDTH, $_HEIGHT);
	$endereco = "$pasta/$extNome".$imagem;
	imagecopyresampled($nova_imagem, $imagemAux, 0, 0, 0, 0, $_WIDTH, $_HEIGHT, $width, $height);

	//Inicio Marca D'agua
	$marca =  "imoveis/logo_03.gif";
	//$marca =  "imoveis/logo.gif";

	$imagem_marca =   ImageCreateFromGif($marca);
	$pontoX1 =   ImagesX($imagem_marca);
	$pontoY1 =   ImagesY($imagem_marca);
	#Habilitando a opcao abaixo ir� criar a mascara com a imagem marca d�agua

	$distx=ceil($width*0.36);
	$disty=ceil($height*0.36);
	//print("<hr>$largura/$altura ::: $distx/$disty");
	ImageCopyMerge($nova_imagem, $imagem_marca, $distx, $disty, 0, 0, $pontoX1, $pontoY1, 20);
	//Fim Marca D'agua


	if($ext[1]=="jpg" || $ext[1]=="JPG" || $ext[1]=="jpeg")	imagejpeg($nova_imagem, $endereco, 80);
	elseif($ext[1]=="gif" || $ext[1]=="GIF")				imagegif($nova_imagem, $endereco, 80);
	elseif($ext[1]=="png" || $ext[1]=="PNG")				imagepng($nova_imagem, $endereco, 80);

    return true;
}
*/

function devolveNumUpload()
{
  	include("./config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
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
function cadastraCategoria($nome, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");

	else
	{
		$comando = "INSERT INTO categoriaimoveis(nome, idUsuarioCadastro, dataCadastro) VALUES('$nome', '$login', now())";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
function devolveListaCategorias($tipo, $index, $mark, $where, $oder, $titulo, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT id, date_format(dataCadastro, '%d/%m/%Y') as dataCadastro, nome FROM categoriaimoveis $where LIMIT $index,25";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				devolveNavegacao($index, "index.php?modulo=imoveis&acao=categorias", $where, $mark, "categoriaimoveis", $post);
				print("
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='20%'>Data de Cadastro</th>
						<th align='left' width='65%'>Nome</th>
						<th colspan='2'>&nbsp;</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					print("
						<tr>
							<td title='$linha[dataCadastro]'>$linha[dataCadastro]</td>
							<td title='$linha[nome]'>$linha[nome]</td>
							<td width='24'><a href='index.php?modulo=imoveis&acao=categorias&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=imoveis&acao=categorias&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");

				devolveNavegacao($index, "index.php?modulo=imoveis&acao=categorias", $where, $mark, "categoriaimoveis", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='65%'>Nome</th>
							<th colspan='2'>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='5'>
								Nenhum registro de Categoria cadastrado para o m�dulo Venda.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibi�ao das Categorias!</strong></center>");
	}
}
function editaCategoria($nome, $codigo, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE categoriaimoveis SET nome='$nome', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$codigo'";
		$dados = mysql_db_query($bancoDados, $comando);
		debug($comando);
		if ($dados)	return true;
	}
	return false;
}
function removeCategoria($id, $idUsuario)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$idUsuario=devolveIdUsuario($login);
		$comando = "UPDATE categoriaimoveis SET deletado='1', idUsuarioAtualizacao='$idUsuario', dataAtualizacao=now() WHERE id='$id'";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
function alterarStatus($statusAntigo, $codigo)
{
	include("config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		if($statusAntigo==1)	$statusNovo=0;
		elseif($statusAntigo==0)	$statusNovo=1;
		$comando = "UPDATE imoveis SET status=$statusNovo WHERE id = $codigo";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if($dados)	return $statusNovo;
		else	return $statusNovo;
	}
}
function alterarDestaque($statusAntigo, $codigo)
{
	include("config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		if($statusAntigo==1)	$statusNovo=0;
		elseif($statusAntigo==0)	$statusNovo=1;
		$comando = "UPDATE imoveis SET destaque=$statusNovo WHERE id = $codigo";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if($dados)	return $statusNovo;
		else	return $statusNovo;
	}
}
function alterarFotoDestaque($statusAntigo, $codigo)
{
	include("config.php");
	if (!conectaBancoDados())

		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		if($statusAntigo==1)	$statusNovo=0;
		elseif($statusAntigo==0)	$statusNovo=1;
		$comando = "UPDATE galeriafotos SET destaque=$statusNovo WHERE id = $codigo";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if($dados)	return true;
		else	return false;
	}
}
function adicionarFotoImovel($imagem, $idImovel){
	include("config.php");
	if(!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$sql = "SELECT ordem FROM galeriafotos WHERE idImovel=$idImovel AND deletado=0 ORDER BY ordem DESC LIMIT 1";
		debug($sql);
		$dados = mysql_db_query($bancoDados, $sql);
		if($linha = mysql_fetch_array($dados))
			$ordem = ($linha['ordem'] + 1);
		else
			$ordem = 0;
		$sql2 = "INSERT INTO galeriafotos (idImovel, imagem, ordem, idUsuarioCadastro, dataCadastro) VALUES ('$idImovel', '$imagem', '$ordem', '$_SESSION[idUsuario]', now())";
		debug($sql2);
		$dados2 = mysql_db_query($bancoDados, $sql2);
		if(!$dados2)
			return false;

		return true;
	}
	return false;
}
function editaFotoImovel($imagem, $codigo)
{
	include("config.php");
	if (!conectaBancoDados())



		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$sql = "SELECT imagem FROM galeriafotos WHERE id = $codigo";
		debug($sql);
		$dados = mysql_db_query($bancoDados, $sql);
		if($dados){
			$linha = mysql_fetch_array($dados);
			if(file_exists("../imoveis/$linha[imagem]")){
				unlink("../imoveis/$linha[imagem]");
			}
			$sqlUp = "UPDATE galeriafotos SET imagem='$imagem', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id = $codigo";
			debug($sqlUp);
			$dadosUp = mysql_db_query($bancoDados, $sqlUp);
			if($dados)
				return true;
		}
	}
	return false;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////**************************************************************************************************************************************/////////////////////

function devolveListaFotosImovel($idImovel){
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$sql = "SELECT id, imagem, destaque FROM galeriafotos WHERE idImovel=$idImovel AND deletado=0 ORDER BY ordem ASC";
		debug($sql);
		$dados = mysql_db_query($bancoDados, $sql);
		if($dados && mysql_num_rows($dados)){
			print("Clique nas imagens e arraste para ordenar as p�ginas.");
			print("<ul id='ordemPag'>");
			while($linha = mysql_fetch_array($dados)){

				$img_destaque="<img src='imagens/destaque$linha[destaque].png' border='0' alt='Destaque' title='Destaque'>";
				if($linha['destaque']==1)
					$title_status="Marcado como destaque. Clique para desmarcar.";
				else
					$title_status="Clique para marcar como destaque.";
				$destaque="<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=galeria&tipo2=fotos&modo=alterarFotoDestaque&destaque=$linha[destaque]&id=$idImovel&idImagem=$linha[id]'>$img_destaque</a>";

				print("
					<li id='imgOrd_$linha[id]'>
						<a href='../imoveis/g_$linha[imagem]' id='thumb' title class='highslide' onclick='return hs.expand(this)'>
							<img src='../imoveis/m_$linha[imagem]' />
						</a>
						<div>
							$destaque
							<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=galeria&tipo2=editarFoto&id=$idImovel&idImagem=$linha[id]'><img src='imagens/editar.png' /></a>
							<a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=galeria&tipo2=fotos&modo=excluirFoto&id=$idImovel&idImagem=$linha[id]' onclick='return confirmaExclusao();'><img src='imagens/delete.png' /></a>
						</div>
					</li>
				");
			}
			print("</ul>");
		}
		else{
			print("Nenhuma imagem cadastrada.");
		}
	}
}


function atualizaOrdem($ordem, $id){
		include("../config.php");
		include("../util.php");
		if (!conectaBancoDados())
			print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
		else
		{
			$sql = "Update galeriafotos set ordem = $ordem where id = $id";
			$dados = mysql_db_query($bancoDados, $sql);

		}
}



////////////////**************************************************************************************************************************************/////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function removeArquivoGaleria($tabela, $codigo)
{
	include("config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE $tabela SET deletado=1 WHERE id=$codigo";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)	{
			return true;
		}
	}
	return false;
}
function removeCroqui($codigo)
{
	include("config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE complementos SET croqui='' WHERE id = $codigo";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)	{
			return true;
		}
	}
	return false;
}
function montaSelectCidadesRegiao($tabela, $idSelecionado)
{
	include("config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		print($idSelecionado);
		$comandoSql = "SELECT * FROM cidades WHERE deletado=0 ORDER BY nome ASC";
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

					$comandoSql2 = "SELECT * FROM regiao WHERE deletado=0 AND idCidade=$linha[id] ORDER BY nome ASC";
					$dados2 = mysql_db_query($bancoDados, $comandoSql2);
					if ($dados2)
					{
						if(mysql_num_rows($dados2) == 0)
						{
							//print("Nenhum registro encontrado.");
						}else
						{
							while ($linha2 = mysql_fetch_array($dados2))
							{
								$idOpcao = "$linha[id]#$linha2[id]";
								if($idOpcao == "$idSelecionado") $selected = "selected"; else $selected = "";
								print("<option value='$linha[id]#$linha2[id]' $selected>&nbsp;&nbsp;&nbsp;&nbsp;$linha2[nome]</option>");
							}
						}
					}
				}
			}
		}
	}
}




function devolveInformacoesComplementares($idImovel){
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comandoSql = "SELECT * FROM complementos WHERE deletado=0 AND idImovel='$idImovel'";
		if($dados = mysql_db_query($bancoDados, $comandoSql))

			if($linha = mysql_fetch_array($dados))

				return $linha;
	}
	return false;
}
function atualizaInfoTerreno($tipo, $idImovel, $cep, $referencia, $complemento, $vizinho, $foneVizinho,$idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $classificacao,$indice, $venda, $locacao, $condominio, $tlu, $iptuIncra,$areaTotal, $areaTerreno, $areaPreservacao, $areaHectares,$metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda,$finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $finCondPagamento, $finPendencias, $finPermuta,$edificado,$obsTerreno, $zoneamento, $numPavimentos,$croqui,$conContato, $conEmail, $conTelefone1, $conTelefone2, $conOutroContato, $conTelefoneOutro,$anuncio, $anuncioPontosFortes, $id){
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		if($croqui!="")	$croqui=" croqui='$croqui', ";
		$comando = "UPDATE complementos SET tipo='$tipo', idImovel='$idImovel', cep='$cep', referencia='$referencia', complemento='$complemento', vizinho='$vizinho', foneVizinho='$foneVizinho', idade='$idade', tipoArea='$tipoArea', ocupado='$ocupado', chaves='$chaves', matricula='$matricula', circunscricao='$circunscricao', inscricaoImobiliaria='$inscricaoImobiliaria', contrato='$contrato', averbado='$averbado', conservacao='$conservacao', pavimentacao='$pavimentacao', horaVisita='$horaVisita', entrega='$entrega', estilo='$estilo', tipoForro='$tipoForro', placa='$placa', posicaoSol='$posicaoSol', classificacao='$classificacao', indice='$indice', venda='$venda', locacao='$locacao',condominio='$condominio', tlu='$tlu', iptu='$iptuIncra', areaTotal='$areaTotal', areaTerreno='$areaTerreno', areaPreservacao='$areaPreservacao', areaHectares='$areaHectares', metragemFrente='$metragemFrente', metragemFundo='$metragemFundo', metragemDireita='$metragemDireita', metragemEsquerda='$metragemEsquerda', finPoupanca='$finPoupanca', finSaldoDevedor='$finSaldoDevedor', finValorPrestacao='$finValorPrestacao', finParcelasPagas='$finParcelasPagas', finParcelasRestantes='$finParcelasRestantes', finBanco='$finBanco', finCondPagamento='$finCondPagamento', finPendencias='$finPendencias', finPermuta='$finPermuta', edificado='$edificado', obsTerreno='$obsTerreno', zoneamento='$zoneamento', numPavimentos='$numPavimentos', $croqui conContato='$conContato', conEmail='$conEmail', conTelefone1='$conTelefone1', conTelefone2='$conTelefone2', conOutroContato='$conOutroContato', conTelefoneOutro='$conTelefoneOutro', anuncio='$anuncio',  anuncioPontosFortes='$anuncioPontosFortes',  idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id=$id ";
		debug($comando);


		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)	return true;
	}
	return false;
}
function atualizaInfoResidencias($tipo, $idImovel, $cep, $referencia, $complemento, $condominioFechado, $numCasasCondominio, $idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $comissao, $indice, $venda, $locacao, $condominio, $tlu, $iptu, $valorLuz, $luzIndividual, $luzIdentificador, $valorAgua, $aguaIndividual, $aguaIdentificador, $areaTotal, $areaTerreno, $metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda, $finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $aptoUsoFgts, $finCondPagamento, $finPendencias, $finPermuta, $edificado, $obsTerreno, $acabamentos, $pintura, $piso, $mobilia, $anuncio, $anuncioPontosFortes, $id){
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comando = "UPDATE complementos SET tipo='$tipo', idImovel='$idImovel', cep='$cep', referencia='$referencia', complemento='$complemento', condominioFechado='$condominioFechado', numCasasCondominio='$numCasasCondominio', idade='$idade', tipoArea='$tipoArea', ocupado='$ocupado', chaves='$chaves', matricula='$matricula', circunscricao='$circunscricao', inscricaoImobiliaria='$inscricaoImobiliaria', contrato='$contrato', averbado='$averbado', conservacao='$conservacao', pavimentacao='$pavimentacao', horaVisita='$horaVisita', entrega='$entrega', estilo='$estilo', tipoForro='$tipoForro', placa='$placa', posicaoSol='$posicaoSol', comissao='$comissao', indice='$indice', venda='$venda', locacao='$locacao',condominio='$condominio', tlu='$tlu', iptu='$iptu', valorLuz='$valorLuz', luzIndividual='$luzIndividual', luzIdentificador='$luzIdentificador', valorAgua='$valorAgua', aguaIndividual='$aguaIndividual', aguaIdentificador='$aguaIdentificador', areaTotal='$areaTotal', areaTerreno='$areaTerreno', metragemFrente='$metragemFrente', metragemFundo='$metragemFundo', metragemDireita='$metragemDireita', metragemEsquerda='$metragemEsquerda', finPoupanca='$finPoupanca', finSaldoDevedor='$finSaldoDevedor', finValorPrestacao='$finValorPrestacao', finParcelasPagas='$finParcelasPagas', finParcelasRestantes='$finParcelasRestantes', finBanco='$finBanco', aptoUsoFgts='$aptoUsoFgts', finCondPagamento='$finCondPagamento', finPendencias='$finPendencias', finPermuta='$finPermuta', obsTerreno='$obsTerreno', acabamentos='$acabamentos', pintura='$pintura', piso='$piso', mobilia='$mobilia', anuncio='$anuncio',  anuncioPontosFortes='$anuncioPontosFortes',  idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id=$id ";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)	return true;
	}
	return false;
}
function atualizaInfoApartamentos($tipo, $idImovel, $cep, $referencia, $complemento, $edificio, $andar, $apartamento, $bloco, $construtora, $numPavimentos, $aptosAndar, $taxaMudanca, $portariaFone, $admCondominio, $admCondominioFone, $idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $comissao, $indice, $venda, $locacao, $poolLocacao, $rendimento, $condominio, $tlu, $iptu, $valorLuz, $luzIndividual, $luzIdentificador, $valorAgua, $aguaIndividual, $aguaIdentificador, $areaTotal, $areaPrivativo, $areaGaragem, $areaComum, $metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda, $finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $aptoUsoFgts, $finCondPagamento, $finPendencias, $finPermuta, $acabamentos, $pintura, $piso, $mobilia, $anuncio, $anuncioPontosFortes, $id){
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comando = "UPDATE complementos SET tipo='$tipo', idImovel='$idImovel', cep='$cep', referencia='$referencia', complemento='$complemento', edificio='$edificio', andar='$andar', apartamento='$apartamento', bloco='$bloco', construtora='$construtora', numPavimentos='$numPavimentos', aptosAndar='$aptosAndar', taxaMudanca='$taxaMudanca', portariaFone='$portariaFone', admCondominio='$admCondominio', admCondominioFone='$admCondominioFone', idade='$idade', tipoArea='$tipoArea', ocupado='$ocupado', chaves='$chaves', matricula='$matricula', circunscricao='$circunscricao', inscricaoImobiliaria='$inscricaoImobiliaria', contrato='$contrato', averbado='$averbado', conservacao='$conservacao', pavimentacao='$pavimentacao', horaVisita='$horaVisita', entrega='$entrega', estilo='$estilo', tipoForro='$tipoForro', placa='$placa', posicaoSol='$posicaoSol', comissao='$comissao', indice='$indice', venda='$venda', locacao='$locacao', poolLocacao='$poolLocacao', rendimento='$rendimento', condominio='$condominio', tlu='$tlu', iptu='$iptu', valorLuz='$valorLuz', luzIndividual='$luzIndividual', luzIdentificador='$luzIdentificador', valorAgua='$valorAgua', aguaIndividual='$aguaIndividual', aguaIdentificador='$aguaIdentificador', areaTotal='$areaTotal', areaPrivativo='$areaPrivativo', areaGaragem='$areaGaragem', areaComum='$areaComum', metragemFrente='$metragemFrente', metragemFundo='$metragemFundo', metragemDireita='$metragemDireita', metragemEsquerda='$metragemEsquerda', finPoupanca='$finPoupanca', finSaldoDevedor='$finSaldoDevedor', finValorPrestacao='$finValorPrestacao', finParcelasPagas='$finParcelasPagas', finParcelasRestantes='$finParcelasRestantes', finBanco='$finBanco', aptoUsoFgts='$aptoUsoFgts', finCondPagamento='$finCondPagamento', finPendencias='$finPendencias', finPermuta='$finPermuta', acabamentos='$acabamentos', pintura='$pintura', piso='$piso', mobilia='$mobilia', anuncio='$anuncio',  anuncioPontosFortes='$anuncioPontosFortes',  idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id=$id ";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)	return true;
	}

	return false;
}
function devolveListaImoveisDestaques($tipo, $index, $mark, $where, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT *, date_format(dataCadastro, '%d/%m/%Y') as dataCadastro FROM imoveis $where LIMIT $index,25";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				devolveNavegacao($index, "index.php?modulo=imoveis&acao=destaques&tipo=listar", $where, $mark, "imoveis", $post);
				print("
				<table width='100%' cellpadding='2' cellspacing='2'>
					<tr>
						<td align='right'>
							$numero encontrado(s)
						</td>
					</tr>
				</table>
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='10%'>Refer�ncia</th>
						<th align='left' width='25%'>Cliente</th>
						<th align='left' width='25%'>Bairro</th>
						<th align='left' width='25%'>Valor</th>
						<th colspan='2'>&nbsp;</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					$cliente=devolveInfo("cliente", $linha[idCliente]);
					$bairro=devolveInfo("bairros", $linha[idBairro]);
					$valor="R$ ".devolveValor($linha['valor']);
					if($linha['imagem'])
					{
						$verimagem = "<a href='../imoveis/g_$linha[imagem]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0'></a>";
					}
					else
					{
						$verimagem="&nbsp;";
					}
					print("
						<tr>
							<td title='$linha[referencia]'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[referencia]</a></td>
							<td title='$cliente[nome]'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$cliente[nome]</a></td>
							<td title='$bairro[nome]'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$bairro[nome]</a></td>
							<td title='$valor'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$valor</a></td>
							<td width='24'>$verimagem</td>
							<td width='24'><a href='index.php?modulo=imoveis&acao=destaques&modo=removerImovelDestaque&id=$linha[id]$post' title='Remover da Lista de Destaques' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");

				devolveNavegacao($index, "index.php?modulo=imoveis&acao=destaques&tipo=listar", $where, $mark, "imoveis", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>

							<th align='left' width='10%'>Refer�ncia</th>
							<th align='left' width='20%'>Cliente</th>
							<th align='left' width='25%'>Bairro</th>
							<th align='left' width='20%'>Valor</th>
						</tr>
						<tr>
							<td colspan='4'>
								Nenhum registro de im�veis em destaque encontrado.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibi�ao dos im�veis em destaque!</strong></center>");
	}
}
function removerProdutoDestaque($idProduto)

{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		$comando = "UPDATE produto SET destaque=0, idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now()  WHERE id = $idProduto";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if($dados)	return true;
	}
	return false;
}


function devolveListaImoveisImprimir($where)
{
	include("../config.php");
	include("../util.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");



	else
	{
		$cont=0;
		$comandoSql = "SELECT cli.nome, cli.telefone, cli.telefoneConjuge, cli.telefoneComercial, cli.telefoneResidencial, imo.*, date_format(imo.dataCadastro, '%d/%m/%Y') as dataCadastro FROM imoveis imo, cliente cli WHERE cli.id = imo.idCliente AND imo.deletado='0' $where	";

		//echo("$comandoSql");
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				$dataG = date("d/m/Y H:i");
					print("
				<table width='800' align='center' cellpadding='3'>
					<tr>
						<th colspan='6'>Carone Im�veis<BR>Impress�o de Im�veis - Gerado em $dataG<BR><BR></th>
					</tr>
					<tr>
						<th align='left'>Ref</th>
						<th align='left'>Cliente</th>
						<th align='left'>Bairro</th>
						<th align='left'>Valor</th>
						<th align='left'>Status</th>
						<th align='left'>Telefone</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					$bairro=devolveInfo("bairros", $linha[idBairro]);
					$valor="R$ ".devolveValor($linha['valor']);
					if($linha['status']==1)
					{
						$title_status="S";
					}
					else
					{
						$title_status="N";
					}
					$status="$title_status";
					//if($linha['telefoneComercial']!="")
						//$telefone = $linha['telefoneComercial'];
					//elseif($linha['telefoneResidencial']!="")
						//$telefone = $linha['telefoneResidencial'];
					//elseif($linha['telefone']!="")
						$telefone = $linha['telefone'];
					//elseif($linha['telefoneConjuge']!="")
						//$telefone = $linha['telefoneConjuge'];
					print("
						<tr>
							<td>$linha[referencia]</td>
							<td>$linha[nome]</td>
							<td>$bairro[nome]</td>
							<td>$valor</td>
							<td width='24'>$status</td>
							<td>$telefone</td>
						</tr>
					");
				}
				print("
				</table>
				");

			}
		}
		else
			print("<center><strong>Erro na exibi�ao dos im�veis!</strong></center>");
	}
}
?>