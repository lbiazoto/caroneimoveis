<?php
	$msgErro="";
	if($tipo=="acessoRapido")
	{
		if($id=existeImovel($acesso))
		{
			print("
				<script language='javascript'>
					window.location='index.php?site=detalhes&id=$id';
				</script>
			");
		}
		else
		{
			print("
				<script language='javascript'>
					alert(\"Imóvel com referência '$acesso' não encontrado.\");
				</script>
			");
            //$msgErro="<span style='color:#900; text-align:right; padding-right:20px;'></span>";
		}
	}
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<form name="formBuscaImoveis" id="formBuscaImoveis" action="imoveis.php" method="get">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td width="162"><img src="images/pesquise.jpg" width="162" height="78"></td>
						<td width="600">
							<table width="100%" cellpadding="2" cellspacing="3">
								<tr>
									<td align="left">
										<label>
											<input type="radio" id="tipoImovel" name="tipoImovel" value="-1" <?php if($tipoImovel=="-1" || $tipoImovel=="") print("checked");?> /><span style="float:left; margin-top:-5px;">&nbsp;Todos</span>
										</label>
										<label>
				                            <input type="radio" id="tipoImovel" name="tipoImovel" value="1" <?php if($tipoImovel=="1") print("checked");?> /><span style="float:left; margin-top:-5px;">&nbsp;Loca&ccedil;&atilde;o</span>
				                        </label>
										<label>
				                            <input type="radio" id="tipoImovel" name="tipoImovel" value="0" <?php if($tipoImovel=="0") print("checked");?> /><span style="float:left; margin-top:-5px;">&nbsp;Venda</span>
										</label>
										<label>
											<span>Tipo: </span>
											<span>
											<select id="idCategoria" name="idCategoria">
				                                <option value="">Todos</option>
					                            <?php montaSelect("categorias", $idCategoria); ?>
				                            </select>
				                            </span>
										</label>
										<label>
											<span>Ref: </span>
											<span>
												<input type="text" name="referencia" id="referencia" style="width:100px;">
											</span>
										</label>
									</td>
								</tr>
								<tr>
									<td align="left">
										<label>
											<span>Localiza&ccedil;&atilde;o:</span>
											<select id="idCidadeRegiao" name="idCidadeRegiao">
				                                <option value="">Todas</option>
				                                <?php montaSelectCidadesRegiao("cidades", $idCidadeRegiao); ?>
				                            </select>
										</label>
										<label style="margin-left:20px;">
											<span>Valor: </span>
											<input type="text" name="valorIni" size="15" style="padding-right:3px;" tipo="numerico" orientacao="esquerda" mascara="###.###.###.###,##" value="<?php print("$valorIni"); ?>">
										</label>
										<label>
											<span style="width:20px; margin:0 5px;">at&eacute;</span>
											<input type="text" name="valorFim" size="15" style="padding-right:3px;" tipo="numerico" orientacao="esquerda" mascara="###.###.###.###,##" value="<?php print("$valorFim"); ?>">
										</label>
									</td>
								</tr>
							</table>
						</td>
						<td width="95" align="center"><input type="submit" name="submitBusca" id="submitBusca" value=""></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<?php
				$idDestaque=devolveImoveisDestaqueNovo();
			?>

		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<?php
			$retorno = devolveImoveisDestaqueHome($idDestaque);
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<?php
				devolveImoveisHome($idDestaque, $retorno[0], $retorno[1], $retorno[2]);
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center"><img src="images/atendimento_personalizado.jpg"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>