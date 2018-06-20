<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['avisos'])
{
	include("func.php");

	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;

	print("
		<h1>
			Avisos - Lista de aniversariantes
		</h1>
	");

	if($order=="dataCadastroASC") $orderCadastroASC="selected"; else $orderCadastroASC="";
	if($order=="dataCadastroDESC") $orderCadastroDESC="selected"; else $orderCadastroDESC="";
	if($order=="tituloASC") $orderTituloASC="selected"; else $orderTituloASC="";
	if($order=="tituloDESC") $orderTituloDESC="selected"; else $orderTituloDESC="";
	print("
	<table align='center' width='100%' cellpadding='2' cellspacing='2'>
		<tr>
			<td align='center' valign='top'>
				<form action='index.php?modulo=avisos&acao=aniversariantes&tipo=listar' method='post'>
					<fieldset>
				    	<legend>Listar</legend>
						<table align = 'center' border = '0' cellpadding='2' cellspacing='2'>
							<tr>
								<th align='left'>Ordenado por:</th>
								<td align='left'>
									<select name='order' id='order'>
										<option value='dataCadastroASC' $orderCadastroASC>Data Aniversário Crescente</option>
										<option value='dataCadastroDESC' $orderCadastroDESC>Data Aniversário Decrescente</option>
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
								<th align='left'>Data de Aniversário (dia / mês):</th>
								<td align='left'>
                                    <input style='width:100px;' name='dataIni' value='$dataIni' type='text' id='dataIni' tipo='numerico' mascara='##/##' onfocus='onChangeFocus(this);' onblur='onLostFocus(this);'>
                                    à
                                    <input style='width:100px;' name='dataFim' value='$dataFim' type='text' id='dataFim' tipo='numerico' mascara='##/##' onfocus='onChangeFocus(this);' onblur='onLostFocus(this);'>
                                </td>
							</tr>
							<tr>
								<td colspan='2' align='center'><input type='submit' id='form_submit' name='submitPesquisa' value='Pesquisar'></td>
							</tr>
						</table>
					</fieldset>
				</form>
			</td>
		</tr>
	</table>
	");

	if($order=="") $order="dataCadastroASC";

	$where="";
	if($titulo!=""){
		$where.=" AND nome LIKE '%$titulo%' ";
	}
	if($dataIni!=""){
    	$datafiltro=explode("/", $dataIni);
		$where.=" AND DAY(dataNascimento) >= '$datafiltro[0]' ";
        $where.=" AND MONTH(dataNascimento) >= '$datafiltro[1]' ";
	}
	if($dataFim!=""){
    	$datafiltro=explode("/", $dataFim);
		$where.=" AND DAY(dataNascimento) <= '$datafiltro[0]' ";
        $where.=" AND MONTH(dataNascimento) <= '$datafiltro[1]' ";
	}
	if($order=="dataCadastroASC")	$orderBy="dataNascimento ASC";
	if($order=="dataCadastroDESC")	$orderBy="dataNascimento DESC";
	if($order=="tituloASC")	$orderBy="nome ASC";
	if($order=="tituloDESC")	$orderBy="nome DESC";
	devolveListaAniversariantes($index, $mark, "WHERE deletado='0' $where AND dataNascimento!='0000-00-00' ORDER BY $orderBy", "&dataFim=$dataFim&dataIni=$dataIni&titulo=$titulo&order=$order");
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