<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['categorias'])
{
	include("func.php");

	$linha = devolveInfo("categorias", $id);

	if($linha[deletado]==1)
		$tipo="removido";

	if($tipo=="detalhes" || $tipo=="")	$tituloH1="Categorias - Detalhes do Categoria";
	elseif($tipo=="editar")	$tituloH1="Categorias - Editar Categoria";
	elseif($tipo=="removido")	$tituloH1="Categorias - Excluir Categoria";

	if($modo=="remover")
	{
		$retorno=remove($id, $_SESSION['idUsuario']);
		if($retorno==true)
			$msg="Categoria removida com sucesso!";
		else
			$msg="Erro ao remover Categoria!";

		$tipo = "removido";
	}
	if($tipo=="removido")
	{
		print("<h1>Categorias - Excluir Categoria</h1>");
		devolveMensagem("Categoria removida com sucesso", $retorno);
		print("<br><br><div align='center'><p>Selecione a op��o desejada no menu ao lado.</p></div>");
		$codigo="";
		return false;
	}
	if($modo=="editar")
	{
		$linha = devolveInfo("categorias", $id);
		$retorno=editaCategoria($nome, $rgb2, $id, $_SESSION['idUsuario']);
		if($retorno)
			$msg = "Dados da Categoria atualizados com sucesso!";
		else
			$msg = "Ocorreu uma falha durante a atualiza��o da Categoria!";
	}

	print("
		<h1>
			$tituloH1
		</h1>
	");

	if($msg!="")	devolveMensagem($msg, $retorno);

	$linha = devolveInfo("categorias", $id);
	$usuarioCadastrou = devolveInfo("usuario", $linha[idUsuarioCadastro]);
	$usuarioAtualizou = devolveInfo("usuario", $linha[idUsuarioAtualizacao]);
	$dataCadastro = converteDataHoraFromMysql($linha[dataCadastro]);
	$dataAtualizacao = converteDataHoraFromMysql($linha[dataAtualizacao]);

	if($linha[dataAtualizacao]=="")	$dataAtualizacao="Sem atualiza��es.";
	if($linha[idUsuarioAtualizou]=="") $usuarioAtualizou="Sem atualiza��es."; else $usuarioAtualizou=$usuarioAtualizou[nome];

	if($tipo=="" || $tipo=="detalhes")
	{
		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='90%' align='right'>
						<a href='index.php?modulo=categorias&acao=categoriainfo&tipo=editar&id=$id' title='Editar Categoria'>
							<div class='app_botao'><img src='imagens/editar.png' border='0' class='icone_botao'> Editar</div>
						</a>
					</td>
					<td align='right'>
						<a href='index.php?modulo=categorias&acao=categoriainfo&tipo=&modo=remover&id=$id' onclick='return confirmaExclusao();' title='Excluir Categoria'>
							<div class='app_botao'><img src='imagens/delete.png' border='0' class='icone_botao'> Excluir</div>
						</a>
					</td>
				</tr>
			</table>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th align='left'>Categoria</th>
					<th align='left'>Cor</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$linha[nome]</td>
					<td align='left' style='background-color:$linha[cor];'>&nbsp;$linha[cor]</td>
				</tr>
				<tr>
					<th align='left' width='50%'>Data de Cadastro</th>
					<th align='left' width='50%'>Data de Atualiza��o</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$dataCadastro</td>
					<td align='left'>&nbsp;$dataAtualizacao</td>
				</tr>
				<tr>
					<th align='left'>Usu�rio que cadastrou</th>
					<th align='left'>Usu�rio que atualizou</th>
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
		devolveMensagem("Categoria removido!", $retorno);
		print("<br><br><div align='center'><p>Selecione a op��o desejada no menu ao lado.</p></div>");
		return false;
	}
	elseif($tipo=="editar")
	{
		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td align='right'>
						<a href='index.php?modulo=categorias&acao=categoriainfo&tipo=&id=$id' title='Ver detalhes do Categoria'>
							<div class='app_botao'><img src='imagens/ver_detalhes.png' border='0' class='icone_botao'> Ver detalhes</div>
						</a>
					</td>
				</tr>
			</table>
		");
		$linha = devolveInfo("categorias", $id);
		?>
		<link rel="stylesheet" href="js_color_picker_v2.css" media="screen">
		<script src="color_functions.js"></script>
		<script type="text/javascript" src="js_color_picker_v2.js"></script>
		<form name="formCadastro" id="formCadastro" action="index.php?modulo=categorias&acao=categoriainfo&modo=editar&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
		  	<fieldset>
		    	<legend>Editar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
						<th align="left">Nome:</th>
						<td align="left"><input type="text" name="nome" value="<?php print($linha['nome']);?>" id="nome" maxlength="100" onfocus="validaInputText(this, 'msgNome', 'Nome da Categoria')"  onkeyup="validaInputText(this, 'msgNome', 'Nome da Categoria')"></td>
						<td align="left">
							<div id="msgNome" class="obrigatorio">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Cor:</th>
						<td align="left"><input type="text" value="<?php print($linha['cor']);?>" name="rgb2" id="rgb2" maxlength="100"></td>
						<td align="left"><input type="button" style="width:150px;" value="Selecione uma cor" onclick="showColorPicker(this,document.formCadastro.rgb2)"></td>
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
							<input name="cadastrar" type="submit" id="form_submit" value="Salvar" onclick="return(campoObrigatorio(nome) && campoObrigatorio(rgb2));">
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