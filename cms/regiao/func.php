<?php

function cadastraCidade($nome, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "INSERT INTO cidades(nome, idUsuarioCadastro, dataCadastro) VALUES('$nome', '$login', now())";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return mysql_insert_id();
		}
	}
	return false;
}

function montaSelectCidades($nomeCombo, $idCidade, $filtroPesquisa)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM cidades WHERE deletado='0' ORDER BY nome ASC";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if(mysql_num_rows($dados) == 0)
			{
				print("Nenhuma cidade cadastrada.");
			}else
			{
				if($filtroPesquisa)	$filtroPesquisa="<option value='' selected>Todas</option>";
				print("
					<select name='$nomeCombo' id='$nomeCombo' onfocus=\"validaSelect(this, 'msgCidade');\">
					$filtroPesquisa
				");
				while ($linha = mysql_fetch_array($dados))
				{
					if($linha[id] == "$idCidade") $selected = "selected"; else $selected = "";
					print("<option value='$linha[id]' $selected>$linha[nome]</option>");
				}
				print("</select>");
			}
		}
	}
}

function cadastraRegiao($idCidade, $nome, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "INSERT INTO regiao(idCidade, nome, idUsuarioCadastro, dataCadastro) VALUES('$idCidade', '$nome', '$login', now())";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}

function devolveListaRegiao($tipo, $index, $mark, $where, $oder, $titulo, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT *, date_format(dataCadastro, '%d/%m/%Y') as dataCadastro FROM regiao $where LIMIT $index,25";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				devolveNavegacao($index, "index.php?modulo=regiao&acao=regiao&tipo=listar", $where, $mark, "regiao", $post);
				print("
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='15%'>Data de Cadastro</th>
						<th align='left' width='35%'>Regiao</th>
						<th align='left' width='35%'>Cidade</th>
						<th colspan='3'>&nbsp;</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					$cidade = devolveInfo("cidades", $linha[idCidade]);
					print("
						<tr>
							<td title='$linha[dataCadastro]'><a href='index.php?modulo=regiao&acao=regiaoinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[dataCadastro]</a></td>
							<td title='$linha[nome]'><a href='index.php?modulo=regiao&acao=regiaoinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[nome]</a></td>
							<td title='$cidade[nome]'><a href='index.php?modulo=regiao&acao=regiaoinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$cidade[nome]</a></td>
							<td width='24'><a href='index.php?modulo=regiao&acao=regiaoinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=regiao&acao=regiaoinfo&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=regiao&acao=regiao&tipo=listar&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=regiao&acao=regiao&tipo=listar", $where, $mark, "regiao", $post);
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
								Nenhum registro de regiao cadastrados.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibiçao dos regiao!</strong></center>");
	}
}

function editaRegiao($idCidade, $nome, $codigo, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE regiao SET idCidade='$idCidade', nome='$nome', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$codigo'";
		$dados = mysql_db_query($bancoDados, $comando);
		debug($comando);
		if ($dados)	return true;
	}
	return false;
}
function remove($id, $idUsuario)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$idUsuario=devolveIdUsuario($login);
		$comando = "UPDATE regiao SET deletado='1', idUsuarioAtualizacao='$idUsuario', dataAtualizacao=now() WHERE id='$id'";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
?>