<?php
$msgErro="";
if($tipo=="pesquisar" && $referencia!="") {
	if($id=existeImovel($referencia)){
		print("<script language='javascript'>window.location='index.php?site=detalhes&id=$id';</script>");
	}
	else {
		$msgErro="
			<tr>
				<td colspan='3'>
					<span style='color:#900; text-align:right; padding-right:20px;'>Imóvel com referêcia \"$referencia\" não encontrado.</span>
				</td>
			</tr>
		";
	}
}
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left">
			<img src='images/titulo_pesquisa.jpg' border='0' style='margin-left:20px;'>
		</td>
	</tr>
    <tr><td>&nbsp;</td></tr>
	<tr id="pesquisaTd">
		<td valign="top">
			<form name="formPesquisa" id="formPesquisa" action="index.php?site=pesquisa&tipo=pesquisar&modo=<?php print($modo);?>" method="post">
				<div id="filtros">
					<label>
						<span class="filtro">Refer&ecirc;ncia:</span>
						<span class="valor">Ref <input type="text" name="referencia" value="<?php print("$referencia"); ?>"></span>
					</label>
					<label>
						<span class="filtro">Tipo:</span>
						<span class="valor">
							<select id="idCategoria" name="idCategoria" style="width:330px;">
								<option value="">Todos</option>
								<?php montaSelect("categorias", $idCategoria); ?>
							</select>
						</span>
					</label>
					<label style="width:100px; float:left;"><span class="filtro">Valor:</span></label>
					<label style="width:180px; float:left; line-height:25px;"><input type="text" name="valorIni" tipo="numerico" orientacao="esquerda" mascara="###.###.###.###,##" value="<?php print("$valorIni"); ?>"> &agrave;</label>
					<label style="width:135px;  float:left; line-height:25px;"><input type="text" name="valorFim" tipo="numerico" orientacao="esquerda" mascara="###.###.###.###,##" value="<?php print("$valorFim"); ?>"></label>
					<label>
						<span class="filtro">Cidade:</span>
						<span class="valor">
							<select id="opcaoCategoria" name="opcaoCategoria" onChange="Dados(this.value, 'regioesXML', 'listaSubCategoria', 'opcaoSubCategoria');">
								<option value="">Todas</option>
								<?php montaSelect("cidades", $opcaoCategoria); ?>
							</select>
						</span>
					</label>
					<label>
						<span class="filtro">Regi&atilde;o:</span>
						<span class="valor">
							<select id="listaSubCategoria" name="listaSubCategoria">
								<option id="opcaoSubCategoria" value="">Todas</option>
								<?php montaSelect("regiao", $listaSubCategoria); ?>
							</select>
						</span>
					</label>
					<label><input type="submit" name="pesquisaHome" id="submitPesquisa" value="Pesquisar"></label>
				</div>
                <div id="filtroComposicao">
					
						<span class="filtro" style="width:300px;"><font style="font-size:16px; line-height:35px; color:#333">O que voc&ecirc; deseja?</b></span>
						<span class="valor" style="margin-top:20px;">
							<?php
								listaComposicoesPesquisa($_POST['composicao']);
							?>
						</span>
					
				</div>
				
			</form>
			<script language="javascript">
				document.formPesquisa.referencia.focus();
				function Dados(valor, arquivo, proximoCampo, opcoes){
					var ajax;
					if(window.XMLHttpRequest) // Mozilla, Safari...
				    {
				        ajax = new XMLHttpRequest();
				    }
				    else if(window.ActiveXObject) // IE
				    {
						try{
				            ajax = new ActiveXObject('Msxml2.XMLHTTP');
				        }
				        catch(e)
				        {
				            try{
				                ajax = new ActiveXObject('Microsoft.XMLHTTP');
				            }
				            catch(e){}
				        }
				    }
					if(ajax) {
						document.formPesquisa.listaSubCategoria.options.length=1;
						idOpcao=document.getElementById(opcoes);
						ajax.open('POST', arquivo+'.php', true);
						ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						ajax.onreadystatechange=function() {
							if(ajax.readyState==1) {
								idOpcao.innerHTML='Carregando...';
							}
							if(ajax.readyState==4) {
								if(ajax.responseXML)
									processXML(ajax.responseXML, arquivo, proximoCampo, opcoes);
								else
									idOpcao.innerHTML='';
							}
						}
					}
					var params = 'codigo='+valor;
					ajax.send(params);

				}
				function processXML(obj, arquivo, proximoCampo, opcoes){
					var dataArray = obj.getElementsByTagName('regiao');
					if(dataArray.length > 0) {
						for(var i = 0 ; i < dataArray.length ; i++) {
							var item = dataArray[i];
							var codigo = item.getElementsByTagName('codigo')[0].firstChild.nodeValue;
							var nome =  item.getElementsByTagName('nome')[0].firstChild.nodeValue;
							idOpcao.innerHTML = 'Todas';
							var novo = document.createElement('option');
							novo.setAttribute('id', opcoes);
							novo.value = codigo;
							novo.text  = nome;
							document.formPesquisa.listaSubCategoria.options.add(novo);
						}
					}
					else {
						idOpcao.innerHTML = '';
					}

				}
			</script>
        </td>
    </tr>
    <?php
    if($tipo=="pesquisar")
    {
    ?>
		<script language="javascript">
			hide('pesquisaTd');
		</script>
		<tr><td><div id="novaPesquisa" style="float:right; margin-right:30px; margin-top:10px;"><input type="submit" name="pesquisaHome2" id="submitPesquisa2" value="Pesquisar Mais Im&oacute;veis" style="padding:4px;" onclick="show('pesquisaTd'); hide('novaPesquisa');"></div></td></tr>
		<?php
}
?>
    <tr>
    	<td>
    		<?php
				if($tipo=="pesquisar") {
					devolveImoveisPesquisa($referencia, $idCategoria, $valorIni, $valorFim, $opcaoCategoria, $listaSubCategoria, $_POST['composicao']);
				}
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
