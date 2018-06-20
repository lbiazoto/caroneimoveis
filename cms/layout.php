<?php
function devolveDataExtenso($cidade)
{
	$dia = date("d");
	$ano = date("Y");
	$mes = date("m");
	switch($mes)
	{
		case 1: $mesE = "Janeiro"; break;
		case 2: $mesE = "Fevereiro"; break;
		case 3: $mesE = "Março"; break;
		case 4: $mesE = "Abril"; break;
		case 5: $mesE = "Maio"; break;
		case 6: $mesE = "Junho"; break;
		case 7: $mesE = "Julho"; break;
		case 8: $mesE = "Agosto"; break;
		case 9: $mesE = "Setembro"; break;
		case 10: $mesE = "Outubro"; break;
		case 11: $mesE = "Novembro"; break;
		case 12: $mesE = "Dezembro"; break;
	}
	print("$cidade, $dia de $mesE de $ano");
}

function devolveMenu($idUsuario, $modulo)
{
	include("./config.php");
	if (!conectaBancoDados())
	{
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
	{
		if($idUsuario!="-1")
			$comandoSql = "SELECT modu.id as idModulo,modu.icone as icone, modu.fantasia as nomeModuloFantasia, modu.nome as nomeModulo FROM permissoes per INNER JOIN modulos modu ON per.idModulo=modu.id WHERE per.idUsuario='$idUsuario' ORDER BY ordem ASC";
		else
			$comandoSql = "SELECT modu.id as idModulo,modu.icone as icone, modu.fantasia as nomeModuloFantasia, modu.nome as nomeModulo FROM modulos modu ORDER BY ordem ASC";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			print('
				<table class="middle_wrapper">
					<tr>
						<td class="right_menu_wrapper">
							<div class="clear_both"></div>
							<div class="menu_wrapper">
								<div class="menu_categ_wrapper">
									<div class="menu_categ_active_header">
										<img src="css/images/icons/key_t.png" class="categ_icon" />
										<span>Dashboard</span>
									</div>
								</div>
							');
							$cont=1;
							while($linha = mysql_fetch_array($dados))
							{
								if($modulo==$linha[nomeModulo])
									$style="style='display: block;'";
								else
									$style="style='display: none;'";
								print("
									<div class='menu_categ_wrapper'>
										<div class='menu_categ_header'
											 onmouseover=\"
											 	el = document.getElementById( 'menu_items_wrapper_$cont' );
											 	img_cur = document.getElementById( 'img_cur_$cont' );
												if( el.style.display == 'none')
												{
													img_cur.src='css/images/arr_dn_hover.gif';
												}
											\"
											onmouseout=\"
												if( el.style.display == 'none')
												{
													img_cur.src='css/images/arr_dn.gif';
												}
											\"
											onclick=\"
												if( el.style.display == 'none' )
												{
													el.style.display = 'block';
													img_cur.src = 'css/images/arr_dn_act.gif';
												}
												else
												{
													el.style.display = 'none';
													img_cur.src = 'css/images/arr_dn.gif';
												}
											\"
										>
											<img src='css/images/icons/$linha[icone]' class='categ_icon'>
											<img src='css/images/arr_dn.gif' class='categ_arr'/ id='img_cur_$cont'>
											<a href='#'>$linha[nomeModuloFantasia]</a>
										</div>
										<div class='menu_items_wrapper' id='menu_items_wrapper_$cont' $style>
											");
											$comandoSqlSub = "SELECT * FROM menu WHERE idModulo = '$linha[idModulo]' ORDER BY ordem ASC";
											debug($comandoSqlSub);
											$dadosSub = mysql_db_query($bancoDados, $comandoSqlSub);
											if ($dadosSub)
											{
												$num = mysql_num_rows($dadosSub);
												if($num > 0)
												{
													while($linhaSub = mysql_fetch_array($dadosSub))
													{
														print("
															<div class='menu_item_wrapper'>
																<a href='?modulo=$linha[nomeModulo]&acao=$linhaSub[acao]&tipo=$linhaSub[tipo]'>$linhaSub[nome]</a>
															</div>
														");
													}
												}
											}
											print("
										</div>
									</div>
								");
								$cont++;
							}
							print('
								<div class="menu_categ_wrapper">
									<div class="menu_categ_active_header">
										<img src="css/images/icons/logout.png" class="categ_icon" />&nbsp;
										<span><a href="?acao=logout">Sair</a></span>
									</div>
								</div>
								<div style="text-align:center; margin:20px;">
									<a href="http://www.betag.com.br" title="Betag Sistemas">
										<img src="imagens/logo.gif" border="0" alt="Betag Sistemas" />
									</a>
								</div>
							<div class="clear_both"></div>
						</td>
					</tr>
				</table>
			');
		}
	}
}
?>