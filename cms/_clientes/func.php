<?php
function alterarStatus($statusAntigo, $codigo)
{
	include("config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else{
		if($statusAntigo==1)	$statusNovo=0;
		elseif($statusAntigo==0)	$statusNovo=1;
		$comando = "UPDATE cliente SET status=$statusNovo, idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now()  WHERE id = $codigo";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if($dados)	return true;
		else	return false;
	}
}
function montaSelectEstado($estado, $branco, $todos, $nomeCombo)
{
	if($estado == "" && $branco == false && $todos == false) $estado = 24;
	if($todos)
		$todosP = "<option value='0' $estadoS0>Todos</option>";
	if($branco)
		$brancoP = "<option value='-1'>Selecione o Estado -->></option>";
	$estadoS = "estadoS$estado";
	$$estadoS = " selected";
	print(
	"
	<select name='estado' id='estado' style='width:255px;' onChange=\"validaSelect(this, 'msgEstado');\">
		$brancoP
		$todosP
		<option value='1' $estadoS1>Acre</option>
		<option value='2' $estadoS2>Alagoas</option>
		<option value='3' $estadoS3>Amapa</option>
		<option value='4' $estadoS4>Amazonas</option>
		<option value='5' $estadoS5>Bahia</option>
		<option value='6' $estadoS6>Cear&aacute;</option>
		<option value='7' $estadoS7>Distrito Federal</option>
		<option value='8' $estadoS8>Esp&iacute;rito Santo</option>
		<option value='9' $estadoS9>Goi&aacute;s</option>
		<option value='10' $estadoS10>Maranh&atilde;o</option>
		<option value='11' $estadoS11>Mato Grosso</option>
		<option value='12' $estadoS12>Mato Grosso do Sul</option>
		<option value='13' $estadoS13>Minas Gerais</option>
		<option value='14' $estadoS14>Par&aacute;</option>
		<option value='15' $estadoS15>Para&iacute;ba</option>
		<option value='16' $estadoS16>Paran&aacute;</option>
		<option value='17' $estadoS17>Pernambuco</option>
		<option value='18' $estadoS18>Piau&iacute;</option>
		<option value='19' $estadoS19>Rio de Janeiro</option>
		<option value='20' $estadoS20>Rio Grande do Norte</option>
		<option value='21' $estadoS21>Rio Grande do Sul</option>
		<option value='22' $estadoS22>Rond&ocirc;nia</option>
		<option value='23' $estadoS23>Roraima</option>
		<option value='24' $estadoS24>Santa Catarina</option>
		<option value='25' $estadoS25>S&atilde;o Paulo</option>
		<option value='26' $estadoS26>Sergipe</option>
		<option value='27' $estadoS27>Tocantins</option>
	</select>


	");
}
function adicionaCliente($tipoCliente, $nome, $telefone, $cpf_cnpj, $nacionalidade, $dataNascimento, $rg, $orgaoExpedidor, $profissao, $estadoCivil, $regimeCasamento, $data, $observacoes,
			$nomeConjuge, $telefoneConjuge, $cpfConjuge, $nacionalidadeConjuge, $dataNascimentoConjuge, $rgConjuge, $orgaoExpedidorConjuge, $profissaoConjuge,
			$email, $telefoneComercial, $enderecoComercial, $telefoneResidencial, $enderecoResidencial)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "INSERT INTO cliente(tipoCliente, nome, telefone, cpf_cnpj, nacionalidade, dataNascimento, rg, orgaoExpedidor, profissao, estadoCivil, regimeCasamento, data, observacoes,
							nomeConjuge, telefoneConjuge, cpfConjuge, nacionalidadeConjuge, dataNascimentoConjuge, rgConjuge, orgaoExpedidorConjuge, profissaoConjuge,
							email, telefoneComercial, enderecoComercial, telefoneResidencial, enderecoResidencial, dataCadastro, idUsuarioCadastro)
					VALUES('$tipoCliente', '$nome', '$telefone', '$cpf_cnpj', '$nacionalidade', '$dataNascimento', '$rg', '$orgaoExpedidor', '$profissao', '$estadoCivil',
						'$regimeCasamento', '$data', '$observacoes', '$nomeConjuge', '$telefoneConjuge', '$cpfConjuge', '$nacionalidadeConjuge', '$dataNascimentoConjuge',
						'$rgConjuge', '$orgaoExpedidorConjuge', '$profissaoConjuge', '$email', '$telefoneComercial', '$enderecoComercial', '$telefoneResidencial', '$enderecoResidencial', now(),
						'$_SESSION[idUsuario]')";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if($dados)	return true;
	}
	return false;
}
function atualizaCliente($tipoCliente, $nome, $telefone, $cpf_cnpj, $nacionalidade, $dataNascimento, $rg, $orgaoExpedidor, $profissao, $estadoCivil, $regimeCasamento, $data, $observacoes,
			$nomeConjuge, $telefoneConjuge, $cpfConjuge, $nacionalidadeConjuge, $dataNascimentoConjuge, $rgConjuge, $orgaoExpedidorConjuge, $profissaoConjuge,
			$email, $telefoneComercial, $enderecoComercial, $telefoneResidencial, $enderecoResidencial, $id)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE cliente SET tipoCliente='$tipoCliente', nome='$nome', telefone='$telefone', cpf_cnpj='$cpf_cnpj', nacionalidade='$nacionalidade', dataNascimento='$dataNascimento', rg='$rg', orgaoExpedidor='$orgaoExpedidor', profissao='$profissao', estadoCivil='$estadoCivil', regimeCasamento='$regimeCasamento', data='$data', observacoes='$observacoes', nomeConjuge='$nomeConjuge', telefoneConjuge='$telefoneConjuge', cpfConjuge='$cpfConjuge', nacionalidadeConjuge='$nacionalidadeConjuge', dataNascimentoConjuge='$dataNascimentoConjuge', rgConjuge='$rgConjuge', orgaoExpedidorConjuge='$orgaoExpedidorConjuge', profissaoConjuge='$profissaoConjuge', email='$email', telefoneComercial='$telefoneComercial', enderecoComercial='$enderecoComercial', telefoneResidencial='$telefoneResidencial', enderecoResidencial='$enderecoResidencial', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$id'";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
