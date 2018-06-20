<?php
	include("../../../../config.php");
	if($tipo=="upload")
	{
		if($procurar=="")
		{
			print('<script language="javascript">alert("É nescessário informar o arquivo a ser enviado!");</script>');
		}
		else
		{

			$nomeTemp = $_FILES['procurar']['tmp_name'];
			$nomeReal = $_FILES['procurar']['name'];
			$destino = "$enderecoCompleto/prospeccao/imagens/";
				while(file_exists("../../../../prospeccao/imagens/$nomeReal"))
				{
					$aux = explode(".",$nomeReal);
					$tempNome = reset($aux);
					for($i=1;$i < count($aux) - 1;$i++)
					{
						$tempNome .= next($aux);
					}
					$tipo = end($aux);
					$nomeReal = $tempNome.rand(0,100).".".$tipo;
				}
				if (move_uploaded_file($nomeTemp, "../../../../prospeccao/imagens/$nomeReal"))
				{
					print($arquivoCaminho);
					print('<script language="javascript">alert("Arquivo Enviado Com Sucesso!");</script>');
					print("<script language='javascript'>window.opener.document.formAcc.src.value = '$destino$nomeReal';</script>");
					print('<script language="javascript">window.close();</script>');
				}
				else
				{
					print('<script language="javascript">alert("Erro no Envio do Arquivo!");</script>');
				}
			}
	}
?>
<html>
<head>
<title>Upload de Arquivos</title>
<link href="../css/advimage.css" rel="stylesheet" type="text/css" />
</head>
<body id="advimage">
<form method="POST" name="formUpload" action="prospeccaoUpload.php?tipo=upload" enctype="multipart/form-data">
	<center>Informe o arquivo a ser enviado para o servidor:</center>
	<table align="center" width="90%" class="mceActionPanel">
		<tr>
			<td align="center" class="mceActionPanel">
				<input type="file" name="procurar" size="30">
			</td>
		</tr>
		<tr>
			<td align="center" class="mceActionPanel">
				<input type="submit" name="importar" value="Enviar">
			</td>
		</tr>
	</table>
</form>
</body>
</html>