<table border="0" width="100%" cellpadding="0" cellspacing="2">
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td align="left">
			<img src="images/titulo_contato.jpg" border="0" style="margin-left:20px;">
		</td>
		<td align="left">
			<img src="images/titulo_faleconosco.jpg" border="0" style="margin-left:0px; margin-top:5px;">
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
  	<tr>
    	<td width="49%" align="center" valign="top">
			<table width="95%" align="center" border="0" cellspacing="3" cellpadding="3" style="line-height:16px; text-align:left;">
				<tr>
					<td colspan="2" align="left"><strong style="line-height:20px; letter-spacing:1px; font-size:100%; text-align:left;">Carone - Corretora de Im&oacute;veis</strong></td>
				</tr>
				<tr>
					<td colspan="2" align="left">Rua Dr. João Colin, 1285 - Sala 03 - Esquina com Rua Araranguá</td>
				</tr>
				<tr>
                    <td colspan="2" align="left">América - 89204-001</td>
                </tr>
				<tr>
					<td colspan="2" align="left">Joinville - SC</td>
				</tr>
				<tr>
					<td align="left">Fone: 47 3461-3176</td>
					<td align="left">Fax: 47 3461-3101</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
			</table>
			<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="line-height:16px; letter-spacing:1px; text-align:left;">
				<tr>
					<td align="left"><img src="images/contato_03.jpg" border="0" style="margin-left:0px;"></td>
				</tr>
				<tr>
					<td align="left" style="padding-left:48px;"><strong style="line-height:20px; letter-spacing:2px; font-size:100%; text-align:left;">CRECI 16512</strong></td>
				</tr>
				<tr>
					<td align="left">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" style="padding-left:25px;">47 98804-3167</td>
				</tr>
				<tr>
					<td align="left">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" style="padding-left:25px;"><a href="mailto:anamaria@caroneimoveis.com.br">anamaria@caroneimoveis.com.br</a></td>
				</tr>
			</table>
			<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px; line-height:16px; letter-spacing:1px; text-align:left;">
				<tr>
					<td align="left"><img src="images/contato_06.jpg" border="0" style="margin-left:0px;"></td>
				</tr>
				<tr>
					<td align="left" style="padding-left:48px;"><strong style="line-height:20px; letter-spacing:2px; font-size:100%; text-align:left;">CRECI 12014</strong></td>
				</tr>
				<tr>
					<td align="left">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" style="padding-left:25px;">47 99182-7476</td>
				</tr>
				<tr>
					<td align="left">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" style="padding-left:25px;"><a href="mailto:berna@caroneimoveis.com.br">berna@caroneimoveis.com.br</a></td>
				</tr>
			</table>
		</td>
		<td width="49%" valign="top">
			<?php
				if($_GET[tipo] == "enviar")
				{
					if($_POST[nome] != "" && $_POST[email] != "" && $_POST[mensagem] != "")
					{
						/*
						$texto = "Nome: $_POST[nome]\nE-mail: $_POST[email]\nTelefone: $_POST[telefone]\nMensagem: $_POST[mensagem]";
						$from = "From: $_POST[email]";
						mail("contato@caroneimoveis.com.br","Contato através do site - $_POST[assunto]",$texto, $from);
						*/
						$_POST[mensagem]=nl2br($_POST[mensagem]);
						$msgFinal = "
							<table align='left' cellpadding='3' cellspacing='3'>
								<tr bgcolor='#464646'>
									<th colspan='2' style='color:#93AD4C;'>Contato através do site - $_POST[assunto]</th>
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
									<th align='left' bgcolor='#EFEFEF' valign='top'>Mensagem:</th>
									<td align='left' bgcolor='#EFEFEF' valign='top'>$_POST[mensagem]</td>
								</tr>
							</table>
						";
						$fromMail = "$_POST[email]";
						$fromNome = "$_POST[nome]";
						include("cms/config.php");
						sendMail($endereco_email_destino, $nome_email_padrao, $endereco_email_padrao, "Carone Imóveis", "Contato através do site - $_POST[assunto]", $msgFinal);
						mensagemRetorno("Seu formulário foi enviado com sucesso! <br> Estaremos entrando em contato o mais breve possível!", "");
					}
				}
			?>
			<table width="100%" border="0" align="center" cellspacing="2" cellpadding="2">
				<tr>
					<td style="padding-left:53px; padding-right:50px; color:#333; letter-spacing:1px; line-height:20px;">
						Aqui voc&ecirc; pode tirar d&uacute;vidas, fazer sugest&otilde;es, reclama&ccedil;&otilde;es e solicitar informa&ccedil;&otilde;es.
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
			<form name="form1" method="post" action="?site=contato&tipo=enviar">
				<table width="80%" border="0" align="center" cellspacing="2" cellpadding="2">
					<tr>
						<td colspan="2" align="right" style="font-size:11px; color:#555; padding-right:100px;">
							* Campos obrigat&oacute;rios
						</td>
					</tr>
					<tr>
						<td align="left">Nome:</td>
						<td align="left"><input name="nome" type="text" id="nome" size="30" class="text"> *</td>
					</tr>
		            <tr>
		              	<td align="left">E-mail:</td>
		              	<td align="left"><input name="email" type="text" id="email" size="30" class="text"> *</td>
		            </tr>
		            <tr>
		              	<td align="left">Telefone:</td>
		              	<td align="left"><input name="telefone" type="text" id="telefone" tipo="numerico" mascara="(##) ####-####" size="20" class="text"></td>
		            </tr>
		            <tr>
						<td align="left">Assunto:</td>
						<td align="left"><input name="assunto" type="text" id="assunto" size="30" class="text"> *</td>
					</tr>
		            <tr>
		              	<td colspan="2" align="left">Mensagem:</td>
		            </tr>
		            <tr>
						<td colspan="2" align="left">
		                	<textarea name="mensagem" cols="35" rows="6"></textarea> *
						</td>
					</tr>
		            <tr>
						<td colspan="2" align="right" style="padding-right:50px;">
							<input name="Submit" type="submit" value="Enviar" class="submit" onClick="return (campoObrigatorio(nome) && campoObrigatorio(email) && validaEmail(email) && campoObrigatorio(assunto) && campoObrigatorio(mensagem));">
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td>
		<img src="images/titulo_mapalocalizacao.jpg" border="0" style="margin-left:20px;">
	  </td>
	</tr>
</table>
<center>
<div align="center" style="width:904px; border:2px solid #C3D88B;">
<iframe width="904" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=pt-BR&amp;geocode=&amp;q=Rua+Ararangu%C3%A1,+40,+Am%C3%A9rica,+Joinville+-+Santa+Catarina,+Brasil&amp;sll=-26.290106,-48.850129&amp;sspn=0.012312,0.026157&amp;ie=UTF8&amp;hq=&amp;hnear=R.+Ararangu%C3%A1,+40+-+Am%C3%A9rica,+Joinville+-+Santa+Catarina,+89204-310,+Brasil&amp;ll=-26.287605,-48.848562&amp;spn=0.013467,0.038795&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
</center>