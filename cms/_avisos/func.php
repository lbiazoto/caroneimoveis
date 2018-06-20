<?php
function devolveListaAniversariantes($index, $mark, $where, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT id, nome, dataNascimento, MONTH(dataNascimento) as mes, DAY(dataNascimento) as dia FROM cliente $where LIMIT $index,25";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				devolveNavegacao($index, "index.php?modulo=avisos&acao=aniversariantes&tipo=listar", $where, $mark, "cliente", $post);
				print("
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='20%'>Data do Aniversário</th>
						<th align='left' width='10%'>Idade</th>
						<th align='left' width='50%'>Nome</th>
						<th align='center' width='10%'>Ver Detalhes</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
                    print("
						<tr>
							<td><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[dia] de ".devolveMes($linha['mes'])."</a></td>
							<td><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>".getIdade(converteDataFromMysql($linha['dataNascimento']))."</a></td>
							<td><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[nome]</a></td>
							<td style='text-align:center;'><a href='index.php?modulo=clientes&acao=clienteinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=avisos&acao=aniversariantes&tipo=listar", $where, $mark, "cliente", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data do Aniversário</th>
    						<th align='left' width='10%'>Idade</th>
    						<th align='left' width='50%'>Nome</th>
    						<th align='center' width='10%'>Ver Detalhes</th>
						</tr>
						<tr>
							<td colspan='4'>
								Nenhum registro de aniversariantes encontrado.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibiçao dos aniversariantes!</strong></center>");
	}
}
function getIdade($aniversario, $curr = 'now') {
    $year_curr = date("Y", strtotime($curr));
    $days = !($year_curr % 4) || !($year_curr % 400) & ($year_curr % 100) ? 366: 355;
    list($d, $m, $y) = explode('/', $aniversario);
    return floor(((strtotime($curr) - mktime(0, 0, 0, $m, $d, $y)) / 86400) / $days);
}

function devolveListaImoveisExclusivos($index, $mark, $where, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT id, referencia, idCliente, imagem, DATE_FORMAT(dataTerminoExclusividade,'%d/%m/%Y') as dataTerminoExclusividade FROM imoveis $where LIMIT $index,25";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				devolveNavegacao($index, "index.php?modulo=avisos&acao=exclusivos&tipo=listar", $where, $mark, "imoveis", $post);
				print("
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='15%'>Data Término Exclusividade</th>
						<th align='left' width='10%'>Referência</th>
						<th align='left' width='45%'>Cliente</th>
						<th align='center' width='10%'>Imagem</th>
						<th align='center' width='10%'>Ver Detalhes</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
                    $nomeCliente=devolveInfoCampo("nome", "cliente", $linha['idCliente']);
                    $verimagem="&nbsp;";
                    if($linha['imagem'])
						$verimagem = "<a href='../imoveis/g_$linha[imagem]' id='thumb1' class='highslide' onclick=\"return hs.expand(this)\"><img src='imagens/visualizar.png' border='0'></a>";
					print("
						<tr>
							<td><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[dataTerminoExclusividade]</a></td>
							<td><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$linha[referencia]</a></td>
							<td><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$nomeCliente</a></td>
							<td style='text-align:center;'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes' class='linkNormal'>$verimagem</a></td>
							<td style='text-align:center;'><a href='index.php?modulo=imoveis&acao=imovelinfo&tipo=detalhes&id=$linha[id]' title='Ver detalhes'><img src='imagens/ver_detalhes.png' border='0'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=avisos&acao=exclusivos&tipo=listar", $where, $mark, "imoveis", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='30%'>Data Término Exclusividade</th>
    						<th align='left' width='10%'>Referência</th>
    						<th align='left' width='30%'>Cliente</th>
    						<th align='center' width='10%'>Imagem</th>
    						<th align='center' width='10%'>Ver Detalhes</th>
						</tr>
						<tr>
							<td colspan='5'>
								Nenhum registro de imóveis exclusivos encontrado.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibiçao dos aniversariantes!</strong></center>");
	}
}
?>