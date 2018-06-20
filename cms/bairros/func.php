<?php

function cadastraRegiao($nome, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "INSERT INTO regiao(nome, idUsuarioCadastro, dataCadastro) VALUES('$nome', '$login', now())";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return mysql_insert_id();
		}
	}
	return false;
}

function montaSelectRegioes($nomeCombo, $idRegiao, $filtroPesquisa)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM regiao WHERE deletado='0' ORDER BY idCidade ASC";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if(mysql_num_rows($dados) == 0)
			{
				print("Nenhuma regi�o cadastrada.");
			}else
			{
				if($filtroPesquisa)	$filtroPesquisa=" <option value='' selected>Todas</option> ";
				print("
					<select name='$nomeCombo' id='$nomeCombo' onfocus=\"validaSelect(this, 'msgRegiao');\">
					$filtroPesquisa
				");
				while ($linha = mysql_fetch_array($dados))
				{
					$cidade=devolveInfo("cidades", $linha['idCidade']);
					if($linha[id] == "$idRegiao") $selected = "selected"; else $selected = "";
					print("<option value='$linha[id]' $selected>$cidade[nome] / $linha[nome]</option>");
				}
				print("</select>");
			}
		}
	}
}

function cadastraBairro($idRegiao, $nome, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "INSERT INTO bairros(idRegiao, nome, idUsuarioCadastro, dataCadastro) VALUES('$idRegiao', '$nome', '$login', now())";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}

function devolveListaBairros($tipo, $index, $mark, $where, $oder, $titulo, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT *, date_format(dataCadastro, '%d/%m/%Y') as dataCadastro FROM bairros $where LIMIT $index,25";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				devolveNavegacao($index, "index.php?modulo=bairros&acao=bairros&tipo=listar", $where, $mark, "bairros", $post);
				print("
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='15%'>Data de Cadastro</th>
						<th align='left' width='35%'>Bairro</th>
						<th align='left' width='35%'>Cidade / Regiao</th>
						<th colspan='3'>&nbsp;</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					$regiao=devolveInfo("regiao", $linha['idRegiao']);
					$cidade=devolveInfo("cidades", $regiao['idCidade']);
					print("
						<tr>
							<td title='$linha[dataCadastro]'><a href='index.php?modulo=bairros&acao=bairroinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[dataCadastro]</a></td>
							<td title='$linha[nome]'><a href='index.php?modulo=bairros&acao=bairroinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[nome]</a></td>
							<td title='$regiao[nome]'><a href='index.php?modulo=bairros&acao=bairroinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$cidade[nome] / $regiao[nome]</a></td>
							<td width='24'><a href='index.php?modulo=bairros&acao=bairroinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=bairros&acao=bairroinfo&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=bairros&acao=bairros&tipo=listar&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=bairros&acao=bairros&tipo=listar", $where, $mark, "bairros", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='35%'>Bairro</th>
							<th align='left' width='35%'>Cidade / Regiao</th>
							<th colspan='2'>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='5'>
								Nenhum registro de bairros cadastrados.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibi�ao dos bairros!</strong></center>");
	}
}

function editaBairro($idRegiao, $nome, $codigo, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE bairros SET idRegiao='$idRegiao', nome='$nome', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$codigo'";
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
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$idUsuario=devolveIdUsuario($login);
		$comando = "UPDATE bairros SET deletado='1', idUsuarioAtualizacao='$idUsuario', dataAtualizacao=now() WHERE id='$id'";
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