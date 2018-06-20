<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['corretores'] && $id!="")
{
	include("func.php");

	if($tipo=="" || $tipo=="detalhes")
		$titulo = "Corretores - Detalhes do Corretor";
	elseif($tipo=="editar")
		$titulo = "Corretores - Editar Corretor";
	if($modo=="remover")
		$titulo = "Corretores - Excluir Corretor";

	$linha=devolveInfo("corretor", $id);

	if($modo=="atualizar")
	{
		$retorno=atualizaCorretor($id, $nome, $nomeLogin, $nomeSenha, $email, $telefone, $empresa);
		if($retorno)
			$msg="Atualizado com sucesso";
		else
			$msg="Erro ao atualizar Corretor. Verifique se o login já não está sendo usado.";
		$linha=devolveInfo("corretor", $id);
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
		$retorno=removeCorretor($id, $_SESSION['login']);
		if($retorno)
		{
			devolveMensagem("Corretor excluído com sucesso!", 1);
			print("<br><br><div align='center'><p>Selecione a opção desejada no menu ao lado.</p></div>");
			$codigo="";
			return false;

		}
		else
			$msg="Erro ao remover Corretor";
		$tipo="removido";
	}

	$linha=devolveInfo("corretor", $id);

	if($msg!="")	devolveMensagem($msg, $retorno);
	if($tipo=="detalhes" || $tipo=="")
	{
		$usuarioCadastrou = devolveInfo("usuario", $linha[idUsuarioCadastro]);
		$usuarioCadastrou=$usuarioCadastrou[nome];
		$usuarioAtualizou = devolveInfo("usuario", $linha[idUsuarioAtualizacao]);
		$dataCadastro = converteDataFromMysql($linha[dataCadastro]);
		$dataAtualizacao = converteDataFromMysql($linha[dataAtualizacao]);

		if($linha[dataAtualizacao]=="")	$dataAtualizacao="Sem atualizações.";
		if($linha[idUsuarioAtualizacao]=="0") $usuarioAtualizou="Sem atualizações."; else $usuarioAtualizou=$usuarioAtualizou[nome];


		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='90%' align='right'>
						<a href='index.php?modulo=corretores&acao=corretorinfo&tipo=editar&id=$id' title='Editar Corretor'>
							<div class='app_botao'><img src='imagens/editar.png' border='0' class='icone_botao'> Editar</div>
						</a>
					</td>
					<td align='right'>
						<a href='index.php?modulo=corretores&acao=corretorinfo&tipo=&modo=remover&id=$id' onclick='return confirmaExclusao();' title='Excluir'>
							<div class='app_botao'><img src='imagens/delete.png' border='0' class='icone_botao'> Excluir</div>
						</a>
					</td>
				</tr>
			</table>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th align='left'>Nome</th>
					<th align='left'>Email</th>
				</tr>
				<tr>
					<td align='left'>$linha[nome]</td>
					<td align='left'>$linha[email]</td>
				</tr>
				<tr>
					<th align='left'>Telefone</th>
					<th align='left'>Empresa</th>
				</tr>
				<tr>
					<td align='left'>$linha[telefone]</td>
					<td align='left'>$linha[empresa]</td>
				</tr>
				<!--
				<tr>
					<th align='left'>Login</th>
					<th align='left'>Senha</th>
				</tr>
				<tr>
					<td align='left'>$linha[usuario]</td>
					<td align='left'>$linha[senha]</td>
				</tr>
				-->
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
						<a href='index.php?modulo=corretores&acao=corretorinfo&tipo=&id=$id' title='Ver detalhes'>
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
			function validaLogin(arquivo, valor, corretorAtual)
			{
				if(document.getElementById)
				{
					var obj_msg = document.getElementById("msgLogin");
					var txt = valor.value;
					if (txt.length > 0)
					{
						var ajax = openAjax();
						ajax.open("GET", arquivo + "?login=" + txt + "&loginAtual=" + corretorAtual, true);
						ajax.onreadystatechange = function()
						{
							if(ajax.readyState == 1)
							{
								obj_msg.className = "none";
								obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/aguarde.gif'></div> Aguarde...";
							}
							if(ajax.readyState == 4)
							{
								if(ajax.status == 200)
								{
									var logindisponivel=ajax.responseText;
									if (logindisponivel==1)
									{
										obj_msg.className = "none";
										obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
										login_correto=1;
									}
									else
									{
										obj_msg.className = "errado";
										obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/errado.png'></div> Erro: Login não disponível.";
										login_correto=0;
									}
								}
								else
								{
									obj_msg.className = "obrigatorio";
									obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> Erro: não foi possível realizar a validação.";
									login_correto=0;
								}
							}
						}
						ajax.send(null);
					}
					else
					{
						obj_msg.className = "obrigatorio";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> Login do usuário.";
						login_correto=0;
					}
				}
				else
				{
					obj_msg.className = "errado";
					obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/errado.png'></div> Erro: não foi possível identificar o login.";
					login_correto=0;
				}
			}
			function validaLoginOnSubmit(id, login_correto)
			{
				var obj = document.getElementById(id);
				var txt = obj.value;
				if (txt.length<=0)
				{
					alert("Campo Obrigatório!");
					obj.focus();
					return false;
				}
				if (login_correto==0)
				{
					alert("Login \""+ txt +"\" existente. Por favor, tente outro!");
					obj.focus();
					return false;
				}
				return true;
			}

			var alterar=0;
			var login_correto=1;
		</script>
		<form action="index.php?modulo=corretores&acao=corretorinfo&modo=atualizar&id=<?php print("$linha[id]"); ?>" id="formEditar" name="formEditar" method="post" enctype="multipart/form-data">
			<fieldset>
		    	<legend>Editar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
						<th align="left">Nome:</th>
						<td align="left"><input type="text" name="nome" id="nome" value="<?php print($linha[nome]);?>" maxlength="100" onfocus="validaInputText(this, 'msgNome', 'Nome do corretor.')"  onkeyup="validaInputText(this, 'msgNome', 'Nome do corretor.')"></td>
						<td>
							<div id="msgNome" class="obrigatorio">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Telefone:</th>
						<td align="left"><input type="text" name="telefone" id="telefone"  value="<?php print($linha[telefone]);?>"  maxlength="14" tipo="numerico" mascara="(##) ####-####" onfocus="validaInputText(this, 'msgTelefone', 'Telefone para contato.')"  onkeyup="validaInputText(this, 'msgTelefone', 'Telefone para contato.')"></td>
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
						<th align="left">Empresa:</th>
						<td align="left"><input type="text" name="empresa" id="empresa" maxlength="150" value="<?php print($linha[empresa]);?>" onfocus="validaInputText(this, 'msgEndereco', 'Endereço (Cidade, Rua , Nº).')"  onkeyup="validaInputText(this, 'msgEndereco', 'Endereço (Cidade, Rua , Nº).')"></td>
						<td>
							<div id="msgEndereco" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<!--
					<tr>
						<td>&nbsp;</td>
						<td colspan="2" align="left">
							<input type="checkbox" name="check_alterar" id="check_alterar"
								onclick="if(this.checked){alterar++;show('tr_login'); show('tr_senha'); }else{alterar--;hide('tr_login'); hide('tr_senha');}"
							> Deseja alterar login e senha ?
						</td>
					</tr>
					<tr id="tr_login">
						<th align="left">Login:</th>
						<td align="left"><input type="text" name="nomeLogin" id="nomeLogin"  value="<?php print($linha[usuario]);?>" maxlength="30" onkeyup="validaLogin('validaLoginCorretorEdicao.php', this, <?php print("'$linha[corretor]'"); ?>);"></td>
						<td>
							<div id="msgLogin" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<tr id="tr_senha">
						<th align="left">Nova Senha:</th>
						<td align="left"><input type="text" name="nomeSenha" id="nomeSenha" value="<?php print($linha[senha]);?>"  maxlength="30" onfocus="validaInputText(this, 'msgSenha', 'Entre com uma nova senha.')"  onkeyup="validaInputText(this, 'msgSenha', 'Entre com uma nova senha.')"></td>
						<td>
							<div id="msgSenha" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					-->
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
							<input type="submit" id="form_submit" name="Submit" value="Salvar" onclick="
								if(alterar==1)
								{
									return(campoObrigatorio(nome) && campoObrigatorio(telefone) && validaEmailOnSubmit('email') && campoObrigatorio(empresa) && validaLoginOnSubmit('nomeLogin', login_correto) && campoObrigatorio(nomeSenha));
								}
								else
								{
									return(campoObrigatorio(nome) && campoObrigatorio(telefone) && validaEmailOnSubmit('email') && campoObrigatorio(empresa));
								}
							">
						</td>
					</tr>
				</table>
		    </fieldset>
		</form>
		<script language="javascript">
			document.formEditar.nome.focus();
			hide('tr_login');
			hide('tr_senha');
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