<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['clientes'])
{
	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;
	include("func.php");

	if($tipo=="")	$tipo="cadastrar";

	if($tipo=="cadastrar")	$tituloH1="Clientes - Cadastrar";
	elseif($tipo=="listar")	$tituloH1="Clientes - Listar";

	if($modo=="cadastrar")
	{
		if($nome != "")
		{
			$retorno=adicionaCliente($tipoCliente, $nome, $telefone, $cpf_cnpj, $nacionalidade, converteDataToMysql($dataNascimento), $rg, $orgaoExpedidor, $profissao, $estadoCivil, $regimeCasamento, converteDataToMysql($data), $observacoes,
			$nomeConjuge, $telefoneConjuge, $cpfConjuge, $nacionalidadeConjuge, converteDataToMysql($dataNascimentoConjuge), $rgConjuge, $orgaoExpedidorConjuge, $profissaoConjuge,
			$email, $telefoneComercial, $enderecoComercial, $telefoneResidencial, $enderecoResidencial);
			if($retorno)
			{
				$msg="Cadastrado com sucesso";
				$_POST="";
			}
			else
				$msg="Erro ao cadastrar Cliente.";
		}
	}
	if($modo=="remover")
	{
		$retorno=removeCliente($id);
		if($retorno)
			$msg="Excluído com sucesso";
		else
			$msg="Erro ao remover Cliente";
		$modo="";
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
		<form style="width:500px;" action="index.php?modulo=clientes&acao=clientes&tipo=cadastrar&modo=cadastrar" id="formCadastrar" name="formCadastrar" method="post" enctype="multipart/form-data">
			<fieldset>
		    	<legend>Cliente</legend>
		    	<table width="450" align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
				  		<th width="30%" align="left">Tipo Cliente:</th>
				  		<td align="left">
							<select id="tipoCliente" name="tipoCliente" style="width:85%;">
								<option value="1">Comprador</option>
								<option value="2">Vendedor</option>
							</select> *
						</td>
			 		</tr>
					<tr>
						<th align="left">Nome:</th>
						<td align="left"><input type="text" name="nome" id="nome" maxlength="100"> *</td>
					</tr>
					<tr>
						<th align="left">Telefone:</th>
						<td align="left"><input type="text" name="telefone" id="telefone" maxlength="14" tipo="numerico" mascara="(##) ####-####"></td>
					</tr>
					<tr>
						<th align="left">CPF/CNPJ:</th>
						<td align="left"><input type="text" name="cpf_cnpj" id="cpf_cnpj" maxlength="50"></td>
					</tr>
					<tr>
						<th align="left">Nacionalidade:</th>
						<td align="left"><input type="text" name="nacionalidade" id="nacionalidade" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Data Nascimento:</th>
						<td align="left">
							<input type="text" name="dataNascimento" id="dataNascimento" style="width:225px;" value="" mascara="##/##/####" tipo="numerico">
							<img src="imagens/calendario.gif" id="f_trigger_c" style="cursor: pointer;" width="20" height="20" title="Clique para selecionar a data"/>
							<script type="text/javascript">
								Calendar.setup({
									inputField     :    "dataNascimento",      // id of the input field
									ifFormat       :    "%d/%m/%Y",       // format of the input field
									showsTime      :    false,            // will display a time selector
									button         :    "f_trigger_c",   // trigger for the calendar (button ID)
									singleClick    :    true,           // double-click mode
									step           :    1                // show all years in drop-down boxes (instead of every other year as default)
								});
							</script>
						</td>
					</tr>
					<tr>
						<th align="left">RG:</th>
						<td align="left"><input type="text" name="rg" id="rg" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Org&atilde;o Expedidor:</th>
						<td align="left"><input type="text" name="orgaoExpedidor" id="orgaoExpedidor" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Profiss&atilde;o:</th>
						<td align="left"><input type="text" name="profissao" id="profissao" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Estado Civil:</th>
						<td align="left"><input type="text" name="estadoCivil" id="estadoCivil" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Regime de Casamento:</th>
						<td align="left"><input type="text" name="regimeCasamento" id="regimeCasamento" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Data:</th>
						<td align="left">
							<input type="text" name="data" id="data" style="width:225px;" value="" mascara="##/##/####" tipo="numerico">
							<img src="imagens/calendario.gif" id="f_trigger_d" style="cursor: pointer;" width="20" height="20" title="Clique para selecionar a data"/>
							<script type="text/javascript">
								Calendar.setup({
									inputField     :    "data",      // id of the input field
									ifFormat       :    "%d/%m/%Y",       // format of the input field
									showsTime      :    false,            // will display a time selector
									button         :    "f_trigger_d",   // trigger for the calendar (button ID)
									singleClick    :    true,           // double-click mode
									step           :    1                // show all years in drop-down boxes (instead of every other year as default)
								});
							</script>
						</td>
					</tr>
					<tr>
						<th align="left" valign="top">Observa&ccedil;&otilde;es:</th>
						<td align="left"><textarea name="observacoes" id="observacoes" style="height:150px;"></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
		    	<legend>C&ocirc;njuge</legend>
		    	<table width="450" align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
				  		<th width="30%" align="left">Nome:</th>
						<td align="left"><input type="text" name="nomeConjuge" id="nomeConjuge" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Telefone:</th>
						<td align="left"><input type="text" name="telefoneConjuge" id="telefoneConjuge" maxlength="14" tipo="numerico" mascara="(##) ####-####"></td>
					</tr>
					<tr>
						<th align="left">CPF:</th>
						<td align="left"><input type="text" name="cpfConjuge" id="cpfConjuge" maxlength="50"></td>
					</tr>
					<tr>
						<th align="left">Nacionalidade:</th>
						<td align="left"><input type="text" name="nacionalidadeConjuge" id="nacionalidadeConjuge" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Data Nascimento:</th>
						<td align="left">
							<input type="text" name="dataNascimentoConjuge" id="dataNascimentoConjuge" style="width:225px;" value="" mascara="##/##/####" tipo="numerico">
							<img src="imagens/calendario.gif" id="f_trigger_e" style="cursor: pointer;" width="20" height="20" title="Clique para selecionar a data"/>
							<script type="text/javascript">
								Calendar.setup({
									inputField     :    "dataNascimentoConjuge",      // id of the input field
									ifFormat       :    "%d/%m/%Y",       // format of the input field
									showsTime      :    false,            // will display a time selector
									button         :    "f_trigger_e",   // trigger for the calendar (button ID)
									singleClick    :    true,           // double-click mode
									step           :    1                // show all years in drop-down boxes (instead of every other year as default)
								});
							</script>
						</td>
					</tr>
					<tr>
						<th align="left">RG:</th>
						<td align="left"><input type="text" name="rgConjuge" id="rgConjuge" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Org&atilde;o Expedidor:</th>
						<td align="left"><input type="text" name="orgaoExpedidorConjuge" id="orgaoExpedidorConjuge" maxlength="100"></td>
					</tr>
					<tr>
						<th align="left">Profiss&atilde;o:</th>
						<td align="left"><input type="text" name="profissaoConjuge" id="profissaoConjuge" maxlength="100"></td>
					</tr>
				</table>
		    </fieldset>
		    <fieldset>
		    	<legend>Contato</legend>
		    	<table width="450" align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
				  		<th width="30%" align="left">E-mail:</th>
						<td align="left"><input type="text" name="email" id="email" maxlength="50"></td>
					</tr>
					<tr>
						<th align="left">Telefone Comercial:</th>
						<td align="left"><input type="text" name="telefoneComercial" id="telefoneComercial" maxlength="14" tipo="numerico" mascara="(##) ####-####"></td>
					</tr>
					<tr>
						<th align="left">Endere&ccedil;o Comercial:</th>
						<td align="left"><input type="text" name="enderecoComercial" id="enderecoComercial" maxlength="150"></td>
					</tr>
					<tr>
						<th align="left">Telefone Residencial:</th>
						<td align="left"><input type="text" name="telefoneResidencial" id="telefoneResidencial" maxlength="14" tipo="numerico" mascara="(##) ####-####"></td>
					</tr>
					<tr>
						<th align="left">Endere&ccedil;o Residencial:</th>
						<td align="left"><input type="text" name="enderecoResidencial" id="enderecoResidencial" maxlength="150"></td>
					</tr>
				</table>
		    </fieldset>
	    	<table width="450" align="center" border="0" cellspacing="3" cellpadding="3">
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						<input type="submit" id="form_submit" name="Submit" value="Cadastrar" onclick="return(campoObrigatorio(nome));">
					</td>
				</tr>
			</table>
		</form>
		<script language="javascript">
			document.formCadastrar.tipoCliente.focus();
		</script>
		<?php
	}
	elseif($tipo=="listar")
	{
		if($order=="dataCadastroASC") $orderCadastroASC="selected"; else $orderCadastroASC="";
		if($order=="dataCadastroDESC") $orderCadastroDESC="selected"; else $orderCadastroDESC="";
		if($order=="tituloASC") $orderTituloASC="selected"; else $orderTituloASC="";
		if($order=="tituloDESC") $orderTituloDESC="selected"; else $orderTituloDESC="";

		if($tipoCliente=="")	$sTipoCliente="selected";	else	$sTipoCliente="";
		if($tipoCliente=="1")	$sTipoCliente1="selected";	else	$sTipoCliente1="";
		if($tipoCliente=="2")	$sTipoCliente2="selected";	else	$sTipoCliente2="";

		print("
			<table align='center' width='90%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='80%' align='center' valign='top'>
						<form action='index.php?modulo=clientes&acao=clientes&tipo=listar&modo=pesquisa' method='post'>
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
								  		<th align='left'>Tipo Cliente:</th>
								  		<td align='left'>
											<select id='tipoCliente' name='tipoCliente' style='width:85%;'>
												<option value='' $sTipoCliente>Todos</option>
												<option value='1' $sTipoCliente1>Comprador</option>
												<option value='2' $sTipoCliente2>Vendedor</option>
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
							<table cellpadding='2' cellspacing='2' align='left'>
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
		if($modo=="") $order="dataCadastroASC";

		$where="";
		if($titulo!=""){
			$where.=" AND nome LIKE '%$titulo%' ";
		}
		if($tipoCliente!="")
		{
			$where.=" AND tipoCliente=$tipoCliente ";
		}
		if($order=="dataCadastroASC")	$orderBy="dataCadastro ASC";
		if($order=="dataCadastroDESC")	$orderBy="dataCadastro DESC";
		if($order=="tituloASC")	$orderBy="nome ASC";
		if($order=="tituloDESC")	$orderBy="nome DESC";
		devolveListaClientes($tipo, $index, $mark, "WHERE deletado='0' $where ORDER BY $orderBy", $order, $titulo, "&modo=pesquisa&titulo=$titulo&order=$order&tipoCliente=$tipoCliente");

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