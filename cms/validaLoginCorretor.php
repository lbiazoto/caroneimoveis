<?php
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT");
header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0",false);
header("Pragma: no-cache");

include("util.php");
include("config.php");
if (!conectaBancoDados())
	print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
else
{
	$retorno=0;
	$comandoSql = "SELECT * FROM corretor WHERE usuario = '$login' AND deletado=0";
	if ($dados = mysql_db_query($bancoDados, $comandoSql))
	{
		if(mysql_num_rows($dados)==0)
		{
			$retorno=1;
		}
		else
		{
			if($linha = mysql_fetch_array($dados))
			{
				$retorno=0;
			}
		}
	}
	print($retorno);
}
?>