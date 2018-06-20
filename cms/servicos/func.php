<?php
function montaSelect($tabela, $idSelecionado)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM $tabela WHERE deletado=0 ORDER BY nome ASC";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if(mysql_num_rows($dados) == 0)
			{
				print("<option value='' disabled>Antes, cadastre uma categoria!</option>");
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
function cadastraCategoria($nome, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "INSERT INTO categoriaservicos(nome, idUsuarioCadastro, dataCadastro) VALUES('$nome', '$login', now())";
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
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT id, date_format(dataCadastro, '%d/%m/%Y') as dataCadastro, nome FROM categoriaservicos $where LIMIT $index,25";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				devolveNavegacao($index, "index.php?modulo=negocios&acao=categorias", $where, $mark, "categoriaservicos", $post);
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
							<td width='24'><a href='index.php?modulo=servicos&acao=categorias&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=servicos&acao=categorias&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=negocios&acao=categorias", $where, $mark, "categoriaservicos", $post);
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
								Nenhum registro de categoria cadastrado.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibiçao das Categorias!</strong></center>");
	}
}
function editaCategoria($nome, $codigo, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE categoriaservicos SET nome='$nome', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$codigo'";
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
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$idUsuario=devolveIdUsuario($login);
		$comando = "UPDATE categoriaservicos SET deletado='1', idUsuarioAtualizacao='$idUsuario', dataAtualizacao=now() WHERE id='$id'";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
////////////////////////////
function adicionaServico($idCategoria, $nome, $descricao, $telefone, $email, $endereco)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "INSERT INTO servicos(idCategoria, nome, descricao, telefone, endereco, email, dataCadastro, idUsuarioCadastro)
								VALUES('$idCategoria', '$nome', '$descricao', '$telefone', '$endereco', '$email', now(), '$_SESSION[idUsuario]')";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if($dados)	return true;
	}
	return false;
}
function atualizaServico($id, $idCategoria, $nome, $descricao, $email, $telefone, $endereco)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE servicos SET idCategoria='$idCategoria', nome='$nome', descricao='$descricao', email='$email', telefone='$telefone', endereco='$endereco', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$id'";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
function removeServico($id)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE servicos SET deletado='1', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$id'";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}

