<?php
function validaAdmin($login, $senha)
{
	include("config.php");
	if(!conectaBancoDados()) {
		print("<center><strong>Não foi possível estabelecer conexão com o Banco de Dados!</strong></center>");
	}
	else
	{
		$retorno[0]=false;
		$retorno[1]="";
		$comandoSql = "SELECT * FROM usuario WHERE usuario = '$login' AND deletado=0";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
        {
			if($linha = mysql_fetch_array($dados))
			{
				if($linha[senha] == $senha)
				{
					$ip = $_SERVER['REMOTE_ADDR'];
					$sql = "INSERT INTO ultimoacesso(idLogin, data, ip) VALUES('$linha[id]', now(), '$ip')";
					mysql_db_query($bancoDados, $sql);
					// carrega as variáveis session quando o usuário efetua login
					$_SESSION['sessaoLogin'] = true;
					$_SESSION['login'] = $login;
					$_SESSION['idUsuario'] = $linha[id];

					$_SESSION[ID_ACESSO] = md5($_SESSION['login'].date("d/m/Y H:i:s"));
					$_SESSION[$_SESSION[ID_ACESSO]] = true;

					if($minutosExpirarSessao=="0")
						$_SESSION['horaExpiracao']=0;
					else
						$_SESSION['horaExpiracao']=time()+($minutosExpirarSessao*60); // 15min*60seg=900seg

					if($linha[id]==-1)
					{
						// usuario -1 tem todas as permissões pois é o admin
						$comando2 = "SELECT * FROM modulos";
						$dados2 = mysql_db_query($bancoDados, $comando2);
						if ($dados2)
						{
							while($linha2 = mysql_fetch_array($dados2))
							{
								$_SESSION[$linha2[nome]] = 1;
							}
						}
					}
					else
					{
						$comando2 = "SELECT modu.nome as nomeModulo FROM permissoes per INNER JOIN modulos modu ON per.idModulo=modu.id WHERE per.deletado=0";
						$dados2 = mysql_db_query($bancoDados, $comando2);
						if ($dados2)
						{
							while($linha2 = mysql_fetch_array($dados2))
							{	// carrega as permissões
								$_SESSION[$linha2[nomeModulo]] = 1;
							}
						}
					}
					$retorno[0]=true;
					$retorno[1]="Bem vindo!";
				}
				else
				{
					$retorno[0]=false;
					$retorno[1]="Senha incorreta";
				}
			}
			else
			{
				$retorno[0]=false;
				$retorno[1]="Usuário não encontrado";
			}
		}
		else
		{
			$retorno[0]=false;
			$retorno[1]="Falha na comunicação de dados";
		}
	}
	return $retorno;
}
function devolveModulo($login)
{
	include("config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}else
	{
		$comandoSql = "SELECT moduloInicial FROM usuario WHERE id = $login";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				return devolveModuloSelecionadoNome($linha[moduloInicial]);
			}
		}
	}
	return 0;
}
function devolveModuloInicial($idUsuario)
{
	include("config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}else
	{
		$comandoSql = "SELECT usu.moduloInicial as idModulo, modu.nome as nomeModulo FROM usuario usu, modulos modu WHERE usu.id = $idUsuario AND usu.moduloInicial=modu.id";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				$retorno[0]=$linha[nomeModulo];
				$retorno[1]=$linha[idModulo];
				return $retorno;
			}
		}
	}
	return 0;
}
function devolveAcaoInicial($idModulo)
{
	include("config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}else
	{
		$comandoSql = "SELECT acao, tipo FROM menu WHERE idModulo = $idModulo ORDER BY ordem ASC LIMIT 1";
		//print("ahhh: ".$comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				$retorno = "$linha[acao]&tipo=$linha[tipo]";
				return $retorno;
			}
		}
	}
	return 0;
}
function devolveIdUsuario($login)
{
	include("./config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}else
	{
		$comandoSql = "SELECT id FROM usuario WHERE usuario = '$login'";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				return $linha[id];
			}
		}
	}
	return 0;
}
function devolveModuloSelecionadoNome($id)
{
	include("config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}else
	{
		$comandoSql = "SELECT nome FROM modulos WHERE id = $id";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				return $linha[nome];
			}
		}
	}
	return 0;
}
function recuperarSenha($usuario, $email)
{
	include("config.php");
	if (!conectaBancoDados()) {
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		$retorno[0]=false;
		$retorno[1]= "Erro ao recuperar senha. Por favor, entre em contato conosco.";
		if($usuario!="")
		{
			$filtroUsuario=" AND usuario='$usuario' ";
			$erroUsuario="<b>Usuário:</b> $usuario";
		}
		if($email!="")
		{
			$filtroEmail=" AND email='$email' ";
			$erroEmail="<b>E-mail:</b> $email";
		}
		$comandoSql = "SELECT * FROM usuario WHERE deletado=0 $filtroUsuario $filtroEmail";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				$texto = "Olá $linha[nome],\nSeguem seus dados:\nE-mail: $linha[email]\nUsuário: $linha[usuario]\nSenha: $linha[senha]\nAtt.,\nBetaG Sistemas.";
				$from = "From: betag@betag.com.br (BetaG Sistemas)";
				mail("$linha[email] ($linha[nome])","BetaG Sistemas - Recuperação de Senha",$texto, $from);
				$retorno[0]=false;
				$retorno[1]= "Seus dados foram enviados para <b>$linha[email]</b>.";
			}
			else
			{
				$retorno[0]=false;
				$retorno[1]= "Usuário não encontrado para:$erroUsuario $erroEmail";
			}
		}
	}
	return $retorno;
}
?>