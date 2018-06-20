<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['opcoes'])
{
	include("func.php");

	$titulo = "Opções - Meus Dados";

	$linha=devolveInfo("usuario", $_SESSION['idUsuario']);
	if($linha[deletado]==1)
		$tipo="removido";

	if($modo=="atualizar")
	{
		$retorno=atualizaUsuario($id, $nome, $nomeLogin, $nomeSenha, $email, $idModuloInicial, $_SESSION['login']);
		if($retorno)
			$msg="Atualizado com sucesso";
		else
			$msg="Erro ao atualizar Usuário. Verifique se o login já não está sendo usado.";
		$linha=devolveInfo("usuario", $id);
	}
	////////////////
	print("
		<h1>
			$titulo
		</h1>
	");
	////////////////
	if($msg!="")	devolveMensagem($msg, $retorno);

	if($tipo=="detalhes" || $tipo=="")
	{
		$moduloInicial=devolveInfo("modulos", $linha[moduloInicial]);

		$usuarioCadastrou = devolveInfo("usuario", $linha[idUsuarioCadastro]);
		$usuarioCadastrou=$usuarioCadastrou[nome];
		$usuarioAtualizou = devolveInfo("usuario", $linha[idUsuarioAtualizacao]);
		$dataCadastro = converteDataFromMysql($linha[dataCadastro]);
		$dataAtualizacao = converteDataFromMysql($linha[dataAtualizacao]);

		if($linha[dataAtualizacao]=="" || $linha[dataAtualizacao]=="0000-00-00")	$dataAtualizacao="Sem atualizações.";
		if($linha[idUsuarioAtualizacao]=="0") $usuarioAtualizou="Sem atualizações."; else $usuarioAtualizou=$usuarioAtualizou[nome];
		print("
			<table width='100%' cellpadding='2' cellspacing='2'>
				<tr>
					<td width='90%' align='right'>
						<a href='index.php?modulo=opcoes&acao=meusDados&tipo=editar&id=$id' title='Editar do Usuário'>
							<div class='app_botao'><img src='imagens/editar.png' border='0' class='icone_botao'> Editar</div>
						</a>
					</td>
				</tr>
			</table>
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th>Nome</th>
					<th>Email</th>
				</tr>
				<tr>
					<td>$linha[nome]</td>
					<td>$linha[email]</td>
				</tr>
				<tr>
					<th>Usuário</th>
					<th>Senha</th>
				</tr>
				<tr>
					<td>$linha[usuario]</td>
					<td>$linha[senha]</td>
				</tr>
				<tr>
					<th colspan='2'>Módulo Inicial</th>
				</tr>
				<tr>
					<td colspan='2'>$moduloInicial[fantasia]</td>
				</tr>
				<tr>
					<th colspan='2'>Acessos Permitidos</th>
				</tr>
				<tr>
					<td colspan='2'>"); devolveModulosPermitidos($linha[id]); print("</td>
				</tr>
				<tr>
					<th>Data Cadastro</th>
					<th>Data Atualização</th>
				</tr>
				<tr>
					<td>$dataCadastro</td>
					<td>$dataAtualizacao</td>
				</tr>
				<tr>
					<th>Usuário Cadastro</th>
					<th>Usuário Atualização</th>
				</tr>
				<tr>
					<td>$usuarioCadastrou</td>
					<td>$usuarioAtualizou</td>
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
						<a href='index.php?modulo=opcoes&acao=meusDados&tipo=&id=$id' title='Ver detalhes do Usuário'>
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
			function validaModulos(valor)
			{
				var obj_msg = document.getElementById("msgModulos");
				obj_msg.className = "none";
				obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
			}
			function validaLogin(arquivo, valor, usuarioAtual)
			{
				if(document.getElementById)
				{
					var obj_msg = document.getElementById("msgLogin");
					var txt = valor.value;
					if (txt.length > 0)
					{
						var ajax = openAjax();
						ajax.open("GET", arquivo + "?login=" + txt + "&loginAtual=" + usuarioAtual, true);
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
			function validaSenhaConfirm(valor, senhaAtual)
			{
				var obj_msg = document.getElementById("msgSenhaConfirm");
				var txt = valor.value;
				if (txt.length > 0)
				{
					if(txt == senhaAtual)
					{
						obj_msg.className = "none";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
					}
					else
					{
						obj_msg.className = "errado";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/errado.png'></div> Senhas não correspondem.";
					}
				}
				else
				{
					obj_msg.className = "obrigatorio";
					obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> Confirme sua senha atual.";
				}
			}
			function validaSenhaConfirmNova(valor, senhaAtual)
			{
				var obj_msg = document.getElementById("msgSenhaConfirmNova");
				var txt = valor.value;
				if (txt.length > 0)
				{
					if(txt == senhaAtual)
					{
						obj_msg.className = "none";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
					}
					else
					{
						obj_msg.className = "errado";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/errado.png'></div> Senhas não correspondem.";
					}
				}
				else
				{
					obj_msg.className = "obrigatorio";
					obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> Confirme sua nova senha.";
				}
			}
			function validaSenhaConfirmOnsubmit(id, senhaAtual)
			{
				var obj = document.getElementById(id);
				var txt = obj.value;
				if(txt == "")
				{
					alert("Campo Obrigatório!");
					obj.focus();
					return false;
				}
				if(txt != senhaAtual)
				{
					alert("O campo \"Confirmar Senha Atual\" deve corresponder a sua senha atual!");
					obj.focus();
					return false;
				}
				return true;
			}
			function validaSenhaConfirmNovaOnsubmit(id, senhaAtual)
			{
				var obj = document.getElementById(id);
				var txt = obj.value;
				if(txt == "")
				{
					alert("Campo Obrigatório!");
					obj.focus();
					return false;
				}
				if(txt != senhaAtual)
				{
					alert("O campo \"Confirmar Nova Senha\" deve corresponder a sua nova senha!");
					obj.focus();
					return false;
				}
				return true;
			}

			var alterar=0;
			var login_correto=1;
		</script>
		<form action="index.php?modulo=opcoes&acao=meusDados&modo=atualizar&id=<?php print("$linha[id]"); ?>" id="formEditar" name="formEditar" method="post" enctype="multipart/form-data">
			<fieldset>
		    	<legend>Editar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
						<th align="left">Nome:</th>
						<td align="left"><input type="text" name="nome" id="nome" value="<?php print($linha[nome]);?>" maxlength="100" onfocus="validaInputText(this, 'msgNome', 'Nome do usuário.')"  onkeyup="validaInputText(this, 'msgNome', 'Nome do usuário.')"></td>
						<td>
							<div id="msgNome" class="obrigatorio">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">E-mail:</th>
						<td align="left"><input type="text" name="email" id="email" maxlength="50" value="<?php print($linha[email]);?>" onfocus="validaEmailForm(this)"  onkeyup="validaEmailForm(this)"></td>
						<td>
							<div id="msgEmail" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">M&oacute;dulo Inicial:</th>
						<td align="left"><?php montaSelectModulos("idModuloInicial", $linha[moduloInicial], false, false); ?></td>
						<td>
							<div id="msgModulos" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan="2" align="left">
							<input type="checkbox" name="check_alterar" id="check_alterar"
								onclick="if(this.checked){alterar++;show('tr_login'); show('tr_senha'); show('tr_senha_confirm'); }else{alterar--;hide('tr_login'); hide('tr_senha'); hide('tr_senha_confirm');}"
							> Deseja alterar login e senha ?
						</td>
					</tr>
					<tr id="tr_login">
						<th align="left">Login:</th>
						<td align="left"><input type="text" name="nomeLogin" id="nomeLogin"  value="<?php print($linha[usuario]);?>" maxlength="30" onkeyup="validaLogin('validaLoginEdicao.php', this, <?php print("'$linha[usuario]'"); ?>);"></td>
						<td>
							<div id="msgLogin" class="none">
								<div class='imgMsg'><img src='css/images/correto.png'></div>
							</div>
						</td>
					</tr>
					<tr id="tr_senha">
						<th align="left">Nova Senha:</th>
						<td align="left"><input type="password" name="nomeSenha" id="nomeSenha" maxlength="30" onfocus="validaInputText(this, 'msgSenha', 'Entre com uma nova senha.')"  onkeyup="validaInputText(this, 'msgSenha', 'Entre com uma nova senha.')"></td>
						<td>
							<div id="msgSenha" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr id="tr_senha_confirm">
						<th align="left">Confirmar Nova Senha:</th>
						<td align="left">
							<input type="password" name="nomeSenha2" id="nomeSenha2" maxlength="30" onfocus="validaSenhaConfirmNova(this, document.getElementById('nomeSenha').value)"  onkeyup="validaSenhaConfirmNova(this, document.getElementById('nomeSenha').value)">
						</td>
						<td>
							<div id="msgSenhaConfirmNova" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Confirmar Senha Atual:</th>
						<td align="left">
							<input type="hidden" name="senhaAtual" id="senhaAtual" value="<?php print($linha[senha]);?>">
							<input type="password" name="senhaConfirm" id="senhaConfirm" maxlength="30" onfocus="validaSenhaConfirm(this, document.getElementById('senhaAtual').value)"  onkeyup="validaSenhaConfirm(this, document.getElementById('senhaAtual').value)">
						</td>
						<td>
							<div id="msgSenhaConfirm" class="none">
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
							<input type="submit" id="form_submit" name="Submit" value="Salvar" onclick="
								if(alterar==1)
								{
									return(campoObrigatorio(nome) && validaEmailOnSubmit('email') && validaLoginOnSubmit('nomeLogin', login_correto) && campoObrigatorio(nomeSenha) && validaSenhaConfirmNovaOnsubmit('nomeSenha2', document.getElementById('nomeSenha').value) && validaSenhaConfirmOnsubmit('senhaConfirm', document.getElementById('senhaAtual').value));
								}
								else
								{
									return(campoObrigatorio(nome) && validaEmailOnSubmit('email') && validaSenhaConfirmOnsubmit('senhaConfirm', document.getElementById('senhaAtual').value));
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
			hide('tr_senha_confirm');
		</script>
		<?php
	}
	elseif($tipo=="removido")
	{
		devolveMensagem("Usuário Removido!", 1);
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