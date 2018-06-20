<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['servicos'])
{
	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;
	include("func.php");

	if($tipo=="")	$tipo="cadastrar";

	if($tipo=="cadastrar")	$tituloH1="Servi�os - Cadastrar";
	elseif($tipo=="listar")	$tituloH1="Servi�os - Listar";

	if($modo=="cadastrar")
	{
		if($nome != "")
		{
			$retorno=adicionaServico($idCategoria, $nome, $descricao, $telefone, $email, $endereco);
			if($retorno)
			{
				$msg="Cadastrado com sucesso";
				$_POST="";
			}
			else
				$msg="Erro ao cadastrar Servi�o.";
		}
	}
	if($modo=="remover")
	{
		$retorno=removeServico($id);
		if($retorno)
			$msg="Exclu�do com sucesso";
		else
			$msg="Erro ao remover Servi�o";
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
		<script language="javascript">
			function validaEmailForm(valor)
			{
				var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
				var obj_msg = document.getElementById("msgEmail");
				var mail = valor.value;

				if(typeof(mail) == "string")
				{
		        	if(er.test(mail))
					{
						obj_msg.className = "none";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
					}
					else
					{
		                obj_msg.className = "obrigatorio";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> E-mail v�lido. (nome@provedor.com)";
		            }
		        }
				else
				{
					if(typeof(mail) == "object")
					{
		                if(er.test(mail.value))
						{
		                    obj_msg.className = "none";
							obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
		                }
		        	}
					else
					{
		                obj_msg.className = "obrigatorio";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> E-mail v�lido. (nome@provedor.com)";
		            }
				}
			}
			function validaEmailOnSubmit(id)
			{
				var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
				var obj = document.getElementById(id);
				var mail = obj.value;
				if(mail == "")
				{
					alert("Campo Obrigat�rio!");
					obj.focus();
					return false;
				}
				if(typeof(mail) == "string")
				{
		        	if(er.test(mail))
					{
						return true;
					}
					else
					{
		                alert("O campo \"E-mail\" deve conter um endere�o eletr�nico v�lido!\nFormato: nome@seuprovedor.com!");
						obj.focus();
						return false;
		            }
		        }
				else
				{
					if(typeof(mail) == "object")
					{
		                if(er.test(mail.value))
						{
		                    return true;
		                }
		        	}
					else
					{
		                alert("O campo \"E-mail\" deve conter um endere�o eletr�nico v�lido!\nFormato: nome@seuprovedor.com!");
						obj.focus();
						return false;
		            }
				}
			}
		</script>
		<form action="index.php?modulo=servicos&acao=servicos&tipo=cadastrar&modo=cadastrar" id="formCadastrar" name="formCadastrar" method="post" enctype="multipart/form-data">
			<fieldset>
		    	<legend>Cadastrar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
				  		<th align="left">Categoria:</th>
				  		<td align="left">
							<select id="idCategoria" name="idCategoria">
								<?php montaSelect("categoriaservicos", $idCategoria); ?>
							</select>
						</td>
						<td>
							<div id="msgCategoria" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
			 		</tr>
					<tr>
						<th align="left">Nome:</th>
						<td align="left"><input type="text" name="nome" id="nome" maxlength="100" onfocus="validaInputText(this, 'msgNome', 'Entre com o nome do respons�vel.')"  onkeyup="validaInputText(this, 'msgNome', 'Entre com o nome do respons�vel.')"></td>
						<td>
							<div id="msgNome" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left" valign="top">Descri&ccedil;&atilde;o:</th>
						<td align="left"><textarea name="descricao" id="descricao" onfocus="validaInputText(this, 'msgDescricao', 'Descreva o servi�o.')"  onkeyup="validaInputText(this, 'msgDescricao', 'Descreva o servi�o.')"></textarea></td>
						<td valign="top">
							<div id="msgDescricao" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Telefone:</th>
						<td align="left"><input type="text" name="telefone" id="telefone" maxlength="14" tipo="numerico" mascara="(##) ####-####" onfocus="validaInputText(this, 'msgTelefone', 'Telefone para contato.')" onkeyup="validaInputText(this, 'msgTelefone', 'Telefone para contato.')" onkeydown="validaInputText(this, 'msgTelefone', 'Telefone para contato.')" onblur="validaInputText(this, 'msgTelefone', 'Telefone para contato.')"></td>
						<td>
							<div id="msgTelefone" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">E-mail:</th>
						<td align="left"><input type="text" name="email" id="email" maxlength="50" onfocus="validaEmailForm(this)"  onkeyup="validaEmailForm(this)"></td>
						<td>
							<div id="msgEmail" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Endere&ccedil;o:</th>
						<td align="left"><input type="text" name="endereco" id="endereco" maxlength="150" onfocus="validaInputText(this, 'msgEndereco', 'Endere�o (Cidade, Rua , N�).')"  onkeyup="validaInputText(this, 'msgEndereco', 'Endere�o (Cidade, Rua , N�).')"></td>
						<td>
							<div id="msgEndereco" class="none">
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
					<tr>
						<td colspan="3" align="center">
							<input type="submit" id="form_submit" name="Submit" value="Cadastrar" onclick="
								return(campoObrigatorio(nome) && campoObrigatorio(telefone) && validaEmailOnSubmit('email') && campoObrigatorio(endereco));
							">
						</td>
					</tr>
				</table>
		    </fieldset>
		</form>
		<script language="javascript">
			document.formCadastrar.idCategoria.focus();
		</script>
		<?php
	}
	elseif($tipo=="listar")
	{
		if($order=="dataCadastroASC") $orderCadastroASC="selected"; else $orderCadastroASC="";
		if($order=="dataCadastroDESC") $orderCadastroDESC="selected"; else $orderCadastroDESC="";
		if($order=="tituloASC") $orderTituloASC="selected"; else $orderTituloASC="";
		if($order=="tituloDESC") $orderTituloDESC="selected"; else $orderTituloDESC="";
		print("
			<table align='center' width='90%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='80%' align='center' valign='top'>
						<form action='index.php?modulo=servicos&acao=servicos&tipo=listar&modo=pesquisa' method='post'>
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
		if($order=="dataCadastroASC")	$orderBy="dataCadastro ASC";
		if($order=="dataCadastroDESC")	$orderBy="dataCadastro DESC";
		if($order=="tituloASC")	$orderBy="nome ASC";
		if($order=="tituloDESC")	$orderBy="nome DESC";
		devolveListaServicos($tipo, $index, $mark, "WHERE deletado='0' $where ORDER BY $orderBy", $order, $titulo, "&modo=pesquisa&titulo=$titulo&order=$order");

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