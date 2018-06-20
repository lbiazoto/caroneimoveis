<?php
	include("cms/config.php");
	//$codigo = $_POST['codigo'];
	if (@mysql_connect($servidor, $usuarioBd, $senhaBd)) {
		$comando = "SELECT * FROM subcategorias WHERE idCategoria=$codigo AND deletado=0 ORDER BY nome ASC";
		//echo $comando;
		$dados = mysql_db_query($bancoDados, $comando);
		if($dados && mysql_num_rows($dados)>0)
		{
			//XML
		   	$xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
		   	$xml .= "<subCategorias>\n";
		   	while($linha = mysql_fetch_array($dados)){
		      	$xml .= "<subCategoria>\n";
		      	$xml .= "<codigo>".$linha['id']."</codigo>\n";
		      	$xml .= "<nome>".$linha['nome']."</nome>\n";
		      	$xml .= "</subCategoria>\n";
			}
			$xml.= "</subCategorias>\n";
		}
		/*
		else
		{
			$xml  = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
		   	$xml .= "<subCategorias>\n";
	      	$xml .= "<subCategoria>\n";
	      	$xml .= "<codigo>0</codigo>\n";
	      	$xml .= "<nome>Nenhuma sub categoria para para esta categoria.</nome>\n";
	      	$xml .= "</subCategoria>\n";
			$xml.= "</subCategorias>\n";
		}
		*/
		//CABEÇALHO
		Header("Content-type: application/xml; charset=iso-8859-1");
	}
	//PRINTA O RESULTADO
	echo $xml;
?>