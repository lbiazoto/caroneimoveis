<script type="text/javascript" src="forms.js"></script>
<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['usuarios'])
{
	include("func.php");

	if($modo == "mudar")
	{
		if(strlen($senhaNova1)>12 || strlen($senhaNova1)<4)
		{
			$erroSenhaNova = " Sua senha deve conter entre 4 e 12 caracteres!";
			$msg=$erroSenhaNova;
			$retorno=0;
		}
		else
		{
			if($senhaNova1 != $senhaNova2)
			{
				$erroSenhaNova = " Os dois campos Senha Nova devem ser iguais!";
				$msg=$erroSenhaNova;
				$retorno=0;
			}
			elseif(!mudarSenha($_SESSION['idUsuario'], $senhaAntiga, $senhaNova1))
			{
				$erroSenhaAntiga = " Sua senha antiga está errada!";
				$msg=$erroSenhaAntiga;
				$retorno=0;
			}
			else
			{
				$msg="Senha alterada com sucesso.";
				$retorno=1;
			}
		}
	}

	if($msg!="")	devolveMensagem($msg, $retorno);
	?>
	<h1>Usu&aacute;rios</h1>
	<form action="index.php?modulo=usuarios&acao=senha&modo=mudar" name="formsenha" id="formsenha" method="post" class="niceform">
		<fieldset>
	    	<legend>Alterar Senha</legend>
	    	<table align="center" border="0" cellspacing="3" cellpadding="3">
				<tr>
					<td>Senha Antiga:</td>
					<td>
						<input name="senhaAntiga" id="senhaAntiga" type="password" size="15" maxlength="12" onfocus="onChangeFocus(this);" onBlur="onLostFocus(this);"><?php print($erroSenhaAntiga);?>
					</td>
				</tr>
				<tr>
					<td>Senha Nova:</td>
					<td>
						<input name="senhaNova1" id="senhaNova1" type="password" size="15" maxlength="12" onfocus="onChangeFocus(this);" onBlur="onLostFocus(this);"><?php print($erroSenhaNova);?>
					</td>
				</tr>
				<tr>
					<td>Confirmação da nova senha:</td>
					<td>
						<input name="senhaNova2" id="senhaNova2" type="password" size="15" maxlength="12" onfocus="onChangeFocus(this);" onBlur="onLostFocus(this);">
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" id="form_submit" name="Submit" value="Alterar" onclick="return(campoObrigatorio(senhaAntiga) && campoObrigatorio(senhaNova1) && campoObrigatorio(senhaNova2))">
					</td>
				</tr>
			</table>
	    </fieldset>
	</form>
	<script language="javascript">
		document.formsenha.senhaAntiga.focus();
	</script>
	<?php
}
else
{
	print("
		<br><br>
		<h1>
			");
			if(devolveUsuarioLogado())	devolveMensagem(NAO_AUTORIZADO, false);
			print("
		</h1>
		<br><br>
	");
}
?>