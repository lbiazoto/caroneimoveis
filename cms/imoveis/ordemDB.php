<?php
if ($action == "alterarOrdem"){
	include("../config.php");
	include("../util.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi poss�vel estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		for($i=0; $i<count($imgOrd); $i++){
			$sql = "UPDATE galeriafotos SET ordem='$i' WHERE id=$imgOrd[$i]";
			$dados = mysql_db_query($bancoDados, $sql);
		}
	}
}
?>