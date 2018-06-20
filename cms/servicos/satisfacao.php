<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['servicos'])
{
	include("func.php");

	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;

	if($_POST['submitExcluir'])
	{
		$retorno=removeAvaliacao($lista);
		if($retorno==true)
			$msg="Avaliações removidas com sucesso!";
		else
			$msg="Erro ao remover Avaliações!";
	}
	elseif($_POST['submitValidar'])
	{
		$retorno=validaAvaliacao($lista);
		if($retorno==true)
			$msg="Avaliações validadas com sucesso!";
		else
			$msg="Erro ao remover Avaliações!";
	}

	print("
		<h1>
			Serviços - Satisfação dos Serviços
		</h1>
	");

	if($msg!="")	devolveMensagem($msg, $retorno);

	if($order=="dataCadastroASC") $orderCadastroASC="selected"; else $orderCadastroASC="";
	if($order=="dataCadastroDESC") $orderCadastroDESC="selected"; else $orderCadastroDESC="";
	if($order=="tituloASC") $orderTituloASC="selected"; else $orderTituloASC="";
	if($order=="tituloDESC") $orderTituloDESC="selected"; else $orderTituloDESC="";

	if($status=="1") $sel_status1="selected"; else $sel_status1="";
	if($status=="0") $sel_status0="selected"; else $sel_status0="";

	print("
		<table align='center' width='90%' cellpadding='2' cellspacing='2'>
			<tr>
				<td width='80%' align='center' valign='top'>
					<form action='index.php?modulo=servicos&acao=satisfacao' method='post'>
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
									<th align='left'>Avaliações:</th>
									<td align='left'>
										<select name='status' id='status'>
											<option value=''>-- Todas</option>
											<option value='0' $sel_status0>Não Validadas</option>
											<option value='1' $sel_status1>Já Validadas</option>
										</select>
									</td>
								</tr>
								<tr>
							  		<th align='left'>Serviço:</th>
							  		<td align='left'>
										<select id='idServico' name='idServico'>
											<option value=''>-- Todos</option>
											"); montaSelect("servicos", $idServico); print("
										</select>
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
	if($idServico!="")
	{
		$where.=" AND idServico = $idServico ";
	}
	if($status!="")
	{
		$where.=" AND status = $status ";
	}
	if($order=="dataCadastroASC")	$orderBy="id ASC";
	if($order=="dataCadastroDESC")	$orderBy="id DESC";
	if($order=="tituloASC")	$orderBy="nome ASC";
	if($order=="tituloDESC")	$orderBy="nome DESC";
	devolveListaAvaliacoes($index, $mark, "WHERE deletado='0' $where ORDER BY $orderBy", "&idServico=$idServico&order=$order&status=$status");
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