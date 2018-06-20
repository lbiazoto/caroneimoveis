<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['clientes'] && $id!="")
{
	include("func.php");

	if($tipo=="" || $tipo=="detalhes")
		$titulo = "Clientes - Detalhes do Cliente";
	elseif($tipo=="editar")
		$titulo = "Clientes - Editar Cliente";
	if($modo=="remover")
		$titulo = "Clientes - Excluir Cliente";

	$linha=devolveInfo("cliente", $id);

	if($modo=="atualizar")
	{
		$retorno=atualizaCliente($tipoCliente, $nome, $telefone, $cpf_cnpj, $nacionalidade, converteDataToMysql($dataNascimento), $rg, $orgaoExpedidor, $profissao, $estadoCivil, $regimeCasamento, converteDataToMysql($data), $observacoes,
			$nomeConjuge, $telefoneConjuge, $cpfConjuge, $nacionalidadeConjuge, converteDataToMysql($dataNascimentoConjuge), $rgConjuge, $orgaoExpedidorConjuge, $profissaoConjuge,
			$email, $telefoneComercial, $enderecoComercial, $telefoneResidencial, $enderecoResidencial, $id);
		if($retorno)
			$msg="Atualizado com sucesso";
		else
			$msg="Erro ao atualizar Cliente.";
		$linha=devolveInfo("cliente", $id);
	}
	if($modo == "alterarStatus")
	{
		$retorno=alterarStatus($status, $id);
		if($retorno)
			$msg="Status alterado com sucesso";
		else
			$msg="Erro ao alterar status.";
	}
	////////////////
	print("
		<h1>
			$titulo
		</h1>
	");
	////////////////
	if($modo=="remover")
	{
		$retorno=removeCliente($id, $_SESSION['login']);
		if($retorno)
		{
			devolveMensagem("Cliente excluído com sucesso!", 1);
			print("<br><br><div align='center'><p>Selecione a opção desejada no menu ao lado.</p></div>");
			$codigo="";
			return false;

		}
		else
			$msg="Erro ao remover Cliente";
		$tipo="removido";
	}

	$linha=devolveInfo("cliente", $id);

	if($msg!="")	devolveMensagem($msg, $retorno);
	if($tipo=="detalhes" || $tipo=="")
	{
		$usuarioCadastrou = devolveInfo("usuario", $linha[idUsuarioCadastro]);
		$usuarioCadastrou=$usuarioCadastrou[nome];
		$usuarioAtualizou = devolveInfo("usuario", $linha[idUsuarioAtualizacao]);
		$dataCadastro = converteDataFromMysql($linha[dataCadastro]);
		$dataAtualizacao = converteDataFromMysql($linha[dataAtualizacao]);

		if($linha[dataAtualizacao]=="")	$dataAtualizacao="Sem atualizações.";
		if($linha[idUsuarioAtualizacao]=="") $usuarioAtualizou="Sem atualizações."; else $usuarioAtualizou=$usuarioAtualizou[nome];

		$dataNascimentoConjuge=converteDataFromMysql($linha['dataNascimentoConjuge']);
		$dataNascimento=converteDataFromMysql($linha['dataNascimento']);
		$data=converteDataFromMysql($linha['data']);
		$img_status="<img src='imagens/status$linha[status].png' border='0' class='icone_botao'>";
		if($linha[status]==0)
		{
			$title_status="Bloqueado. Clique para Liberar.";
			$status="Bloqueado";
			$img_status_btn="<img src='imagens/status0.png' border='0' class='icone_botao'>";
		}
		else
		{
			$img_status_btn="<img src='imagens/status1.png' border='0' class='icone_botao'>";
			$title_status="Liberado. Clique para Bloquear.";
			$status="Liberado";
		}
		$tipoCliente = devolveInfo("tipoCliente", $linha['tipoCliente']);
		$observacoes=nl2br($linha['observacoes']);
		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='80%' align='right'>
						<a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&modo=alterarStatus&status=$linha[status]&id=$linha[id]' title='$title_status'>
							<div class='app_botao'>$img_status_btn $status</div>
						</a>
					</td>
					<td width='10%' align='right'>
						<a href='index.php?modulo=clientes&acao=clienteinfo&tipo=editar&id=$id' title='Editar Cliente'>
							<div class='app_botao'><img src='imagens/editar.png' border='0' class='icone_botao'> Editar</div>
						</a>
					</td>
					<td align='right'>
						<a href='index.php?modulo=clientes&acao=clienteinfo&tipo=&modo=remover&id=$id' onclick='return confirmaExclusao();' title='Excluir'>
							<div class='app_botao'><img src='imagens/delete.png' border='0' class='icone_botao'> Excluir</div>
						</a>
					</td>
				</tr>
			</table>
			<h1>Cliente</h1>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th width='50%' align='left'>Nome</th>
					<th width='50%' align='left'>Tipo Cliente</th>
				</tr>
				<tr>
					<td align='left'>$linha[nome]</td>
					<td align='left'>$tipoCliente[nome]</td>
				</tr>
				<tr>
					<th align='left'>CPF / CNPJ</th>
					<th align='left'>RG (Orgão Expedidor)</th>
				</tr>
				<tr>
					<td align='left'>$linha[cpf_cnpj]</td>
					<td align='left'>$linha[rg] ($linha[orgaoExpedidor])</td>
				</tr>
				<tr>
					<th align='left'>Data Nascimento</th>
					<th align='left'>Nacionalidade</th>
				</tr>
				<tr>
					<td align='left'>$dataNascimento</td>
					<td align='left'>$linha[nacionalidade]</td>
				</tr>
				<tr>
					<th align='left'>Profissão</th>
					<th align='left'>Estado Civil</th>
				</tr>
				<tr>
					<td align='left'>$linha[profissao]</td>
					<td align='left'>$linha[estadoCivil]</td>
				</tr>
				<tr>
					<th align='left'>Regime de Casamento</th>
					<th align='left'>Data</th>
				</tr>
				<tr>
					<td align='left'>$linha[regimeCasamento]</td>
					<td align='left'>$data</td>
				</tr>
				<tr>
					<th align='left' colspan='2'>Observações</th>
				</tr>
				<tr>
					<td align='left' colspan='2'>$observacoes</td>
				</tr>
			</table>
			<h1>Cônjuge</h1>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th width='50%' align='left'>Nome</th>
					<th width='50%' align='left'>Telefone</th>
				</tr>
				<tr>
					<td align='left'>$linha[nomeConjuge]</td>
					<td align='left'>$linha[telefoneConjuge]</td>
				</tr>
				<tr>
					<th align='left'>CPF / CNPJ</th>
					<th align='left'>RG (Orgão Expedidor)</th>
				</tr>
				<tr>
					<td align='left'>$linha[cpfConjuge]</td>
					<td align='left'>$linha[rgConjuge] ($linha[orgaoExpedidorConjuge])</td>
				</tr>
				<tr>
					<th align='left'>Data Nascimento</th>
					<th align='left'>Nacionalidade</th>
				</tr>
				<tr>
					<td align='left'>$dataNascimentoConjuge</td>
					<td align='left'>$linha[nacionalidadeConjuge]</td>
				</tr>
				<tr>
					<th align='left' colspan='2'>Profissão</th>
				</tr>
				<tr>
					<td align='left' colspan='2'>$linha[profissaoConjuge]</td>
				</tr>
			</table>
			<h1>Contato e Dados do sistema</h1>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th align='left'>Endereço Comercial</th>
					<th align='left'>Endereço Residencial</th>
				</tr>
				<tr>
					<td align='left'>$linha[enderecoComercial]</td>
					<td align='left'>$linha[enderecoResidencial]</td>
				</tr>
				<tr>
					<th align='left'>Telefone Comercial</th>
					<th align='left'>Telefone Residencial</th>
				</tr>
				<tr>
					<td align='left'>$linha[telefoneComercial]</td>
					<td align='left'>$linha[telefoneResidencial]</td>
				</tr>
				<tr>
					<th align='left' colspan='2'>E-mail</th>
				</tr>
				<tr>
					<td align='left' colspan='2'>$linha[email]</td>
				</tr>
				<tr>
					<th align='left'>Data Cadastro</th>
					<th align='left'>Data Atualização</th>
				</tr>
				<tr>
					<td align='left'>$dataCadastro</td>
					<td align='left'>$dataAtualizacao</td>
				</tr>
				<tr>
					<th align='left'>Usuário Cadastro</th>
					<th align='left'>Usuário Atualização</th>
				</tr>
				<tr>
					<td align='left'>$usuarioCadastrou</td>
					<td align='left'>$usuarioAtualizou</td>
				</tr>
			</table>
		");
	}
	elseif($tipo=="editar")
	{
		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td align='right'>
						<a href='index.php?modulo=clientes&acao=clienteinfo&tipo=&id=$id' title='Ver detalhes'>
							<div class='app_botao'><img src='imagens/ver_detalhes.png' border='0' class='icone_botao'> Ver detalhes</div>
						</a>
					</td>
				</tr>
			</table>
		");
		$dataNascimentoConjuge=converteDataFromMysql($linha['dataNascimentoConjuge']);
		$dataNascimento=converteDataFromMysql($linha['dataNascimento']);
		$data=converteDataFromMysql($linha['data']);
		?>
		<form style="width:500px;" action="index.php?modulo=clientes&acao=clienteinfo&modo=atualizar&id=<?php print("$linha[id]"); ?>" id="formEditar" name="formEditar" method="post" enctype="multipart/form-data">
			<fieldset>
		    	<legend>Cliente</legend>
		    	<table width="450" align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
				  		<th width="30%" align="left">Tipo Cliente:</th>
				  		<td align="left">
							<select id="tipoCliente" name="tipoCliente" style="width:85%;">
								<option value="1" <?php if($linha['tipoCliente']==1)	print("selected");?>>Comprador</option>
								<option value="2" <?php if($linha['tipoCliente']==2)	print("selected");?>>Vendedor</option>
							</select> *
						</td>
			 		</tr>
					<tr>
						<th align="left">Nome:</th>
						<td align="left"><input type="text" name="nome" id="nome" maxlength="100" value="<?php print($linha['nome']);?>"></td>
					</tr>
					<tr>
						<th align="left">Telefone:</th>
						<td align="left"><input type="text" name="telefone" id="telefone" maxlength="14" value="<?php print($linha['telefone']);?>" tipo="numerico" mascara="(##) ####-####"></td>
					</tr>
					<tr>
						<th align="left">CPF/CNPJ:</th>
						<td align="left"><input type="text" name="cpf_cnpj" id="cpf_cnpj" maxlength="50" value="<?php print($linha['cpf_cnpj']);?>"></td>
					</tr>
					<tr>
						<th align="left">Nacionalidade:</th>
						<td align="left"><input type="text" name="nacionalidade" id="nacionalidade" maxlength="100" value="<?php print($linha['nacionalidade']);?>"></td>
					</tr>
					<tr>
						<th align="left">Data Nascimento:</th>
						<td align="left">
							<input type="text" name="dataNascimento" id="dataNascimento" style="width:225px;"  value="<?php print($dataNascimento);?>" tipo="numerico" mascara="##/##/####">
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
						<td align="left"><input type="text" name="rg" id="rg" maxlength="100" value="<?php print($linha['rg']);?>"></td>
					</tr>
					<tr>
						<th align="left">Org&atilde;o Expedidor:</th>
						<td align="left"><input type="text" name="orgaoExpedidor" id="orgaoExpedidor" maxlength="100" value="<?php print($linha['orgaoExpedidor']);?>"></td>
					</tr>
					<tr>
						<th align="left">Profiss&atilde;o:</th>
						<td align="left"><input type="text" name="profissao" id="profissao" maxlength="100" value="<?php print($linha['profissao']);?>"></td>
					</tr>
					<tr>
						<th align="left">Estado Civil:</th>
						<td align="left"><input type="text" name="estadoCivil" id="estadoCivil" maxlength="100" value="<?php print($linha['estadoCivil']);?>"></td>
					</tr>
					<tr>
						<th align="left">Regime de Casamento:</th>
						<td align="left"><input type="text" name="regimeCasamento" id="regimeCasamento" maxlength="100" value="<?php print($linha['regimeCasamento']);?>"></td>
					</tr>
					<tr>
						<th align="left">Data:</th>
						<td align="left">
							<input type="text" name="data" id="data" style="width:225px;"  value="<?php print($data);?>" tipo="numerico" mascara="##/##/####">
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
						<td align="left"><textarea name="observacoes" id="observacoes" style="height:150px;"><?php print($linha['observacoes']);?></textarea></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
		    	<legend>C&ocirc;njuge</legend>
		    	<table width="450" align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
				  		<th width="30%" align="left">Nome:</th>
						<td align="left"><input type="text" name="nomeConjuge" id="nomeConjuge" maxlength="100" value="<?php print($linha['nomeConjuge']);?>"></td>
					</tr>
					<tr>
						<th align="left">Telefone:</th>
						<td align="left"><input type="text" name="telefoneConjuge" id="telefoneConjuge" maxlength="14" value="<?php print($linha['telefoneConjuge']);?>" tipo="numerico" mascara="(##) ####-####"></td>
					</tr>
					<tr>
						<th align="left">CPF:</th>
						<td align="left"><input type="text" name="cpfConjuge" id="cpfConjuge" maxlength="50" value="<?php print($linha['cpfConjuge']);?>"></td>
					</tr>
					<tr>
						<th align="left">Nacionalidade:</th>
						<td align="left"><input type="text" name="nacionalidadeConjuge" id="nacionalidadeConjuge" maxlength="100" value="<?php print($linha['nacionalidadeConjuge']);?>"></td>
					</tr>
					<tr>
						<th align="left">Data Nascimento:</th>
						<td align="left">
							<input type="text" name="dataNascimentoConjuge" id="dataNascimentoConjuge" style="width:225px;"  value="<?php print($dataNascimentoConjuge);?>" tipo="numerico" mascara="##/##/####">
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
						<td align="left"><input type="text" name="rgConjuge" id="rgConjuge" maxlength="100" value="<?php print($linha['rgConjuge']);?>"></td>
					</tr>
					<tr>
						<th align="left">Org&atilde;o Expedidor:</th>
						<td align="left"><input type="text" name="orgaoExpedidorConjuge" id="orgaoExpedidorConjuge" maxlength="100" value="<?php print($linha['orgaoExpedidorConjuge']);?>"></td>
					</tr>
					<tr>
						<th align="left">Profiss&atilde;o:</th>
						<td align="left"><input type="text" name="profissaoConjuge" id="profissaoConjuge" maxlength="100" value="<?php print($linha['profissaoConjuge']);?>"></td>
					</tr>
				</table>
		    </fieldset>
		    <fieldset>
		    	<legend>Contato</legend>
		    	<table width="450" align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
				  		<th width="30%" width="25%" align="left">E-mail:</th>
						<td align="left"><input type="text" name="email" id="email" maxlength="50" value="<?php print($linha['email']);?>"></td>
					</tr>
					<tr>
						<th align="left">Telefone Comercial:</th>
						<td align="left"><input type="text" name="telefoneComercial" id="telefoneComercial" maxlength="14" tipo="numerico" mascara="(##) ####-####" value="<?php print($linha['telefoneComercial']);?>"></td>
					</tr>
					<tr>
						<th align="left">Endere&ccedil;o Comercial:</th>
						<td align="left"><input type="text" name="enderecoComercial" id="enderecoComercial" maxlength="150" value="<?php print($linha['enderecoComercial']);?>"></td>
					</tr>
					<tr>
						<th align="left">Telefone Residencial:</th>
						<td align="left"><input type="text" name="telefoneResidencial" id="telefoneResidencial" maxlength="14" tipo="numerico" mascara="(##) ####-####" value="<?php print($linha['telefoneResidencial']);?>"></td>
					</tr>
					<tr>
						<th align="left">Endere&ccedil;o Residencial:</th>
						<td align="left"><input type="text" name="enderecoResidencial" id="enderecoResidencial" maxlength="150" value="<?php print($linha['enderecoResidencial']);?>"></td>
					</tr>
				</table>
		    </fieldset>
	    	<table width="450" align="center" border="0" cellspacing="3" cellpadding="3">
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						<input type="submit" id="form_submit" name="Submit" value="Salvar" onclick="return(campoObrigatorio(nome));">
					</td>
				</tr>
			</table>
		</form>
		<script language="javascript">
			document.formEditar.tipoCliente.focus();
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