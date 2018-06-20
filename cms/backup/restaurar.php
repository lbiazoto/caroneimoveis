<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['backup'])
{
	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;
	include("func.php");

	if($tipo=="")	$tipo="remoto";

	if($tipo=="remoto")	$tituloH1="Backup - Restaurar";
	elseif($tipo=="local")	$tituloH1="Backup - Restaurar Local";

	if($tipo=="local" && $arquivo != "" && $modo=="restaurar")
	{
		$retorno=restauraBackupLocal($arquivo,$id,$_SESSION['login']);
		if($retorno)
			$msg="Backup Restaurado com sucesso!";
		else
			$msg="O Backup não pode ser restaurado!";
	}
	if($tipo == "remoto" && $modo == "restaurar" && $id!="")
	{
		if($retorno=restauraBackup($file,$id,$_SESSION['login']))
			$msg="Backup Restaurado com sucesso!";
		else
			$msg="O Backup não pode ser restaurado!";
	}
	if($tipo == "remoto" && $modo=="remover" && $id!="")
	{
		$retorno=removeBackup($id, $_SESSION['login']);
		if($retorno)
			$msg="Excluído com sucesso";
		else
			$msg="Erro ao remover Backup";
	}
	///////////////
	print("
		<h1>
			$tituloH1
		</h1>
	");
	//////////////
	if($msg!="")	devolveMensagem($msg, $retorno);

	if($tipo=="remoto")
	{
		devolveListaBackupsRestaurar();
	}
	elseif($tipo=="local")
	{
		?>
		<script language="javascript">
			function validaArquivo(valor)
			{
				var obj_msg = document.getElementById("msgArquivo");
				var txt = valor.value;
				if (txt.length > 0)
				{
					var vetor = txt.split("\\");
					var tamanho = vetor.length;
					tamanho--;
					var nome_arquivo = vetor[tamanho];
					if(nome_arquivo.search('.sql')!='-1')
					{
						obj_msg.className = "none";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/correto.png'></div>";
					}
					else
					{
						obj_msg.className = "errado";
						obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/errado.png'></div> Atenção: Extensão '.sql'.";
					}
				}
				else
				{
					obj_msg.className = "obrigatorio";
					obj_msg.innerHTML = "<div class='imgMsg'><img src='css/images/obrigatorio.png'></div> Atenção: Extensão '.sql'.";
				}
			}
			function validaArquivoOnSubmit(id)
			{
				var obj = document.getElementById(id);
				var valor = obj.value;
				if(valor == "")
				{
					alert("Campo Obrigatório!");
					obj.focus();
					return false;
				}
				if(valor.length>0)
				{
					var vetor = valor.split("\\");
					var tamanho = vetor.length;
					tamanho--;
					var nome_arquivo = vetor[tamanho];
					if(nome_arquivo.search('.sql')!='-1')
					{
						return true
					}
					else
					{
						alert("O arquivo deve ter a extensão \".sql\".");
						obj.focus();
						return false;
					}
				}
				return true;
			}
		</script>
		<form method="post" id="formCadastrar" name="formCadastrar" action="index.php?modulo=backup&acao=restaurar&tipo=local&modo=restaurar" enctype="multipart/form-data">
			<p style="line-height:25px; letter-spacing:2px;">Para restaurar um backup localize o arquivo e clique em Restaurar Backup<BR>O arquivo deve ter a extens&atilde;o <b>.sql</b></p>
			<fieldset>
		    	<legend>Cadastrar</legend>
		    	<table align="center" border="0" cellspacing="3" cellpadding="3">
					<tr>
						<th>Arquivo:</th>
						<td><input type="file" name="arquivo" id="arquivo" onfocus="validaArquivo(this)" onchange="validaArquivo(this)"></td>
						<td>
							<div id="msgArquivo" class="obrigatorio">
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
					<tr valign="baseline">
						<td nowrap align="center" colspan="3">
							<input name="cadastrar" type="submit" id="form_submit" value="Restaurar" onclick="if(validaArquivoOnSubmit('arquivo')){alert('Por motivos de segurança será gerado um backup antes de restaurar o antigo.'); return confirmaExclusao('Você tem certeza que deseja restaurar este backup?');}else return false;">
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
		<script language="javascript">
			document.formCadastrar.arquivo.focus();
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