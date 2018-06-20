<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['usuarios'])
{
	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;
	include("func.php");

	if($tipo=="")	$tipo="cadastrar";

	if($tipo=="cadastrar")	$tituloH1="Usuários - Cadastrar";
	elseif($tipo=="listar")	$tituloH1="Usuários - Listar";

	if($modo=="cadastrar")
	{
		if($nome != "")
		{
			$retorno=adicionaUsuario($nome, $nomeLogin, $nomeSenha, $email, $idModulo, $modulos, $_SESSION['login']);
			if($retorno)
			{
				$msg="Cadastrado com sucesso";
				$_POST="";
			}
			else
				$msg="Erro ao cadastrar Usuário. Verifique se o login já não está sendo usado.";
		}
	}
	if($modo=="remover")
	{
		$retorno=removeUsuario($id, $_SESSION['login']);
		if($retorno)
			$msg="Excluído com sucesso";
		else
			$msg="Erro ao remover Usuário";
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
			function validaPermissoes(valor)
			{
				var obj_msg = document.getElementById("msgPermissoes");
				if (valor > 0)
				{
					obj_msg.className = "none";
					obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
				}
				else
				{
					obj_msg.className = "obrigatorio";
					obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> Selecione os módulos permitidos para este usuário.";
				}
			}
			function validaPermissoesOnSubmit(valor)
			{
				if (valor < 1)
				{
					alert("É necessário que seja atribuída a permissão para pelo menos um módulo!");
					return false;
				}
				return true;
			}
			function validaLogin(valor)
			{
				if(document.getElementById)
				{
					var obj_msg = document.getElementById("msgLogin");
					var txt = valor.value;
					if (txt.length > 0)
					{
						var ajax = openAjax();
						ajax.open("GET", "validaLogin.php?login=" + txt, true);
						ajax.onreadystatechange = function()
						{
							if(ajax.readyState == 1) {
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
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> Entre com um login.";
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
				if (txt.length==0)
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
					obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> Confirme a senha.";
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
					alert("O campo \"Confirmação de Senha\" deve corresponder a sua senha atual!");
					obj.focus();
					return false;
				}
				return true;
			}

			var login_correto=0;
		</script>
		<form action="index.php?modulo=usuarios&acao=usuarios&tipo=cadastrar&modo=cadastrar" id="formCadastrar" name="formCadastrar" method="post" enctype="multipart/form-data">
			<fieldset>
		    	<legend>Cadastrar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
						<th align="left">Nome:</th>
						<td align="left"><input type="text" name="nome" id="nome" maxlength="100" onfocus="validaInputText(this, 'msgNome', 'Entre com o nome do usuário.')"  onkeyup="validaInputText(this, 'msgNome', 'Entre com o nome do usuário.')"></td>
						<td>
							<div id="msgNome" class="obrigatorio">
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
						<th align="left">M&oacute;dulo Inicial:</th>
						<td align="left"><?php montaSelectModulos("idModulo", $idModulo, false, false); ?></td>
						<td>
							<div id="msgModulos" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left" valign="top">Permiss&otilde;es:</th>
						<td align="left"><?php montaCheckboxesModulos("formCadastrar"); ?></td>
						<td valign="top">
							<div id="msgPermissoes" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Login:</th>
						<td align="left"><input type="text" name="nomeLogin" id="nomeLogin" maxlength="30" onfocus="validaLogin(this);"  onkeyup="validaLogin(this);"></td>
						<td>
							<div id="msgLogin" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Senha:</th>
						<td align="left"><input type="password" name="nomeSenha" id="nomeSenha" maxlength="30" onfocus="validaInputText(this, 'msgSenha', 'Entre com uma senha.')"  onkeyup="validaInputText(this, 'msgSenha', 'Entre com uma senha.')"></td>
						<td>
							<div id="msgSenha" class="none">
								<div class='imgMsg'><img src='css/images/obrigatorio.png'></div>
							</div>
						</td>
					</tr>
					<tr>
						<th align="left">Confirma Senha:</th>
						<td align="left"><input type="password" name="nomeSenha2" id="nomeSenha2" maxlength="30" onfocus="validaSenhaConfirm(this, document.getElementById('nomeSenha').value)"  onkeyup="validaSenhaConfirm(this, document.getElementById('nomeSenha').value)"></td>
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
							<input type="submit" id="form_submit" name="Submit" value="Cadastrar" onclick="
								return(campoObrigatorio(nome) && validaEmailOnSubmit('email') && validaPermissoesOnSubmit(tamanhoVetor) && validaLoginOnSubmit('nomeLogin', login_correto) && campoObrigatorio(nomeSenha) && validaSenhaConfirmOnsubmit('nomeSenha2', document.getElementById('nomeSenha').value));
							">
						</td>
					</tr>
				</table>
		    </fieldset>
		</form>
		<script language="javascript">
			document.formCadastrar.nome.focus();
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
						<form action='index.php?modulo=usuarios&acao=usuarios&tipo=listar&modo=pesquisa' method='post'>
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
		devolveListaUsuarios($tipo, $index, $mark, "WHERE deletado='0' AND id!='-1' $where ORDER BY $orderBy", $order, $titulo, "&modo=pesquisa&titulo=$titulo&order=$order");

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