function removeCliente($id)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comando = "UPDATE cliente SET deletado='1', idUsuarioAtualizacao='$_SESSION[idUsuario]', dataAtualizacao=now() WHERE id='$id'";
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
function devolveListaClientes($tipo, $index, $mark, $where, $oder, $titulo, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else {
		$comandoSql = "SELECT *, DATE_FORMAT(dataCadastro, '%d/%m/%Y') as dataCadastro FROM cliente $where LIMIT $index,25 ";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				print("<div align='right'>Registros: ($numero encontrados)</div>");
				devolveNavegacao($index, "index.php?modulo=clientes&acao=clientes&tipo=listar", $where, $mark, "cliente", $post);
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='15%'>Tipo</th>
							<th align='left' width='30%'>Nome</th>
							<th align='left' width='25%'>Telefone</th>
							<th align='left' width='25%'>E-mail</th>
							<th colspan='3'>&nbsp;</th>
						</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					if($linha['tipoCliente']==1)	$tipoCliente="Comprador";
					elseif($linha['tipoCliente']==2)	$tipoCliente="Vendedor";
					else $tipoCliente="Não definido";

					print("
						<tr>
							<td title='$linha[dataCadastro]'><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[dataCadastro]</a></td>
							<td title='$tipoCliente'><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$tipoCliente</a></td>
							<td title='$linha[nome]'><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[nome]</a></td>
							<td title='$linha[telefone]'><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[telefone]</a></td>
							<td title='$linha[email]'><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[email]</a></td>
							<td width='24'><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=editar&id=$linha[id]' title='Editar'><img src='imagens/editar.png' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=clientes&acao=clientes&tipo=listar&modo=remover&id=$linha[id]' title='Excluir' onclick='return confirmaExclusao();'><img src='imagens/delete.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=clientes&acao=clientes&tipo=listar", $where, $mark, "cliente", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='30%'>Nome</th>
							<th align='left' width='25%'>Telefone</th>
							<th align='left' width='25%'>E-mail</th>
							<th colspan='3'>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='6'>
								Nenhum registro de clientes cadastrados.
							</td>
						</tr>
					</table>
				");
			}

		}
		else
			print("<center><strong>Erro na exibiçao!</strong></center>");
	}
}
?>