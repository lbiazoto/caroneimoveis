<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['backup'])
{
	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;
	include("func.php");

	if($tipo=="")	$tipo="cadastrar";

	if($modo=="cadastrar")
	{
		$retorno=agendaBackup($seg, $ter, $qua, $qui, $sex, $sab, $dom,$_SESSION['login']);
		if($retorno)
			$msg="Agendamento de Backup Realizado com sucesso!";
		else
			$msg="O Backup não pode ser Agendado!";
	}
	?>
	<h1>Backup Autom&aacute;tico</h1>
	<?php
	if($msg!="")	devolveMensagem($msg, $retorno);

	if($tipo=="cadastrar")
	{
		$linha=devolveInfo("backupagendamento", 1);
		?>
		<form method="post" id="formCadastrar" name="formCadastrar" action="index.php?modulo=backup&acao=automatico&modo=cadastrar">
			<p>Selecione os dias que o sistema ir&aacute; fazer backup automaticamente.<BR>Os backups ocorrem as 18horas.</p>
			<table align="center" border="0" cellpadding="3" cellspacing="3">
				<tr valign="baseline">
					<th align="left">Dia da Semana</th>
					<th>Backup</th>
				</tr>
				<tr>
					<td>Domingo</td>
					<td><div align="center"><input type="checkbox" value="1" name="dom" <?php if($linha[dom]) print(" checked");?>></div></td>
				</tr>
				<tr>
					<td>Segunda-Feira</td>
					<td><div align="center"><input type="checkbox" value="1" name="seg" <?php if($linha[seg]) print(" checked");?>></div></td>
				</tr>
				<tr>
					<td>Ter&ccedil;a-Feira</td>
					<td><div align="center"><input type="checkbox" value="1" name="ter" <?php if($linha[ter]) print(" checked");?>></div></td>
				</tr>
				<tr>
					<td>Quarta-Feira</td>
					<td><div align="center"><input type="checkbox" value="1" name="qua" <?php if($linha[qua]) print(" checked");?>></div></td>
				</tr>
				<tr>
					<td>Quinta-Feira</td>
					<td><div align="center"><input type="checkbox" value="1" name="qui" <?php if($linha[qui]) print(" checked");?>></div></td>
				</tr>
				<tr>
					<td>Sexta-Feira</td>
					<td><div align="center"><input type="checkbox" value="1" name="sex" <?php if($linha[sex]) print(" checked");?>></div></td>
				</tr>
				<tr>
					<td>S&aacute;bado</td>
					<td><div align="center"><input type="checkbox" value="1" name="sab" <?php if($linha[sab]) print(" checked");?>></div></td>
				</tr>
			</table>
			<center><input name="cadastrar" type="submit" id="cadastrar" value="Salvar" onclick="return campoObrigatorio(nome);"></center>
		</form>
		<?php
	}
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