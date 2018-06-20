<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['servicos'])
{
	include("func.php");

	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;

	if($modo=="cadastrar")
	{
		$retorno = cadastraCategoria($nome, $_SESSION['idUsuario']);
		if($retorno==true)
			$msg="Categoria cadastrada com sucesso!";
		else
			$msg="Erro ao cadastrar Categoria!";
	}
	if($modo=="editar")
	{
		$linha = devolveInfo("categoriaservicos", $id);
		$retorno = editaCategoria($nome, $id, $_SESSION['idUsuario']);
		if($retorno)
			$msg = "Dados da Categoria atualizados com sucesso!";
		else
			$msg = "Ocorreu uma falha durante a atualização da Categoria!";
	}
	if($modo=="remover")
	{
		$retorno=removeCategoria($id, $_SESSION['idUsuario']);
		if($retorno==true)
			$msg="Categoria removida com sucesso!";
		else
			$msg="Erro ao remover Categoria!";
	}

	print("
		<h1>
			Serviços - Categorias
		</h1>
	");

	if($msg!="")	devolveMensagem($msg, $retorno);

	if($tipo=="editar")
	{
		$linha=devolveInfo("categoriaservicos", $id);
		?>
		<form name="formCadastro" id="formCadastro" action="index.php?modulo=servicos&acao=categorias&modo=editar&id=<?php print($id);?>" method="post" enctype="multipart/form-data">
		  	<fieldset>
		    	<legend>Cadastrar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
						<th>Nome:</th>
						<td><input type="text" name="nome" value="<?php print($linha[nome]);?>" id="nome" maxlength="100" onfocus="validaInputText(this,'msgNome','Nome da Categoria')"  onkeyup="validaInputText(this,'msgNome','Nome da Categoria')"></td>
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
							<input name="cadastrar" type="submit" id="form_submit" value="Salvar" onclick="return campoObrigatorio(nome);">
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
		<script language="javascript">
			document.formCadastro.nome.focus();
		</script>
		<?php
	}
	else
	{
	?>
		<form name="formCadastro" id="formCadastro" action="index.php?modulo=servicos&acao=categorias&modo=cadastrar" method="post" enctype="multipart/form-data">
		  	<fieldset>
		    	<legend>Cadastrar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
						<th>Nome:</th>
						<td><input type="text" name="nome" id="nome" maxlength="100" onfocus="validaInputText(this,'msgNome','Nome da Categoria')"  onkeyup="validaInputText(this,'msgNome','Nome da Categoria')"></td>
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
			document.formCadastro.nome.focus();
		</script>
		<?php
		if($order=="dataCadastroASC") $orderCadastroASC="selected"; else $orderCadastroASC="";
		if($order=="dataCadastroDESC") $orderCadastroDESC="selected"; else $orderCadastroDESC="";
		if($order=="tituloASC") $orderTituloASC="selected"; else $orderTituloASC="";
		if($order=="tituloDESC") $orderTituloDESC="selected"; else $orderTituloDESC="";
		print("
		<hr>
		<table align='center' width='90%' cellpadding='2' cellspacing='2'>
			<tr>
				<td width='80%' align='center' valign='top'>
					<form action='index.php?modulo=servicos&acao=categorias' method='post'>
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
				<td width='20%' align='center' valign='top'>
					<fieldset style='width:170px; text-align:left;'>
						<legend>Legenda</legend>
						<table cellpadding='3' cellspacing='3' align='left'>
							<tr>
								<td align='center' valign='middle'><img src='imagens/editar.png' border='0' title='Editar' alt='Editar'></td>
								<td align='left' valign='middle'>Editar</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/delete.png' border='0' title='Excluir' alt='Excluir'></td>
								<td align='left' valign='middle'>Excluir</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>
		");

		if($order=="") $order="dataCadastroASC";

		$where="";
		if($titulo!="")
		{
			$where.=" AND nome LIKE '%$titulo%' ";
		}
		if($order=="dataCadastroASC")	$orderBy="id ASC";
		if($order=="dataCadastroDESC")	$orderBy="id DESC";
		if($order=="tituloASC")	$orderBy="nome ASC";
		if($order=="tituloDESC")	$orderBy="nome DESC";
		devolveListaCategorias($tipo, $index, $mark, "WHERE deletado='0' AND id!='-1' $where ORDER BY $orderBy", $order, $titulo, "&titulo=$titulo&order=$order");
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