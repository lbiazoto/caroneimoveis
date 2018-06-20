<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="4">
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left">
			<img src="images/inclua_seu_imovel_16.jpg" border="0" style="margin-left:20px;">
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left" style="padding:20px;">
			<?php
				if($_GET[tipo] == "enviar")
				{
					if($_POST[nome] != "" && $_POST[email] != "" && $_POST[descricao] != "")
					{
						/*
						$texto = "
							Nome: $_POST[nome]<BR>
							E-mail: $_POST[email]<BR>
							Telefone: $_POST[telefone]<BR>
							Endereço: $_POST[endereco]<BR>
							Bairro: $_POST[bairro]<BR>
							Cidade: $_POST[cidade]<BR>
							Cliente: $_POST[cliente]<BR>
							Descrição: $_POST[descricao]<BR>
							<BR>
							Como nos Conheceu:<BR>
							Jornal: $_POST[jornal]<BR>
							Revista: $_POST[revista]<BR>
							Guia: $_POST[guia]<BR>
							Panfleto: $_POST[panfleto]<BR>
							Internet: $_POST[internet]<BR>
							Plantao: $_POST[plantao]<BR>
							Outros: $_POST[outros]<BR>
						";

						$headers = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1\n";
						$headers .= "From: $_POST[email]\n";

						mail("rogerio@betag.com.br","$assunto",$texto, $headers);
						*/
						$_POST[descricao]=nl2br($_POST[descricao]);
						$msgFinal = "
							<table align='left' cellpadding='3' cellspacing='3'>
								<tr bgcolor='#464646'>
									<th colspan='2' style='color:#93AD4C;'>Inclua o Seu Imóvel</th>
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
									<th align='left' bgcolor='#EFEFEF'>Endereço:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[endereco]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Bairro:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[bairro]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Cidade:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[cidade]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Cliente:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[cliente]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF' valign='top'>Desrição:</th>
									<td align='left' bgcolor='#EFEFEF' valign='top'>$_POST[descricao]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF' colspan='2'>Como nos Conheceu</th>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Jornal:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[jornal]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Revista:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[jornal]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Guia:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[jornal]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Panfleto:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[jornal]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Internet:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[jornal]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Plantão:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[jornal]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Outros:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[jornal]</td>
								</tr>
							</table>
						";
						$fromMail = "$_POST[email]";
						$fromNome = "$_POST[nome]";
						include("cms/config.php");
						sendMail($endereco_email_destino, $nome_email_padrao, $endereco_email_padrao, "Carone Imóveis", "Inclua o Seu Imóvel", $msgFinal);
						mensagemRetorno("Os dados foram encaminhados com sucesso! <br> Estaremos entrando em contato o mais breve possível!", " width:400px; ");
					}
				}
				?>
				<form action="?site=incluaOseu&tipo=enviar" method="post" enctype="multipart/form-data" name="form1">
					<table width="100%" border="0" align="center" cellspacing="2" cellpadding="2">
						<tr>
							<td colspan="2" align="justify" style="padding:0px 20px 20px 0px; line-height:20px; letter-spacing:1px;">
								Cadastre aqui seu im&oacute;vel!<br>
								Preencha o formul&aacute;rio, sem compromisso, e assim que poss&iacute;vel entraremos em contato.
							</td>
							<td width="40%">&nbsp;</td>
						</tr>
					</table>
					<table border="0" align="left" cellspacing="3" cellpadding="3">
						<tr>
							<td colspan="2" align="right" style="font-size:11px; color:#555;">
								* Campos obrigat&oacute;rios
							</td>
						</tr>
						<tr>
							<td align="left">Nome:</td>
							<td align="left"><input name="nome" type="text" id="nome" size="41" class="text"> *</td>
						</tr>
						<tr>
							<td align="left">E-mail:</td>
							<td align="left"><input name="email" type="text" id="email" size="41" class="text"> *</td>
						</tr>
						<tr>
							<td align="left">Telefone:</td>
							<td align="left"><input name="telefone" type="text" id="telefone" tipo="numerico" mascara="(##) ####-####" size="25" class="text"></td>
						</tr>
						<tr>
							<td align="left">Cidade:</td>
							<td align="left"><input name="cidade" type="text" id="cidade" size="41" class="text"> *</td>
						</tr>
						<tr>
							<td align="left">Bairro:</td>
							<td align="left"><input name="bairro" type="text" id="bairro" size="41" class="text"> *</td>
						</tr>
						<tr>
							<td align="left">Endere&ccedil;o:</td>
							<td align="left"><input name="endereco" type="text" id="endereco" size="41" class="text"> *</td>
						</tr>
						<tr>
							<td align="left">J&aacute; sou Cliente:</td>
							<td align="left"><input name="cliente" type="checkbox" id="cliente" value="Sim" style="border:none;">Sim</td>
						</tr>
						<tr>
							<td colspan="2" align="left">Descri&ccedil;&atilde;o do Im&oacute;vel:</td>
						</tr>
						<tr>
							<td colspan="2" align="left"><textarea name="descricao" cols="46" rows="6" id="descricao"></textarea> *</td></tr>
						<tr>
							<td colspan="2" align="left">Como nos Conheceu:</td>
						</tr>
						<tr>
							<td colspan="2" align="left">
								<table align="left" width="100%" border="0" cellspacing="3" cellpadding="3">
									<tr>
										<td><input name="jornal" type="checkbox" id="jornal" value="Sim"  style="border:none; margin:0px; padding:0px;">&nbsp;Jornal </td>
										<td><input name="revista" type="checkbox" id="revista" value="Sim"  style="border:none; margin:0px; padding:0px;">&nbsp;Revista</td>
										<td><input name="guia" type="checkbox" id="guia" value="Sim"  style="border:none; margin:0px; padding:0px;">&nbsp;Guia</td>
										<td><input name="panfleto" type="checkbox" id="panfleto" value="Sim"  style="border:none; margin:0px; padding:0px;">&nbsp;Panfleto</td>
									</tr>
									<tr>
										<td><input name="internet" type="checkbox" id="internet" value="Sim"  style="border:none; margin:0px; padding:0px;">&nbsp;Internet</td>
										<td><input name="plantao" type="checkbox" id="plantao" value="Sim"  style="border:none; margin:0px; padding:0px;">&nbsp;Plant&atilde;o</td>
										<td><input name="outros" type="checkbox" id="outros" value="Sim"  style="border:none; margin:0px; padding:0px;">&nbsp;Outros</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
						<td colspan="2" align="center">
							<input name="Submit" type="submit" value="Enviar" class="submit" onClick="return (campoObrigatorio(nome) && campoObrigatorio(email) && validaEmail(email) && campoObrigatorio(cidade) && campoObrigatorio(bairro) && campoObrigatorio(endereco) && campoObrigatorio(descricao));">
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>