<?php
function adicionaUsuario($nome, $nomeLogin, $nomeSenha, $email, $idModuloInicial, $modulos, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM usuario WHERE usuario = '$nomeLogin'";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if ($linha = mysql_fetch_array($dados))
			{
				return false;
			}
			else
			{
				$idUsuario=devolveIdUsuario($login);
				$comando = "INSERT INTO usuario(nome, usuario, senha, email, moduloInicial, dataCadastro, idUsuarioCadastro)
										VALUES('$nome', '$nomeLogin', '$nomeSenha', '$email', '$idModuloInicial', now(), '$idUsuario')";
				$dados = mysql_db_query($bancoDados, $comando);
				$idUsuarioNovo=mysql_insert_id();
				if ($dados)
				{
					while(list($chave,$linhaArray) = each($modulos))
					{
						$comando2 = "INSERT INTO permissoes(idUsuario, idModulo)	VALUES ('$idUsuarioNovo', '$linhaArray')";
						$dados2 = mysql_db_query($bancoDados, $comando2);
						if(!$dados2)	return false;
					}
					return true;
				}
			}
		}
	}
	return false;
}
function atualizaUsuario($id, $nome, $nomeLogin, $nomeSenha, $email, $idModuloInicial, $modulos, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		if($nomeLogin!="" && $nomeSenha!="")
		{
			$comandoSql = "SELECT COUNT(*) as contador FROM usuario WHERE usuario = '$nomeLogin' AND id != '$id'";
			$dados = mysql_db_query($bancoDados, $comandoSql);
			$linha = mysql_fetch_array($dados);
			if ($linha[contador]==0)
			{
				$idUsuario=devolveIdUsuario($login);
				$dataNascimento=converteDataToMysql($dataNascimento);
				$comando = "UPDATE usuario SET nome='$nome', usuario='$nomeLogin', senha='$nomeSenha', email='$email', idUsuarioAtualizacao='$idUsuario', moduloInicial='$idModuloInicial', dataAtualizacao=now() WHERE id='$id'";
				$dados = mysql_db_query($bancoDados, $comando);
				if ($dados)
				{
					$comando2 = "DELETE FROM permissoes WHERE idUsuario='$id'";
					$dados2 = mysql_db_query($bancoDados, $comando2);
					while(list($chave,$linhaArray) = each($modulos))
					{
						$comando2 = "INSERT INTO permissoes(idUsuario, idModulo)	VALUES ('$id', '$linhaArray')";
						$dados2 = mysql_db_query($bancoDados, $comando2);
						if(!$dados2)	return false;
					}
					return true;
				}
			}
		}
		else
		{
			$idUsuario=devolveIdUsuario($login);
			$dataNascimento=converteDataToMysql($dataNascimento);
			$comando = "UPDATE usuario SET nome='$nome', email='$email', idUsuarioAtualizacao='$idUsuario', moduloInicial='$idModuloInicial', dataAtualizacao=now() WHERE id='$id'";
			debug($comando);
			$dados = mysql_db_query($bancoDados, $comando);
			if ($dados)
			{
				$comando2 = "DELETE FROM permissoes WHERE idUsuario='$id'";
				$dados2 = mysql_db_query($bancoDados, $comando2);
				while(list($chave,$linhaArray) = each($modulos))
				{
					$comando2 = "INSERT INTO permissoes(idUsuario, idModulo)	VALUES ('$id', '$linhaArray')";
					$dados2 = mysql_db_query($bancoDados, $comando2);
					if(!$dados2)	return false;
				}
				return true;
			}
		}
	}
	return false;
}
function removeUsuario($id, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$idUsuario=devolveIdUsuario($login);
		$comando = "UPDATE usuario SET deletado='1', idUsuarioAtualizacao='$idUsuario', dataAtualizacao=now() WHERE id='$id'";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
function devolveListaUsuarios($tipo, $index, $mark, $where, $oder, $titulo, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else {
		$comandoSql = "SELECT *, DATE_FORMAT(dataCadastro, '%d/%m/%Y') as dataCadastro FROM usuario $where LIMIT $index,25 ";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				print("<div align='right'>Registros: ($numero encontrados)</div>");
				devolveNavegacao($index, "index.php?modulo=usuarios&acao=usuarios&tipo=listar", $where, $mark, "usuario", $post);
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='35%'>Nome</th>
							<th align='left' width='35%'>E-mail</th>
							<th colspan='3'>&nbsp;</th>
						</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					print("
						<tr>
							<td title='$linha[dataCadastro]'><a href='index.php?modulo=usuarios&acao=usuarioinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[dataCadastro]</a></td>
							<td title='$linha[nome]'><a href='index.php?modulo=usuarios&acao=usuarioinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[nome]</a></td>
							<td title='$linha[email]'><a href='index.php?modulo=usuarios&acao=usuarioinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[email]</a></td>
							<td width='24'><a href='index.php?modulo=usuarios&acao=usuarioinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=usuarios&acao=usuarioinfo&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=usuarios&acao=usuarios&tipo=listar&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=usuarios&acao=usuarios&tipo=listar", $where, $mark, "usuario", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='35%'>Nome</th>
							<th align='left' width='35%'>E-mail</th>
							<th colspan='3'>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='6'>
								Nenhum registro de usuários cadastrados.
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
function mudarSenha($id, $senhaAntiga, $senhaNova)
{
	include("config.php");
	if(!conectaBancoDados()) {
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comando = "SELECT id, senha FROM usuario WHERE id=$id AND senha='$senhaAntiga'";
		$dadosA = mysql_db_query($bancoDados, $comando);
		if($dadosA)
        {
			if($linha=mysql_fetch_array($dadosA))
			{
				$comandoB = "UPDATE usuario SET senha='$senhaNova' WHERE id= $id";
				$dadosB = mysql_db_query($bancoDados, $comandoB);
				if ($dadosB)
				{
					return true;
				}
				else
					return false;
			}
			else
				return false;
		}
		else
			return false;
	}
}
function montaCheckboxesModulos($formulario)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM modulos ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			$num=mysql_num_rows($dados);
			print("
				<script language='javascript'>
					var tamanhoVetor=0;
				</script>
				<table align='left' cellpadding='0' cellspacing='0' border='0'>
					");
					$cont=1;
					$idCheck="";
					while($linha = mysql_fetch_array($dados))
					{
						if($cont==1)
						{
							$idCheck = "id='primeiroCheck'";
							$cont++;
						}
						print("
							<tr>
								<td align='left' style='padding-bottom:3px;'>
									<input $idCheck style='width:50px;' type='checkbox' name='modulos[]' value='$linha[id]'
										onclick=\"if(this.checked){tamanhoVetor++;}else{tamanhoVetor--;} validaPermissoes(tamanhoVetor);\"
										onfocus=\"validaPermissoes(tamanhoVetor);\"
										> $linha[fantasia]
								</td>
							</tr>
						");
					}
					print("
				</table>
			");
		}
	}
}
function montaCheckboxesModulosEdicao($formulario, $vetorModulos)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM modulos ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			$num=mysql_num_rows($dados);
			print("
				<script language='javascript'>
					var tamanhoVetor=0;
				</script>
				<table width='100%' cellpadding='0' cellspacing='0' border='0'>
					");
					$cont=0;
					while($linha = mysql_fetch_array($dados))
					{
						if($vetorModulos[$linha[id]])
						{
							$checked="checked";
							$cont++;
						}
						else
						{
							$checked="";
						}
						print("
							<tr>
								<td align='left' style='padding-bottom:3px;'>
									<input type='checkbox' name='modulos[]' value='$linha[id]'
										onclick=\"if(this.checked){tamanhoVetor++;}else{tamanhoVetor--;} validaPermissoes(tamanhoVetor);\"
										onfocus=\"validaPermissoes(tamanhoVetor);\"
										$checked> $linha[fantasia]
								</td>
							</tr>
						");
					}
					print("
				</table>
				<script language='javascript'>
					var tamanhoVetor=$cont;
				</script>
			");
		}
	}
}
function devolveModulosPermitidos($usuario)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM modulos modu INNER JOIN permissoes per ON modu.id=per.idModulo WHERE per.idUsuario=$usuario ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			$num=mysql_num_rows($dados);
			print("
				<table width='100%' cellpadding='0' cellspacing='0' border='0'>
					");
					while($linha = mysql_fetch_array($dados))
					{
						print("<tr><td align='left' style='border:none;'>$linha[fantasia]</td></tr>");
					}
					print("
				</table>
			");
		}
	}
}
function devolveVetorModulosPermitidos($usuario)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM modulos modu INNER JOIN permissoes per ON modu.id=per.idModulo WHERE per.idUsuario=$usuario ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			$vetor="";
			while($linha = mysql_fetch_array($dados))
			{
				$vetor[$linha[idModulo]]=1;
			}
			return $vetor;
		}
	}
	return false;
}
function montaSelectModulos($nomeCombo, $idModulo, $branco, $todos)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM modulos ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if(mysql_num_rows($dados) == 0)
			{
				print("Nenhum campo disponível para este módulo");
			}else
			{
				print("<select name='$nomeCombo' id='$nomeCombo' onfocus='validaModulos(this);'>");
				if($branco)
					print("<option value='-1'>&nbsp;</option>");
				if($todos)
					print("<option value='0'>Todos</option>");
				while ($linha = mysql_fetch_array($dados))
				{
					if($linha[id] == "$idModulo") $selected = "selected"; else $selected = "";
					print("<option value='$linha[id]' $selected>$linha[fantasia]</option>");
				}
				print("</select>");
			}
		}
	}
}
?>