<?php
function mensagemRetorno($mensagem, $style)
{
	print("
		<div style='border: 1px solid #90AE4E; padding: 1px; margin:0px; background-color:#C3D88B; $style' align='center'>
			<div style='border: 1px solid #90AE4E; padding: 8px; margin:1px; background-color:#C3D88B; color:#464646;' align='center'>
				$mensagem
			</div>
		</div>
	");
}
function existeImovel($referencia)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM imoveis WHERE deletado=0 AND status=1 AND referencia = '$referencia'";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if(mysql_num_rows($dados) <= 0)
			{
				return false;
			}
			else
			{
				$linha = mysql_fetch_array($dados);
				return $linha['id'];
			}
		}
	}
}
function montaSelectCidadesRegiao($tabela, $idSelecionado)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
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
					$comandoSql2 = "SELECT bai.id as id, bai.nome as nome FROM regiao reg, bairros bai where reg.id=bai.idRegiao and reg.idCidade=$linha[id] and reg.deletado=0 and bai.deletado=0 group by bai.id order by bai.nome ASC";
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
								$idOpcao = "$linha[id]-$linha2[id]";
								if($idOpcao == "$idSelecionado") $selected = "selected"; else $selected = "";
								print("<option value='$linha[id]-$linha2[id]' $selected>&nbsp;&nbsp;&nbsp;&nbsp;$linha2[nome]</option>");
							}
						}
					}
				}
			}
		}
	}
}
function montaSelectNaoExclusivo($idSelecionado)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM categorias WHERE deletado=0 ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if(mysql_num_rows($dados) == 0)
			{
				//print("Nenhum registro encontrado.");
			}else
			{
				if($idSelecionado=="-1") $selectedNaoExclusivo = "selected"; else $selectedNaoExclusivo = "";
				print("<option value='-1' $selectedNaoExclusivo>Nao Exclusivo</option>");
				while ($linha = mysql_fetch_array($dados))
				{
					if($linha[id] == "$idSelecionado") $selected = "selected"; else $selected = "";
					print("<option value='$linha[id]' $selected>$linha[nome]</option>");
				}
			}
		}
	}
}
function montaSelect($tabela, $idSelecionado)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM $tabela WHERE deletado=0 ORDER BY nome ASC";
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
function montaSelectCategoriaServicos($idSelecionado)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM categoriaservicos WHERE deletado=0 ORDER BY nome ASC";
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
					$comandoSql2 = "SELECT * FROM servicos WHERE deletado=0 AND idCategoria=$linha[id] GROUP BY idCategoria ORDER BY id ASC";
					$dados2 = mysql_db_query($bancoDados, $comandoSql2);
					if ($dados)
					{
						if(mysql_num_rows($dados2) == 0)
						{
							//print("Nenhum registro encontrado.");
						}else
						{
							while ($linha2 = mysql_fetch_array($dados2))
							{
								if($linha['id'] == "$idSelecionado") $selected = "selected"; else $selected = "";
								print("<option value='$linha[id]' $selected>$linha[nome]</option>");
							}
						}
					}
				}
			}
		}
	}
}
function remove($id, $idUsuario)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
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
function devolveImoveisDestaque($limit)
{
	include("cms/config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "SELECT imo.id as idImovel, imo.valor as valor, imo.imagem as imagemImovel, cat.imagem as imagemCat FROM imoveis imo INNER JOIN categorias cat ON imo.idCategoria=cat.id WHERE cat.deletado=0 AND imo.deletado=0 AND imo.status=1 AND imo.destaque=1 AND imo.exclusivo=1 ORDER BY RAND() DESC LIMIT $limit";
		//echo $comandoSql;
		$dados = mysql_db_query($bancoDados, $comandoSql);
		$num=mysql_num_rows($dados);
		if ($dados && $num>0)
		{
			print("
				<table align='center' border='0' cellpadding='0' cellspacing='1'>
					<tr>
				");
				while($linha = mysql_fetch_array($dados))
				{
					$valor=devolveValor($linha['valor']);
					if($linha['imagemImovel'])
					{
						$tamanho=getimagesize("imoveis/m_$linha[imagemImovel]");
						$height="";
						if($tamanho[1]>$tamanho[0])
						{
							$height="height='172'";
						}
						$imagem="<img src='imoveis/m_$linha[imagemImovel]' title='Clique para ver o imóvel' $height border='0'>";
					}
					print("
						<td align='center' width='33%'>
							<table width='100%' cellpadding='0' cellspacing='0' border='0' bgcolor='#DEDEDE'>
								<tr>
									<td valign='middle' align='center' style='height:172px; ' bgcolor='#383431'><img src='images/destaque_$linha[imagemCat].jpg' border='0'></td>
									<td valign='middle' align='center' style='height:172px; width:230px;' bgcolor='#383431'><a href='index.php?site=detalhes&id=$linha[idImovel]'>$imagem</a></td>
								</tr>
								<tr>
									<td colspan='2' style='height:30px; text-align:center;'>
										<a href='index.php?site=detalhes&id=$linha[idImovel]'><b>R$ $valor</b></a>
									</td>
								</tr>
							</table>
						</td>
					");
				}
				print("
					</tr>
				</table>
			");
		}
		else
		{
			return false;
		}
	}
	return false;
}
function cadastraNewsletter($nome, $email)
{
	include("cms/config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "INSERT INTO newsletter (nome, email, dataCadastro) VALUES ('$nome', '$email', now())";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)	return true;
	}
	return false;
}
function montaSelectFiltroRegiao()
{
	include("cms/config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "SELECT * FROM regiao WHERE deletado=0 ORDER BY idCidade,nome ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			$num = mysql_num_rows($dados);
			if($num==0)
			{
				print("<option value='' style='height:35px;'>Regiões não cadastradas</option>");
			}
			else
			{
				print("<option value='' style='height:35px;'>Todas</option>");
				while($linha = mysql_fetch_array($dados))
				{
					$cidade=devolveInfoSite("cidades", $linha['idCidade']);
					print("<option value='$linha[id]' style='height:35px;'>$cidade[nome] / $linha[nome]</option>");
				}
			}
		}
	}
	return true;
}
function devolveInfoSite($tabela, $id)
{
	include("cms/config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else{
		$comandoSql = "SELECT * FROM $tabela WHERE id=$id";
		if($dados = mysql_db_query($bancoDados, $comandoSql))
		{
			if($linha = mysql_fetch_array($dados))
				return $linha;
		}
		else
			print("Erro na consulta à $tabela.");
	}
}
/**** DETALHES ****/
function devolveComposicao($id)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "
			SELECT
		      comp.nome as nomeComposicao,
		      compimo.qtdeComposicao as qtdeComposicao
		    FROM composicao comp INNER JOIN composicaoimovel compimo ON comp.id=compimo.idComposicao
		    WHERE compimo.idImovel=$id
		    ORDER BY comp.relevancia DESC
		";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados && mysql_num_rows($dados)>0)
		{
			print("
				<table width='100%' cellpadding='2' cellspacing='2'>
					");
					$cont=0;
					while($linha = mysql_fetch_array($dados))
					{
						if($cont%4==0)	print("<tr>");
						if($linha['qtdeComposicao']==1)
							$qtde="";
						else
							$qtde=$linha['qtdeComposicao']."&nbsp;";
						print("
							<td align='left'>$qtde $linha[nomeComposicao]</td>
						");
						if(($cont+1)%4==0)	print("</tr>");
						$cont++;
					}

					if($cont%4!=0)	print("<td colspan='2' style='border:none;'>&nbsp</td></tr>");
					print("
				</table>
			");
		}
		else{
			print("&nbsp;");
		}
	}
	return false;
}
function existeComposicao($id)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "SELECT * FROM composicaoimovel WHERE idImovel=$id";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados && mysql_num_rows($dados)>0)
		{
			return true;
		}
		else{
			return false;
		}
	}
	return false;
}
function devolveFotos($id)
{

	include("cms/config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT * FROM galeriafotos WHERE idImovel=$id AND deletado=0 ORDER BY id DESC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero>0)
			{
				print("
				<table cellpadding='2' cellspacing='2' width='100%'>
				");
				$cont=2;
				while ($linha = mysql_fetch_array($dados))
				{
					print("<tr>");
					if($linha[imagem])
					{
						$verimagem = "<a href='imoveis/g_$linha[imagem]' id='thumb1' title='$linha[nome]' class='highslide' onclick=\"return hs.expand(this)\"><img src='imoveis/p_$linha[imagem]' border='0'  style='border: 1px solid #C3D88B;'></a>";
					}
					else
					{
						$verimagem="&nbsp;";
					}
					print("
					<td align='center'>
						$verimagem
					</td>
					");
					if ($linha = mysql_fetch_array($dados))
					{
						if($linha[imagem])
						{
							$verimagem = "<a href='imoveis/g_$linha[imagem]' id='thumb1' title='$linha[nome]' class='highslide' onclick=\"return hs.expand(this)\"><img src='imoveis/p_$linha[imagem]' border='0'  style='border: 1px solid #C3D88B;'></a>";
						}
						else
						{
							$verimagem="&nbsp;";
						}
						print("
						<td align='center'>
							$verimagem
						</td>
						");
					}
					if ($linha = mysql_fetch_array($dados))
					{
						if($linha[imagem])
						{
							$verimagem = "<a href='imoveis/g_$linha[imagem]' id='thumb1' title='$linha[nome]' class='highslide' onclick=\"return hs.expand(this)\"><img src='imoveis/p_$linha[imagem]' border='0'  style='border: 1px solid #C3D88B;'></a>";
						}
						else
						{
							$verimagem="&nbsp;";
						}
						print("
						<td align='center'>
							$verimagem
						</td>
						");
					}
					if ($linha = mysql_fetch_array($dados))
					{
						if($linha[imagem])
						{
							$verimagem = "<a href='imoveis/g_$linha[imagem]' id='thumb1' title='$linha[nome]' class='highslide' onclick=\"return hs.expand(this)\"><img src='imoveis/p_$linha[imagem]' border='0'  style='border: 1px solid #C3D88B;'></a>";
						}
						else
						{
							$verimagem="&nbsp;";
						}
						print("
						<td align='center'>
							$verimagem
						</td>
						");
					}
					if ($linha = mysql_fetch_array($dados))
					{
						if($linha[imagem])
						{
							$verimagem = "<a href='imoveis/g_$linha[imagem]' id='thumb1' title='$linha[nome]' class='highslide' onclick=\"return hs.expand(this)\"><img src='imoveis/p_$linha[imagem]' border='0'  style='border: 1px solid #C3D88B;'></a>";
						}
						else
						{
							$verimagem="&nbsp;";
						}
						print("
						<td align='center'>
							$verimagem
						</td>
						");
					}

					print("</tr>");
					$cont++;
				}
				print("
				</table>
				");
			}
			else{
				print("Aguarde novidades...");
			}

		}
	}
}
function devolveFotos2($id)
{
	include("cms/config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT * FROM galeriafotos WHERE idImovel=$id AND deletado=0 ORDER BY ordem asc, id desc";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero>0)
			{
				$cont=1;
				while ($linha = mysql_fetch_array($dados))
				{
					print("<a class='highslide' href='imoveis/g_$linha[imagem]' onclick=\"return hs.expand(this)\" style='padding:5px; float:left; height:130px;'><img src='imoveis/p_$linha[imagem]' alt='$linha[nome]' title='$linha[nome]' style='border:1px solid #93AD4A;'></a>");
				}
			}
			else{
				print("Aguarde novidades...");
			}
		}
	}
}
function devolveVideo($id)
{
	include("cms/config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT video FROM imoveis WHERE id=$id AND deletado=0";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if($linha = mysql_fetch_array($dados)){
				if($linha['video']!=""){
					$codVideo = end(explode("?v=",$linha['video']));
					$codVideo = explode("&",$codVideo);
					$codVideo = $codVideo[0];
					$miniatura="http://img.youtube.com/vi/$codVideo/hq1.jpg";
					print("
						<a href='http://www.youtube.com/embed/$codVideo?rel=0&amp;wmode=transparent&amp;autoplay=1;' onclick=\"return hs.htmlExpand(this, {objectType: 'iframe', width: 480, height: 385, allowSizeReduction: false, wrapperClassName: 'draggable-header no-footer', preserveContent: false, objectLoadTime: 'after'})\" class='highslide' style='padding:5px; float:left;text-decoration:none;'>
							<div style='border:1px solid #93AD4A; width:300px; height:230px; background:url($miniatura) top center; color:#fff; text-align:center;'><span style='font-size:26pt; margin:100px 30px 0 90px;'>VÍDEO</span><br><span style='font-size:10pt; margin:0 30px 0 70px;'>clique aqui para assistir</span></div>
						</a>
					");
				}
			}
		}
	}
}
function existeFotos($id)
{
	include("cms/config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT * FROM galeriafotos WHERE idImovel=$id AND deletado=0 ORDER BY id DESC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero>0)
			{
				return true;
			}
			else{
				return false;
			}
		}
	}
}
/**** SERVIÇOS ****/
function devolveServicos($filtro, $limit)
{
	include("cms/config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "SELECT * FROM categoriaservicos WHERE deletado=0 $filtro ORDER BY id DESC LIMIT $limit";
		//echo $comandoSql;
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados && mysql_num_rows($dados)>0)
		{
			$cont=0;
			while($linha = mysql_fetch_array($dados))
			{
				if($cont%2==0)	$color="#93AD4A";	else	$color="#C3D88B";
				$comandoSql2 = "SELECT * FROM servicos WHERE deletado=0 AND idCategoria=$linha[id] ORDER BY id DESC LIMIT $limit";
				$dados2 = mysql_db_query($bancoDados, $comandoSql2);
				if ($dados2 && mysql_num_rows($dados2)>0)
				{
					print("
						<table width='100%' align='center' border='0' cellpadding='2' cellspacing='2' style='margin-bottom:5px;'>
							<tr>
								<td bgcolor='$color' align='left' valign='middle' class='tituloServico'>
									$linha[nome]
								</td>
							</tr>
							<tr>
								<td align='center' valign='top'>
									");
									$cont2=0;
									while($linha2 = mysql_fetch_array($dados2))
									{
										$linha2[descricao]=nl2br($linha2[descricao]);
										if($cont2%2==0)	$bgcolor="#E2E2E2";	else	$bgcolor="#EFEFEF";
										$satisfacao=devolveMediaAvaliacoes($linha2['id']);
										print("
											<table width='100%' cellpadding='3' cellspacing='3' border='0' bgcolor='$bgcolor' style='margin-bottom:3px;'>

												<tr>
													<td align='left' valign='top' width='33%'><b>Empresa: </b>$linha2[nome] ($linha2[email])</td>
													<td align='left' valign='top' width='25%'><b>Telefone: </b>$linha2[telefone]</td>
													<td align='left' valign='top' width='41%'><b>Endereço: </b>$linha2[endereco]</td>
												</tr>
												<tr>
													<td colspan='3' align='left'>
														<b>Descrição:</b>
														$linha2[descricao]
													</td>
												</tr>
												<tr>
													<td align='left' height='23' valign='middle'><b>Satisfação: </b>$satisfacao</td>
													<td align='left' valign='top'><a href='index.php?site=servicos&tipo=opine&idCategoria=$linha[id]&id=$linha2[id]' style='color:#900; font:Tahoma, Geneva, sans-serif; letter-spacing:1px; font-weight:bold;'>deixe sua opinião</a></td>
													<td align='left' valign='top' class='opine'>&nbsp;</td>
												</tr>
											</table>
										");
										$cont2++;
									}
									print("
								</td>
							</tr>
						</table>
					");
					$cont++;
				}
			}
		}
		else
		{
			return false;
		}
	}
	return false;
}
function listaComposicoes($composicaoValue)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "
			SELECT comp.id as idComposicao, comp.nome as nomeComposicao, MAX(compimo.qtdeComposicao) as qtdeComposicao
      		FROM composicaoimovel compimo INNER JOIN composicao comp ON compimo.idComposicao=comp.id GROUP BY compimo.idComposicao ORDER BY comp.nome, compimo.qtdeComposicao DESC
		";
		$dados = mysql_db_query($bancoDados, $comando);






		if ($dados && mysql_num_rows($dados)>0)
		{
			print("
				<table width='550' celppadding='3' cellspacing='3' border='0' align='center'>
					");
					$composicao = array();
					$cont=0;
					while($linha = mysql_fetch_array($dados))
					{
						$idComposicao=$linha['idComposicao'];
						if($cont%2==0)	print("<tr>");
						print("
							<td width='10%' align='left'>
								<select name='composicao[$idComposicao]' id='composicao[$idComposicao]'>
									");
									$cont2=1;
									print("<option value='' selected>--</option>");
									while($cont2<=5)
									{
										if($composicaoValue[$idComposicao]==$cont2)	$sel="selected";	else	$sel="";
										print("<option value='$cont2' $sel>$cont2</option>");
										$cont2++;
									}
									print("
								</select>
							</td>
							<td width='40%' align='left'>$linha[nomeComposicao]</td>
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
						<th>Nenhuma composição cadastrada.</th>
					</tr>
				</table>
			");
		}
	}
	return false;
}
function devolveNovoVetor($listaComposicao)
{
	if(is_array($listaComposicao))
	{
		$novoArray=array();
		reset($listaComposicao);
		while(list($chave,$linhaArray) = each($listaComposicao))
		{
			if($linhaArray!="" && $linhaArray>0)
			{
				$novoArray[$chave]=$linhaArray;
			}
		}
		return $novoArray;
	}
}


function devolveImoveisPesquisaAvancada($tipoImovel, $nao_exclusivos, $referencia, $idCategoria, $idSubCategoria, $valorIni, $valorFim, $opcaoCategoria, $listaSubCategoria, $listaSubCategoria2, $composicao)
{
	include("cms/config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$filtro="";
		if($tipoImovel!="")
		{
			$filtro.=" AND tipo=$tipoImovel ";
		}
        //if($nao_exclusivos)			$filtro.=" AND exclusivo=0 "; else $filtro.=" AND exclusivo=1 ";
		if($referencia!="")			$filtro.=" AND imo.referencia like '%$referencia%' ";
		//if($idCategoria!="")		$filtro.=" AND idCategoria=$idCategoria ";
		if($idCategoria!="")
		{
			if($idCategoria=="-1" && $_SESSION['sessaoCorretor'])
			{
				$filtro.=" AND exclusivo=0 ";
			}
			else
			{
				$filtro.=" AND exclusivo=1 ";
				$filtro.=" AND idCategoria=$idCategoria ";
			}
		}
		else
		{
			$filtro.=" AND exclusivo=1 ";
		}
		if($opcaoCategoria!="")		$filtro.=" AND imo.idCidade=$opcaoCategoria ";
		if($cont==0)
		{
			if($idSubCategoria!="")		$filtro.=" AND imo.idSubCategoria=$idSubCategoria ";
			if($listaSubCategoria!="")	$filtro.=" AND imo.idRegiao=$listaSubCategoria ";
			if($listaSubCategoria2!="")	$filtro.=" AND imo.idBairro=$listaSubCategoria2 ";
			if($valorIni!="")
			{
				$valorFiltroIni=formataValor($valorIni);
				$filtro.=" AND imo.valor>=$valorFiltroIni ";
			}

			if($valorFim!="")
			{
				$valorFiltroFim=formataValor($valorFim);
				$filtro.=" AND imo.valor<=$valorFiltroFim ";
			}
		}
		$comandoSql = "SELECT * FROM imoveis imo WHERE deletado=0 AND status=1 $filtro ORDER BY id DESC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		$num=mysql_num_rows($dados);
		if($dados && $num>0)
		{
			print("
				<table width='100%' align='center' cellpadding='5' cellspacing='5'>
					<tr>
						<td align='right'>$num imóvel(eis) encontrado(s)</td>
					</tr>
				</table>
			");
			while($linha = mysql_fetch_array($dados))
			{
				$valor=devolveValor($linha['valor']);
				if($linha['imagem'])
				{
					$tamanho=getimagesize("imoveis/p_$linha[imagem]");
					$height="";
					if($tamanho[1]>$tamanho[0])
					{
						$height="height='90'";
					}
					$imagem="
						<img src='imoveis/p_$linha[imagem]' title='Clique para ver o imóvel' $height border='0'>
					";
				}
				if($_SESSION['id_detalhe']!="" && $_SESSION['id_detalhe']==$linha['id'])
				{
					//$corgeral="#6D8436";
					$ultimoVisto="
						<tr>
							<th align='left'>
								<a href='index.php?site=detalhes&id=$linha[id]' style='color:#FFF;' title='ÚLTIMO VISTO'>
									<img src='images/check.png' border='0'>
								</a>
							</th>
						</tr>
					";
					$descricaoCurta="<b title='ÚLTIMO VISTO'>$linha[descricaoCurta]</b>";
					$borda=" border: 1px solid #464646; ";
				}
				else
				{
					//$corgeral="#93AD4C";
					$ultimoVisto="";
					$descricaoCurta="$linha[descricaoCurta]";
					$borda="";
				}
				$categoria=devolveInfoSite("categorias", $linha['idCategoria']);
				$cidade=devolveInfoSite("cidades", $linha['idCidade']);
				$regiao=devolveInfoSite("regiao", $linha['idRegiao']);
				$bairro=devolveInfoSite("bairros", $linha['idBairro']);
				$linha[valor]="R$ ".devolveValor($linha[valor]);
				$linha[descricaoCurta]=nl2br($linha[descricaoCurta]);

				$novoVetor=devolveNovoVetor($composicao);
				if($novoVetor)

				{
					if(existeComposicaoImovelPesquisaQtde($linha['id'], $novoVetor))
					{
						print("

							<table width='100%' align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#93AD4A' style='margin-bottom:5px; $borda'>
								<tr>
									<td bgcolor='#6D8436' width='40' align='center' valign='middle'>
										<img src='images/lista_$categoria[imagem].jpg' border='0'>
									</td>
									<td align='center' valign='top'>
										<table width='95%' cellpadding='0' cellspacing='0' border='0'>
											<tr>
												<td valign='middle' width='140'>
													<table width='134' cellpadding='0' cellspacing='0' border='0'>
														<tr>
															<td valign='middle' align='center' style='background:url(images/fundo_img_p.jpg) no-repeat; width:134px; height:104px;'><a href='index.php?site=detalhes&id=$linha[id]' style='padding:0px;'>$imagem</a></td>
														</tr>
													</table>
												</td>
												<td valign='top' width='500'>
													<table width='500' cellpadding='0' cellspacing='0' border='0'>

														<tr>

															<td colspan='4' style='padding:5px; line-height:20px; letter-spacing:1px;' valign='top' height='80' bgcolor='#C3D88B'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$descricaoCurta</a></td>
														</tr>
														<tr>
															<th height='45' width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Referência: $linha[referencia]</a></th>
															<th width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Valor: $linha[valor]</a></th>
														</tr>
													</table>
												</td>
												<td valign='top' width='140'>
													<table cellpadding='5' cellspacing='5' border='0'>
														$ultimoVisto
														<tr>
															<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$cidade[nome]</a></th>

														</tr>
														<tr>
															<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Região $regiao[nome]</a></th>
														</tr>
														<tr>
															<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$bairro[nome]</a></th>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						");
					}
					else
					{
						return 0;
					}
				}
				else
				{
					print("
						<table width='100%' align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#93AD4A' style='margin-bottom:5px; $borda'>
							<tr>
								<td bgcolor='#6D8436' width='40' align='center' valign='middle'>
									<img src='images/lista_$categoria[imagem].jpg' border='0'>
								</td>
								<td align='center' valign='top'>
									<table width='95%' cellpadding='0' cellspacing='0' border='0'>
										<tr>
											<td valign='middle' width='140'>
												<table width='134' cellpadding='0' cellspacing='0' border='0'>
													<tr>
														<td valign='middle' align='center' style='background:url(images/fundo_img_p.jpg) no-repeat; width:134px; height:104px;'><a href='index.php?site=detalhes&id=$linha[id]' style='padding:0px;'>$imagem</a></td>
													</tr>
												</table>
											</td>
											<td valign='top' width='500'>
												<table width='500' cellpadding='0' cellspacing='0' border='0'>
													<tr>
														<td colspan='4' style='padding:5px; line-height:20px; letter-spacing:1px;' valign='top' height='80' bgcolor='#C3D88B'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$descricaoCurta</a></td>
													</tr>
													<tr>
														<th height='45' width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Referência: $linha[referencia]</a></th>
														<th width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Valor: $linha[valor]</a></th>
													</tr>
												</table>
											</td>
											<td valign='top' width='140'>
												<table cellpadding='5' cellspacing='5' border='0'>
													$ultimoVisto
													<tr>
														<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$cidade[nome]</a></th>
													</tr>
													<tr>
														<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Região $regiao[nome]</a></th>
													</tr>
													<tr>
														<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$bairro[nome]</a></th>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					");
				}

			} // while linha
		}  // if dados
		return $num;
	}
}
function devolveImoveisPesquisaAvancadaSemelhantes($tipoImovel, $nao_exclusivos, $referencia, $idCategoria, $idSubCategoria, $valorIni, $valorFim, $opcaoCategoria, $listaSubCategoria, $listaSubCategoria2, $composicao)
{
	include("cms/config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$filtroId="";
		$cont=0;
		while($num<5)
		{
			$filtro= $filtroId;
			if($cont==0)
			{
				if($nao_exclusivos)			$filtro.=" AND exclusivo=0 ";
				if($tipoImovel!="")		$filtro.=" AND tipo=$tipoImovel ";
                if($idCategoria!="")		$filtro.=" AND idCategoria=$idCategoria ";
				if($opcaoCategoria!="")		$filtro.=" AND imo.idCidade=$opcaoCategoria ";
				if($referencia!="")			$filtro.=" AND imo.referencia like '%$referencia%' ";
				if($idSubCategoria!="")		$filtro.=" AND imo.idSubCategoria=$idSubCategoria ";
				if($listaSubCategoria!="")	$filtro.=" AND imo.idRegiao=$listaSubCategoria ";
				if($listaSubCategoria2!="")	$filtro.=" AND imo.idBairro=$listaSubCategoria2 ";
				if($valorIni!="")
				{
					$valorFiltroIni=formataValor($valorIni);
					$filtro.=" AND imo.valor>=$valorFiltroIni ";
				}
				if($valorFim!="")
				{
					$valorFiltroFim=formataValor($valorFim);
					$filtro.=" AND imo.valor<=$valorFiltroFim ";
				}
			}
			elseif($cont==1)
			{
				if($nao_exclusivos)			$filtro.=" AND exclusivo=0 ";
    			if($tipoImovel!="")		    $filtro.=" AND tipo=$tipoImovel ";
				if($idCategoria!="")		$filtro.=" AND idCategoria=$idCategoria ";
				if($opcaoCategoria!="")		$filtro.=" AND imo.idCidade=$opcaoCategoria ";
				if($idSubCategoria!="")		$filtro.=" AND imo.idSubCategoria=$idSubCategoria ";
				if($listaSubCategoria!="")	$filtro.=" AND imo.idRegiao=$listaSubCategoria ";
				if($listaSubCategoria2!="")	$filtro.=" AND imo.idBairro=$listaSubCategoria2 ";
				if($valorIni!="")
				{
					$valorFiltroIni=formataValor($valorIni);
					$valorFiltroIni_20menos = $valorFiltroIni - $valorFiltroIni * 20/100;
					$filtro.=" AND imo.valor>=$valorFiltroIni_20menos ";
				}
				if($valorFim!="")
				{
					$valorFiltroFim=formataValor($valorFim);
					$valorFiltroFim_20mais = $valorFiltroFim + $valorFiltroFim * 20/100;
					$filtro.=" AND imo.valor<=$valorFiltroFim_20mais ";
				}
			}
			elseif($cont==2)
			{
				if($nao_exclusivos)			$filtro.=" AND exclusivo=0 ";
				if($tipoImovel!="")		    $filtro.=" AND tipo=$tipoImovel ";
				if($idCategoria!="")		$filtro.=" AND idCategoria=$idCategoria ";
				if($opcaoCategoria!="")		$filtro.=" AND imo.idCidade=$opcaoCategoria ";
				if($idSubCategoria!="")		$filtro.=" AND imo.idSubCategoria=$idSubCategoria ";
				if($listaSubCategoria!="")	$filtro.=" AND imo.idRegiao=$listaSubCategoria ";
				if($listaSubCategoria2!="")	$filtro.=" AND imo.idBairro=$listaSubCategoria2 ";
			}
			elseif($cont==3)
			{
				if($nao_exclusivos)			$filtro.=" AND exclusivo=0 ";
				if($tipoImovel!="")		    $filtro.=" AND tipo=$tipoImovel ";
				if($idCategoria!="")		$filtro.=" AND idCategoria=$idCategoria ";
				if($opcaoCategoria!="")		$filtro.=" AND imo.idCidade=$opcaoCategoria ";
				if($listaSubCategoria!="")	$filtro.=" AND imo.idRegiao=$listaSubCategoria ";
				if($listaSubCategoria2!="")	$filtro.=" AND imo.idBairro=$listaSubCategoria2 ";
			}
			elseif($cont==4)
			{
				if($nao_exclusivos)			$filtro.=" AND exclusivo=0 ";
				if($tipoImovel!="")		    $filtro.=" AND tipo=$tipoImovel ";
				if($idCategoria!="")		$filtro.=" AND idCategoria=$idCategoria ";
				if($opcaoCategoria!="")		$filtro.=" AND imo.idCidade=$opcaoCategoria ";
				if($listaSubCategoria!="")	$filtro.=" AND imo.idRegiao=$listaSubCategoria ";
			}
			$comandoSql = "SELECT * FROM imoveis imo WHERE deletado=0 AND status=1 $filtro ORDER BY id DESC";
			//print("$cont $comandoSql<hr>");
			$dados = mysql_db_query($bancoDados, $comandoSql);
			if($dados)
			{
				while($linha = mysql_fetch_array($dados))
				{
					$filtroId .= " AND imo.id!=$linha[id] ";
					$valor=devolveValor($linha['valor']);
					if($linha['imagem'])
					{
						$tamanho=getimagesize("imoveis/p_$linha[imagem]");
						$height="";
						if($tamanho[1]>$tamanho[0])
						{

							$height="height='90'";
						}
						$imagem="
							<img src='imoveis/p_$linha[imagem]' title='Clique para ver o imóvel' $height border='0'>
						";
					}
					$categoria=devolveInfoSite("categorias", $linha['idCategoria']);
					$cidade=devolveInfoSite("cidades", $linha['idCidade']);
					$regiao=devolveInfoSite("regiao", $linha['idRegiao']);
					$bairro=devolveInfoSite("bairros", $linha['idBairro']);
					$linha[valor]="R$ ".devolveValor($linha[valor]);
					$linha[descricaoCurta]=nl2br($linha[descricaoCurta]);

					if($_SESSION['id_detalhe']!="" && $_SESSION['id_detalhe']==$linha['id'])
					{
						//$corgeral="#6D8436";
						$ultimoVisto="
							<tr>
								<th align='left'>
									<a href='index.php?site=detalhes&id=$linha[id]' style='color:#FFF;' title='ÚLTIMO VISTO'>
										<img src='images/check.png' border='0'>
									</a>
								</th>
							</tr>
						";
						$descricaoCurta="<b title='ÚLTIMO VISTO'>$linha[descricaoCurta]</b>";
						$borda=" border: 1px solid #464646; ";
					}
					else
					{
						//$corgeral="#93AD4C";
						$ultimoVisto="";
						$descricaoCurta="$linha[descricaoCurta]";
						$borda="";
					}

					$novoVetor=devolveNovoVetor($composicao);
					if($novoVetor)
					{
						if(existeComposicaoImovelPesquisaQtde($linha['id'], $novoVetor))
						{

							//se encontrar as quantidades desejadas
						}
						elseif(existeComposicaoImovelPesquisa($linha['id'], $novoVetor))
						{
							//se não encontrar com quantidade, tenta sem quantidade
						}
					}
					print("
						<table width='100%' align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#93AD4A' style='margin-bottom:5px; $borda'>
							<tr>
								<td bgcolor='#6D8436' width='40' align='center' valign='middle'>
									<img src='images/lista_$categoria[imagem].jpg' border='0'>
								</td>
								<td align='center' valign='top'>
									<table width='95%' cellpadding='0' cellspacing='0' border='0'>
										<tr>
											<td valign='middle' width='140'>
												<table width='134' cellpadding='0' cellspacing='0' border='0'>
													<tr>
														<td valign='middle' align='center' style='background:url(images/fundo_img_p.jpg) no-repeat; width:134px; height:104px;'><a href='index.php?site=detalhes&id=$linha[id]' style='padding:0px;'>$imagem</a></td>
													</tr>
												</table>
											</td>
											<td valign='top' width='500'>
												<table width='500' cellpadding='0' cellspacing='0' border='0'>
													<tr>
														<td colspan='4' style='padding:5px; line-height:20px; letter-spacing:1px;' valign='top' height='80' bgcolor='#C3D88B'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$descricaoCurta</a></td>
													</tr>
													<tr>
														<th height='45' width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Referência: $linha[referencia]</a></th>
														<th width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Valor: $linha[valor]</a></th>
													</tr>
												</table>
											</td>
											<td valign='top' width='140'>
												<table cellpadding='5' cellspacing='5' border='0'>
													$ultimoVisto
													<tr>
														<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$cidade[nome]</a></th>
													</tr>
													<tr>
														<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Região $regiao[nome]</a></th>
													</tr>
													<tr>
														<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$bairro[nome]</a></th>
													</tr>
												</table>
											</td>
										</tr>
									</table>

								</td>
							</tr>
						</table>
					");
				} // while linha
			}  // if dados
			$cont++;
			$num++;
		} // while (num<5)
	}
}
function cadastraAvaliacao($id, $nome, $email, $satisfacao, $comentario)
{
	include("cms/config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "INSERT INTO avaliacao (idServico, nome, email, satisfacao, comentario, dataCadastro) VALUES ('$id', '$nome', '$email', '$satisfacao', '$comentario', now())";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados){
			$empresa = devolveInfo("servicos", $id);
			switch($satisfacao){
				case 1: $valorSatisfacao = "Ruim"; break;
				case 2: $valorSatisfacao = "Bom"; break;
				case 3: $valorSatisfacao = "Ótimo"; break;
			}
			$mensagem = "
				<table align='left' cellpadding='3' cellspacing='3'>
					<tr bgcolor='#464646'>
						<th colspan='2' style='color:#93AD4C;'>Nova avaliação cadastrada.</th>
					</tr>
					<tr>
						<th align='left' bgcolor='#EFEFEF'>Empresa:</th>
						<td align='left' bgcolor='#EFEFEF'>$empresa[nome]</td>
					</tr>
					<tr>
						<th align='left' bgcolor='#EFEFEF'>Nome:</th>
						<td align='left' bgcolor='#EFEFEF'>$nome</td>
					</tr>
					<tr>
						<th align='left' bgcolor='#EFEFEF'>E-mail:</th>
						<td align='left' bgcolor='#EFEFEF'>$email</td>
					</tr>
					<tr>
						<th align='left' bgcolor='#EFEFEF'>Satisfação:</th>
						<td align='left' bgcolor='#EFEFEF'>$valorSatisfacao</td>
					</tr>
					<tr>
						<th align='left' bgcolor='#EFEFEF' valign='top'>Comentário:</th>
						<td align='left' bgcolor='#EFEFEF' valign='top'>$comentario</td>
					</tr>
				</table>
			";
			sendMail($endereco_email_destino, $nome_email_padrao, $endereco_email_padrao, "Carone Imóveis", "Nova avaliação cadastrada.", $mensagem);
			return TRUE;
		}
	}
	return false;
}
function devolveMediaAvaliacoes($idServico)
{
	include("cms/config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else {
		$comandoSql = "SELECT COUNT(*) as total_votos FROM avaliacao WHERE idServico=$idServico AND status=1 AND deletado=0";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if($linha=mysql_fetch_array($dados))
			{
				$comandoSql2 = "SELECT SUM(satisfacao) as total_avaliacao FROM avaliacao WHERE idServico=$idServico AND status=1 AND deletado=0";
				debug($comandoSql2);
				$dados2 = mysql_db_query($bancoDados, $comandoSql2);

				if ($dados2)
				{
					if($linha2=mysql_fetch_array($dados2))
					{
						if($linha2['total_avaliacao']>0){
							$maximo=$linha['total_votos']*3;
							$valor = 100*($linha2['total_avaliacao']);
							$valor = $valor/$maximo;

							$cheias = intval($valor/20);
							$meias = $valor%20;
							$estrelas="";
							for($i=0;$i<$cheias;$i++)
							{
								$estrelas.="<img src='images/estrela_cheia.png' border='0'>&nbsp;&nbsp;";
							}
							if($meias>0)
							{
								$estrelas.="<img src='images/estrela_meia.png' border='0'>&nbsp;&nbsp;";
							}
							$percent = ceil($valor);
							return "<div title='$percent %'>$estrelas</div>";
						}
						else
						{
							return "Sem avaliações";
						}
					}
				}
			}
			elseif($num==0)
			{
				return "Sem avaliações";
			}
		}
	}
}
function sendMail($toMail, $toNome, $fromMail, $fromNome, $subject, $msg){
	include("cms/config.php");
	require_once('class.phpmailer.php');
	$mail             = new PHPMailer();
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = $smtp_email_padrao;   // SMTP server
	$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
	                                           // 1 = errors and messages
	                                           // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Host       = $smtp_email_padrao; // sets the SMTP server
	$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
	$mail->Username   = $endereco_email_padrao; // SMTP account username
	$mail->Password   = $senha_email_padrao;        // SMTP account password
	$mail->SetFrom("$fromMail", "$fromNome");
	$mail->AddReplyTo("$toMail","$toNome");
	$mail->Subject    = "$subject";
	$mail->MsgHTML($msg);
	$mail->AddAddress($toMail, "$toNome");
	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	  return true;
	} else {
	  return false;
	  //echo "Message sent!";
	}
}
function devolveImoveisDestaqueNovo()
{
	include("cms/config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "SELECT id, imagem, idCidade, idBairro, descricaoCurta, valor FROM imoveis WHERE deletado=0 AND status=1 AND destaque=1 AND imagem!='' ORDER BY RAND() LIMIT 1";
		//echo $comandoSql;
		$dados = mysql_db_query($bancoDados, $comandoSql);
		$num=mysql_num_rows($dados);
		if ($dados && $num>0) {
			if($linha = mysql_fetch_array($dados))
			{
				$nomeBairro=devolveInfoCampo("nome", "bairros", $linha['idBairro']);
				$nomeCidade=devolveInfoCampo("nome", "cidades", $linha['idCidade']);
				$valor=devolveValor($linha['valor']);
				$imagem="<img src='imoveis/g_$linha[imagem]' title='Clique para ver o imóvel' border='0' height='227'>";
				print("
					<div id='box_destaque_home'>
						<div id='imagem'><a href='index.php?site=detalhes&id=$linha[id]'>$imagem</a></div>
						<div id='bairro'><a href='index.php?site=detalhes&id=$linha[id]'>$nomeCidade / $nomeBairro</a></div>
						<div id='descricao'><a href='index.php?site=detalhes&id=$linha[id]'>$linha[descricaoCurta]</a></div>
						<div id='valor'><a href='index.php?site=detalhes&id=$linha[id]'>R$ $valor</a></div>
					</div>
				");
				return $linha['id'];
			}
		}
	}
	return false;
}
function devolveImoveisHome($id1, $id2, $id3, $id4)
{
	include("cms/config.php");
	if (!conectaBancoDados())
	{

		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "
			SELECT
				cat.id as idCategoria, cat.nome as nomeCategoria, cat.imagem as imagemCategoria
				FROM categorias cat

				WHERE (SELECT COUNT(*) as totalImoveisCat FROM imoveis imo WHERE imo.idCategoria=cat.id AND imo.deletado=0 AND imo.status=1)>3
				ORDER BY RAND()
				LIMIT 2
	  	";
		//echo $comandoSql;
		$dados = mysql_db_query($bancoDados, $comandoSql);
		$num=mysql_num_rows($dados);
		if ($dados && $num>0) {
			while($linha = mysql_fetch_array($dados)) {
				$comando2 = "SELECT id, imagem, idCidade, idBairro, valor FROM imoveis WHERE id != '$id1' AND id != '$id2' AND id != '$id3' AND id != '$id4' AND deletado=0 AND status=1 AND imagem!='' AND idCategoria=$linha[idCategoria] ORDER BY RAND() LIMIT 3";
				$dados2 = mysql_db_query($bancoDados, $comando2);
				print("
					<h1><img src='images/$linha[imagemCategoria].jpg'></h1>
					<div id='imoveis_home'>
					");
					$cont=0;
					while($linha2 = mysql_fetch_array($dados2)){
						$styleBg="";
						$styleValor=" style='color:#92ad4b;' ";

						if($cont%2!=0){
							$styleBg=" style='background:#92ad4b;' ";
							$styleValor=" style='color:#fff;' ";
						}

						$nomeBairro=devolveInfoCampo("nome", "bairros", $linha2['idBairro']);
						$nomeCidade=devolveInfoCampo("nome", "cidades", $linha2['idCidade']);
						$valor=devolveValor($linha2['valor']);
						$tam=getimagesize("imoveis/m_$linha2[imagem]");
						$height="";
						if($tam[1]>170)
							$height="height='170'";
						$imagem="<img src='imoveis/m_$linha2[imagem]' title='Clique para ver o imóvel' border='0' $height>";
						print("
							<div id='box_imovel_home' $styleBg>
								<div id='imagem'><a href='index.php?site=detalhes&id=$linha2[id]'>$imagem</a></div>
								<div id='local'><a href='index.php?site=detalhes&id=$linha2[id]'>$nomeCidade / $nomeBairro</a></div>
								<div id='valor'><a href='index.php?site=detalhes&id=$linha2[id]' $styleValor>R$ $valor</a></div>
							</div>
						");
						$cont++;
					}
					print("
					</div><!--imoveis_home-->
				");
			}
		}
	}
	return false;
}
function devolveImoveisDestaqueHome($idDestaque)
{
	include("cms/config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{

		$comando2 = "SELECT id, imagem, idCidade, idBairro, valor FROM imoveis WHERE deletado=0 AND status=1 AND destaque=1 AND imagem!='' AND id!=$idDestaque ORDER BY RAND() LIMIT 3";
		$dados2 = mysql_db_query($bancoDados, $comando2);

		print("
			<h1><img src='images/vejamaisimoveis.jpg'></h1>
			<div id='imoveis_home'>
			");
		$cont=0;
		while($linha2 = mysql_fetch_array($dados2)){
			$retorno[$cont]=$linha[id];
			$styleBg="";
			$styleValor=" style='color:#92ad4b;' ";
			if($cont%2!=0){
				$styleBg=" style='background:#92ad4b;' ";
				$styleValor=" style='color:#fff;' ";
			}

			$nomeBairro=devolveInfoCampo("nome", "bairros", $linha2['idBairro']);
			$nomeCidade=devolveInfoCampo("nome", "cidades", $linha2['idCidade']);
			$valor=devolveValor($linha2['valor']);
			$tam=getimagesize("imoveis/m_$linha2[imagem]");
			$height="";
			if($tam[1]>170)
				$height="height='170'";
			$imagem="<img src='imoveis/m_$linha2[imagem]' title='Clique para ver o imóvel' border='0' $height>";
			print("
				<div id='box_imovel_home' $styleBg>
					<div id='imagem'><a href='index.php?site=detalhes&id=$linha2[id]'>$imagem</a></div>
					<div id='local'><a href='index.php?site=detalhes&id=$linha2[id]'>$nomeCidade / $nomeBairro</a></div>
					<div id='valor'><a href='index.php?site=detalhes&id=$linha2[id]' $styleValor>R$ $valor</a></div>
				</div>
			");
			$cont++;
		}
		print("
			</div><!--imoveis_home-->
		");


	}
	return $retorno;
}
function enviaAvisos() {
	include("cms/config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else {
		$hoje = date("Y-m-d")." 23:59:59";
		$comandoSql = "SELECT * FROM enviaavisos WHERE dataEnvio<='$hoje'";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados && mysql_fetch_array($dados)>0){
			return false;
		}

		$hoje = date("Y-m-d")." 00:00:00";
		$diff = date("w",strtotime($hoje));



		$diaInicioSemana = strftime("%Y-%m-%d",strtotime("$hoje -$diff days"));
		$diaFimSemana = strftime("%Y-%m-%d",strtotime("$diaInicioSemana +6 days"));
		$tabelaAniversariantes="";
		$tabelaExclusivos="";
		//avisos
		$where="";
		$datafiltro=explode("-", $diaInicioSemana);

		$where.=" AND DAY(dataNascimento) >= '$datafiltro[2]' ";
		$where.=" AND MONTH(dataNascimento) >= '$datafiltro[1]' ";
		$datafiltro=explode("-", $diaFimSemana);
		$where.=" AND DAY(dataNascimento) <= '$datafiltro[2]' ";
		$where.=" AND MONTH(dataNascimento) <= '$datafiltro[1]' ";
		$comandoSql = "SELECT id, nome, email, dataNascimento FROM cliente WHERE deletado=0 $where";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados){
			if(mysql_num_rows($dados)>0){
				$tabelaAniversariantes="<table cellpadding='2' cellspacing='2'><tr bgcolor='#efefef'><th align='center'>Cliente</th><th align='center'>E-mail</th><th>Data Aniversário (idade)</th></tr>";
				while($linha = mysql_fetch_array($dados)){
					$dataAniversario=converteDataFromMysql($linha['dataNascimento']);
					$idade=getIdade($dataAniversario);
					$tabelaAniversariantes.="<tr bgcolor='#efefef'><td align='left'>$linha[nome]</td><td align='left'>$linha[email]</td><td align='left'>$dataAniversario ($idade)</td></tr>";
				}

				$tabelaAniversariantes.="</table>";
			}
		}
		//exclusivos
		$comandoSql = "SELECT id, referencia, dataAviso, dataTerminoExclusividade, idCliente FROM imoveis WHERE deletado=0 AND dataAviso>='$diaInicioSemana' AND dataAviso<='$diaFimSemana'";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados){
			if(mysql_num_rows($dados)>0){
				$tabelaExclusivos="<table cellpadding='2' cellspacing='2'><tr><th align='center'>CI</th><th align='center'>Cliente</th><th>Data de Aviso | Data de Término Exclusividade</th></tr>";
				while($linha = mysql_fetch_array($dados)){
					$nomeCliente=devolveInfoCampo("nome", "cliente", $linha['idCliente']);
					$dataAviso=converteDataFromMysql($linha['dataAviso']);
					$dataExclusividade=converteDataFromMysql($linha['dataTerminoExclusividade']);
					$tabelaExclusivos.="<tr bgcolor='#efefef'><td align='left'>CI $linha[referencia]</td><td align='left'>$nomeCliente</td><td align='left'>$dataAviso | $dataExclusividade</td></tr>";
				}
				$tabelaExclusivos.="</table>";
			}
		}
	}

	$retornoAniversariantes="";
	$retornoExclusivos="";
	if($tabelaAniversariantes!=""){
		sendMail($endereco_email_padrao, $nome_email_padrao, $endereco_email_padrao, $nome_email_padrao, "AVISOS - Aniversariantes da Semana", $tabelaAniversariantes);
		$retornoAniversariantes=1;
	}
	if($tabelaExclusivos!=""){
		sendMail($endereco_email_padrao, $nome_email_padrao, $endereco_email_padrao, $nome_email_padrao, "AVISOS - Términos de Exclusividade da Semana", $tabelaExclusivos);
		$retornoExclusivos=1;
	}
	if($retornoExclusivos || $retornoAniversariantes){
		$comandoSql = "INSERT INTO enviaavisos (dataEnvio) VALUES (now())";
		$dados = mysql_db_query($bancoDados, $comandoSql);
	}
	return false;
}
function getIdade($aniversario, $curr = 'now') {
	$year_curr = date("Y", strtotime($curr));
	$days = !($year_curr % 4) || !($year_curr % 400) & ($year_curr % 100) ? 366: 355;
	list($d, $m, $y) = explode('/', $aniversario);
	return floor(((strtotime($curr) - mktime(0, 0, 0, $m, $d, $y)) / 86400) / $days);
}
function listaComposicoesPesquisa($composicaoValue)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "
			SELECT

				comp.id as idComposicao,
				comp.nome as nomeComposicao,
				MAX(compimo.qtdeComposicao) as qtdeComposicao
      		FROM
      			composicaoimovel compimo INNER JOIN composicao comp ON compimo.idComposicao=comp.id
      		WHERE comp.relevancia=10
			GROUP BY compimo.idComposicao
      		ORDER BY comp.nome, compimo.qtdeComposicao DESC
		";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados && mysql_num_rows($dados)>0) {
			print("
				<table width='300' celppadding='2' cellspacing='2' border='0' align='center'>
					");
					$composicao = array();
					$cont=0;
					while($linha = mysql_fetch_array($dados))
					{
						$idComposicao=$linha['idComposicao'];
						if($cont%2==0)	print("<tr>");
						print("
							<td width='10%' align='left'>
								<select name='composicao[$idComposicao]' id='composicao[$idComposicao]'>
									");
						$cont2=1;
						print("<option value='' selected='selected'>--</option>");
						while($cont2<=5)
						{
							if($composicaoValue[$idComposicao]==$cont2)	$sel="selected";	else	$sel="";
							print("<option value='$cont2' $sel>$cont2</option>");
							$cont2++;
						}
						print("
								</select>

							</td>
							<td width='90%' align='left'>$linha[nomeComposicao]</td>
						");
						if($cont%2!=0)	print("</tr>");
						$cont++;
					}
					print("
				</table>
			");
		}
	}
	return false;
}
function devolveImoveisPesquisa($referencia, $idCategoria, $valorIni, $valorFim, $opcaoCategoria, $listaSubCategoria, $composicao) {
	include("cms/config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else {

		$filtro="";
		$filtroValor="";
		if($referencia!="")	$filtro.=" AND referencia like '%$referencia%' ";
		if($idCategoria!="") $filtro.=" AND idCategoria=$idCategoria ";
		if($opcaoCategoria!="")		$filtro.=" AND imo.idCidade=$opcaoCategoria ";
		if($listaSubCategoria!="")	$filtro.=" AND imo.idRegiao=$listaSubCategoria ";
		if($valorIni!="")
		{
			$valorFiltroIni=formataValor($valorIni);
			$filtroValor.=" AND imo.valor>=$valorFiltroIni ";
		}
		if($valorFim!="")
		{
			$valorFiltroFim=formataValor($valorFim);
			$filtroValor.=" AND imo.valor<=$valorFiltroFim ";
		}


		$listaIdsResultado=array();
		$tabelaResultadoInteresse="";
		$tabelaResultadoProvavel="";
		$tabelaImovel="";

		$comandoSql = "SELECT * FROM imoveis imo WHERE deletado=0 AND status=1 $filtro $filtroValor ORDER BY id DESC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		$num=mysql_num_rows($dados);
		if($dados && $num>0) {
			while($linha = mysql_fetch_array($dados)) {
				$valor=devolveValor($linha['valor']);
				if($linha['imagem'])
					$imagem="<img src='imoveis/p_$linha[imagem]' title='Clique para ver o imóvel' border='0' style='max-height:90px;'>";
				else
					$imagem="";
				if($_SESSION['id_detalhe']!="" && $_SESSION['id_detalhe']==$linha['id']) {
					$ultimoVisto="<tr><th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#FFF;' title='ÚLTIMO VISTO'><img src='images/check.png' border='0'></a></th></tr>";
					$descricaoCurta="<b title='ÚLTIMO VISTO'>$linha[descricaoCurta]</b>";
					$borda=" border: 1px solid #464646; ";
				}
				else {
					$ultimoVisto="";
					$descricaoCurta="$linha[descricaoCurta]";
					$borda="";
				}
				$categoria=devolveInfoSite("categorias", $linha['idCategoria']);
				$cidade=devolveInfoSite("cidades", $linha['idCidade']);
				$regiao=devolveInfoSite("regiao", $linha['idRegiao']);
				$bairro=devolveInfoSite("bairros", $linha['idBairro']);
				$linha['valor']="R$ ".devolveValor($linha['valor']);
				$linha['descricaoCurta']=nl2br($linha['descricaoCurta']);
				$tabelaImovel="
					<table width='90%' align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#93AD4A' style='margin-bottom:5px; $borda'>
						<tr><td bgcolor='#6D8436' width='40' align='center' valign='middle'><img src='images/lista_$categoria[imagem].jpg' border='0'></td>
							<td align='center' valign='top'>
								<table width='95%' cellpadding='0' cellspacing='0' border='0'>
									<tr><td valign='middle' width='140'><table width='134' cellpadding='0' cellspacing='0' border='0'><tr><td valign='middle' align='center' style='background:url(images/fundo_img_p.jpg) no-repeat; width:134px; height:104px;'><a href='index.php?site=detalhes&id=$linha[id]' style='padding:0px;'>$imagem</a></td></tr></table></td>
										<td valign='top' width='500'>
											<table width='500' cellpadding='0' cellspacing='0' border='0'>
												<tr><td colspan='4' style='padding:5px; line-height:20px; letter-spacing:1px;' valign='top' height='80' bgcolor='#C3D88B'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$descricaoCurta</a></td></tr>
												<tr><th height='45' width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Referência: $linha[referencia]</a></th><th width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Valor: $linha[valor]</a></th></tr>
											</table>
										</td>
										<td valign='top' width='140'>
											<table cellpadding='5' cellspacing='5' border='0'>
												$ultimoVisto
												<tr><th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$cidade[nome]</a></th></tr>
												<tr><th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Região $regiao[nome]</a></th></tr>
												<tr><th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$bairro[nome]</a></th></tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				";
				$novoVetor=devolveNovoVetor($composicao);
				if($novoVetor) {
					if(existeComposicaoImovelPesquisa($linha['id'], $novoVetor)) {
						if(existeComposicaoImovelPesquisaQtde($linha['id'], $novoVetor)) {
							$listaIdsResultado[$linha['id']]=1;
							$tabelaResultadoInteresse.=$tabelaImovel;
						}
						else {
							$listaIdsResultado[$linha['id']]=1;
							$tabelaResultadoProvavel.=$tabelaImovel;
						}
					}
					else {
						$listaIdsResultado[$linha['id']]=1;
						$tabelaResultadoProvavel.=$tabelaImovel;
					}
				}
				else {
					$listaIdsResultado[$linha['id']]=1;
					$tabelaResultadoInteresse.=$tabelaImovel;
				}
			} // while linha
		}  // if dados
		elseif($num==0)
		{
			$comandoSql = "SELECT * FROM imoveis imo WHERE deletado=0 AND status=1 $filtro ORDER BY id DESC";
			//echo "não encontrado:".$comandoSql;
			$dados = mysql_db_query($bancoDados, $comandoSql);
			$num=mysql_num_rows($dados);
			if($dados && $num>0) {
				while($linha = mysql_fetch_array($dados)) {
					$valor=devolveValor($linha['valor']);
					if($linha['imagem'])
						$imagem="<img src='imoveis/p_$linha[imagem]' title='Clique para ver o imóvel' border='0' style='max-height:90px;'>";
					else
						$imagem="";
					if($_SESSION['id_detalhe']!="" && $_SESSION['id_detalhe']==$linha['id']) {
						$ultimoVisto="
							<tr>
								<th align='left'>
									<a href='index.php?site=detalhes&id=$linha[id]' style='color:#FFF;' title='ÚLTIMO VISTO'>
										<img src='images/check.png' border='0'>
									</a>

								</th>
							</tr>
						";
						$descricaoCurta="<b title='ÚLTIMO VISTO'>$linha[descricaoCurta]</b>";
						$borda=" border: 1px solid #464646; ";
					}
					else {
						$ultimoVisto="";
						$descricaoCurta="$linha[descricaoCurta]";
						$borda="";
					}
					$categoria=devolveInfoSite("categorias", $linha['idCategoria']);
					$cidade=devolveInfoSite("cidades", $linha['idCidade']);

					$regiao=devolveInfoSite("regiao", $linha['idRegiao']);
					$bairro=devolveInfoSite("bairros", $linha['idBairro']);
					$linha['valor']="R$ ".devolveValor($linha['valor']);
					$linha['descricaoCurta']=nl2br($linha['descricaoCurta']);
					$tabelaImovel="
						<table width='90%' align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#93AD4A' style='margin-bottom:5px; $borda'>
							<tr><td bgcolor='#6D8436' width='40' align='center' valign='middle'><img src='images/lista_$categoria[imagem].jpg' border='0'></td>
								<td align='center' valign='top'>
									<table width='95%' cellpadding='0' cellspacing='0' border='0'>
										<tr><td valign='middle' width='140'><table width='134' cellpadding='0' cellspacing='0' border='0'><tr><td valign='middle' align='center' style='background:url(images/fundo_img_p.jpg) no-repeat; width:134px; height:104px;'><a href='index.php?site=detalhes&id=$linha[id]' style='padding:0px;'>$imagem</a></td></tr></table></td>
											<td valign='top' width='500'>
												<table width='500' cellpadding='0' cellspacing='0' border='0'>
													<tr><td colspan='4' style='padding:5px; line-height:20px; letter-spacing:1px;' valign='top' height='80' bgcolor='#C3D88B'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$descricaoCurta</a></td></tr>
													<tr><th height='45' width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Referência: $linha[referencia]</a></th><th width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Valor: $linha[valor]</a></th></tr>
												</table>
											</td>
											<td valign='top' width='140'>
												<table cellpadding='5' cellspacing='5' border='0'>
													$ultimoVisto
													<tr><th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$cidade[nome]</a></th></tr>
													<tr><th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Região $regiao[nome]</a></th></tr>
													<tr><th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$bairro[nome]</a></th></tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					";
					$novoVetor=devolveNovoVetor($composicao);
					if($novoVetor) {
						if(existeComposicaoImovelPesquisa($linha['id'], $novoVetor)) {
							if(existeComposicaoImovelPesquisaQtde($linha['id'], $novoVetor)) {
								if(!$listaIdsResultado[$linha['id']])
									$tabelaResultadoProvavel.=$tabelaImovel;
							}
							else {
								if(!$listaIdsResultado[$linha['id']])
									$tabelaResultadoProvavel.=$tabelaImovel;
							}
						}
						else {
							// já é provável
						}
					}
					else {
						// já é provável
					}
				} // while linha
			}  // if dados
			elseif($num==0){
				$retorno="
					<center>
						<table align='center' cellpadding='5' cellspacing='5'>
							<tr>
								<td align='justify' style='padding:10px; letter-spacing:1px; line-height:20px;'>
									Não foram encontrados imóveis com todos os filtros desejados.
								</td>
							</tr>
						</table>
					</center>
				";
				mensagemRetorno("$retorno", "margin:5px auto; width:600px; text-align:center;");
			}
		}
		if($tabelaResultadoInteresse!=""){
			print("<h1>Encontramos estes resultados para você</h1>".$tabelaResultadoInteresse);
			if($tabelaResultadoProvavel!=""){
				print("<h1>E também encontramos outros imóveis que possam lhe agradar</h1>".$tabelaResultadoProvavel);
			}
		}
		elseif($tabelaResultadoProvavel!=""){
			print("<div style='border:1px solid #C3CC8B; background-color: #C3D88B; width: 840px; margin: 50px auto;'><h1>Não encontramos imóveis com os parâmetros solicitados. No entanto encontramos outros imóveis que possam lhe agradar...</h1></div>".$tabelaResultadoProvavel);
		}

	}
}
function existeComposicaoImovelPesquisa($idImovel, $composicao)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else {
		if($composicao && sizeof($composicao)>0) {
			while(list($chave,$linhaArray) = each($composicao))	{
				$comandoSql = "SELECT idImovel, qtdeComposicao FROM composicaoimovel WHERE idImovel=$idImovel AND idComposicao=$chave";
				$dados = mysql_db_query($bancoDados, $comandoSql);
				$num = mysql_num_rows($dados);
				if($dados && $num>0) {
					return true;

				}
				return false;
			}
		}
		return false;
	}
	return false;
}
function existeComposicaoImovelPesquisaQtde($idImovel, $composicao)
{
	include("cms/config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else {
		$cont=0;
		while(list($chave,$linhaArray) = each($composicao))	{
			$comandoSql = "SELECT idImovel, qtdeComposicao FROM composicaoimovel WHERE idImovel=$idImovel AND idComposicao=$chave AND qtdeComposicao>=$linhaArray";
			$dados = mysql_db_query($bancoDados, $comandoSql);
			$num = mysql_num_rows($dados);
			if($dados && $num>0) {
				$cont++;
			}
		}
		if($cont==count($composicao)){
			return true;
		}

	}
	return false;
}
function devolveImoveis($tipoImovel, $idCategoria, $idCidadeRegiao, $valorIni, $valorFim, $ord, $ppp, $index, $mark, $referencia){
	include("cms/config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else{
		$filtro="";
		if($referencia!="")	$filtro.=" AND referencia like '%$referencia%' ";
		if($tipoImovel!="" && $tipoImovel!="-1")	$filtro.=" AND tipo=$tipoImovel ";
		if($idCategoria>0)	$filtro.=" AND idCategoria=$idCategoria ";
		if($valorIni!=""){
			$valorFiltroIni=formataValor($valorIni);
			$filtro.=" AND valor>=$valorFiltroIni ";
		}
		if($valorFim!=""){
			$valorFiltroFim=formataValor($valorFim);
			$filtro.=" AND valor<=$valorFiltroFim ";
		}
		if($idCidadeRegiao!=""){
			$filtroCidadeRegiao = explode("-", $idCidadeRegiao);
			if($filtroCidadeRegiao[0]!="")
				$filtro.=" AND idCidade=$filtroCidadeRegiao[0] ";
			if($filtroCidadeRegiao[1]!="")
				$filtro.=" AND idBairro=$filtroCidadeRegiao[1] ";
		}
		$filtroLimit="";
		if($ppp!="0"){
			$filtroLimit=" LIMIT $index,$ppp ";
		}

		if($ord=="novos") $filtroOrd=" ORDER BY id DESC ";
		if($ord=="precoMais") $filtroOrd=" ORDER BY valor DESC ";
		if($ord=="precoMenos") $filtroOrd=" ORDER BY valor ASC ";

		$comandoSql = "SELECT * FROM imoveis WHERE deletado=0 AND status=1 $filtro $filtroOrd $filtroLimit";
		//echo $comandoSql;
		$dados = mysql_db_query($bancoDados, $comandoSql);
		$total_encontrado = mysql_num_rows($dados);
		if($dados && $total_encontrado>0){
			devolveNavegacaoImoveis($index, "imoveis", "WHERE deletado=0 AND status=1 $filtro ", $mark, "imoveis", "&tipoImovel=$tipoImovel&idCategoria=$idCategoria&idCidadeRegiao=$idCidadeRegiao&valorIni=$valorIni&valorFim=$valorFim&ord=$ord&ppp=$ppp", $ppp, $total_encontrado);
			$cont=0;
			while($linha = mysql_fetch_array($dados))
			{
				$valor=devolveValor($linha['valor']);
				if($linha['imagem'] && file_exists("imoveis/p_$linha[imagem]"))
				{
					$tamanho=getimagesize("imoveis/p_$linha[imagem]");
					$height="";
					if($tamanho[1]>$tamanho[0])
					{
						$height="height='90'";
					}
					$imagem="
						<img src='imoveis/p_$linha[imagem]' title='Clique para ver o imóvel' $height border='0'>
					";
				}
				else
				{
					$imagem="
						<img src='images/p_naoencontrada.jpg' title='Clique para ver o imóvel' border='0'>
					";
				}
				$categoria=devolveInfoSite("categorias", $linha['idCategoria']);
				$cidade=devolveInfoSite("cidades", $linha['idCidade']);
				$regiao=devolveInfoSite("regiao", $linha['idRegiao']);
				$bairro=devolveInfoSite("bairros", $linha['idBairro']);
				$linha[valor]="R$ ".devolveValor($linha[valor]);
				$linha[descricaoCurta]=nl2br($linha[descricaoCurta]);
				if($_SESSION['id_detalhe']!="" && $_SESSION['id_detalhe']==$linha['id'])
				{
					//$corgeral="#6D8436";
					$ultimoVisto="
						<tr>
							<th align='left' valign='middle'>
								<a href='index.php?site=detalhes&id=$linha[id]' style='color:#FFF;' title='ÚLTIMO VISTO'>
									<img src='images/check.png' border='0'>
								</a>
							</th>
						</tr>
					";
					$descricaoCurta="<b title='ÚLTIMO VISTO'>$linha[descricaoCurta]</b>";
					$borda=" border: 1px solid #464646; ";
				}
				else
				{

					//$corgeral="#93AD4C";

					$ultimoVisto="";
					$descricaoCurta="$linha[descricaoCurta]";
					$borda="";
				}
				if($categoria['imagem']!=""){
					$img_cat="<img src='images/lista_$categoria[imagem].jpg' border='0'>";
				}
				else{
					$img_cat="&nbsp;";
				}

				print("
					<table width='100%' align='center' border='0' cellpadding='0' cellspacing='0' bgcolor='#93AD4C' style='margin-bottom:5px; $borda'>
						<tr>
							<td bgcolor='#6D8436' width='40' align='center' valign='middle'>
								$img_cat
							</td>
							<td align='center' valign='top'>

								<table width='95%' cellpadding='0' cellspacing='0' border='0'>
									<tr>
										<td valign='middle' width='140'>
											<table width='134' cellpadding='0' cellspacing='0' border='0'>
												<tr>
													<td valign='middle' align='center' style='background:url(images/fundo_img_p.jpg) no-repeat; width:134px; height:104px;'><a href='index.php?site=detalhes&id=$linha[id]' style='padding:0px;'>$imagem</a></td>
												</tr>
											</table>
										</td>
										<td valign='top' width='500'>
											<table width='500' cellpadding='0' cellspacing='0' border='0'>
												<tr>
													<td colspan='4' style='padding:5px; line-height:20px; letter-spacing:1px;' valign='top' height='80' bgcolor='#C3D88B'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$descricaoCurta</a></td>
												</tr>
												<tr>
													<th height='45' width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Referência: $linha[referencia]</a></th>
													<th width='50%' valign='middle' align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Valor: $linha[valor]</a></th>
												</tr>
											</table>
										</td>
										<td valign='top' width='140'>
											<table cellpadding='5' cellspacing='5' border='0'>
												$ultimoVisto
												<tr>
													<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$cidade[nome]</a></th>
												</tr>
												<tr>
													<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>Região $regiao[nome]</a></th>
												</tr>
												<tr>
													<th align='left'><a href='index.php?site=detalhes&id=$linha[id]' style='color:#333;'>$bairro[nome]</a></th>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				");
			}
			devolveNavegacaoImoveis($index, "imoveis", "WHERE deletado=0 AND status=1 $filtro ", $mark, "imoveis", "&tipoImovel=$tipoImovel&idCategoria=$idCategoria&idCidadeRegiao=$idCidadeRegiao&valorIni=$valorIni&valorFim=$valorFim&ord=$ord&ppp=$ppp", $ppp, $total_encontrado);
		}
		else
		{
			$retorno="
				<table cellpadding='5' cellspacing='5'>

					<tr>
						<td align='right'>Nenhum imóvel encontrado com os parâmetros passados</td>
					</tr>
				</table>
			";
			mensagemRetorno("$retorno", "margin:5px; clear:both;");
			return false;
		}
	}
	return false;
}
function devolveNavegacaoImoveis($index, $acao, $where, $mark, $tabela, $post, $qtde_pagina, $total_encontrado)
{
	include("cms/config.php"); // Inclui o arquivo de configuraçao do Banco de Dados.
	if(!conectaBancoDados()) {
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "SELECT COUNT(*) as numero FROM $tabela $where ";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				//$totalGeral=$linha['numero'];
				print("<div id='divclear'></div>");
				if($linha['numero']>$qtde_pagina && $qtde_pagina>0)	{

					$inicio=1;
					$fim=ceil($linha['numero']/$qtde_pagina);
					$ini_pag = (($mark-1)*$qtde_pagina)+1;
					$fim_pag = $ini_pag + $qtde_pagina - 1;
					if($fim_pag>$linha['numero'])
						$fim_pag=$linha['numero'];

					$tamanhoUl=30*$fim."px";

					if($linha['numero']==1) $qtdeEncontrado="1 encontrado";
					else 					$qtdeEncontrado="$linha[numero] encontrados";

					print("
						<div id='total_encontrado'> $qtdeEncontrado <b>|</b> Mostrando $ini_pag - $fim_pag</div>
						<div id='navegacao'>
							<ul style='width:$tamanhoUl;'>
							");
					$y=$inicio;
					while($y<=$fim){

						if($y == $mark){
							//over
							print("<li id='over'><a href='index.php?site=$acao&index=$limite&mark=$y$post'>$y</a></li>");
						}
						else{
							$limite = ($y-1)*$qtde_pagina;
							print("<li><a href='index.php?site=$acao&index=$limite&mark=$y$post'>$y</a></li>");
						}
						$y++;
					}
					$nesta_pagina=$qtde_pagina-$mark;
					print("
							</ul>
						</div>

					");
				}
				else{
					if($linha['numero']==1) $qtdeEncontrado="1 encontrado";
					else 					$qtdeEncontrado="$linha[numero] encontrados";
					print("
						<div id='navegacao'>
							&nbsp;
						</div>
						<div id='total_encontrado'> $qtdeEncontrado <b>|</b> Mostrando 1 - $linha[numero]</div>
					");
				}
				print("<div id='divclear'></div>");
			}
		}
	}
}
?>