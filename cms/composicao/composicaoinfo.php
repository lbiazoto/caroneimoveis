<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['composicao'])
{
	include("func.php");

	$linha = devolveInfo("composicao", $id);

	if($linha[deletado]==1)
		$tipo="removido";

	if($tipo=="detalhes" || $tipo=="")	$tituloH1="Composição - Detalhes";
	elseif($tipo=="editar")	$tituloH1="Composição - Editar";
	elseif($tipo=="removido")	$tituloH1="Composição - Excluir";

	if($modo=="remover")
	{
		$retorno=remove($id, $_SESSION['idUsuario']);
		if($retorno==true)
			$msg="Composição removida com sucesso!";
		else
			$msg="Erro ao remover Composição!";

		$tipo = "removido";
	}
	if($tipo=="removido")
	{
		print("<h1>Composição - Excluir</h1>");
		devolveMensagem("Composição removida com sucesso", $retorno);
		print("<br><br><div align='center'><p>Selecione a opção desejada no menu ao lado.</p></div>");
		$codigo="";
		return false;
	}
	if($modo=="editar")
	{
		$linha = devolveInfo("composicao", $id);
		$retorno=editaComposicao($nome, $relevancia, $id, $_SESSION['idUsuario']);
		if($retorno)
			$msg = "Dados da Composição atualizados com sucesso!";
		else
			$msg = "Ocorreu uma falha durante a atualização da Composição!";
	}

	print("
		<h1>
			$tituloH1
		</h1>
	");

	if($msg!="")	devolveMensagem($msg, $retorno);

	$linha = devolveInfo("composicao", $id);
	$usuarioCadastrou = devolveInfo("usuario", $linha[idUsuarioCadastro]);
	$usuarioAtualizou = devolveInfo("usuario", $linha[idUsuarioAtualizacao]);
	$dataCadastro = converteDataHoraFromMysql($linha[dataCadastro]);
	$dataAtualizacao = converteDataHoraFromMysql($linha[dataAtualizacao]);

	if($linha[dataAtualizacao]=="")	$dataAtualizacao="Sem atualizações.";
	if($linha[idUsuarioAtualizacao]=="") $usuarioAtualizou="Sem atualizações."; else $usuarioAtualizou=$usuarioAtualizou[nome];

	if($tipo=="" || $tipo=="detalhes")
	{
		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='90%' align='right'>
						<a href='index.php?modulo=composicao&acao=composicaoinfo&tipo=editar&id=$id' title='Editar'>
							<div class='app_botao'><img src='imagens/editar.png' border='0' class='icone_botao'> Editar</div>
						</a>
					</td>
					<td align='right'>
						<a href='index.php?modulo=composicao&acao=composicaoinfo&tipo=&modo=remover&id=$id' onclick='return confirmaExclusao();' title='Excluir'>
							<div class='app_botao'><img src='imagens/delete.png' border='0' class='icone_botao'> Excluir</div>
						</a>
					</td>
				</tr>
			</table>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th align='left'>Relevância</th>
					<th align='left'>Nome</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$linha[relevancia]</td>
					<td align='left'>&nbsp;$linha[nome]</td>
				</tr>
				<tr>
					<th align='left' width='50%'>Data de Cadastro</th>
					<th align='left' width='50%'>Data de Atualização</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$dataCadastro</td>
					<td align='left'>&nbsp;$dataAtualizacao</td>
				</tr>
				<tr>
					<th align='left'>Usuário que cadastrou</th>
					<th align='left'>Usuário que atualizou</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$usuarioCadastrou[nome]</td>
					<td align='left'>&nbsp;$usuarioAtualizou</td>
				</tr>
			</table>
		");
	}
	elseif($linha[deletado]==1)
	{
		devolveMensagem("Composição removida!", $retorno);
		print("<br><br><div align='center'><p>Selecione a opção desejada no menu ao lado.</p></div>");
		return false;
	}
	elseif($tipo=="editar")
	{
		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td align='right'>
						<a href='index.php?modulo=composicao&acao=composicaoinfo&tipo=&id=$id' title='Ver detalhes'>
							<div class='app_botao'><img src='imagens/ver_detalhes.png' border='0' class='icone_botao'> Ver detalhes</div>
						</a>
					</td>
				</tr>
			</table>
		");
		$linha = devolveInfo("composicao", $id);
		?>
		<form name="formCadastro" id="formCadastro" action="index.php?modulo=composicao&acao=composicaoinfo&modo=editar&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
		  	<fieldset>
		    	<legend>Editar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
						<th>Nome:</th>
						<td><input type="text" name="nome" id="nome" maxlength="100" value="<?php echo $linha[nome]; ?>" onfocus="validaInputText(this,'msgNome','Nome da Composição')"  onkeyup="validaInputText(this,'msgNome','Nome da Composição')"></td>
						<td>
							<div id="msgNome" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Relev&acirc;ncia:</th>
						<td colspan="2" align="left">
							<select name="relevancia" id="relevancia">
								<option value="0" <?php if($linha['relevancia']==0)	print("selected");?>>0</option>
								<option value="1" <?php if($linha['relevancia']==1)	print("selected");?>>1</option>
								<option value="2" <?php if($linha['relevancia']==2)	print("selected");?>>2</option>
								<option value="3" <?php if($linha['relevancia']==3)	print("selected");?>>3</option>
								<option value="4" <?php if($linha['relevancia']==4)	print("selected");?>>4</option>
								<option value="5" <?php if($linha['relevancia']==5)	print("selected");?>>5</option>
								<option value="6" <?php if($linha['relevancia']==6)	print("selected");?>>6</option>
								<option value="7" <?php if($linha['relevancia']==7)	print("selected");?>>7</option>
								<option value="8" <?php if($linha['relevancia']==8)	print("selected");?>>8</option>
								<option value="9" <?php if($linha['relevancia']==9)	print("selected");?>>9</option>
								<option value="10" <?php if($linha['relevancia']==10)	print("selected");?>>10</option>
							</select>
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