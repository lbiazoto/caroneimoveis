<?php
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
function atualizaUsuario($id, $nome, $nomeLogin, $nomeSenha, $email, $idModuloInicial, $login)
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
				return true;
			}
		}
	}
	return false;
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
					var tamanhoVetor=$num;
				</script>
				<table width='100%' cellpadding='0' cellspacing='0' border='0'>
					");
					while($linha = mysql_fetch_array($dados))
					{
						if($vetorModulos[$linha[id]])
							$checked="checked";
						else
							$checked="";
						print("
							<tr>
								<td align='left' style='padding-bottom:3px;'>
									<input type='checkbox' name='modulos[]' value='$linha[id]'
										onclick=\"if(this.checked){tamanhoVetor++;}else{tamanhoVetor--;} validaPermissoes(tamanhoVetor);\"
										onfocus=\"validaPermissoes(tamanhoVetor);\"
										onblur=\"validaPermissoesOnBlur(tamanhoVetor);\" $checked> $linha[fantasia]
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
function devolveModulosPermitidos($usuario)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		if($usuario!="-1")
			$comandoSql = "SELECT * FROM modulos modu INNER JOIN permissoes per ON modu.id=per.idModulo WHERE per.idUsuario=$usuario ORDER BY nome ASC";
		else
			$comandoSql = "SELECT * FROM modulos modu ORDER BY nome ASC";
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
		if($usuario!="-1")
			$comandoSql = "SELECT * FROM modulos modu INNER JOIN permissoes per ON modu.id=per.idModulo WHERE per.idUsuario=$usuario ORDER BY nome ASC";
		else
			$comandoSql = "SELECT * FROM modulos ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			$vetor="";
			while($linha = mysql_fetch_array($dados))
			{
				$vetor[$linha[id]]=1;
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
		$usuario=$_SESSION['idUsuario'];
		if($usuario!="-1")
			$comandoSql = "SELECT modu.id as idModulo, modu.fantasia as fantasia FROM modulos modu INNER JOIN permissoes per ON modu.id=per.idModulo WHERE per.idUsuario=$usuario ORDER BY modu.nome ASC";
		else
			$comandoSql = "SELECT modu.id as idModulo, modu.fantasia as fantasia FROM modulos modu ORDER BY modu.nome ASC";
		debug($comandoSql);
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
					if($linha[idModulo] == "$idModulo") $selected = "selected"; else $selected = "";
					print("<option value='$linha[idModulo]' $selected>$linha[fantasia]</option>");
				}
				print("</select>");
			}
		}
	}
}
?>