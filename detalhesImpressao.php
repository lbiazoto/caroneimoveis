<html>
<head>
	<title>Carone - corretora de im&oacute;veis</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<META NAME="author" CONTENT="BetaG Soluções">
	<META NAME="robots" CONTENT="index,follow">
	<META HTTP-EQUIV="content-language" content="pt-br">
	<META NAME="reply-to" CONTENT="">
	<META NAME="description" CONTENT="">
	<META NAME="keywords" CONTENT="">
	<script type="text/javascript" src="js/util.js"></script>
	<style>
		body{background-color:#FFFFFF; margin:0px;}
		th{
			text-align:left;
		}
		#comlinha td{border-bottom:1px solid #ddd;}
	</style>
</head>
<body>
<div>
<?php
	include("func.php");
	include("cms/util.php");
$linha = devolveInfoSite("imoveis", $id);
if($linha['deletado']==1){
	print("<script type='text/javascript'>window.location='index.php';</script>");
}
$valor = "R$ ".devolveValor($linha['valor']);
?>
<table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="center">
			<table width="600" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td rowspan="5"><img src="images/logo_carone.png"></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>contato@caroneimoveis.com.br | Escrit&oacute;rio - (47) 3461.3176</td></tr>
				<tr><td>CRECI 16512 | Ana Maria Carone - (47) 8804.3167</td></tr>
				<tr><td>CRECI 12014 | Bernadete Carone - (47) 9182.7476</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td colspan="2">&nbsp;</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" id="comlinha">
            	<tr>
                	<td width="40%" align="center" valign="middle" style='border:none;'>
						<?php
                            if($linha['imagem'] && file_exists("imoveis/m_$linha[imagem]"))
                            {
                                $tamanho=getimagesize("imoveis/m_$linha[imagem]");
								$height="";
								if($tamanho[1]>$tamanho[0])
								{
									$height="height='172'";
								}
								print("
                                    <table width='244' cellpadding='0' cellspacing='0' border='0'>
										<tr id='tableImagem1'>
											<td valign='middle' align='center' style='border:none;'>
												<img src='imoveis/m_$linha[imagem]' $height border='0'>
											</td>
										</tr>
										<tr id='tableImagem2'>
											<td align='center' style='border:none;'><a href='#' onclick=\"hide('tableImagem1'); hide('tableImagem2'); return false;\">Clique para esconder a imagem</a>
										</tr>
									</table>

                                ");
                            }
                        ?>
            		</td>
                    <td width="60%" align="center" valign="top" style='border:none;'>
						<?php
                            if($linha['descricaoCompleta'])
                            {
                                print("
									<table width='500' cellpadding='0' cellspacing='0' border='0'>
										<tr>
											<td style='padding:4px; line-height:18px;' valign='top'>Referência: CI $linha[referencia]</td>
										</tr>
									</table>
                                    <table width='500' cellpadding='0' cellspacing='0' border='0'>
										<tr>
											<td style='padding:4px; height:80px; line-height:18px;' valign='top'>$linha[descricaoCompleta]</td>
										</tr>
									</table>
                                ");
                            }
                        ?>
                        <br>
            		</td>
        		</tr>
            </table>
            <table width="100%" align="center" cellpadding="1" cellspacing="0" style="margin-top:5px;" id="comlinha">
                <tr>
                	<th class="thDetalhes">Valor</td>
                </tr>
                <tr>
                	<td class="tdDetalhes"><?php print($valor);?></td>
                </tr>
                <tr>
                	<th class="thDetalhes">Composição</td>
                </tr>
                <tr>
                	<td class="tdDetalhes" style="border:none;"><?php devolveComposicao($linha['id']);?></td>
                </tr>
                <tr>
                	<th class="thDetalhes">Mais Informações</td>
                </tr>
                <tr>
                	<td class="tdDetalhes"><?php print(nl2br($linha['maisInformacoes']));?></td>
                </tr>
                <tr>
                	<th class="thDetalhes">Localiza&ccedil;&atilde;o</td>
                </tr>
                <tr>
                	<td class="tdDetalhes">
						<?php
							$localizacao="";
							if($linha['idCidade']!="")
							{
								$cidade = devolveInfoSite("cidades", $linha['idCidade']);
								$localizacao.=" $cidade[nome] ";
							}
							if($linha['idRegiao']!="")
							{
								$regiao = devolveInfoSite("regiao", $linha['idRegiao']);
								$localizacao.=" / $regiao[nome] ";
							}
							if($linha['idBairro']!="")
							{
								$bairro = devolveInfoSite("bairros", $linha['idBairro']);
								$localizacao.=" / $bairro[nome] ";
							}
							print("$localizacao");
						?>
					</td>
                </tr>
                <tr>
                	<th class="thDetalhes">Mapa</td>
                </tr>
                <tr>
			    	<td style="text-align:center;">


			    		   <script type="text/javascript" src="js/maps.js"></script>
			    		   <?php
			    		   $endereco = "BR, $cidade[nome], $bairro[nome], $linha[endereco]";
			    		   ?>
			    		   <div id="mapa" style="widht: 100%; height:350px; margin: 0px; padding: 0px; border:1px solid #999;overflow:hidden"></div>
			    		   <!--caroneimoveis.com.br - ABQIAAAAiIZRoZbslJAsDBGkEn9GbBT2n4v0MHtMSW_vrbvpJZ7Lu3LsyBSj84pq9__Y9_9ysPqi-EO3XfvDcQ-->
			    		   <!--server: ABQIAAAAp6ATGQuwk18B6iDfzxqlKRQaOzcbF5ealenFI9Pv5eWXfr2UbRSDRuGF67P9wNsN0x9l3y1i9bXLWg-->
			    		   <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAiIZRoZbslJAsDBGkEn9GbBT2n4v0MHtMSW_vrbvpJZ7Lu3LsyBSj84pq9__Y9_9ysPqi-EO3XfvDcQ" type="text/javascript"></script>
			    		   <script type="text/javascript">
			    		   var widthMapa = 850;
			    		   var heightMapa = 350;
			    		   inicializa(widthMapa, heightMapa);
			    		   <?php
			    		   if($linha['localizacao_mapa']!=""){
			    		   ?>showAddress("<?php print("$linha[localizacao_mapa]");?>", "<?php print("<img src='imoveis/m_$linha[imagem]' $height border='0' style='clear:both;'>");?>", "<?php print("$cont");?>");<?php
}
else{
?>realizaConsulta("<?php print("$endereco");?>","<?php print("<img src='imoveis/m_$linha[imagem]' $height border='0' style='clear:both;'>");?>");<?php
}
?>
			    		   </script>

					</td>
			    </tr>
        	</table>
        </td>
		<td width="50">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
</div>
</body>