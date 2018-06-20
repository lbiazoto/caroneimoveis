<?php
if($site=="")
{
	$idCategoria = $_GET['idCategoria'];
	$referencia = $_GET['referencia'];
	$idCidadeRegiao = $_GET['idCidadeRegiao'];
	$valorIni = $_GET['valorIni'];
	$valorFim = $_GET['valorFim'];
	$tipoImovel = $_GET['tipoImovel'];
	header("Location: index.php?site=imoveis&idCategoria=$idCategoria&referencia=$referencia&idCidadeRegiao=$idCidadeRegiao&valorIni=$valorIni&valorFim=$valorFim&tipoImovel=$tipoImovel");
}

if($index == "") $index = 0;
if($mark=="")    $mark = 1;
if($ord=="")     $ord="novos";
if($ppp=="")     $ppp="12";

if($referencia!="")
{
	if($id=existeImovel($referencia))
	{
		print("
			<script language='javascript'>
				window.location='index.php?site=detalhes&id=$id';
			</script>
		");
	}
	else
	{
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
	<tr>
		<td align="center">
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

	<tr><td colspan="2">&nbsp;</td></tr>
    <tr>
		<td colspan="2" align="left">

			<img src="images/titulo_imoveis.jpg" border="0" style="margin-left:20px;">
		</td>
	</tr>

	<tr>
		<td>
			<div id="filtros">
				<div id="classificacao">
		            <h2>Ordenar por:</h2>
		            <a href="index.php?site=imoveis&tipoImovel=<?php print($tipoImovel);?>&idCategoria=<?php print($idCategoria);?>&idCidadeRegiao=<?php print($idCidadeRegiao);?>&valorIni=<?php print($valorIni);?>&valorFim=<?php print($valorFim);?>&ord=novos&ppp=<?php print($ppp); ?>&index=<?php print($index);?>&mark=<?php print($mark);?>" class="filtro<?php if($ord=="novos") print("Over"); ?>">Recentes</a>
		            <a href="index.php?site=imoveis&tipoImovel=<?php print($tipoImovel);?>&idCategoria=<?php print($idCategoria);?>&idCidadeRegiao=<?php print($idCidadeRegiao);?>&valorIni=<?php print($valorIni);?>&valorFim=<?php print($valorFim);?>&ord=precoMais&ppp=<?php print($ppp); ?>&index=<?php print($index);?>&mark=<?php print($mark);?>" class="filtro<?php if($ord=="precoMais") print("Over"); ?>">Maior Valor</a>
		            <a href="index.php?site=imoveis&tipoImovel=<?php print($tipoImovel);?>&idCategoria=<?php print($idCategoria);?>&idCidadeRegiao=<?php print($idCidadeRegiao);?>&valorIni=<?php print($valorIni);?>&valorFim=<?php print($valorFim);?>&ord=precoMenos&ppp=<?php print($ppp); ?>&index=<?php print($index);?>&mark=<?php print($mark);?>" class="filtro<?php if($ord=="precoMenos") print("Over"); ?>">Menor Valor</a>
		        </div><!--classificacao-->

		        <div id="resultados">
		            <h2 style="margin-left:210px;">Im&oacute;veis por p&aacute;gina:</h2>
		            <a href="index.php?site=imoveis&tipoImovel=<?php print($tipoImovel);?>&idCategoria=<?php print($idCategoria);?>&idCidadeRegiao=<?php print($idCidadeRegiao);?>&valorIni=<?php print($valorIni);?>&valorFim=<?php print($valorFim);?>&ord=<?php print($ord); ?>&ppp=12&index=<?php print($index);?>&mark=<?php print($mark);?>" class="filtro<?php if($ppp=="12") print("Over"); ?>">12</a>
		            <a href="index.php?site=imoveis&tipoImovel=<?php print($tipoImovel);?>&idCategoria=<?php print($idCategoria);?>&idCidadeRegiao=<?php print($idCidadeRegiao);?>&valorIni=<?php print($valorIni);?>&valorFim=<?php print($valorFim);?>&ord=<?php print($ord); ?>&ppp=16&index=<?php print($index);?>&mark=<?php print($mark);?>" class="filtro<?php if($ppp=="16") print("Over"); ?>">16</a>
		            <a href="index.php?site=imoveis&tipoImovel=<?php print($tipoImovel);?>&idCategoria=<?php print($idCategoria);?>&idCidadeRegiao=<?php print($idCidadeRegiao);?>&valorIni=<?php print($valorIni);?>&valorFim=<?php print($valorFim);?>&ord=<?php print($ord); ?>&ppp=20&index=<?php print($index);?>&mark=<?php print($mark);?>" class="filtro<?php if($ppp=="20") print("Over"); ?>">20</a>
		            <a href="index.php?site=imoveis&tipoImovel=<?php print($tipoImovel);?>&idCategoria=<?php print($idCategoria);?>&idCidadeRegiao=<?php print($idCidadeRegiao);?>&valorIni=<?php print($valorIni);?>&valorFim=<?php print($valorFim);?>&ord=<?php print($ord); ?>&ppp=0&index=<?php print($index);?>&mark=<?php print($mark);?>" class="filtro<?php if($ppp=="0") print("Over"); ?>">Todos</a>
		        </div><!--resultados-->
			</div><!--filtros-->
			<?php
				devolveImoveis($tipoImovel, $idCategoria, $idCidadeRegiao, $valorIni, $valorFim, $ord, $ppp, $index, $mark, $referencia);
			?>
        </td>
		<td width="50">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>