function devolveListaServicos($tipo, $index, $mark, $where, $oder, $titulo, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else {
		$comandoSql = "SELECT *, DATE_FORMAT(dataCadastro, '%d/%m/%Y') as dataCadastro FROM servicos $where LIMIT $index,25 ";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				print("<div align='right'>Registros: ($numero encontrados)</div>");
				devolveNavegacao($index, "index.php?modulo=servicos&acao=servicos&tipo=listar", $where, $mark, "servicos", $post);
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='20%'>Categoria</th>
							<th align='left' width='20%'>Nome</th>
							<th align='left' width='15%'>Telefone</th>
							<th align='left' width='20%'>Avaliação</th>
							<th colspan='3'>&nbsp;</th>
						</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					$cat = devolveInfo("categoriaservicos", $linha['idCategoria']);
					$media=devolveMediaAvaliacoes($linha['id']);
					print("
						<tr>
							<td title='$linha[dataCadastro]'><a href='index.php?modulo=servicos&acao=servicoinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[dataCadastro]</a></td>
							<td title='$linha[nome]'><a href='index.php?modulo=servicos&acao=servicoinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[nome]</a></td>
							<td title='$cat[nome]'><a href='index.php?modulo=servicos&acao=servicoinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[telefone]</a></td>
							<td title='$linha[telefone]'><a href='index.php?modulo=servicos&acao=servicoinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$cat[nome]</a></td>
							<td>$media</td>
							<td width='24'><a href='index.php?modulo=servicos&acao=servicoinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=servicos&acao=servicoinfo&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=servicos&acao=servicos&tipo=listar&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=servicos&acao=servicos&tipo=listar", $where, $mark, "servicos", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='25%'>Categoria</th>
							<th align='left' width='30%'>Nome</th>
							<th align='left' width='25%'>Telefone</th>
							<th colspan='3'>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='6'>
								Nenhum registro de serviços cadastrados.
							</td>
						</tr>
					</table>
				");
			}

		}
		else
			print("<center><strong>Erro na exibiçao!</strong></center>");
	}
}
function devolveMediaAvaliacoes($idServico)
{
	include("./config.php");

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
								$estrelas.="<img src='imagens/estrela_cheia.png' border='0'>&nbsp;&nbsp;";
							}
							if($meias>0)
							{
								$estrelas.="<img src='imagens/estrela_meia.png' border='0'>&nbsp;&nbsp;";
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
/***************************************************/

function devolveListaAvaliacoes($index, $mark, $where, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else {
		$comandoSql = "SELECT *, DATE_FORMAT(dataCadastro, '%d/%m/%Y') as dataCadastro FROM avaliacao $where LIMIT $index,25 ";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				print("<div align='right'>Registros: ($numero encontrados)</div>");
				devolveNavegacao($index, "index.php?modulo=servicos&acao=satisfacao", $where, $mark, "avaliacao", $post);
				print("
					<div align='left'>
						<a href='#' onclick='javascript: tamanhoVetor=selecionar_tudo(); return false;'>Marcar todos</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href='#' onclick='javascript:deselecionar_tudo(); tamanhoVetor=0; return false;'>Desmarcar todos</a>
					</div>
					<script language='javascript'>
						var tamanhoVetor=0;
					</script>
					<form style='width:auto;' name='f1' id='f1' action='index.php?modulo=servicos&acao=satisfacao' method='post'>
					<table width='100%'>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					$cat = devolveInfo("categoriaservicos", $linha['idCategoria']);
					if($linha['satisfacao']==1)	$avaliacao="Ruim";
					elseif($linha['satisfacao']==2)	$avaliacao="Bom";
					elseif($linha['satisfacao']==3)	$avaliacao="Ótimo";
					$comentario = nl2br($linha['comentario']);

					if($linha['status']==0)
					{
						$status = "<img src='imagens/destaque0.png' border='0' class='icone_botao'> Não validada</a>";
					}
					elseif($linha['status']==1)
					{
						$status = "<img src='imagens/destaque1.png' border='0' class='icone_botao'> Já validada</a>";
					}
					$servico = devolveInfo("servicos", $linha['idServico']);
					print("
						<tr>
							<td colspan='2'>
								<table width='100%' id='gradient-style-detalhes'>
									<tr>
										<th align='left' colspan='5'>
											Empresa Avaliada
										</th>
									</tr>
									<tr>
										<td colspan='5'>
											$servico[nome]
										</td>
									</tr>
									<tr>
										<td align='center' rowspan='4' valign='middle' width='5%'>
											<input type='checkbox' name='lista[]' value='$linha[id]' onclick=\"if(this.checked){tamanhoVetor++;}else{tamanhoVetor--;}\">
										</td>
										<th align='left' width='20%'>Data de Cadastro</th>
										<th align='left' width='25%'>Nome</th>
										<th align='left' width='25%'>E-mail</th>
										<th align='left' width='25%'>Avaliação</th>
									</tr>
									<tr>
										<td align='left'>$linha[dataCadastro]</td>
										<td align='left'>$linha[nome]</td>
										<td align='left'>$linha[email]</td>
										<td align='left'>$avaliacao</td>
									</tr>
									<tr>
										<th align='left' colspan='3'>Descrição</th>
										<th align='left'>Status Avaliação</th>
									</tr>
									<tr>
										<td align='left' colspan='3'>$comentario</td>
										<td align='left'>$status</td>
									</tr>
								</table>
							</td>
						</tr>
					");
				}
				print("
					<tr>
						<td align='right' style='padding-right:100px;'>
							<input type='submit' id='form_submit' name='submitExcluir' value='Excluir' onclick=\"if(tamanhoVetor<=0){alert('Selecione pelo menos um ítem para excluir!'); return false;}else{return confirmaExclusao();}\">
						</td>
						<td align='left' style='padding-left:100px;'>
							<input type='submit' id='form_submit' name='submitValidar' value='Validar' onclick=\"if(tamanhoVetor<=0){alert('Selecione pelo menos um ítem para validar!'); return false;}else{return confirmaExclusao('Deseja validar as avaliações selcionadas?');}\">
						</td>
					</tr>
				</table>
				</form>
				<script language='javascript'>
					function selecionar_tudo(tamanhoVetor){
					   for (i=0;i<document.f1.elements.length;i++)
					      if(document.f1.elements[i].type == \"checkbox\")
					      {
					         tamanhoVetor++;
							 document.f1.elements[i].checked=1;
						  }
						return tamanhoVetor;
					}
					function deselecionar_tudo(tamanhoVetor){
					   for (i=0;i<document.f1.elements.length;i++)
					      if(document.f1.elements[i].type == \"checkbox\")
					      {
					         document.f1.elements[i].checked=0;
						  }
						tamanhoVetor=0;
					}
				</script>
				");
				devolveNavegacao($index, "index.php?modulo=servicos&acao=servicos", $where, $mark, "servicos", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left'>&nbsp;Avaliações</th>
						</tr>
						<tr>
							<td>
								Nenhum registro de avaliações para serviços.
							</td>
						</tr>
					</table>
				");
			}

		}
		else
			print("<center><strong>Erro na exibiçao!</strong></center>");
	}
}
function removeAvaliacao($mensagens)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		if(sizeof($mensagens)>0)
		{
			while(list($chave,$linhaArray) = each($mensagens))
			{
				$comando = "UPDATE avaliacao SET deletado='1' WHERE id='$linhaArray'";
				$dados = mysql_db_query($bancoDados, $comando);
				if(!$dados)	return false;
			}
			return true;
		}
	}
	return false;
}
function validaAvaliacao($mensagens)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		if(sizeof($mensagens)>0)
		{
			while(list($chave,$linhaArray) = each($mensagens))
			{
				$comando = "UPDATE avaliacao SET status='1' WHERE id='$linhaArray'";
				$dados = mysql_db_query($bancoDados, $comando);
				if(!$dados)	return false;
			}
			return true;
		}
	}
	return false;
}
?>