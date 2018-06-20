<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['backup'])
{
	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;
	include("func.php");

	if($tipo=="")	$tipo="cadastrar";

	if($tipo=="cadastrar")	$tituloH1="Backup - Cadastrar";
	elseif($tipo=="listar")	$tituloH1="Backup - Listar";

	if($modo=="cadastrar")
	{
		if($nome != "")
		{
			$arquivo = backupBaseDados();
			$retorno=adicionaBackup($nome,$_SESSION['login'], $arquivo);
			if($retorno)
				$msg="Backup Realizado com sucesso!";
			else
				$msg="O Backup não pode ser realizado!";
		}
	}
	if($modo=="remover" && $id!="")
	{
		$retorno=removeBackup($id, $_SESSION['login']);
		if($retorno)
			$msg="Excluído com sucesso";
		else
			$msg="Erro ao remover Backup";
		$acessoLiberado=true;
	}
	if($modo == "restaurar" && $id!="")
	{
		if($retorno=restauraBackup($file,$id,$_SESSION['login']))
			$msg="Backup Restaurado com sucesso!";
		else
			$msg="O Backup não pode ser restaurado!";
	}
	/////////
	print("
		<h1>
			$tituloH1
		</h1>
	");
	/////////
	if($msg!="")	devolveMensagem($msg, $retorno);

	if($tipo=="cadastrar")
	{
		?>
		<form method="post" id="formCadastrar" name="formCadastrar" action="index.php?modulo=backup&acao=backup&modo=cadastrar">
			<fieldset>
		    	<legend>Cadastrar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
						<th>Nome:</th>
						<td><input type="text" name="nome" id="nome" maxlength="100" onfocus="validaInputText(this,'msgNome','Identificação do backup')"  onkeyup="validaInputText(this,'msgNome','Identificação do backup')"></td>
						<td>
							<div id="msgNome" class="obrigatorio">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3" align="right">
							<fieldset style="width:180px; text-align:left;">
								<legend>Legenda</legend>
								<table cellpadding="2" cellspacing="2" align="right">
									<tr>
										<td align="center" valign="middle"><img src="css/images/obrigatorio.png" border="0" title="Campo Obrigat&oacute;rio" alt="Campo Obrigat&oacute;rio"></td>
										<td align="left" valign="middle">Campo Obrigat&oacute;rio</td>
									</tr>
									<tr>
										<td align="center" valign="middle"><img src="css/images/errado.png" border="0" title="Preenchimento Incorreto" alt="Preenchimento Incorreto"></td>
										<td align="left" valign="middle">Preenchimento Incorreto</td>
									</tr>
									<tr>
										<td align="center" valign="middle"><img src="css/images/correto.png" border="0" title="Preenchimento Correto" alt="Preenchimento Correto"></td>
										<td align="left" valign="middle">Preenchimento Correto</td>
									</tr>
								</table>
							</fieldset>
						</td>
					</tr>
					<tr valign="baseline">
						<td nowrap align="center" colspan="3">
							<input name="cadastrar" type="submit" id="form_submit" value="Cadastrar" onclick="return campoObrigatorio(nome);">
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
		<script language="javascript">
			document.formCadastrar.nome.focus();
		</script>
		<?php
	}
	elseif($tipo=="listar")
	{
		if($order=="dataCadastroASC") $orderCadastroASC="selected"; else $orderCadastroASC="";
		if($order=="dataCadastroDESC") $orderCadastroDESC="selected"; else $orderCadastroDESC="";
		if($order=="tituloASC") $orderTituloASC="selected"; else $orderTituloASC="";
		if($order=="tituloDESC") $orderTituloDESC="selected"; else $orderTituloDESC="";
		print("
			<table align='center' width='90%' cellpadding='2' cellspacing='2'>
			<tr>
				<td width='80%' align='center' valign='top'>
					<form action='index.php?modulo=backup&acao=backup&tipo=listar&modo=pesquisa' method='post'>
						<fieldset style='width:450px;'>
					    	<legend>Listar</legend>
							<table align = 'center' border = '0' cellpadding='2' cellspacing='2'>
								<tr>
									<th align='left'>Ordenado por:</th>
									<td align='left'>
										<select name='order' id='order'>
											<option value='dataCadastroASC' $orderCadastroASC>Data Cadastro Crescente</option>
											<option value='dataCadastroDESC' $orderCadastroDESC>Data Cadastro Decrescente</option>
											<option value='tituloASC' $orderTituloASC>Nome Crescente</option>
											<option value='tituloDESC' $orderTituloDESC>Nome Decrescente</option>
										</select>
									</td>
								</tr>
								<tr>
									<th align='left'>Nome:</th>
									<td align='left'><input name='titulo' value='$titulo' type='text' id='titulo' size='40' maxlength='100' onfocus='onChangeFocus(this);' onblur='onLostFocus(this);'></td>
								</tr>
								<tr>
									<td colspan='2' align='center'><input type='submit' id='form_submit' name='submitPesquisa' value='Pesquisar'></td>
								</tr>
							</table>
						</fieldset>
					</form>
				</td>
				<td width='20%' valign='top'>
					<fieldset style='width:150px; text-align:left;'>
						<legend>Legenda</legend>
						<table cellpadding='2' cellspacing='2' align='right'>
							<tr>
								<td align='center' valign='middle'><img src='imagens/carregar.png' border='0' title='Restaurar backup' alt='Restaurar backup'></td>
								<td align='left' valign='middle'>Restaurar backup</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/salvar.png' border='0' title='Salvar backup' alt='Salvar backup'></td>
								<td align='left' valign='middle'>Salvar backup</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/delete.png' border='0' title='Excluir backup' alt='Excluir backup'></td>
								<td align='left' valign='middle'>Excluir backup</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>
		");

		if($modo=="" || $modo=="restaurar") $order="dataCadastroASC";

		$where="";
		if($titulo!=""){
			$where.=" AND nome LIKE '%$titulo%' ";
		}
		if($order=="dataCadastroASC")	$orderBy="id ASC";
		if($order=="dataCadastroDESC")	$orderBy="id DESC";
		if($order=="tituloASC")	$orderBy="nome ASC";
		if($order=="tituloDESC")	$orderBy="nome DESC";
		devolveListaBackups($tipo, $index, $mark, "WHERE deletado='0' AND id!='-1' $where ORDER BY $orderBy", $order, $titulo, "&modo=pesquisa&titulo=$titulo&order=$order");
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