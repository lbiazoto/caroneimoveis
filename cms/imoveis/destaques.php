<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['imoveis'])
{
	include("func.php");

	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;

	if($modo=="adicionarImovelDestaque")
	{
		$retorno=adicionarProdutoDestaque($id);
		if($retorno==true)
			$msg="Imóvel adicionado a lista de Destaque com sucesso!";
		else
			$msg="Erro ao adicionar imóvel a lista de Destaques!";
	}
	if($modo=="removerImovelDestaque")
	{
		$retorno=removerProdutoDestaque($id);
		if($retorno==true)
			$msg="Imóvel removido da lista de Destaque com sucesso!";
		else
			$msg="Erro ao remover imóvel da lista de Destaques!";
	}

	print("
		<h1>
			Imóveis - Destaques
		</h1>
	");

	if($msg!="")	devolveMensagem($msg, $retorno);

	$info=devolveInfo("destaque",1);
	if($order=="dataCadastroASC") $orderCadastroASC="selected"; else $orderCadastroASC="";
	if($order=="dataCadastroDESC") $orderCadastroDESC="selected"; else $orderCadastroDESC="";
	print("
	<h2>Lista de Imóveis em Destaque</h2>
	<table align='center' width='90%' cellpadding='2' cellspacing='2'>
		<tr>
			<td width='80%' align='center' valign='top'>
				<form name='formPesquisa' id='formPesquisa' action='index.php?modulo=imoveis&acao=destaques' method='post'>
					<fieldset>
				    	<legend>Listar</legend>
						<table align = 'center' border = '0' cellpadding='2' cellspacing='2'>
							<tr>
								<th align='left'>Ordenado por:</th>
								<td align='left'>
									<select name='order' id='order'>
										<option value='dataCadastroASC' $orderCadastroASC>Data Cadastro Crescente</option>
										<option value='dataCadastroDESC' $orderCadastroDESC>Data Cadastro Decrescente</option>
									</select>
								</td>
								<td  align='center'><input type='submit' id='form_submit' name='submitPesquisa' value='Pesquisar'></td>
							</tr>
						</table>
					</fieldset>
					<script language='javascript'>
            			document.formPesquisa.order.focus();
            		</script>
				</form>
			</td>
			<td width='20%' align='center' valign='top'>
				<fieldset style='width:150px; text-align:left;'>
					<legend>Legenda</legend>
					<table cellpadding='2' cellspacing='2' align='right'>
						<tr>
							<td align='center' valign='middle'><img src='imagens/delete.png' border='0'></td>
							<td align='left' valign='middle'>Excluir da lista de Destaque</td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
	</table>
	");

	if($order=="") $order="dataCadastroASC";

	$where="";

	if($order=="dataCadastroASC")	$orderBy="id ASC";
	if($order=="dataCadastroDESC")	$orderBy="id DESC";

	devolveListaImoveisDestaques($tipo, $index, $mark, "WHERE deletado='0' AND status='1' AND destaque='1' $where ORDER BY $orderBy", "&titulo=$titulo&order=$order&idCategoria=$idCategoria&idSubCategoria=$idSubCategoria");
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