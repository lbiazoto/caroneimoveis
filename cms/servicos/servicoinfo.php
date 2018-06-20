<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['servicos'] && $id!="")
{
	include("func.php");

	if($tipo=="" || $tipo=="detalhes")
		$titulo = "Serviços - Detalhes do Serviço";
	elseif($tipo=="editar")
		$titulo = "Serviços - Editar Serviço";
	if($modo=="remover")
		$titulo = "Serviços - Excluir Serviço";

	$linha=devolveInfo("servicos", $id);

	if($modo=="atualizar")
	{
		$retorno=atualizaServico($id, $idCategoria, $nome, $descricao, $email, $telefone, $endereco);
		if($retorno)
			$msg="Atualizado com sucesso";
		else
			$msg="Erro ao atualizar Serviço.";
		$linha=devolveInfo("servicos", $id);
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
		$retorno=removeServico($id, $_SESSION['login']);
		if($retorno)
		{
			devolveMensagem("Serviço excluído com sucesso!", 1);
			print("<br><br><div align='center'><p>Selecione a opção desejada no menu ao lado.</p></div>");
			$codigo="";
			return false;

		}
		else
			$msg="Erro ao remover Serviço";
		$tipo="removido";
	}

	$linha=devolveInfo("servicos", $id);

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

		$cat=devolveInfo("categoriaservicos", $linha['idCategoria']);

		$descricao=nl2br($linha['descricao']);

		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='90%' align='right'>
						<a href='index.php?modulo=servicos&acao=servicoinfo&tipo=editar&id=$id' title='Editar Serviço'>
							<div class='app_botao'><img src='imagens/editar.png' border='0' class='icone_botao'> Editar</div>
						</a>
					</td>
					<td align='right'>
						<a href='index.php?modulo=servicos&acao=servicoinfo&tipo=&modo=remover&id=$id' onclick='return confirmaExclusao();' title='Excluir'>
							<div class='app_botao'><img src='imagens/delete.png' border='0' class='icone_botao'> Excluir</div>
						</a>
					</td>
				</tr>
			</table>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th align='left'>Nome</th>
					<th align='left'>E-mail</th>
				</tr>
				<tr>
					<td align='left'>$linha[nome]</td>
					<td align='left'>$linha[email]</td>
				</tr>
				<tr>
					<th colspan='2' align='left'>Categoria</th>
				</tr>
				<tr>
					<td colspan='2' align='left'>$cat[nome]</td>
				</tr>
				<tr>
					<th align='left'>Telefone</th>
					<th align='left'>Endereço</th>
				</tr>
				<tr>
					<td align='left'>$linha[telefone]</td>
					<td align='left'>$linha[endereco]</td>
				</tr>
				<tr>
					<th colspan='2' align='left'>Descrição do Serviço</th>
				</tr>
				<tr>
					<td colspan='2' align='left'>$descricao</td>
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
						<a href='index.php?modulo=servicos&acao=servicoinfo&tipo=&id=$id' title='Ver detalhes'>
							<div class='app_botao'><img src='imagens/ver_detalhes.png' border='0' class='icone_botao'> Ver detalhes</div>
						</a>
					</td>
				</tr>
			</table>
		");
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
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> E-mail válido. (nome@provedor.com)";
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
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> E-mail válido. (nome@provedor.com)";
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
					alert("Campo Obrigatório!");
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
		                alert("O campo \"E-mail\" deve conter um endereço eletrônico válido!\nFormato: nome@seuprovedor.com!");
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
		                alert("O campo \"E-mail\" deve conter um endereço eletrônico válido!\nFormato: nome@seuprovedor.com!");
						obj.focus();
						return false;
		            }
				}
			}
		</script>
		<form action="index.php?modulo=servicos&acao=servicoinfo&modo=atualizar&id=<?php print("$linha[id]"); ?>" id="formEditar" name="formEditar" method="post" enctype="multipart/form-data">
			<fieldset>
		    	<legend>Editar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
				  		<th align="left">Categoria:</th>
				  		<td align="left">
							<select id="idCategoria" name="idCategoria">
								<?php montaSelect("categoriaservicos", $linha['idCategoria']); ?>
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
						<td align="left"><input type="text" name="nome" id="nome" value="<?php print($linha[nome]);?>" maxlength="100" onfocus="validaInputText(this, 'msgNome', 'Nome do usuário.')"  onkeyup="validaInputText(this, 'msgNome', 'Nome do usuário.')"></td>
						<td>
							<div id="msgNome" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left" valign="top">Descri&ccedil;&atilde;o:</th>
						<td align="left"><textarea name="descricao" id="descricao" onfocus="validaInputText(this, 'msgDescricao', 'Descreva o serviço.')"  onkeyup="validaInputText(this, 'msgDescricao', 'Descreva o serviço.')"><?php print($linha['descricao']);?></textarea></td>
						<td valign="top">
							<div id="msgDescricao" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Telefone:</th>
						<td align="left"><input type="text" name="telefone" id="telefone"  value="<?php print($linha[telefone]);?>"  maxlength="14" tipo="numerico" mascara="(##) ####-####" onfocus="validaInputText(this, 'msgTelefone', 'Telefone para contato.')"  onkeyup="validaInputText(this, 'msgTelefone', 'Telefone para contato.')"  onkeydown="validaInputText(this, 'msgTelefone', 'Telefone para contato.')"></td>
						<td>
							<div id="msgTelefone" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">E-mail:</th>
						<td align="left"><input type="text" name="email" id="email" maxlength="50" value="<?php print($linha[email]);?>" onfocus="validaEmail(this)"  onkeyup="validaEmail(this)"></td>
						<td>
							<div id="msgEmail" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Endere&ccedil;o:</th>
						<td align="left"><input type="text" name="endereco" id="endereco" maxlength="150" value="<?php print($linha[endereco]);?>" onfocus="validaInputText(this, 'msgEndereco', 'Endereço (Cidade, Rua , Nº).')"  onkeyup="validaInputText(this, 'msgEndereco', 'Endereço (Cidade, Rua , Nº).')"></td>
						<td>
							<div id="msgEndereco" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
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
							<input type="submit" id="form_submit" name="Submit" value="Salvar" onclick="return(campoObrigatorio(nome) && campoObrigatorio(telefone) && validaEmailOnSubmit('email') && campoObrigatorio(endereco));">
						</td>
					</tr>
				</table>
		    </fieldset>
		</form>
		<script language="javascript">
			document.formEditar.idCategoria.focus();
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