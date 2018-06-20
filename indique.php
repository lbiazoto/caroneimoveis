<?php

	$linha=devolveInfoSite("imoveis", $id);
?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left">
			<img src="images/indique_16.jpg" border="0" alt="Indique" style="margin-left:20px;">
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
  	<tr>
    	<td align="justify" style="padding:20px;">
			<?php
		    	if($_GET[tipo] == "enviar")
				{
					if($_POST[nome] != "" && $_POST[email] != "" && $_POST[paraemail] != "")
					{
						/*
						$texto = "$_POST[nome] estava visitando o site caroneimoveis.com.br e indicou um imóvel para você.<BR>
						<a href='http://www.caroneimoveis.com.br/index.php?site=detalhes&id=$id'>Clique aqui para ver o imóvel</a><BR>Mensagem: $_POST[mensagem]";

						$headers = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1\n";
						$headers .= "From: $_POST[email]\n";

						mail("$_POST[paraemail]","Estava visitando o site CaroneImoveis.com.br",$texto, $headers);
						mensagemRetorno("Sua indicação foi enviada com sucesso!", " width:400px; ");
						*/


						$msgFinal = "
							<table align='left' cellpadding='3' cellspacing='3'>
								<tr bgcolor='#464646'>
									<th colspan='2' style='color:#93AD4C;'>Estava visitando o site CaroneImoveis.com.br</th>
								</tr>
								<tr>
									<td align='left' bgcolor='#EFEFEF' colspan='2'>$_POST[nome] ($_POST[email]) estava visitando o site caroneimoveis.com.br e indicou um imóvel para você.</td>
								</tr>
								<tr>
									<td align='left' bgcolor='#EFEFEF' colspan='2'><a href='http://www.caroneimoveis.com.br/index.php?site=detalhes&id=$id'>Clique aqui para ver o imóvel</a></td>
								</tr>
								<tr>
									<td align='left' bgcolor='#EFEFEF'><b>Mensagem:</b><br>$_POST[mensagem]</td>
								</tr>
							</table>
						";
						$fromMail = "$_POST[email]";
						$fromNome = "$_POST[nome]";
						include("cms/config.php");
						
						sendMail("$_POST[paraemail]", "$_POST[paraemail]", $endereco_email_padrao,"Carone Imóveis", "Estava visitando o site CaroneImoveis.com.br", $msgFinal);
						$msgFinal = "
							<table align='left' cellpadding='3' cellspacing='3'>
								<tr bgcolor='#464646'>
									<th colspan='2' style='color:#93AD4C;'>Estava visitando o site CaroneImoveis.com.br</th>
								</tr>
								<tr>
									<td align='left' bgcolor='#EFEFEF' colspan='2'>$_POST[nome] ($_POST[email]) estava visitando o site caroneimoveis.com.br e indicou um imóvel para você.</td>
								</tr>
								<tr>
									<td align='left' bgcolor='#EFEFEF' colspan='2'><a href='http://www.caroneimoveis.com.br/index.php?site=detalhes&id=$id'>Clique aqui para ver o imóvel</a></td>
								</tr>
								<tr>
									<td align='left' bgcolor='#EFEFEF'><b>Mensagem:</b><br>$_POST[mensagem]</td>
								</tr>
								<tr>
									<td align='left' bgcolor='#EFEFEF'>Quem Recebeu: $_POST[paraemail]</td>
								</tr>
							</table>
						";
						sendMail($endereco_email_destino, $nome_email_padrao, $endereco_email_padrao, "Carone Imóveis", "Estava visitando o site CaroneImoveis.com.br", $msgFinal);
						mensagemRetorno("A Sua indicação foi enviada com sucesso!", " width:400px; ");

					}
				}
        	?>
			<form action="index.php?site=indique&tipo=enviar&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" name="form1">
				<table width="55%" border="0" align="left" cellspacing="2" cellpadding="2">
					<tr>
           	  			<td align="justify">
                			Preencha o formul&aacute;rio para indicar este im&oacute;vel
						</td>
            		</tr>
            		<tr><td>&nbsp;</td></tr>
            		<tr>
						<td align="left">Seu Nome:</td>
            		</tr>
            		<tr>
						<td align="left"><input name="nome" type="text" id="nome" size="41" class="text"> *</td>
					</tr>
		            <tr>
		              	<td align="left">Seu E-mail:</td>
		             </tr>
		             <tr>
		              	<td align="left"><input name="email" type="text" id="email" size="41" class="text"> *</td>
		            </tr>
		            <tr>
		              	<td align="left">E-mail de quem vai receber:</td>
		            </tr>
		            <tr>
		              	<td align="left"><input name="paraemail" type="text" id="paraemail" size="41" class="text"> *</td>
		            </tr>
		            <tr>
		              	<td align="left">Mensagem:</td>
		            </tr>
            		<tr>
						<td align="left">
                  			<textarea name="mensagem" cols="46" rows="6"></textarea>
            			</td>
					</tr>
            		<tr>
						<td align="center">
							<input name="Submit" type="submit" value="Enviar" class="submit" onClick="return (campoObrigatorio(nome) && campoObrigatorio(email) && validaEmail(email) && campoObrigatorio(paraemail) && campoObrigatorio(mensagem));">
						</td>
					</tr>
				</table>
		    </form>
		</td>
		<td valign="top">
			<table border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td align="right">
						<a href="index.php?site=detalhes&id=<?php print($id);?>"><img src="images/voltar.jpg" border="0"></a>
					</td>
				</tr>
				<tr>
					<td>
						<?php
							print("
								<a href='index.php?site=detalhes&id=$id'>
									<img src='imoveis/m_$linha[imagem]' style='border: 2px solid #C3D88B; float:right;' border='0'>
								</a>
							");
					  	?>
					</td>
				</tr>
			</table>
		</td>
  	</tr>
</table>