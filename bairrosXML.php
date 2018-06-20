<?php
	include("cms/config.php");
	$codigo = $_POST['codigo'];
	if (@mysql_connect($servidor, $usuarioBd, $senhaBd)) {
		$comando = "SELECT * FROM bairros WHERE idRegiao=$codigo AND deletado=0 ORDER BY nome ASC";
		$dados = mysql_db_query($bancoDados, $comando);
		if($dados && mysql_num_rows($dados)>0)
		{
			//XML
		   	$xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
		   	$xml .= "<bairros>\n";
		   	while($linha = mysql_fetch_array($dados)){
		      	$xml .= "<bairro>\n";
		      	$xml .= "<codigo>".$linha['id']."</codigo>\n";
		      	$xml .= "<nome>".$linha['nome']."</nome>\n";
		      	$xml .= "</bairro>\n";
			}
			$xml.= "</bairros>\n";
		}
		else
		{
			$xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
		   	$xml .= "<bairros>\n";
	      	$xml .= "<bairro>\n";
	      	$xml .= "<codigo>0</codigo>\n";
	      	$xml .= "<nome>Nenhum bairro para para esta região.</nome>\n";
	      	$xml .= "</bairro>\n";
			$xml.= "</bairros>\n";
		}
		//CABEÇALHO
		Header("Content-type: application/xml; charset=iso-8859-1");
	}
	//PRINTA O RESULTADO
	echo $xml;
?>