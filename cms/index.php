<?php

foreach ($_REQUEST as $nome_campo => $valor_campo)
	{
		if($_GET[$nome_campo])
    		$$nome_campo = $_GET[$nome_campo];
    	elseif($_POST[$nome_campo])
			$$nome_campo = $_POST[$nome_campo];
	}

include("util.php");
include("funcoes.php");
include("config.php");
include("layout.php");
include("lang/br.php");
session_start();

$_SESSION[debugMsg] = "";

if($acao == "logout" || $acao=="")
{
	session_unset();
	session_destroy();
	$headerGo = "Location:login.php";
}

if(devolveUsuarioLogado() && ($_SESSION['horaExpiracao']>time() || $_SESSION['horaExpiracao']==0))
{
	if($minutosExpirarSessao>0)
		$_SESSION['horaExpiracao']=time()+($minutosExpirarSessao*60); // XX min*60seg
}
else
{
	$expirou="";
	if($_SESSION['horaExpiracao']<time() && $_SESSION['horaExpiracao']>0)
		$expirou="&aviso=sessaoExpirou";
	$nova = $_SERVER['REQUEST_URI'];
	$nova = explode("/",$nova);
	$nova=$nova[2];
	if($acao != "" && $modulo != "")
	{
		$headerGo = "Location:login.php?siteref=$nova$expirou";
	}else
	{
		$headerGo = "Location:login.php?$expirou";
	}
}
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
	<link rel="stylesheet" type="text/css" href="css/default.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="highslide/highslide.css">
	<link rel="stylesheet" type="text/css" href="css/validation.css">
	<link rel="stylesheet" type="text/css" href="uploadify/uploadify.css">
	<link rel="stylesheet" type="text/css" media="all" href="cal/calendar-win2k-cold-1.css" title="win2k-cold-1" />
	<script type="text/javascript" src="js/mascaras.js"></script>
	<script type="text/javascript" src="js/util.js"></script>
	<script type="text/javascript" src="js/final.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="cal/calendar.js"></script>
	<script type="text/javascript" src="cal/lang/calendar-en.js"></script>
	<script type="text/javascript" src="cal/calendar-setup.js"></script>
	<script type="text/javascript" src="mce/tiny_mce.js"></script>
	<script type="text/javascript" src="highslide/highslide.js"></script>
	<script type="text/javascript" src="js/validation.js"></script>
	<script type="text/javascript" src="js/AC_RunActiveContent.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<!--
	<script type="text/javascript" src="js/clearbox.js"></script>
	-->
</head>
<body onload="Mascaras.carregar();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #CCC; padding:0px; margin:0px;">
	<tr>
    	<td class="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
      			<tr valign="middle" align="left">
        			<td width="10">&nbsp;
					</td>
					<td><a href="?acao=logout"><img src="imagens/logo_cli.png" border="0" title="Sair do Sistema"></a></td>
		        	<td width="300" align="center" class="boxUsuario" valign="top">
						<table width="250" align="center" border="0" cellspacing="5" cellpadding="3" height="70" style="margin-top:3px;">
							<tr>
								<td align="left">
									Login: <?php print($_SESSION['login']); ?>
								</td>
							</tr>
							<tr>
								<td align="left"><span id="relogio" class="relogio"></span></td>
								</td>
							</tr>
							<tr>
								<td align="left"><?devolveDataExtenso("Joinville");?></td>
							</tr>
						</table>
					</td>
					<td width="10">&nbsp;
					</td>
      			</tr>
    		</table>
		</td>
  	</tr>
  	<tr>
    	<td>
			<table width="100%"  border="0" cellspacing="3" cellpadding="0">
      			<tr valign="top">
					<td style="border:1px solid #CCC; padding:0px; margin:0px;">
						<table width="100%" class="tabela" border="0">
				   			<tr valign="top">
				   				<td align="center" width="200" valign="top">
				   					<?php devolveMenu($_SESSION['idUsuario'], $modulo); ?>
				   				</td>
				   				<td width="1%" style="border-left:1px solid #CCC;">&nbsp;</td>
								<td align="center" valign="top">
									<?php
										if($modulo == "")
											$barra = "";
										else
											$barra="/";
										if(file_exists($modulo."$barra".$acao.".php"))
										{
											include($modulo."$barra".$acao.".php");
										}else
										{
											print("<BR><BR><BR><BR><CENTER>O arquivo procurado não foi encontrado!</CENTER><BR><BR><BR><BR>");
										}
									?>
								</td>
				  			</tr>
				 		</table>
					</td>
		  		</tr>
			</table>
		</td>
	</tr>
	<tr>
    	<td class="bottom">
			BetaG Solu&ccedil;&otilde;es - Sistemas WEB - <a href="http://www.betag.com.br">www.betag.com.br </a>
		</td>
  	</tr>
</table>
<?php
	if($debugModeOn)
	{
	print("
		<BR><table border='1' cellspacing='0' cellpadding='5' align='center' width='100%' bgcolor='#FFFF99'>
			<tr>
				<td align='left'>
					<b>Módulo:</b> $modulo <b>Ação:</b> $acao <b>Tipo:</b> $tipo <BR><b>SQL:</b> $_SESSION[debugMsg]
				</td>
			</tr>
		</table><BR>
	");
	}
?>
</body>
</html>