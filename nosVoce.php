<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left">
			<img src="images/titulo_nosmaisvoce_22.jpg" border="0" style="margin-left:20px;">
		</td>
	</tr>
    <tr>
    	<td align="center">
        <?php
				if($_GET[tipo] == "enviar")
				{
					if($_POST[nome] != "" && $_POST[email])
					{
						/*$texto = "
							Nome: $_POST[nome]\n
							E-mail: $_POST[email]\n
							Telefone Celular: $_POST[telefoneCelular]\n
							Telefone Comercial: $_POST[telefoneComercial]\n
							Objetivo:  $_POST[objetivoPrincipal]\n
							At� o Valor de:  $_POST[valorDe]\n
							Tem im�vel para permutar ou vender? $_POST[temImovel]\n
							Tipo do im�vel: $_POST[tipoImovel]\n
							Cidade: $_POST[cidade]\n
							Bairro: $_POST[bairro]\n
							Foi avaliado? $_POST[foiAvaliado]\n
							Qual valor? $_POST[qualValor]\n
							O que faz quest�o no im�vel que procura?\n
							$_POST[questaoImovel]\n
							Outros tipos de observa��es:\n
							 $_POST[observacoes]
						";
						$from = "From: $_POST[email]";
						mail("contato@caroneimoveis.com.br","N�s + Voc� = Seu Objetivo - Contato atrav�s do site",$texto, $from);
						*/
						$_POST[questaoImovel]=nl2br($_POST[questaoImovel]);
						$_POST[observacoes]=nl2br($_POST[observacoes]);
						$msgFinal = "
							<table align='left' cellpadding='3' cellspacing='3'>
								<tr bgcolor='#464646'>
									<th colspan='2' style='color:#93AD4C;'>N�s + Voc� = Seu Objetivo - Contato atrav�s do site</th>
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
									<th align='left' bgcolor='#EFEFEF'>Telefone Celular:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[telefoneCelular]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Telefone Comercial:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[telefoneComercial]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Objetivo Principal:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[objetivoPrincipal]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>At� o valor de:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[valorDe]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Tem im�vel para permutar ou vender?</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[temImovel]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Tipo do Im�vel:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[tipoImovel]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Cidade:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[cidade]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Bairro:</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[bairro]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Foi avaliado?</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[foiAvaliado]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF'>Qual Valor?</th>
									<td align='left' bgcolor='#EFEFEF'>$_POST[qualValor]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF' valign='top'>O que faz quest�o no im�vel que procura?</th>
									<td align='left' bgcolor='#EFEFEF' valign='top'>$_POST[questaoImovel]</td>
								</tr>
								<tr>
									<th align='left' bgcolor='#EFEFEF' valign='top'>Outros tipos de observa��o:</th>
									<td align='left' bgcolor='#EFEFEF' valign='top'>$_POST[observacoes]</td>
								</tr>
							</table>
						";
						$fromMail = "$_POST[email]";
						$fromNome = "$_POST[nome]";
						include("cms/config.php");
						sendMail($endereco_email_destino, $nome_email_padrao, $endereco_email_padrao, "Carone Im�veis", "N�s + Voc� = Seu Objetivo - Contato atrav�s do site", $msgFinal);
						mensagemRetorno("Seus dados foram enviados com sucesso! <br> Estaremos entrando em contato o mais breve poss�vel!", " width:400px; ");
					}
				}
			?>
        </td>
    </tr>
	<tr>
		<td valign="top" style="text-align:justify; line-height:20px; letter-spacing:1px; padding:10px 50px 10px 50px;">
			<p>
				Nossa experi�ncia nos permite ajudar a concretizar seus objetivos.
				Quando existe a inten��o de comprar um novo ou primeiro im�vel, por�m com alguma pend�ncia pessoal ou mesmo tenha que vender um outro im�vel, n�s podemos ajudar a encontrar a melhor maneira
			</p>
			<p>
				Temos uma din�mica de trabalho personalizado, cada caso � �nico e requer uma estrat�gia pr�pria.
			</p>
			<p>
				A nossa grande integra��o com outros profissionais aut�nomos, rede de im�veis e imobili�rias, resulta em �timas negocia��es em per�odos mais reduzidos.
				Colocamo-nos � disposi��o para atend�-los pessoalmente, e tamb�m os convidamos a preencher o formul�rio abaixo, para irmos nos familiarizando com os seus objetivos.
			</p>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" style="text-align:justify; line-height:20px; letter-spacing:1px; padding:10px 50px 10px 50px;">
			<form name="form1" method="post" action="?site=nosVoce&tipo=enviar">
				<table border="0" align="left" cellspacing="2" cellpadding="2">
					<tr>
						<td colspan="2" align="right" style="font-size:11px; color:#555; padding-right:100px;">
							* Campos obrigat&oacute;rios
						</td>
					</tr>
					<tr>
						<td width="35%" align="left">Nome:</td>
						<td align="left"><input name="nome" type="text" id="nome" size="30" class="text"> *</td>
					</tr>
		            <tr>
		              	<td align="left">E-mail:</td>
		              	<td align="left"><input name="email" type="text" id="email" size="30" class="text"> *</td>
		            </tr>
		            <tr>
		              	<td align="left">Telefone Celular:</td>
		              	<td align="left"><input name="telefoneCelular" type="text" id="telefoneCelular" tipo="numerico" mascara="(##) ####-####" size="20" class="text"></td>
		            </tr>
		            <tr>
		              	<td align="left">Telefone Comercial:</td>
		              	<td align="left"><input name="telefoneComercial" type="text" id="telefoneComercial" tipo="numerico" mascara="(##) ####-####" size="20" class="text"></td>
		            </tr>
		            <tr>
						<td align="left">Objetivo Principal:</td>
						<td align="left"><input name="objetivoPrincipal" type="text" id="objetivoPrincipal" size="30" class="text"></td>
					</tr>
                    <tr>
						<td align="left">At� o Valor de:</td>
						<td align="left"><input name="valorDe" type="text" id="valorDe" size="30" class="text"></td>
					</tr>
					<tr>
						<td align="left">Tem im&oacute;vel para permutar ou vender?</td>
						<td align="left"><input name="temImovel" type="text" id="temImovel" size="30" class="text"></td>
					</tr>
					<tr>
						<td align="left">Tipo do Im&oacute;vel</td>
						<td align="left"><input name="tipoImovel" type="text" id="tipoImovel" size="30" class="text"></td>
					</tr>
					<tr>
						<td align="left">Cidade</td>
						<td align="left"><input name="cidade" type="text" id="cidade" size="30" class="text"></td>
					</tr>
					<tr>
						<td align="left">Bairro</td>
						<td align="left"><input name="bairro" type="text" id="bairro" size="30" class="text"></td>
					</tr>
					<tr>
						<td align="left">Foi avaliado?</td>
						<td align="left"><input name="foiAvaliado" type="text" id="foiAvaliado" size="30" class="text"></td>
					</tr>
					<tr>
						<td align="left">Qual valor?</td>
						<td align="left"><input name="qualValor" type="text" id="qualValor" size="30" class="text"></td>
					</tr>
		            <tr>
		              	<td colspan="2" align="left">O que faz quest&atilde;o no im&oacute;vel que procura?</td>
		            </tr>
		            <tr>
						<td colspan="2" align="left">
		                	<textarea name="questaoImovel" cols="48" rows="6"></textarea>
						</td>
					</tr>
					<tr>
		              	<td colspan="2" align="left">Outros tipos de observa&ccedil;&otilde;es:</td>
		            </tr>
		            <tr>
						<td colspan="2" align="left">
		                	<textarea name="observacoes" cols="48" rows="6"></textarea>
						</td>
					</tr>
		            <tr>
						<td colspan="2" align="right" style="padding-right:150px;">
							<input name="Submit" type="submit" value="Enviar" class="submit" onClick="return (campoObrigatorio(nome) && campoObrigatorio(email) && validaEmail(email));">
						</td>
					</tr>
				</table>
			</form>

		</td>
	</tr>
</table>