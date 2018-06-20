<?php
function adicionaCorretor($nome, $telefone, $email, $empresa, $nomeLogin, $nomeSenha)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		/*
		$comandoSql = "SELECT * FROM corretor WHERE usuario = '$nomeLogin' AND deletado=0";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if ($linha = mysql_fetch_array($dados))
			{
				return false;
			}
			else
			{
				*/
				$comando = "INSERT INTO corretor(nome, telefone, empresa, usuario, senha, email, dataCadastro, idUsuarioCadastro)
										VALUES('$nome', '$telefone', '$empresa', '$nomeLogin', '$nomeSenha', '$email', now(), '$_SESSION[idUsuario]')";
				debug($comando);
				$dados = mysql_db_query($bancoDados, $comando);
				if($dados)	return true;
		/*
			}
		}
		*/
	}
	return false;
}
function atualizaCorretor($id, $nome, $nomeLogin, $nomeSenha, $email, $telefone, $empresa)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		if($nomeLogin!="" && $nomeSenha!="")
		{
			$comandoSql = "SELECT COUNT(*) as contador FROM corretor WHERE usuario = '$nomeLogin' AND id != '$id'";
			$dados = mysql_db_query($bancoDados, $comandoSql);
			$linha = mysql_fetch_array($dados);
			if ($linha[contador]==0)
			{
				$comando = "UPDATE corretor SET nome='$nome', telefone='$telefone', empresa='$empresa', usuario='$nomeLogin', senha='$nomeSenha', email='$email', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$id'";
				debug($comando);
				$dados = mysql_db_query($bancoDados, $comando);
				if ($dados)
				{
					return true;
				}
			}
		}
		else
		{
			$comando = "UPDATE corretor SET nome='$nome', email='$email', telefone='$telefone', empresa='$empresa', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$id'";
			debug($comando);
			$dados = mysql_db_query($bancoDados, $comando);
			if ($dados)
			{
				return true;
			}
		}
	}
	return false;
}
function removeCorretor($id)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE corretor SET deletado='1', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$id'";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
function devolveListaCorretores($tipo, $index, $mark, $where, $oder, $titulo, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else {
		$comandoSql = "SELECT *, DATE_FORMAT(dataCadastro, '%d/%m/%Y') as dataCadastro FROM corretor $where LIMIT $index,25 ";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				print("<div align='right'>Registros: ($numero encontrados)</div>");
				devolveNavegacao($index, "index.php?modulo=corretores&acao=corretores&tipo=listar", $where, $mark, "corretor", $post);
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='30%'>Nome</th>
							<th align='left' width='25%'>Telefone</th>
							<th align='left' width='25%'>E-mail</th>
							<th colspan='3'>&nbsp;</th>
						</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					print("
						<tr>
							<td title='$linha[dataCadastro]'><a href='index.php?modulo=corretores&acao=corretorinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[dataCadastro]</a></td>
							<td title='$linha[nome]'><a href='index.php?modulo=corretores&acao=corretorinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[nome]</a></td>
							<td title='$linha[telefone]'><a href='index.php?modulo=corretores&acao=corretorinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[telefone]</a></td>
							<td title='$linha[email]'><a href='index.php?modulo=corretores&acao=corretorinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[email]</a></td>
							<td width='24'><a href='index.php?modulo=corretores&acao=corretorinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=corretores&acao=corretorinfo&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=corretores&acao=corretores&tipo=listar&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=corretores&acao=corretores&tipo=listar", $where, $mark, "corretor", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='30%'>Nome</th>
							<th align='left' width='25%'>Telefone</th>
							<th align='left' width='25%'>E-mail</th>
							<th colspan='3'>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='6'>
								Nenhum registro de corretores cadastrados.
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
?>