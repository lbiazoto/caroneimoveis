<?php
include("config.php");
include("funcoes.php");
include("util.php");
include("lang/br.php");
session_start(); // Inicia ou continua uma sesao.

if($acao == "login")
{
	$retornoLogin=validaAdmin($usuario, $senha);
	if ($retornoLogin[0])
	{
		if($siteref=="")
		{
			$mod = devolveModuloInicial($_SESSION['idUsuario']);
			$acao = devolveAcaoInicial($mod[1]);
			$headerGo = "Location:index.php?modulo=$mod[0]&acao=$acao";
		}
		else
		{
			$headerGo = "Location:$siteref&acao=$acao2&tipo=$tipo";
		}

	}
}

if($aviso=="sessaoExpirou")
	$erro="Sessão expirou, faça login novamente";

if($headerGo != "")
{
	header("$headerGo");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>CMS <?php print($nomeEmpresa);?> - BetaG Sistemas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/login.css">
<script type="text/javascript" src="js/util.js"></script>
</head>
<body>
<div class="admin_login_wrapper">
	<img class="admin_login_icon" src="imagens/logo_cli.png" />
	<div class="admin_login_form_wrapper">
    	<form class="admin_login_form" id="form1" name="form1" method="post" action="login.php?acao=login<?php if(($acao != "" || $modulo != "") && ($erro=="" || $erro=="Sessão expirou, faça login novamente")) echo "&siteref=$siteref&acao2=$acao&tipo=$tipo";?>">
            <table cellspacing="20" cellpadding="0" class="admin_login_table">
                <tr>
                    <td class="value">Usu&aacute;rio:</td>
                    <td><input type="text" name="usuario" id="admin_username"></td>
                </tr>
                <tr>
                    <td class="value">Senha:</td>
                    <td><input type="password" name="senha" id="admin_password"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
						<input type="submit" id="admin_login_form_submit" value="entrar" onclick="return (campoObrigatorio(usuario) && campoObrigatorio(senha));" style="font-size:10px; float:left;">

						<input type="button" id="admin_login_form_submit" value="lembrar senha" onclick="window.location='lembrarSenha.php';" style="font-size:10px; float:right;">
					</td>
                </tr>
                <tr><td colspan="2"><?php print($retornoLogin[1]);?></td></tr>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
	document.form1.usuario.focus();
</script>
</body>
</html>
