<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['bairros'])
{
	include("func.php");

	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;

	if($tipo=="cadastrar")	$tituloH1="Bairros - Cadastrar";
	elseif($tipo=="listar")	$tituloH1="Bairros - Listar";

	if($modo=="cadastrar")
	{
		if($novaRegiao!="")
		{
			$idRegiao=cadastraRegiao($novaRegiao, $_SESSION['idUsuario']);
		}
		$retorno=cadastraBairro($idRegiao, $nome, $_SESSION['idUsuario']);
		if($retorno==true)
			$msg="Bairro cadastrado com sucesso!";
		else
			$msg="Erro ao cadastrar Bairro!";
	}

	if($modo=="remover")
	{
		$retorno=remove($id, $_SESSION['idUsuario']);
		if($retorno==true)
			$msg="Bairro removido com sucesso!";
		else
			$msg="Erro ao remover Bairro!";
	}

	print("
		<h1>
			$tituloH1
		</h1>
	");

	if($msg!="")	devolveMensagem($msg, $retorno);

	if($tipo=="cadastrar")
	{
		?>
		<form name="formCadastro" id="formCadastro" action="index.php?modulo=bairros&acao=bairros&modo=cadastrar&tipo=cadastrar" method="post" enctype="multipart/form-data">
		  	<fieldset>
		    	<legend>Cadastrar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr id="combo">
						<th align="left">Cidade / Regi&atilde;o:</th>
						<td align="left"><?php montaSelectRegioes("idRegiao", $idRegiao, false); ?></td>
						<td valign="top">
							<div id="msgRegiao" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Nome:</th>
						<td align="left"><input type="text" name="nome" id="nome" maxlength="100" onfocus="validaInputText(this,'msgNome','Nome do Bairro')"  onkeyup="validaInputText(this,'msgNome','Nome do Bairro')"></td>
						<td>
							<div id="msgNome" class="none">
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
			document.formCadastro.idRegiao.focus();
		</script>
		<?php
	}
	elseif($tipo=="listar" || $tipo=="")
	{
		if($order=="dataCadastroASC") $orderCadastroASC="selected"; else $orderCadastroASC="";
		if($order=="dataCadastroDESC") $orderCadastroDESC="selected"; else $orderCadastroDESC="";
		if($order=="tituloASC") $orderTituloASC="selected"; else $orderTituloASC="";
		if($order=="tituloDESC") $orderTituloDESC="selected"; else $orderTituloDESC="";
		print("
		<table align='center' width='90%' cellpadding='2' cellspacing='2'>
			<tr>
				<td width='80%' align='center' valign='top'>
					<form action='index.php?modulo=bairros&acao=bairros&tipo=listar&modo=pesquisa' method='post'>
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
									<th align='left'>Cidade / Regi�o:</th>
									<td align='left'>");montaSelectRegioes("idRegiao", $idRegiao, true);print("

									</td>
								</tr>
								<tr>
									<th align='left'>Nome do Bairro:</th>
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
								<td align='center' valign='middle'><img src='imagens/ver_detalhes.png' border='0' title='Ver detalhes' alt='Ver detalhes'></td>
								<td align='left' valign='middle'>Ver detalhes</td>
							</tr>
							<tr>
								<td align='center' valign='middle'><img src='imagens/editar.png' border='0' title='Editar' alt='Editar'></td>
								<td align='left' valign='middle'>Editar dados</td>
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

		if($modo=="remover" || $modo=="") $order="dataCadastroASC";

		$where="";
		if($titulo!=""){
			$where.=" AND nome LIKE '%$titulo%' ";
		}
		if($idRegiao!=""){
			$where.=" AND idRegiao=$idRegiao ";
		}
		if($order=="dataCadastroASC")	$orderBy="id ASC";
		if($order=="dataCadastroDESC")	$orderBy="id DESC";
		if($order=="tituloASC")	$orderBy="nome ASC";
		if($order=="tituloDESC")	$orderBy="nome DESC";
		devolveListaBairros($tipo, $index, $mark, "WHERE deletado='0' AND id!='-1' $where ORDER BY $orderBy", $order, $titulo, "&modo=pesquisa&titulo=$titulo&order=$order&idRegiao=$idRegiao");
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