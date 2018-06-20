<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="4">
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left">
			<img src="images/sua_opiniao_16.jpg" border="0" style="margin-left:20px;">
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left" style="padding:20px;">
			<?php
				$empresa = devolveInfoSite("servicos", $id);
				if($_GET[tipo] == "enviar")
				{
					$retorno=cadastraAvaliacao($id, $nome, $email, $satisfacao, $comentario);
					if($retorno)
					{
						print("
							<div style='width:80%; border: 1px solid #93AD4A; padding: 8px; margin:10px; background-color:#C3D88B; color:#333;' align='center'>
								Obrigado por colaborar conosco. Sua opinião é de extrema importância para nosso trabalho.
							</div>
						");
					}
				}
				?>
				<form action="index.php?site=opine&tipo=enviar&id=<?php print($id); ?>" method="post" enctype="multipart/form-data" name="form1">
					<table width="100%" border="0" align="center" cellspacing="2" cellpadding="2">
						<tr>
							<td colspan="2" align="justify" style="padding:0px 20px 20px 0px; line-height:20px; letter-spacing:1px;">
								Opine sobre a empresa <?php print("<b>$empresa[nome]</b>");?>!
							</td>
							<td width="40%">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" align="justify" style="padding:0px 20px 20px 0px; line-height:20px; letter-spacing:1px;">
								Envie-nos informa&ccedil;&otilde;es para qualificarmos o servi&ccedil;o referente ao servi&ccedil;o prestado.
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
							<td align="left" colspan="2">Como voc&ecirc; avalia o servi&ccedil;o ?</td>
						</tr>
						<tr>
							<td colspan="2" align="left">
								<table align="left" width="100%" border="0" cellspacing="3" cellpadding="3">
									<tr>
										<td align="left"><input name="satisfacao" type="radio" id="ruim" value="1" style="border:none; margin:0px; padding:0px;">&nbsp;Ruim</td>
										<td align="left"><input name="satisfacao" type="radio" id="bom" value="2" style="border:none; margin:0px; padding:0px;" checked>&nbsp;Bom</td>
										<td align="left"><input name="satisfacao" type="radio" id="otimo" value="3" style="border:none; margin:0px; padding:0px;">&nbsp;&Oacute;timo</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td align="left" colspan="2">Comente sua avalia&ccedil;&atilde;o:</td>
						</tr>
						<tr>
							<td align="left" colspan="2">
								<textarea name="comentario" id="comentario" style="width:95%; height:150px;"></textarea> *
							</td>
						</tr>
						<tr>
						<td colspan="2" align="center">
							<input name="Submit" type="submit" value="Enviar" class="submit" onClick="return (campoObrigatorio(nome) && campoObrigatorio(email) && validaEmail(email) && campoObrigatorio(comentario));">
						</td>
					</tr>
				</table>
			</form>
		</td>
		<td>
			<?php
				print("
					<a href='index.php?site=servicos&idCategoria=$idCategoria'>voltar</a>
				");
			?>
		</td>
	</tr>
</table>