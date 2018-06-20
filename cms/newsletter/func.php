<?php
function exportaEmail($dataInicio, $dataFim)
{
	include("config.php");
	if (!conectaBancoDados()){
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else {
		if(file_exists("../Newsletter/emails.txt"))
			fopen ("../Newsletter/emails.txt", "w+");
		$arquivo = "../Newsletter/emails.txt";
		$arquivo = str_replace(" ","",$arquivo);
		if(!$abrir = fopen($arquivo, "w+")){
			print("Erro na Exportação!");
	    }
		else
		{
			if($dataInicio!="")
			{
				$dataIni = converteDataToMysql($dataInicio);
				$where.=" AND dataCadastro>='$dataIni' ";
			}
			if($dataFim!="")
			{
				$dataF = converteDataToMysql($dataFim);
				$where.=" AND dataCadastro<='$dataF' ";
			}
			$comandoSql = "SELECT * FROM newsletter WHERE email!='' $where ORDER BY email";
			$dados = mysql_db_query($bancoDados, $comandoSql);
			if ($dados)
			{
				$numReg = mysql_num_rows($dados);
				while ($linha = mysql_fetch_array($dados))
				{
					$conteudo	=	"$linha[email];\r\n";
					if(!fwrite($abrir, $conteudo))	print("Erro na Exportação!");
				}
				fclose($abrir);
				return $arquivo;
			}
		}
	}
}
?>