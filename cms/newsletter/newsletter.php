<?php
include("func.php");
if($tipo=="exportar")
{
	$arquivo=exportaEmail($dataInicio, $dataFim);
	if($arquivo!=null)	$result = "ok";
	else				$result = "fail";
}

print("
	<form name='form1' method='post' action='index.php?modulo=newsletter&acao=newsletter&tipo=exportar' enctype='multipart/form-data'>
		<fieldset>
			<legend>Exportar E-mails</legend>
			<table align='center' cellpadding='3' cellspacing='3'>
			    <tr>
					<td align='center' colspan='2'>
						<p style='line-height:25px;'>
							Ao clicar em 'Exportar', voc&ecirc; ir&aacute; criar um arquivo chamado <b>emails.txt</b>.
						</p>
						<p style='line-height:25px;'>
							Esse arquivo conter&aacute; os emails dos usu&aacute;rios que se cadastraram no site para receberem o <i>newsletter</i>.
						</p>
					</td>
				</tr>
				<tr>
				  	<th scope='col' align='left'>Data de Cadastro:</th>
				  	<td scope='col' align='left'>
					  	<input type='text' name='dataInicio' id='dataInicio' value='$dataInicio' style='width:80px;' onfocus=\"onChangeFocus(this);\" onblur=\"onLostFocus(this);\" tipo='numerico' mascara='##/##/####'>
					  	<img src='imagens/calendario.gif' id='f_trigger_c' style='cursor: pointer;' width='20' height='20' title='Clique para selecionar a data'>
					  	<script type='text/javascript'>
							Calendar.setup({
								inputField     :    'dataInicio',      // id of the input field
								ifFormat       :    '%d/%m/%Y',       // format of the input field
								showsTime      :    false,            // will display a time selector
								button         :    'f_trigger_c',   // trigger for the calendar (button ID)
								singleClick    :    true,           // double-click mode
								step           :    1                // show all years in drop-down boxes (instead of every other year as default)
							});
						</script>

						&nbsp;à&nbsp;

						<input type='text' name='dataFim' id='dataFim' value='$dataFim' style='width:80px;' onfocus=\"onChangeFocus(this);\" onblur=\"onLostFocus(this);\" tipo='numerico' mascara='##/##/####'>
					  	<img src='imagens/calendario.gif' id='f_trigger_d' style='cursor: pointer;' width='20' height='20' title='Clique para selecionar a data'>
					  	<script type='text/javascript'>
							Calendar.setup({
								inputField     :    'dataFim',      // id of the input field
								ifFormat       :    '%d/%m/%Y',       // format of the input field
								showsTime      :    false,            // will display a time selector
								button         :    'f_trigger_d',   // trigger for the calendar (button ID)
								singleClick    :    true,           // double-click mode
								step           :    1                // show all years in drop-down boxes (instead of every other year as default)
							});
						</script>
					</td>
				</tr>
				<tr><td colspan='2'>&nbsp;</td></tr>
				<tr>
			      	<td  colspan='2' align='center'><input type='submit' name='Submit' id='form_submit' value='Exportar'></td>
			    </tr>
			    ");
				if($result=="ok"){
					print("
							<tr valign='bottom'>
						       	<td colspan='2'>
									<div align='center'><br><br>Arquivo exportado com sucesso!<BR></div>
						       		<BR><div align='center'><a target='_blank' class='linkNormal' href='$arquivo'>Clique aqui para abri-lo</a><BR></div>
								</td>
							</tr>
					");
				}
				elseif($result=="fail"){
					print("
							<tr valign='bottom'>
						       	<td colspan='2'>
									<div align='center'><br><br>Ocorreu uma falha durante a exportação do arquivo.!<BR>
						       		Por favor, tente novamente!
									</div>
								</td>
							</tr>
					");
				}
				print("
			</table>
		</fieldset>
	</form>
");
?>