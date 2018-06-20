<?php
include("config.php");
include("funcoes.php");
include("util.php");
include("lang/br.php");
session_start(); // Inicia ou continua uma sesao.

if($acao == "lembrarSenha")
{
	$retornoSenha=recuperarSenha($usuario, $email);
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
	<a href="login.php"><img class="admin_login_icon" src="imagens/logo.gif" border="0"></a>
	<div class="admin_login_form_wrapper">
    	<form class="admin_login_form" id="form1" name="form1" method="post" action="lembrarSenha.php?acao=lembrarSenha">
            <table cellspacing="20" cellpadding="0" class="admin_login_table">
                <tr>
                    <td class="value">Usu&aacute;rio:</td>
                    <td><input type="text" name="usuario" id="admin_username"></td>
                </tr>
                <tr>
                    <td class="value">Email:</td>
                    <td><input type="text" name="email" id="admin_password"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
						<input type="submit" id="admin_login_form_submit" value="enviar" onclick="return (campoObrigatorioLembrarSenha(admin_username,admin_password))" style="font-size:10px; float:left;">
						<input type="button" id="admin_login_form_submit" value="voltar" onclick="window.location='login.php';" style="font-size:10px; float:right;">
					</td>
                </tr>
                <tr><td colspan="2" style="font-size:12px;"><?php print($retornoSenha[1]);?></td></tr>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
	document.form1.usuario.focus();
	function campoObrigatorioLembrarSenha(id1,id2)
	{
		if(id1.value == "" && id2.value=="")
		{
			alert("É necessário preencher usuário ou email para recuperar a senha!");
			id1.focus();
			return false;
		}
		if(id2.value!="")
		{
			return validaEmail(id2);
		}
		return true;
	}
</script>
</body>
</html>
