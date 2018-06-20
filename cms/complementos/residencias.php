<?php
if($modulo!="" && devolveUsuarioLogado() && $_SESSION['complementos'])
{
	include("func.php");

	if($index == "")	$index = 0;
	if($mark=="")		$mark = 1;

	if($tipo=="cadastrar")	$tituloH1="Informações Complementares (Residências) - Cadastrar";
	elseif($tipo=="listar")	$tituloH1="Informações Complementares (Residências) - Listar";

	if($modo=="cadastrar"){
		$indice=formataValor($indice);
		$venda=formataValor($venda);
		$locacao=formataValor($locacao);
		$condominio=formataValor($condominio);
		$tlu=formataValor($tlu);
		$iptuIncra=formataValor($iptuIncra);

		$finPoupanca=formataValor($finPoupanca);
		$finSaldoDevedor=formataValor($finSaldoDevedor);
		$finValorPrestacao=formataValor($finValorPrestacao);

		$retorno=cadastraInfoResidencia("residencias", $id, $tipoImovel, $outroTipoImovel, $cep, $referencia, $complemento, $condominioFechado, $numCasasCondominio,
		$idade, $tipoArea, $ocupado, $chaves, $matricula, $circunscricao, $inscricaoImobiliaria, $contrato, $averbado, $conservacao, $pavimentacao, $horaVisita, $entrega, $estilo, $tipoForro, $placa, $posicaoSol, $comissao,
		$indice, $venda, $locacao, $condominio, $tlu, $iptuIncra, $valorLuz, $luzIndividual, $luzIdentificador, $valorAgua, $aguaIndividual, $aguaIdentificador,
		$areaTotal, $areaTerreno, $areaPreservacao, $areaHectares,
		$metragemFrente, $metragemFundo, $metragemDireita, $metragemEsquerda,
		$finPoupanca, $finSaldoDevedor, $finValorPrestacao, $finParcelasPagas, $finParcelasRestantes, $finBanco, $aptoUsoFgts, $finCondPagamento, $finPendencias, $finPermuta,
		$obsTerreno, $acabamentos, $pintura, $piso, $mobilia, $anuncio, $anuncioPontosFortes
		);
		if($retorno==true){
    		print("
                <script language='javascript'>window.location='index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&id=$id'</script>
            ");
		}
		else
			$msg="Erro ao cadastrar Informações!";
	}

	print("<h1>$tituloH1</h1>");

	if($msg!="")	devolveMensagem($msg, $retorno);


	if($tipo=="cadastrar"){
    	if(existeComplemento($id)){
            print("
                <script language='javascript'>window.location='index.php?modulo=imoveis&acao=imovelinfo&tipo=complementos&aviso=true&id=$id'</script>
            ");
        }
		$verimagem="Não Cadastrada";
		$imovel=devolveInfo("imoveis", $id);
		$cliente=devolveInfoCampo("nome", "cliente", $imovel['idCliente']);
		$categoria=devolveInfoCampo("nome", "categorias", $imovel['idCategoria']);
		$subcategoria=devolveInfoCampo("nome", "subcategorias", $imovel['idSubCategoria']);
		if($imovel[imagem])	$verimagem = "<a href='../imoveis/m_$imovel[imagem]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0' class='icone_botao'> $imovel[imagem]</a>";
		print("
			<table width='100%' align='center' id='gradient-style-detalhes'>
				<tr>
					<th align='left' width='50%'>Referência</th>
					<th align='left' width='50%'>Imagem</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$imovel[referencia]</td>
					<td align='left'>&nbsp;$verimagem</td>
				</tr>
				<tr>
					<th align='left'>Cliente</th>
					<th align='left'>Categoria | Sub Categoria</th>
				</tr>
				<tr>
					<td align='left'>&nbsp;$cliente</td>
					<td align='left'>&nbsp;$categoria <b>|</b> $subcategoria</td>
				</tr>
			</table>
		");
		?>
		<table align="center" width="450" border="0" cellspacing="3" cellpadding="3">
			<tr>
				<td align="right" style="color:787878; letter-spacing:1px; font-size:85%;">* Campos Obrigat&oacute;rios</td>
			</tr>
			<tr valign="baseline">
				<td nowrap align="center">
					<form style="width:450px;" name="formCadastro" id="formCadastro" action="index.php?modulo=complementos&acao=residencias&modo=cadastrar&tipo=cadastrar<?php print("&id=$id");?>" method="post" enctype="multipart/form-data">
					  	<fieldset style="width:450px;">
							<legend>Identifica&ccedil;&atilde;o</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" align="left">Tipo:</th>
									<td align="left">
										<select name="tipoImovel" id="tipoImovel">
											<option value="Alvenaria">Alvenaria</option>
											<option value="Madeira">Madeira</option>
											<option value="Mista">Mista</option>
											<option value="Em Constru&ccedil;&atilde;o">Em Constru&ccedil;&atilde;o</option>
											<option value="Outros">Outros</option>
										</select>
									</td>
								</tr>
								<tr>
									<th align="left">Outro Tipo:</th>
									<td align="left"><input type="text" name="outroTipoImovel" id="outroTipoImovel" maxlength="100"></td>
								</tr>
							</table>
						</fieldset>
						<br>
						<fieldset style="width:450px;">
							<legend>Localiza&ccedil;&atilde;o</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" align="left">Estado:</th>
									<td align="left"><?php print(devolveEstado($imovel['idEstado'])); ?></td>
								</tr>
								<tr>
							  		<th align="left">Cidade:</th>
							  		<td align="left"><?php print(devolveInfoCampo("nome", "cidades", $imovel['idCidade']));?>
									</td>
						 		</tr>
						 		<tr>
							  		<th align="left">Regi&atilde;o:</th>
							  		<td align="left"><?php print(devolveInfoCampo("nome", "regiao", $imovel['idRegiao']));?>
									</td>
						 		</tr>
						 		<tr>
							  		<th align="left">Bairro:</th>
							  		<td align="left"><?php print(devolveInfoCampo("nome", "bairros", $imovel['idBairro']));?>
									</td>
						 		</tr>
						 		<tr>
							  		<th align="left">Endere&ccedil;o:</th>
							  		<td align="left"><?php print($imovel['endereco']);?>
									</td>
						 		</tr>
						 		<tr>
									<th align="left">CEP:</th>
									<td align="left"><input type="text" name="cep" id="cep" maxlength="9" mascara="#####-###" tipo="numerico"></td>
								</tr>
								<tr>
									<th align="left">Refer&ecirc;ncia:</th>
									<td align="left"><input type="text" name="referencia" id="referencia" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Complemento:</th>
									<td align="left"><input type="text" name="complemento" id="complemento" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Condom&iacute;nio Fechado:</th>
									<td align="left"><input type="text" name="condominioFechado" id="condominioFechado" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">N&ordm; de Casas:</th>
									<td align="left"><input type="text" name="numCasasCondominio" id="numCasasCondominio" maxlength="100"></td>
								</tr>
							</table>
						</fieldset>
						<br>
						<fieldset style="width:450px;">
							<legend>Informa&ccedil;&otilde;es</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" align="left">Idade:</th>
									<td align="left"><input type="text" name="idade" id="idade" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Tipo de &Aacute;rea:</th>
									<td align="left"><input type="text" name="tipoArea" id="tipoArea" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Ocupado:</th>
									<td align="left"><input type="text" name="ocupado" id="ocupado" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Chaves:</th>
									<td align="left"><input type="text" name="chaves" id="chaves" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Matr&iacute;cula:</th>
									<td align="left"><input type="text" name="matricula" id="matricula" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Circunscri&ccedil;&atilde;o:</th>
									<td align="left"><input type="text" name="circunscricao" id="circunscricao" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Inscri&ccedil;&atilde;o Imobili&aacute;ria:</th>
									<td align="left"><input type="text" name="inscricaoImobiliaria" id="inscricaoImobiliaria" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Contrato:</th>
									<td align="left"><input type="text" name="contrato" id="contrato" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Averbado:</th>
									<td align="left"><input type="text" name="averbado" id="averbado" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Conserva&ccedil;&atilde;o:</th>
									<td align="left"><input type="text" name="conservacao" id="conservacao" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Pavimenta&ccedil;&atilde;o:</th>
									<td align="left"><input type="text" name="pavimentacao" id="pavimentacao" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Hor&aacute;rio de Visita:</th>
									<td align="left"><input type="text" name="horaVisita" id="horaVisita" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Entrega:</th>
									<td align="left"><input type="text" name="entrega" id="entrega" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Estilo:</th>
									<td align="left"><input type="text" name="estilo" id="estilo" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Tipo de Forro:</th>
									<td align="left"><input type="text" name="tipoForro" id="tipoForro" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Placa:</th>
									<td align="left"><input type="text" name="placa" id="placa" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Posi&ccedil;&atilde;o do Sol:</th>
									<td align="left"><input type="text" name="posicaoSol" id="posicaoSol" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Comiss&atilde;o (%):</th>
									<td align="left"><input type="text" name="comissao" id="comissao" maxlength="10"></td>
								</tr>
							</table>
						</fieldset>
						<br>
						<fieldset style="width:450px;">
							<legend>Valor</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" align="left">Total:</th>
									<td align="left"><?php print("R$ ".devolveValor($imovel['valor']));?></td>
								</tr>
								<tr>
									<th align="left">&Iacute;ndice:</th>
									<td align="left"><input type="text" name="indice" id="indice" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Venda:</th>
									<td align="left"><input type="text" name="venda" id="venda" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">Loca&ccedil;&atilde;o:</th>
									<td align="left"><input type="text" name="locacao" id="locacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">Condom&iacute;nio:</th>
									<td align="left"><input type="text" name="condominio" id="condominio" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">TLU:</th>
									<td align="left"><input type="text" name="tlu" id="tlu" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">IPTU:</th>
									<td align="left"><input type="text" name="iptuIncra" id="iptuIncra" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">Luz:</th>
									<td align="left"><input type="text" name="valorLuz" id="valorLuz" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">Luz &eacute; individual:</th>
									<td align="left"><?php montaCheckSimNao($luzIndividual, "luzIndividual", "style='width:15px;'"); ?></td>
								</tr>
								<tr>
									<th align="left">N&ordm; Rel&oacute;gio / Conta:</th>
									<td align="left"><input type="text" name="luzIdentificador" id="luzIdentificador" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">&Aacute;gua:</th>
									<td align="left"><input type="text" name="valorAgua" id="valorAgua" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">&Aacute;gua &eacute; individual:</th>
									<td align="left"><?php montaCheckSimNao($aguaIndividual, "aguaIndividual", "style='width:15px;'"); ?></td>
								</tr>
								<tr>
									<th align="left">N&ordm; Hidr&ocirc;metro / Localiz.:</th>
									<td align="left"><input type="text" name="aguaIdentificador" id="aguaIdentificador" maxlength="100"></td>
								</tr>
							</table>
						</fieldset>
						<br>
						<fieldset style="width:450px;">
							<legend>&Aacute;rea</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" align="left">Total:</th>
									<td align="left"><input type="text" name="areaTotal" id="areaTotal" maxlength="50"></td>
								</tr>
								<tr>
									<th align="left">Terreno:</th>
									<td align="left"><input type="text" name="areaTerreno" id="areaTerreno" maxlength="50"></td>
								</tr>
							</table>
						</fieldset>
						<br>
						<fieldset style="width:450px;">
							<legend>Metragem</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" align="left">Frente:</th>
									<td align="left"><input type="text" name="metragemFrente" id="metragemFrente" maxlength="50"></td>
								</tr>
								<tr>
									<th width="30%" align="left">Fundo:</th>
									<td align="left"><input type="text" name="metragemFundo" id="metragemFundo" maxlength="50"></td>
								</tr>
								<tr>
									<th width="30%" align="left">Lateral &agrave; Direita:</th>
									<td align="left"><input type="text" name="metragemDireita" id="metragemDireita" maxlength="50"></td>
								</tr>
								<tr>
									<th width="30%" align="left">Lateral &agrave; Esquerda:</th>
									<td align="left"><input type="text" name="metragemEsquerda" id="metragemEsquerda" maxlength="50"></td>
								</tr>
							</table>
						</fieldset>
						<br>
						<fieldset style="width:450px;">
							<legend>Financiamento</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" align="left">VL. Poupan&ccedil;a:</th>
									<td align="left"><input type="text" name="finPoupanca" id="finPoupanca" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">Saldo Devedor:</th>
									<td align="left"><input type="text" name="finSaldoDevedor" id="finSaldoDevedor" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">VL. Presta&ccedil;&otilde;es:</th>
									<td align="left"><input type="text" name="finValorPrestacao" id="finValorPrestacao" maxlength="20" tipo="numerico" mascara="###.###.###.###,##" orientacao="esquerda"></td>
								</tr>
								<tr>
									<th align="left">Parcelas Pagas:</th>
									<td align="left"><input type="text" name="finParcelasPagas" id="finParcelasPagas" maxlength="100" tipo="numerico"></td>
								</tr>
								<tr>
									<th align="left">Parcelas Restantes:</th>
									<td align="left"><input type="text" name="finParcelasRestantes" id="finParcelasRestantes" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Banco:</th>
									<td align="left"><input type="text" name="finBanco" id="finBanco" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Apto para uso de FGTS:</th>
									<td align="left"><?php montaCheckSimNao($aptoUsoFgts, "aptoUsoFgts", "style='width:15px;'");?></td>
								</tr>
								<tr>
									<th align="left">Condi&ccedil;&atilde;o de Pagamento</th>
									<td align="left"><input type="text" name="finCondPagamento" id="finCondPagamento" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Pend&ecirc;ncias</th>
									<td align="left"><input type="text" name="finPendencias" id="finPendencias" maxlength="100"></td>
								</tr>
								<tr>
									<th align="left">Permuta</th>
									<td align="left"><input type="text" name="finPermuta" id="finPermuta" maxlength="100"></td>
								</tr>
							</table>
						</fieldset>
						<br>
						<fieldset style="width:450px;">
							<legend>Observa&ccedil;&atilde;o Terreno</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" valign="top" align="left">Observa&ccedil;&atilde;o:</th>
									<td align="left"><textarea name="obsTerreno" id="obsTerreno" rows="3" style="height:120px;"></textarea></td>
								</tr>
							</table>
						</fieldset>
						<br>
						<fieldset style="width:450px;">
							<legend>Acabamentos</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" valign="top" align="left">Observa&ccedil;&atilde;o:</th>
									<td align="left"><textarea name="acabamentos" id="acabamentos" rows="3" style="height:120px;"></textarea></td>
								</tr>
								<tr>
									<th align="left">Pintura:</th>
									<td align="left"><input type="text" name="pintura" id="pintura" maxlength="150"></td>
								</tr>
								<tr>
									<th align="left">Piso:</th>
									<td align="left"><input type="text" name="piso" id="piso" maxlength="150"></td>
								</tr>
								<tr>
									<th align="left">Mob&iacute;lia:</th>
									<td align="left"><input type="text" name="mobilia" id="mobilia" maxlength="150"></td>
								</tr>
							</table>
						</fieldset>
						<br>
						<fieldset style="width:450px;">
							<legend>An&uacute;ncio</legend>
					    	<table align="center" border="0" cellspacing="3" cellpadding="3">
								<tr>
									<th width="30%" valign="top" align="left">An&uacute;ncio:</th>
									<td align="left">
										<select name="anuncio" id="anuncio">
											<option value="Jornal">Jornal</option>
											<option value="Site">Site</option>
											<option value="Rede">Rede</option>
											<option value="Revista">Revista</option>
											<option value="N&atilde;o Enviar">N&atilde;o Enviar</option>
										</select>
									</td>
								</tr>
								<tr>
									<th valign="top" align="left">Pontos Fortes:</th>
									<td align="left"><textarea name="anuncioPontosFortes" id="anuncioPontosFortes" rows="3" style="height:120px;"></textarea></td>
								</tr>
							</table>
						</fieldset>
						<table align="center" border="0" cellspacing="3" cellpadding="3">
							<tr valign="baseline">
								<td nowrap align="center">
									<input name="cadastrar" type="submit" id="form_submit" value="Cadastrar">
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
		<?php
	}
	elseif($tipo=="listar" || $tipo=="")
	{
		?>
		<table align="center" width="700" cellpadding="2" cellspacing="2">
			<tr>
				<td width="80%" align="center" valign="top">
					<form name="formPesquisa" id="formPesquisa" action="index.php?modulo=complementos&acao=residencias&tipo=listar" method="post">
						<fieldset style='width:450px;'>
					    	<legend>Listar</legend>
							<table align = "center" border = "0" cellpadding="2" cellspacing="2">
								<tr>
									<th align="left">Ordenado por:</th>
									<td align="left">
										<select name="order" id="order">
											<option value="dataCadastroASC" <?php if($order=="dataCadastroASC") print("selected");?>>Data Cadastro Crescente</option>
											<option value="dataCadastroDESC" <?php if($order=="dataCadastroDESC") print("selected");?>>Data Cadastro Decrescente</option>
										</select>
									</td>
								</tr>
								<tr>
									<th align="left">Refer&ecirc;ncia</th>
									<td align="left"><input type="text" name="referencia" id="referencia" value="<?php print($referencia);?>"></td>
								</tr>
								<tr>
									<th align="left">Cliente</th>
									<td align="left"><?php montaComboGenerico("cliente", "idCliente", " WHERE status=1 AND deletado=0 ", $idCliente, true, false, "id", "nome");?></td>
								</tr>
								<tr>
							  		<th align="left">Categoria:</th>
							  		<td align="left">
										<select id="idCategoria" name="idCategoria" style="width:95%;" onChange="DadosCategoria(this.value, 'subCategoriaXML', 'idSubCategoria', 'subCatOpcoes');">
											<option value="0">Todas</option>
											<?php
												// seleciona categorias que não sejam apartamentos e terrenos
												montaSelect("categorias", $idCategoria, " AND id!=2 AND id!=3 "); ?>
										</select> *
									</td>
						 		</tr>
								<tr>
							  		<th align="left">Sub Categoria: </th>
							  		<td align="left">
						 				<select id="idSubCategoria" name="idSubCategoria" style="width:95%;">
										  	<option id="subCatOpcoes" value="0">Todas</option>
										  	<?php
										  		if($idSubCategoria!="")	montaSelect("subcategorias", $idSubCategoria, " AND id=$idSubCategoria ");
											?>
										</select> *
						  	  		</td>
								</tr>
								<tr>
									<td colspan="2" align="center"><input type="submit" id="form_submit" name="submitPesquisa" value="Pesquisar"></td>
								</tr>
							</table>
						</fieldset>
					</form>
					<script language="javascript">
						document.formPesquisa.order.focus();

						function DadosCategoria(valor, arquivo, proximoCampo, opcoes)
						{
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
								document.formPesquisa.idSubCategoria.options.length=1;
								idOpcao=document.getElementById(opcoes);
								ajax.open('POST', arquivo+'.php', true);
								ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
								ajax.onreadystatechange=function() {
									if(ajax.readyState==1) {
										idOpcao.innerHTML='Carregando...';
									}
									if(ajax.readyState==4) {
										if(ajax.responseXML)
											processXMLCategoria(ajax.responseXML, arquivo, proximoCampo, opcoes);
										else
											idOpcao.innerHTML='';
									}
								}
							}
							var params = 'codigo='+valor;
							ajax.send(params);

						}
						function processXMLCategoria(obj, arquivo, proximoCampo, opcoes){
							var dataArray = obj.getElementsByTagName('subCategoria');
							if(dataArray.length > 0) {
								for(var i = 0 ; i < dataArray.length ; i++) {
									var item = dataArray[i];
									var codigo = item.getElementsByTagName('codigo')[0].firstChild.nodeValue;
									var nome =  item.getElementsByTagName('nome')[0].firstChild.nodeValue;
									idOpcao.innerHTML = '-- Selecione uma das opções >>';
									var novo = document.createElement('option');
									novo.setAttribute('id', opcoes);
									novo.value = codigo;
									novo.text  = nome;
									document.formPesquisa.idSubCategoria.options.add(novo);
								}
							}
							else {
								idOpcao.innerHTML = '';
							}
						}
					</script>
				</td>
			</tr>
		</table>
		<?php
		if($order=="") $order="dataCadastroASC";

		$where="";
		if($referencia!="")
		{
			$where.=" AND imo.referencia = '$referencia' ";
		}
		if($idCliente!="" && $idCliente!="0")
		{
			$where.=" AND imo.idCliente='$idCliente' ";
		}
		if($idCategoria!="" && $idCategoria!="0")
		{
			$where.=" AND imo.idCategoria='$idCategoria' ";
		}
		else
		{
			$where.=" AND imo.idCategoria!=2 AND imo.idCategoria!=3 ";
		}
		if($idSubCategoria!="" && $idSubCategoria!="0")
		{
			$where.=" AND imo.idSubCategoria='$idSubCategoria' ";
		}
		if($order=="dataCadastroASC")	$orderBy="imo.id ASC";
		if($order=="dataCadastroDESC")	$orderBy="imo.id DESC";
		devolveListaImoveis($acao, $index, $mark, "WHERE imo.deletado='0' $where", " ORDER BY $orderBy ","&order=$order&referencia=$referencia&idCliente=$idCliente&idCategoria=$idCategoria&idSubCategoria=$idSubCategoria");
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