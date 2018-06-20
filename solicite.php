<?php

	$linha=devolveInfoSite("imoveis", $id);
?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left">
			<img src="images/solicite_16.jpg" border="0" alt="Solicite" style="margin-left:20px;">
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
  	<tr>
    	<td align="justify" style="padding:20px;">
			<?php
			    if($_GET[tipo] == "enviar")
					{
						if($_POST[nome] != "" && $_POST[email] != "")
						{
							/*$texto = "
							Nome: $_POST[nome]<br>
							Email: $_POST[email]<br>
							Telefone: $_POST[telefone]<br>
							Horário: $_POST[horario]<br>
							Mensagem: $_POST[mensagem]<br>


							Estava visitando o site caroneimoveis.com.br e solicitou mais informações.<BR>
							<a href='http://www.caroneimoveis.com.br/index.php?site=detalhes&id=$id'>Clique aqui para ver o imóvel</a><BR>";

							$headers = "MIME-Version: 1.0\n";
							$headers .= "Content-type: text/html; charset=iso-8859-1\n";

							$headers .= "From: $_POST[email]\n";

							mail("anamaria@caroneimoveis.com.br","Solicitação de Informações",$texto, $headers);
							mensagemRetorno("Os dados foram encaminhados com sucesso! <br> Estaremos entrando em contato o mais breve possível!", " width:400px; ");
							*/
							$_POST[mensagem]=nl2br($_POST[mensagem]);
							$imagem="<img src='http://www.caroneimoveis.com.br/imoveis/m_$linha[imagem]'>";
							$msgFinal = "
								<table align='left' cellpadding='3' cellspacing='3'>
									<tr bgcolor='#464646'>
										<th colspan='2' style='color:#93AD4C;'>Solicitação de Informações</th>
									</tr>
									<tr>
										<th align='left' bgcolor='#EFEFEF'>Nome:</th>
										<td align='left' bgcolor='#EFEFEF'>$_POST[nome]</td>
									</tr>
									<tr>
										<th align='left' bgcolor='#EFEFEF'>E-mail:</th>
										<td align='left' bgcolor='#EFEFEF'>$_POST[email]</td>
									</tr>
									<tr>
										<th align='left' bgcolor='#EFEFEF'>Telefone:</th>
										<td align='left' bgcolor='#EFEFEF'>$_POST[telefone]</td>
									</tr>
									<tr>
										<th align='left' bgcolor='#EFEFEF'>Horário:</th>
										<td align='left' bgcolor='#EFEFEF'>$_POST[horario]</td>
									</tr>
									<tr>
										<th align='left' bgcolor='#EFEFEF' valign='top'>Mensagem:</th>
										<td align='left' bgcolor='#EFEFEF' valign='top'>$_POST[mensagem]</td>
									</tr>
									<tr>
										<th align='left' bgcolor='#EFEFEF' valign='top'>Imóvel:</th>
										<td align='left' bgcolor='#EFEFEF' valign='top'>
											Id:$linha[id]<br>
											Referência:$linha[referencia]<br>
											Imagem:$imagem<br>
											Clique para ver o imóvel:<br>
											<a href='http://www.caroneimoveis.com.br/index.php?site=detalhes&id=$id'>Clique aqui para ver o imóvel</a>
										</td>
									</tr>
								</table>
							";
							$fromMail = "$_POST[email]";
							$fromNome = "$_POST[nome]";
							include("cms/config.php");
							sendMail($endereco_email_destino, $nome_email_padrao, $endereco_email_padrao, "Carone Imóveis", "Solicitação de Informações", $msgFinal);
							mensagemRetorno("Os dados foram encaminhados com sucesso! <br> Estaremos entrando em contato o mais breve possível!", " width:400px; ");
						}
					}
			    ?>
				<form action="index.php?site=solicite&tipo=enviar&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" name="form1">

					<table width="55%" border="0" align="left" cellspacing="2" cellpadding="2">
						<tr>
			           	  	<td align="justify">
			                	Preencha o formul&aacute;rio para solicitar mais informa&ccedil;&otilde;es
							</td>
			            </tr>
			            <tr>
							<td>&nbsp;</td>
						</tr>
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
			              	<td align="left">Telefone:</td>
			             </tr>
			             <tr>
			              	<td align="left"><input name="telefone" type="text" id="telefone" tipo="numerico" mascara="(##) ####-####" size="25" class="text"></td>
			            </tr>
			            <tr>
			              	<td align="left">Hor&aacute;rio para Contato:</td>
			            </tr>
			            <tr>
			              	<td align="left"><input name="horario" type="text" id="horario" size="30" class="text"></td>
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
								<input name="Submit" type="submit" value="Enviar" class="submit" onClick="return (campoObrigatorio(nome) && campoObrigatorio(email) && validaEmail(email))">
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