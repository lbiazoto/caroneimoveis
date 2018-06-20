<?php
function cadastraCategoria($nome, $cor, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "INSERT INTO categorias(nome, cor, idUsuarioCadastro, dataCadastro) VALUES('$nome', '$cor', '$login', now())";
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
		$comandoSql = "SELECT id, date_format(dataCadastro, '%d/%m/%Y') as dataCadastro, nome, cor FROM categorias $where LIMIT $index,25";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				print("<div align='right'>Registros: ($numero encontrados)</div>");
				devolveNavegacao($index, "index.php?modulo=categorias&acao=categorias&tipo=listar", $where, $mark, "categorias", $post);
				print("
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='20%'>Data de Cadastro</th>
						<th align='left' width='45%'>Nome</th>
							<th align='left' width='20%'>Cor</th>
						<th colspan='3'>&nbsp;</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					print("
						<tr>
							<td title='$linha[dataCadastro]'><a href='index.php?modulo=categorias&acao=categoriainfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[dataCadastro]</a></td>
							<td title='$linha[nome]'><a href='index.php?modulo=categorias&acao=categoriainfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[nome]</a></td>
							<td style='background-color:$linha[cor]'>&nbsp;$linha[cor]</td>
							<td width='24'><a href='index.php?modulo=categorias&acao=categoriainfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=categorias&acao=categoriainfo&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=categorias&acao=categorias&tipo=listar&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=categorias&acao=categorias&tipo=listar", $where, $mark, "categorias", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='45%'>Nome</th>
							<th align='left' width='20%'>Cor</th>
							<th colspan='2'>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='5'>
								Nenhum registro de categorias cadastrados.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibiçao dos categorias!</strong></center>");
	}
}

function editaCategoria($nome, $cor, $codigo, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE categorias SET nome='$nome', cor='$cor', idUsuarioAtualizacao='$login', dataAtualizacao=now() WHERE id='$codigo'";
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
		$comando = "UPDATE categorias SET deletado='1', idUsuarioAtualizacao='$idUsuario', dataAtualizacao=now() WHERE id='$id'";
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