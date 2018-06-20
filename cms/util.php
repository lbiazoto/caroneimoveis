<?php
/**
* @author Ademir Camillo Junior
* @version 1.0
* **/

function conectaBancoDados()
{
	include("config.php");
	$resultado = false;
	if (@mysql_connect($servidor, $usuarioBd, $senhaBd))
	{
		$resultado = true;
	}
	if(!$resultado)
		print("Não foi possível conectar ao banco de dados!");
	return $resultado;
}
/**
* Função responsável por mostrar uma mensagem para o usuário.
* @author Eduardo Reginini Maito
* @version 1.0
* @param $msg, $tipo
* @return mensagem exibida para o usuário
*/
function devolveMensagem($msg,$tipo)
{
	if($tipo)
	{
		print("
		<table border='0' cellspacing='0' cellpadding='0' align='center' width='88%' name='msgBox' id='msgBox' title='Clique aqui para esconder'
			style='border: 1px solid #9FB6CD; height: 30px; cursor:pointer; margin: 10px; padding:0px;' bgcolor='#B9D3EE' onclick='hide(\"msgBox\");'
		>
			<tr>
				<td align='center'>
					<img src='imagens/info.png' border='0' style='float:right; padding-right:20px;'>
					$msg
				</td>
			</tr>
		</table>
	");
	}else
	{
		print("
			<table border='0' cellspacing='0' cellpadding='0' align='center' width='88%' name='msgBox' id='msgBox' title='Clique aqui para esconder'
			style='border: 1px solid #CD0000; height: 30px; cursor:pointer; margin: 10px; padding:0px;' bgcolor='#FFDDDD' onclick='hide(\"msgBox\");'
		>
			<tr>
				<td align='center'>
					<img src='imagens/alert.png' border='0' style='float:right; padding-right:20px;'>
					$msg
				</td>
			</tr>
		</table>
	");
	}

}
/**
* Função responsável por retornar se algum usuário está logado.
* @author Eduardo Reginini Maito
* @version 1.0
* @param
* @return status da variável de controle de login
*/
function devolveUsuarioLogado(){
	return $_SESSION[$_SESSION[ID_ACESSO]];
}

function devolveInfo($tabela, $id)
{
	include("config.php");
	if(conectaBancoDados())
	{
		$comandoSql = "SELECT * FROM $tabela WHERE id = $id";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				return $linha;
			}
		}
	}
	return false;
}
function devolveInfoCampo($campo, $tabela, $id)
{
	include("config.php");
	if(conectaBancoDados())
	{
		$comandoSql = "SELECT $campo FROM $tabela WHERE id = $id";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				return $linha[$campo];
			}
		}
	}
	return false;
}

function devolveMsg($id)
{
	include("config.php");
	if(conectaBancoDados())
	{
		$comandoSql = "SELECT * FROM mensagem WHERE id = $id";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				if($linha[erro])
					$classe='class=\'erro\'';
				print("<p $classe>$linha[mensagem]</p>");
			}
		}else
		{
			return false;
		}
	}
}

function devolveDepartamento($depto)
{
	include("config.php"); // Inclui o arquivo de configuraçao do Banco de Dados.
	if(!conectaBancoDados()) {
		print("<center><strong>Não foi possível estabelecer conexão com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "SELECT * FROM rhdepartamento WHERE deletado = 0 AND id=$depto";
		//print($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			//print("OK");
			if($linha = mysql_fetch_array($dados))
			{
				print($linha[nome]);
			}
		}
	}
}

function montaComboEstado($estado, $branco, $todos)
{
if($estado == "" && $branco == false && $todos == false) $estado = 24;
if($todos)
	$todosP = "<option value='0' $estadoS0>Todos</option>";
if($branco)
	$brancoP = "<option value='-1'>&nbsp;</option>";
$estadoS = "estadoS$estado";
$$estadoS = " selected";
print(
"
<select name='estado' id='estado' style='width:218px;'>
	$brancoP
	$todosP
	<option value='1' $estadoS1>Acre</option>
	<option value='2' $estadoS2>Alagoas</option>
	<option value='3' $estadoS3>Amapa</option>
	<option value='4' $estadoS4>Amazonas</option>
	<option value='5' $estadoS5>Bahia</option>
	<option value='6' $estadoS6>Cear&aacute;</option>
	<option value='7' $estadoS7>Distrito Federal</option>
	<option value='8' $estadoS8>Esp&iacute;rito Santo</option>
	<option value='9' $estadoS9>Goi&aacute;s</option>
	<option value='10' $estadoS10>Maranh&atilde;o</option>
	<option value='11' $estadoS11>Mato Grosso</option>
	<option value='12' $estadoS12>Mato Grosso do Sul</option>
	<option value='13' $estadoS13>Minas Gerais</option>
	<option value='14' $estadoS14>Par&aacute;</option>
	<option value='15' $estadoS15>Para&iacute;ba</option>
	<option value='16' $estadoS16>Paran&aacute;</option>
	<option value='17' $estadoS17>Pernambuco</option>
	<option value='18' $estadoS18>Piau&iacute;</option>
	<option value='19' $estadoS19>Rio de Janeiro</option>
	<option value='20' $estadoS20>Rio Grande do Norte</option>
	<option value='21' $estadoS21>Rio Grande do Sul</option>
	<option value='22' $estadoS22>Rond&ocirc;nia</option>
	<option value='23' $estadoS23>Roraima</option>
	<option value='24' $estadoS24>Santa Catarina</option>
	<option value='25' $estadoS25>S&atilde;o Paulo</option>
	<option value='26' $estadoS26>Sergipe</option>
	<option value='27' $estadoS27>Tocantins</option>
</select>


");
}
function devolveEstado($estado)
{
	if($estado>-2 && $estado<28)
	{
		$listaEstados[-1] = " ";
		$listaEstados[0] = "Todos";
		$listaEstados[1] = "Acre";
		$listaEstados[2] = "Alagoas";
		$listaEstados[3] = "Amapa";
		$listaEstados[4] = "Amazonas";
		$listaEstados[5] = "Bahia";
		$listaEstados[6] = "Cear&aacute;";
		$listaEstados[7] = "Distrito Federal";
		$listaEstados[8] = "Esp&iacute;rito Santo";
		$listaEstados[9] = "Goi&aacute;s";
		$listaEstados[10] = "Maranh&atilde;o";
		$listaEstados[11] = "Mato Grosso";
		$listaEstados[12] = "Mato Grosso do Sul";
		$listaEstados[13] = "Minas Gerais";
		$listaEstados[14] = "Par&aacute;";
		$listaEstados[15] = "Para&iacute;ba";
		$listaEstados[16] = "Paran&aacute;";
		$listaEstados[17] = "Pernambuco";
		$listaEstados[18] = "Piau&iacute;";
		$listaEstados[19] = "Rio de Janeiro";
		$listaEstados[20] = "Rio Grande do Norte";
		$listaEstados[21] = "Rio Grande do Sul";
		$listaEstados[22] = "Rond&ocirc;nia";
		$listaEstados[23] = "Roraima";
		$listaEstados[24] = "Santa Catarina";
		$listaEstados[25] = "S&atilde;o Paulo";
		$listaEstados[26] = "Sergipe";
		$listaEstados[27] = "Tocantins";
		return $listaEstados[$estado];
	}else
	{
		return "Estado Inválido!";
	}
}
/**
* Função responsável por retornar o nome (não imprimir na tela) de um estado baseado no código passado para a função.
* @author Eduardo Reginini Maito
* @version 1.0
* @param $estado
* @return nome do estado ou erro caso o código não seja de nenhum estado
*/
function retornaEstado($estado)
{
	if($estado>-2 && $estado<28)
	{
		$listaEstados[-1] = " ";
		$listaEstados[0] = "Todos";
		$listaEstados[1] = "Acre";
		$listaEstados[2] = "Alagoas";
		$listaEstados[3] = "Amapa";
		$listaEstados[4] = "Amazonas";

		$listaEstados[5] = "Bahia";
		$listaEstados[6] = "Cear&aacute;";
		$listaEstados[7] = "Distrito Federal";
		$listaEstados[8] = "Esp&iacute;rito Santo";
		$listaEstados[9] = "Goi&aacute;s";
		$listaEstados[10] = "Maranh&atilde;o";
		$listaEstados[11] = "Mato Grosso";
		$listaEstados[12] = "Mato Grosso do Sul";
		$listaEstados[13] = "Minas Gerais";
		$listaEstados[14] = "Par&aacute;";
		$listaEstados[15] = "Para&iacute;ba";
		$listaEstados[16] = "Paran&aacute;";
		$listaEstados[17] = "Pernambuco";
		$listaEstados[18] = "Piau&iacute;";
		$listaEstados[19] = "Rio de Janeiro";
		$listaEstados[20] = "Rio Grande do Norte";
		$listaEstados[21] = "Rio Grande do Sul";
		$listaEstados[22] = "Rond&ocirc;nia";
		$listaEstados[23] = "Roraima";
		$listaEstados[24] = "Santa Catarina";
		$listaEstados[25] = "S&atilde;o Paulo";
		$listaEstados[26] = "Sergipe";
		$listaEstados[27] = "Tocantins";
		return $listaEstados[$estado];
	}else
	{
		 return "Estado Inválido!";
	}
}
function montaComboSexo($sexo, $branco, $todos)
{
if($todos)
	$todosP = "<option value='0' $sexoS0>Todos</option>";
if($branco)
	$brancoP = "<option value='-1'>&nbsp;</option>";
$sexoS = "sexoS$sexo";
$$sexoS = " selected";
print(
"

<select name='sexo' id='sexo'>
	$brancoP
	$todosP
	<option value='1' $sexoS1>Masculino</option>
	<option value='2' $sexoS2>Feminino</option>
</select>


");
}
function devolveSexo($sexo)
{
	if($sexo>-2 && $sexo<3)
	{
		$listaSexos[-1] = " ";
		$listaSexos[0] = "Todos";
		$listaSexos[1] = "Masculino";
		$listaSexos[2] = "Feminino";

		print($listaSexos[$sexo]);
	}else
	{
		print("Sexo Inválido!");
	}
}
function montaComboQtde($default, $nome, $inicio, $fim, $branco, $todos)
{
	$sel = "sel$nome";
	$$sel = " selected";
	$qtd=$inicio;
	print("<select name='$nome' id='$nome'>");
	if($branco)
		print("<option value='-1'>&nbsp;</option>");
	if($todos)
		print("<option value='0' sel0>Todos</option>");
	while($qtd < $fim){
		//if($qtd==0) $qtd+=1;
		if($qtd==$default)
			print("<option value='$qtd' selected>$qtd</option>");
		else
			print("<option value='$qtd' sel$qtd>$qtd</option>");
		$qtd++;
	}
	print("</select>");
}
function montaComboEstadoCivil($estadoCivil, $branco, $todos)
{
if($todos)
	$todosP = "<option value='0' $estadoCivilS0>Todos</option>";
if($branco)
	$brancoP = "<option value='-1'>&nbsp;</option>";
$estadoCivilS = "estadoS$estadoCivil";
$$estadoCivilS = " selected";
print(
"

<select name='estadoCivil' id='estadoCivil'>
	$brancoP
	$todosP
	<option value='1' $estadoCivilS1>Solteiro</option>
	<option value='2' $estadoCivilS2>Casado</option>
	<option value='3' $estadoCivilS3>Separado</option>
	<option value='4' $estadoCivilS4>Divorciado</option>
	<option value='5' $estadoCivilS5>Viúvo</option>
	<option value='6' $estadoCivilS6>União Estável</option>
</select>


");
}
function devolveEstadoCivil($estadoCivil)
{
	if($estadoCivil>-2 && $estadoCivil<7)
	{
		$listaEstadoCivil[-1] = " ";
		$listaEstadoCivil[0] = "Todos";
		$listaEstadoCivil[1] = "Solteiro";
		$listaEstadoCivil[2] = "Casado";
		$listaEstadoCivil[3] = "Separado";
		$listaEstadoCivil[4] = "Divorciado";
		$listaEstadoCivil[5] = "Viúvo";
		$listaEstadoCivil[6] = "União Estável";
		print($listaEstadoCivil[$estadoCivil]);
	}else
	{
		print("Estado Civil Inválido!");
	}
}
function devolveEscolaridade($escolaridade)
{
		if($escolaridade>-2 && $escolaridade<9)
		{
			$listaEscolaridade[-1] = " ";
			$listaEscolaridade[0] = "Todos";
			$listaEscolaridade[1] = "Analfabeto";
			$listaEscolaridade[2] = "Ensino Fundamental Incompleto";
			$listaEscolaridade[3] = "Ensino Fundamental Completo";
			$listaEscolaridade[4] = "Ensino M&eacute;dio Incompleto";
			$listaEscolaridade[5] = "Ensino M&eacute;dio Completo";
			$listaEscolaridade[6] = "Ensino Superior Incompleto";
			$listaEscolaridade[7] = "Ensino Superior Completo";
			print($listaEscolaridade[$escolaridade]);
		}else
		{
			print("Escolaridade Inválida!");
		}
}
function montaComboEscolaridade($escolaridade, $branco, $todos)
{
	if($todos)
	$todosP = "<option value='0' $escolaridadeS0>Todos</option>";
	if($branco)
		$brancoP = "<option value='-1'>&nbsp;</option>";
	$escolaridadeS = "escolaridadeS$escolaridade";
	$$escolaridadeS = " selected";
	print(
	"
	<select name='escolaridade' id='escolaridade'>
		$brancoP
		$todosP
		<option value='1' $escolaridadeS1>Analfabeto</option>
		<option value='2' $escolaridadeS2>Ensino Fundamental Incompleto</option>
		<option value='3' $escolaridadeS3>Ensino Fundamental Completo</option>
		<option value='4' $escolaridadeS4>Ensino M&eacute;dio Incompleto</option>
		<option value='5' $escolaridadeS5>Ensino M&eacute;dio Completo</option>
		<option value='6' $escolaridadeS5>Ensino Superior Incompleto</option>
		<option value='7' $escolaridadeS5>Ensino Superior Completo</option>
	</select>
	");
}
function devolveRaca($raca)
{
	if($raca>-2 && $raca<6)
	{
		$racaS[-1] = " ";
		$racaS[0] = "Todos";
		$racaS[1] = "Branco";
		$racaS[2] = "Índio";
		$racaS[3] = "Mulato";
		$racaS[4] = "Negro";
		$racaS[5] = "Pardo";
		print($racaS[$raca]);
	}else
	{
		print("Raça Inválida!");
	}
}
function montaComboRaca($raca, $branco, $todos)
{
	if($todos)
	$todosP = "<option value='0' $racaS0>Todos</option>";
	if($branco)
		$brancoP = "<option value='-1'>&nbsp;</option>";
	$racaS = "racaS$raca";
	$$racaS = " selected";
	print(
	"
	<select name='raca' id='raca'>
		$brancoP
		$todosP
		<option value='1' $racaS1>Branco</option>
		<option value='2' $racaS2>Índio</option>
		<option value='3' $racaS3>Mulato</option>
		<option value='4' $racaS4>Negro</option>
		<option value='5' $racaS5>Pardo</option>
	</select>
	");
}
function devolveTipoSanguineo($tipoSanguineo)
{
	if($tipoSanguineo>-2 && $tipoSanguineo<9)
	{
		$tipoSanguineoS[-1] = " ";
		$tipoSanguineoS[0] = "Todos";
		$tipoSanguineoS[1] = "A+";
		$tipoSanguineoS[2] = "B+";
		$tipoSanguineoS[3] = "AB+";
		$tipoSanguineoS[4] = "O+";
		$tipoSanguineoS[5] = "A-";
		$tipoSanguineoS[6] = "B-";
		$tipoSanguineoS[7] = "AB-";
		$tipoSanguineoS[8] = "O-";
		print($tipoSanguineoS[$tipoSanguineo]);
	}else
	{
		print("Tipo Sanguíneo Inválido!");
	}
}
function montaComboTipoSanguineo($tipoSanguineo, $branco, $todos)
{
	if($todos)
	$todosP = "<option value='0' $tipoSanguineoS0>Todos</option>";
	if($branco)
		$brancoP = "<option value='-1'>&nbsp;</option>";
	$tipoS = "tipoSanguineoS$tipoSanguineo";
	$$tipoS = " selected";
	print(
	"
	<select name='tipoSanguineo' id='tipoSanguineo'>
		$brancoP
		$todosP
		<option value='1' $tipoSanguineoS1>A+</option>
		<option value='2' $tipoSanguineoS2>B+</option>
		<option value='3' $tipoSanguineoS3>AB+</option>
		<option value='4' $tipoSanguineoS4>O+</option>
		<option value='5' $tipoSanguineoS5>A-</option>
		<option value='6' $tipoSanguineoS6>B-</option>
		<option value='7' $tipoSanguineoS7>AB-</option>
		<option value='8' $tipoSanguineoS8>O-</option>
	</select>
	");

}
function montaCheckSimNao($simNao, $nome, $style)
{
if($simNao)
	$checked1 = " checked";
else
	$checked0 = " checked";
print(
"
	<input name='$nome' type='radio' value='1' $checked1 $style>Sim
	<input name='$nome' type='radio' value='0' $checked0 $style>Não
");
}
function devolveSimNao($simNao)
{
	if($simNao)
		return("Sim");
	else
		return("Não");
}
function montaCheckSimNaoPesquisa($simNao, $nome)
{

print(
"
	<input name='$nome' type='radio' value='1'>Sim
	<input name='$nome' type='radio' value='0'>Não
	<input name='$nome' type='radio' value='-1' checked>Todos
");
}
function formataValor($valor)
{
	$valor =  str_replace('.', '', $valor);
	$valor =  str_replace(',', '.', $valor);
	return $valor;
}
function devolveValor($valor)
{
	return number_format($valor, 2, ',', '.');
}
function addAspas($campo)
{
	return str_replace('\'', '\\\'', $campo);
}
function stripAspas($campo)
{
	return str_replace('\\\'', '\'', $campo);
}
function alternarCorList($index)
{
	include("config.php");
	if($index%2!=0)
	{
		return $corFundoAmareloEscuro;
	}else
	{
		return $corFundoAmareloClaro;
	}
}
function montaComboDia($dia, $branco, $todos)
{
	if($todos)
		$todosP = "<option value='0' $dia0>Todos</option>";
	if($branco)
		$brancoP = "<option value='-1'>&nbsp;</option>";
	$diaS = "dia$dia";
	$$diaS = " selected";
	print(
	"
			<select name='dia' id='dia'>
				$brancoP
				$todosP
				<option value='1' $dia1>1</option>
				<option value='2' $dia2>2</option>
				<option value='3' $dia3>3</option>
				<option value='4' $dia4>4</option>
				<option value='5' $dia5>5</option>
				<option value='6' $dia6>6</option>
				<option value='7' $dia7>7</option>
				<option value='8' $dia8>8</option>
				<option value='9' $dia9>9</option>
				<option value='10' $dia10>10</option>
				<option value='11' $dia11>11</option>
				<option value='12' $dia12>12</option>
				<option value='13' $dia13>13</option>
				<option value='14' $dia14>14</option>
				<option value='15' $dia15>15</option>
				<option value='16' $dia16>16</option>
				<option value='17' $dia17>17</option>
				<option value='18' $dia18>18</option>
				<option value='19' $dia19>19</option>
				<option value='20' $dia20>20</option>
				<option value='21' $dia21>21</option>
				<option value='22' $dia22>22</option>
				<option value='23' $dia23>23</option>
				<option value='24' $dia24>24</option>
				<option value='25' $dia25>25</option>
				<option value='26' $dia26>26</option>
				<option value='27' $dia27>27</option>
				<option value='28' $dia28>28</option>
				<option value='29' $dia29>29</option>
				<option value='30' $dia30>30</option>
				<option value='31' $dia31>31</option>
		  	</select>
	");
}
function montaComboMes($mes, $branco, $todos)
{
	if($todos)
		$todosP = "<option value='0' $mes0>Todos</option>";
	if($branco)
		$brancoP = "<option value='-1'>&nbsp;</option>";
	$mesS = "mes$mes";
	$$mesS = " selected";
	print(
	"
			<select name='mes' id='mes'>
				$todosP
				$brancoP
				<option value='1' $mes1>Janeiro</option>
				<option value='2' $mes2>Fevereiro</option>
				<option value='3' $mes3>Mar&ccedil;o</option>
				<option value='4' $mes4>Abril</option>
				<option value='5' $mes5>Maio</option>
				<option value='6' $mes6>Junho</option>
				<option value='7' $mes7>Julho</option>
				<option value='8' $mes8>Agosto</option>
				<option value='9' $mes9>Setembro</option>
				<option value='10' $mes10>Outubro</option>
				<option value='11' $mes11>Novembro</option>
				<option value='12' $mes12>Dezembro</option>
		  	</select>
	");
}
function devolveMes($mes)
{
	if($mes>-2 && $mes<13)
	{
		$mesS[-1] = " ";
		$mesS[0] = "Todos";
		$mesS[1] = "Janeiro";
		$mesS[2] = "Fevereiro";
		$mesS[3] = "Mar&ccedil;o";
		$mesS[4] = "Abril";
		$mesS[5] = "Maio";
		$mesS[6] = "Junho";
		$mesS[7] = "Julho";
		$mesS[8] = "Agosto";
		$mesS[9] = "Setembro";
		$mesS[10] = "Outubro";
		$mesS[11] = "Novembro";
		$mesS[12] = "Dezembro";
		return($mesS[$mes]);
	}else
	{
		return("Mês inválido!");
	}
}

function montaComboAno($ano, $branco, $todos)
{
	print("<select name='ano' id='ano'>");
	if($branco)
		print("<option value='-1'>&nbsp;</option>");
	if($todos)
		print("<option value='0' $ano0>Todos</option>");
	for($i=date("Y"); $i>=1950; $i--)
	{
		if($ano == $i) $sel = "selected"; else $sel = "";
		print(
		"
					<option value='$i' $sel>$i</option>
		");
	}
	print("</select>");
}

/**
* Funcao que recebe o valor data no padrao brasileiro dd/mm/aaaa e converte para o padrao para salvar no
* MySQL - aaaa-mm-dd
* @param $data - dd/mm/aaaa
* @return $dataF - aaaa-mm-dd ou false se a data de entrada estiver errada
* **/
function converteDataToMysql($data)
{
	if(strlen($data)==10)
		$dataF = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
	else
		$dataF = false;
	return $dataF;
}

/**
* Funcao que recebe o valor data no padrao MySQL - aaaa-mm-dd e
* converte para o padrao brasileiro dd/mm/aaaa
* @param $data - aaaa-mm-dd
* @return $dataF - dd/mm/aaaa ou false se a data de entrada estiver errada
* **/
function converteDataFromMysql($data)
{
	if(strlen($data)==10)
		$dataF = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);
	else
		$dataF = false;
	return $dataF;
}

/**
* Funcao que recebe o valor data no padrao MySQL - aaaa-mm-dd e
* converte para o padrao brasileiro dd/mm/aaaa
* @param $data - aaaa-mm-dd
* @return $dataF - dd/mm/aaaa ou false se a data de entrada estiver errada
* **/
function converteDataTimeFromMysql($data)
{
	if(strlen($data)==19)
		$dataF = substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4)." às ".substr($data, 11,8);
	else
		$dataF = false;
	return $dataF;
}

/**
* Funcao que recebe o valor $dataHora no padrao MySQL e converte para o padrao brasileiro
* @param $dataHora
* @return $dataF no formato correto, caso a data de entrada estiver errada false
* **/
function converteDataHoraFromMysql($dataHora)
{
	if(strlen($dataHora)!=10)
		$dataF = substr($dataHora,8,2) . "/" .substr($dataHora,5,2) . "/" . substr($dataHora,0,4) ." ". substr($dataHora,11,8);
	else
		$dataF = false;
	if($dataF=="// ") $dataF="";
	return $dataF;
}

/**
* Funcao para gerar um combo apartir de uma tabela
* @param 	$tabela - tabela onde estao os dados
* 			$nomeCombo - nome do select do combo
* 			$clausulaWhere - " WHERE id = 10", deixar em branco para todos.
* 			$selecionado - igual ao nomeCombo se for pegar quando der erro e definir o valor se quiser selecionar
* 			$todos - true para exibir a opcao todos
* 			$branco - true para exibir uma opcao em branco, se for campo obrigatorio $branco = false;
* 			$valueCampo - nome do campo da tabela que será usado com value=''
* 			$valueShow - nome do campo da tabela que será exibido no combo
* @return Sem retorno / print se sucesso ou mensagem de erro.
* **/
function montaComboGenerico($tabela, $nomeCombo, $clausulaWhere, $selecionado, $todos, $branco, $valueCampo, $valueShow)
{
	include("config.php");
	if (conectaBancoDados())
		$comando = "SELECT * FROM $tabela $clausulaWhere";
		//print($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			if(mysql_num_rows($dados) == 0)
			{
				print("Nenhum campo disponível para este módulo");
			}else
			{
				print("<select name='$nomeCombo' id='$nomeCombo'>");
				if($branco)
					print("<option value='-1'>&nbsp;</option>");
				if($todos)
					print("<option value='0'>Todos</option>");
				while ($linha = mysql_fetch_array($dados))
				{
					$vvalue = $linha[$valueCampo];
					$sshow = $linha[$valueShow];
					if($linha[$valueCampo] == "$selecionado") $selected = "selected"; else $selected = "";
					print("<option value='$vvalue' $selected>$sshow</option>");
				}
			}
		}
		print("</select>");
}

function validaEmail($email)
{
	$parte1 = explode("@",$email);
    $parte2 = explode(".",$parte1[1]);
    if (!((strlen($parte1[0]) >= 1) && (strlen($parte2[0])) >= 1 && (strlen($parte2[1]) >= 1)))
    {
    	return false;
    }
    else return true;
}

/**
* <?php
	if($index == "")
		$index = 0;
	if($mark=="")
		$mark = 1;
* >
* devolveNavegacao($index, $modulo, $acao, $where, $mark,$tabela);
* $index = Iniciar com zero
* $modulo = Modulo referente
* $acao = Acao do modulo
* $where = clausula where ex: " where id = 1 "
* $mark = marcador de posicao atual = iniciar com 1
* $tabela = tabela
* $post = comando post que deve ser informado na url
* **/

function devolveNavegacao($index, $acao, $where, $mark, $tabela, $post)
{
	include("config.php"); // Inclui o arquivo de configuraçao do Banco de Dados.
	if(!conectaBancoDados()) {
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	}
	else
    {
		$comandoSql = "SELECT COUNT(*) as numero FROM $tabela  $where ";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if($linha = mysql_fetch_array($dados))
			{
				if($linha[numero]>25)
				{
					$inicio=1;
					$fim=ceil($linha['numero']/25);
					$y=1;
					if($fim>=21)
					{
						if($mark<=10 && (ceil($linha['numero']/25))>21)
						{
							$fim=21;
						}
						if((10<$mark) && ($mark<(ceil($linha['numero']/25)-10)))
						{
							$inicio=$mark-10;
							$fim=$mark+10;
						}
						if($mark>=(ceil($linha['numero']/25)-10))
						{
							$inicio=ceil($linha['numero']/25)-20;
						}
					}

					print("<table width='100%'  border='0' cellspacing='5' cellpadding='10'><tr><td><div align='center'>");
					print(" <a href='$acao&mark=1$post' class='linkNormal'><img src='imagens/resultset_first.gif' border='0' title='Primeira Página' class='navLink'></a> ");
					if($index-25>=0)
					{
					 	$prev = $index-25;
					 	$markPrev = $mark-1;
					 print("
					 	<a href='$acao&index=$prev&mark=$markPrev$post'><img src='imagens/resultset_previous.gif' border='0' title='Página Anterior' class='navLink'></a>
						");
					}else
					{
						 print("
					 		<img src='imagens/resultset_previouspb.gif' border='0' class='navLink'>
						");

					}
					$y=$inicio;
					while($y<=$fim)
					{
						if($y == $mark)
						{
							print(" <span class='navLink'>$y</span> ");
						}else
						{
							$limite = ($y-1)*25;
							print(" <a href='$acao&index=$limite&mark=$y$post' class='navLink'>$y</a> ");
						}
						$y++;
					}

					$ultimo = ceil($linha['numero']/25);
					$indexUltimo = ($ultimo*25)-25;
					if($index+25<=$linha[numero])
					{
					 	$next = $index+25;
					 	$markNext = $mark+1;
					 print("
					 	<a href='$acao&index=$next&mark=$markNext$post'><img src='imagens/resultset_next.gif' border='0' title='Próxima Página' class='navLink'></a>
						");
					}else
					{
						 print("
					 		<img src='imagens/resultset_nextpb.gif' border='0' class='navLink'>
						");

					}
				print("<a href='$acao&index=$indexUltimo&mark=$ultimo$post' class='linkVer'><img src='imagens/resultset_last.gif' border='0' title='Última Página' class='navLink'></a> ");
				print("</div></td></tr></table>");
				}else
				{
					print("<BR>");
				}
			}
		}
	}
}

/**
* Função responsável por tirar os acentos de uma string passada como paramtro.
* @author Eduardo Reginini Maito
* @version 1.0
* @param $msg
* @return string sem os acentos
*/
function removeAcentos($msg)
{
	$aux = array("/[ÂÀÁÄÃ]/"=>"A",
		"/[âãàáä]/"=>"a",
		"/[ÊÈÉË]/"=>"E",
		"/[êèéë]/"=>"e",
		"/[ÎÍÌÏ]/"=>"I",
		"/[îíìï]/"=>"i",
		"/[ÔÕÒÓÖ]/"=>"O",
		"/[ôõòóö]/"=>"o",
		"/[ÛÙÚÜ]/"=>"U",
		"/[ûúùü]/"=>"u",
		"/ç/"=>"c",
		"/Ç/"=> "C");

	return preg_replace(array_keys($aux), array_values($aux), $msg);
}

/**
* Função responsável por retornar o dia da semana em português a partir de uma data no formato dd/mm/aaaa.
* @author Eduardo Reginini Maito
* @version 1.0
* @param $data
* @return string com o dia da semana
*/
function diaSemanaPortugues($data) {
	$diasemana = date("w", mktime(0,0,0,substr("$data", 3, 2),substr("$data", 0, 2),substr("$data", 6, 4)) );

	switch($diasemana) {
		case"0": $diasemana = "Domingo";       		break;
		case"1": $diasemana = "Segunda-Feira"; 		break;
		case"2": $diasemana = "Ter&ccedil;a-Feira"; break;
		case"3": $diasemana = "Quarta-Feira";  		break;
		case"4": $diasemana = "Quinta-Feira";  		break;
		case"5": $diasemana = "Sexta-Feira";   		break;
		case"6": $diasemana = "S&aacute;bado";      break;
	}
	return $diasemana;
}

/**
* Função responsável por montar uma expressão para testes
* @author Ademir Camillo Junior
* @version 1.0
* @param $msg
* @return mensagem exibida para o usuário
*/
function debug($msg)
{
	$_SESSION[debugMsg] .= $msg."<BR>";
}

/**
* Função responsável por somar um número determinado de dias a uma data passada. Formato da data a ser passada "dd/mm/YY"
* @author Eduardo Reginini Maito
* @version 1.0
* @param $data, $dias
* @return data final com os dias somados
*/
function dateAdd($data, $dias) {
    $data=explode("/",$data);
    return date("d/m/Y" , (mktime(0,0,0,$data[1],$data[0],$data[2])+($dias*24*60*60)) );
}

/**
*Função responsável por devolver a navegacao em um detalhe de tabela
*@author Ademir Camillo
*@version 1.0
*@param $id = id atual
* ,$tabela = tabela Referente
* ,$modulo = modulo
* ,$acao = acao
* , $campo = campo que será exibido no alt
* , $order = campo que será usado para ordenar
* , $where = clausula where se necessaria
*@exemplo ("cliente",$modulo,$acao, "nomeFantasia", "id", " AND tipoPessoa = 'Físico' ");
*@return
*/
function devolveAnterior($id,$tabela,$modulo,$acao, $campo, $where)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM $tabela WHERE id < '$id' AND deletado = 0 $where ORDER BY id DESC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if ($linha = mysql_fetch_array($dados))
			{
				print("&nbsp;<a href='index.php?modulo=$modulo&acao=$acao&id=$linha[id]'><img src='imagens/resultset_previous.gif' border='0' title='Anterior [$linha[$campo]]'></a>&nbsp;");
			}else
			{
				print("&nbsp;<img src='imagens/resultset_previouspb.gif' border='0'>&nbsp;");
			}
		}
	}
	return 0;
}
/**
*Função responsável por devolver a navegacao em um detalhe de tabela
*@author Ademir Camillo
*@version 1.0
*@param $id = id atual
* ,$tabela = tabela Referente
* ,$modulo = modulo
* ,$acao = acao
* , $campo = campo que será exibido no alt
* , $order = campo que será usado para ordenar
* , $where = clausula where se necessaria
*@exemplo ($id,"cliente",$modulo,$acao, "nomeFantasia", "id", " AND tipoPessoa = 'Físico' ");
*@return
*/
function devolveProximo($id,$tabela,$modulo,$acao, $campo, $where)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM $tabela WHERE id > '$id' AND deletado = 0 $where  ORDER BY id ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if ($linha = mysql_fetch_array($dados))
			{
				print("&nbsp;<a href='index.php?modulo=$modulo&acao=$acao&id=$linha[id]'><img src='imagens/resultset_next.gif' border='0' title='Próximo [$linha[$campo]]'></a>&nbsp;");;
			}else
			{
				print("&nbsp;<img src='imagens/resultset_nextpb.gif' border='0'>&nbsp;");;
			}
		}
	}
	return 0;
}
/**
*Função responsável por devolver a navegacao em um detalhe de tabela
*@author Ademir Camillo
*@version 1.0
*@param
* ,$tabela = tabela Referente
* ,$modulo = modulo
* ,$acao = acao
* , $campo = campo que será exibido no alt
* , $order = campo que será usado para ordenar
* , $where = clausula where se necessaria
*@exemplo ("cliente",$modulo,$acao, "nomeFantasia", "id", " AND tipoPessoa = 'Físico' ");
*@return
*/
function devolvePrimeiro($id,$tabela,$modulo,$acao, $campo, $where)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM $tabela WHERE deletado = 0  $where ORDER BY id ASC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if ($linha = mysql_fetch_array($dados))
			{
				if($linha[id] != $id)
					print("&nbsp;<a href='index.php?modulo=$modulo&acao=$acao&id=$linha[id]'><img src='imagens/resultset_first.gif' border='0' title='Primeiro [$linha[$campo]]'></a>&nbsp;");
				else
					print("&nbsp;<img src='imagens/resultset_firstpb.gif' border='0'>&nbsp;");
			}else
			{
				print("&nbsp;<img src='imagens/resultset_firstpb.gif' border='0'>&nbsp;");
			}
		}
	}
	return 0;
}
/**
*Função responsável por devolver a navegacao em um detalhe de tabela
*@author Ademir Camillo
*@version 1.0
*@param
* ,$tabela = tabela Referente
* ,$modulo = modulo
* ,$acao = acao
* , $campo = campo que será exibido no alt
* , $order = campo que será usado para ordenar
* , $where = clausula where se necessaria
*@exemplo ("cliente",$modulo,$acao, "nomeFantasia", "id", " AND tipoPessoa = 'Físico' ");
*@return
*/
function devolveUltimo($id,$tabela,$modulo,$acao, $campo, $where)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$comandoSql = "SELECT * FROM $tabela WHERE deletado = 0  $where ORDER BY id DESC";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			if ($linha = mysql_fetch_array($dados))
			{
				if($linha[id] != $id)
					print("&nbsp;<a href='index.php?modulo=$modulo&acao=$acao&id=$linha[id]'><img src='imagens/resultset_last.gif' border='0' title='Último [$linha[$campo]]'></a>&nbsp;");
				else
					print("&nbsp;<img src='imagens/resultset_lastpb.gif' border='0'>&nbsp;");
			}else
			{
				print("&nbsp;<img src='imagens/resultset_lastpb.gif' border='0'>&nbsp;");
			}
		}
	}
	return 0;
}
/**
* Função responsável por retornar um valor por extenso baseado no valor, na moeda e centavos
* @author Eduardo Reginini Maito
* @version 1.0
* @param $valor, $moedaSing, $moedaPlur, $centSing, $centPlur
* @return valor por extenso
*/
function valorExtenso($valor, $moedaSing="real", $moedaPlur="reais", $centSing="centavo", $centPlur="centavos")
{

   $centenas = array( 0,
       array(0, "cento",        "cem"),
       array(0, "duzentos",     "duzentos"),
       array(0, "trezentos",    "trezentos"),
       array(0, "quatrocentos", "quatrocentos"),
       array(0, "quinhentos",   "quinhentos"),
       array(0, "seiscentos",   "seiscentos"),
       array(0, "setecentos",   "setecentos"),
       array(0, "oitocentos",   "oitocentos"),
       array(0, "novecentos",   "novecentos") ) ;

   $dezenas = array( 0,
            "dez",
            "vinte",
            "trinta",
            "quarenta",
            "cinqüenta",
            "sessenta",
            "setenta",
            "oitenta",
            "noventa" ) ;

   $unidades = array( 0,
            "um",
            "dois",
            "três",
            "quatro",
            "cinco",
            "seis",
            "sete",
            "oito",
            "nove" ) ;

   $excecoes = array( 0,
            "onze",
            "doze",
            "treze",
            "quatorze",
            "quinze",
            "dezeseis",
            "dezesete",
            "dezoito",
            "dezenove" ) ;

   $extensoes = array( 0,
       array(0, "",       ""),
       array(0, "mil",    "mil"),
       array(0, "milhão", "milhões"),
       array(0, "bilhão", "bilhões"),
       array(0, "trilhão","trilhões") ) ;

   $valorForm = trim( number_format($valor,2,".",",") ) ;

   $inicio    = 0 ;

   if ( $valor <= 0 ) {
      return ( $valorExt ) ;
   }

   for ( $conta = 0; $conta <= strlen($valorForm)-1; $conta++ ) {
      if ( strstr(",.",substr($valorForm, $conta, 1)) ) {
         $partes[] = str_pad(substr($valorForm, $inicio, $conta-$inicio),3," ",STR_PAD_LEFT) ;
         if ( substr($valorForm, $conta, 1 ) == "." ) {
            break ;
         }
         $inicio = $conta + 1 ;
      }
   }

   $centavos = substr($valorForm, strlen($valorForm)-2, 2) ;

   if ( !( count($partes) == 1 and intval($partes[0]) == 0 ) ) {
      for ( $conta=0; $conta <= count($partes)-1; $conta++ ) {

         $centena = intval(substr($partes[$conta], 0, 1)) ;
         $dezena  = intval(substr($partes[$conta], 1, 1)) ;
         $unidade = intval(substr($partes[$conta], 2, 1)) ;

         if ( $centena > 0 ) {

            $valorExt .= $centenas[$centena][($dezena+$unidade>0 ? 1 : 2)] . ( $dezena+$unidade>0 ? " e " : "" ) ;
         }

         if ( $dezena > 0 ) {
            if ( $dezena>1 ) {
               $valorExt .= $dezenas[$dezena] . ( $unidade>0 ? " e " : "" ) ;

            } elseif ( $dezena == 1 and $unidade == 0 ) {
               $valorExt .= $dezenas[$dezena] ;

            } else {
               $valorExt .= $excecoes[$unidade] ;
            }

         }

         if ( $unidade > 0 and $dezena != 1 ) {
            $valorExt .= $unidades[$unidade] ;
         }

         if ( intval($partes[$conta]) > 0 ) {
            $valorExt .= " " . $extensoes[(count($partes)-1)-$conta+1][(intval($partes[$conta])>1 ? 2 : 1)] ;
         }

         if ( (count($partes)-1) > $conta and intval($partes[$conta])>0 ) {
            $conta3 = 0 ;
            for ( $conta2 = $conta+1; $conta2 <= count($partes)-1; $conta2++ ) {
               $conta3 += (intval($partes[$conta2])>0 ? 1 : 0) ;
            }

            if ( $conta3 == 1 and intval($centavos) == 0 ) {
               $valorExt .= " e " ;
            } elseif ( $conta3>=1 ) {
               $valorExt .= ", " ;
            }
         }

      }

      if ( count($partes) == 1 and intval($partes[0]) == 1 ) {
         $valorExt .= $moedaSing ;

      } elseif ( count($partes)>=3 and ((intval($partes[count($partes)-1]) + intval($partes[count($partes)-2]))==0) ) {
         $valorExt .= " de " + $moedaPlur ;

      } else {
         $valorExt = trim($valorExt) . " " . $moedaPlur ;
      }

   }

   if ( intval($centavos) > 0 ) {

      $valorExt .= (!empty($valorExt) ? " e " : "") ;

      $dezena  = intval(substr($centavos, 0, 1)) ;
      $unidade = intval(substr($centavos, 1, 1)) ;

      if ( $dezena > 0 ) {
         if ( $dezena>1 ) {
            $valorExt .= $dezenas[$dezena] . ( $unidade>0 ? " e " : "" ) ;

         } elseif ( $dezena == 1 and $unidade == 0 ) {
            $valorExt .= $dezenas[$dezena] ;

         } else {
            $valorExt .= $excecoes[$unidade] ;
         }

      }

      if ( $unidade > 0 and $dezena != 1 ) {
         $valorExt .= $unidades[$unidade] ;
      }
      $valorExt .= " " . ( intval($centavos)>1 ? $centPlur : $centSing ) ;
   }
   return ( $valorExt ) ;
}

/**
*Função que retorna data atual por extenso
*@author Eduardo Reginini Maito
*@version 1.0
*@param
*@return data no formato "DIA de DIA_DO_MÊS de ANO"
*/
function dataAtualPorExtenso(){
	 $m = date("n");
	 $dia = date("d");
	 $ano = date("Y");
	 $semana = array("Sun" => "Domingo", "Mon" => "Segunda-feira", "Tue" => "Terça-feira", "Wed" => "Quarta-feira", "Thu" => "Quinta-feira", "Fri" => "Sexta-feira", "Sat" => "Sábado");
	 $mes = array(1 =>"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
	 return "$dia de $mes[$m] de $ano";
}

/**
*Função responsável para testar se o módulo passado existe no sistema ou não
*@author Eduardo Reginini Maito
*@version 1.0
*@param $nomeModulo
*@return true caso o modulo exista e false caso nao exista
*/
function sistemaPossuiModulo($nomeModulo)
{
	include("config.php");
	if(conectaBancoDados())
	{
		$comandoSql = "SELECT * FROM modulos WHERE nome='$nomeModulo'";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($linha = mysql_fetch_array($dados))
				return true;
		}
	}
	return false;
}

/**
*Função responsável por testar se o sistema possui loja única ou várias lojas
*@author Eduardo Reginini Maito
*@version 1.0
*@param
*@return true caso possua mais de uma loja e false caso possua somente uma
*/
function sistemaPossuiVariasLojas()
{
	include("config.php");
	if(conectaBancoDados())
	{
		$comandoSql = "SELECT * FROM lojas";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		$numeroLinhas = mysql_num_rows($dados);
		if($numeroLinhas>1)
			return true;
	}
	return false;
}

/**
*Função responsável por devolver o id da loja quando ela é única, OBS: essa função somente deve ser chamada depois de se saber que
* o sistema não sistemaPossuiVariasLojas().
*@author Eduardo Reginini Maito
*@version 1.0
*@param
*@return caso pesquise com sucesso o id da loja, caso contrário 0
*/
function devolveIdLojaUnica()
{
	include("config.php");
	if(conectaBancoDados())
	{
		$comandoSql = "SELECT * FROM lojas";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($linha = mysql_fetch_array($dados))
				return $linha[id];
		}
	}
	return 0;
}
function devolveIdUnicaLoja()
{
	include("config.php");
	if(conectaBancoDados())
	{
		$comandoSql = "SELECT * FROM lojas";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($linha = mysql_fetch_array($dados))
				return $linha[id];
		}
	}
	return 0;
}

/**
*Função responsável por devolver os dados que serão impressos no cabeçalho dos comprovantes (não dos relatórios) de uma loja passada.
*@author Eduardo Reginini Maito
*@version 1.0
*@param $idLoja
*@return linha contendo os dados para impressão no comprovante
*/
function devolveDadosCabecalhoComprovanteLoja($idLoja)
{
	include("config.php");
	if(conectaBancoDados())
	{
		$comandoSql = "SELECT * FROM lojas WHERE id='$idLoja'";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($linha = mysql_fetch_array($dados))
				return $linha;
		}
	}
	return 0;
}


/**
*Função responsável por montar um combobox com as lojas as quais o usuário tem acesso ao seu conteúdo.
*  Essa verificação é feita pelas variáveis de sessão.
*@author Eduardo Reginini Maito
*@version 1.0
*@param $nomeCombo, $branco, $todos, $selecionado
*@return caso pesquise com sucesso o combobox montado, caso contrários "".
*/
function montaComboLojaAcessoUsuario($nomeCombo, $branco, $todos, $selecionado)
{
	include("config.php"); // Inclui o arquivo de configuraçao do Banco de Dados.
	if(!conectaBancoDados()) {
		print("<center><strong>Não foi possível estabelecer conexão com o Banco de Dados!</strong></center>");
	}
	else
	{
		if($todos)
			$todosP = "<option value='0'>Todos</option>";
		if($branco)
			$brancoP = "<option value='-1'>&nbsp;</option>";
		$comandoSql = "SELECT * FROM lojas ORDER BY nome";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			if($_SESSION['numeroLojasAcessaConteudo']==1)
			{
				while($linha = mysql_fetch_array($dados))
				{
					if($_SESSION['acessaConteudoLoja'][$linha[id]]==true)
						print("<input type='hidden' name='$nomeCombo' value='$linha[id]'>");
				}
			}
			else
			{
				print("<tr>
						<td align='left'>Loja:</td>
						<td align='left'>
						<select name='$nomeCombo' id='$nomeCombo' style='width:218px;'>
							$brancoP
							$todosP");
				while($linha = mysql_fetch_array($dados))
				{
					if($_SESSION['acessaConteudoLoja'][$linha[id]])
					{
						if($linha[id] == "$selecionado") $selected = "selected"; else $selected = "";
						print("<option value='$linha[id]' $selected>$linha[nome]</option>");
					}
				}
				print("	</select>
						</td>
					   </tr>");
			}
		}
	}
}

/**
*Função responsável por devolver uma expressão a ser aplicada a uma consulta ou relatório com as lojas as quais o usuário tem acesso.
* Isso só vai ocorrer quando for mulilojas e quando o usuário acessar mais de uma loja
*@author Eduardo Reginini Maito
*@version 1.0
*@param $nomeTabelaCampo
*@return caso pesquise com sucesso a expressão, caso contrários "".
*/
function montaExpressaoConsultaLojaAcessoUsuario($nomeTabelaCampo, $idUsuario)
{
	include("config.php"); // Inclui o arquivo de configuraçao do Banco de Dados.
	if(!conectaBancoDados()) {
		print("<center><strong>Não foi possível estabelecer conexão com o Banco de Dados!</strong></center>");
	}
	else
	{
		$expressao="AND (";
		$cont=0;
		if(sistemaPossuiVariasLojas())
		{
			$comando = "SELECT * FROM usuarioloja WHERE idUsuario='$idUsuario' AND status='1' AND deletado='0'";
			$dados = mysql_db_query($bancoDados, $comando);
			if ($dados)
			{
				while($linha = mysql_fetch_array($dados))
				{
					if($cont!=0)
						$expressao.=" OR ";
					$expressao.=" $nomeTabelaCampo='$linha[idLoja]' ";
					$cont++;
				}
			}
		}
		else
		{
			$expressao.=" $nomeTabelaCampo='".devolveIdLojaUnica()."' ";
		}
		$expressao.=" )";
		return $expressao;
	}
}

function montaComboFornecedor($fornecedor,$branco,$todos)
{
	include("config.php"); // Inclui o arquivo de configuraçao do Banco de Dados.
	if(!conectaBancoDados()) {
		print("<center><strong>Não foi possível estabelecer conexão com o Banco de Dados!</strong></center>");
	}
	else
	{
		if($todos)
			$todosP = "<option value='0'>Todos</option>";
		if($branco)
			$brancoP = "<option value='-1'>&nbsp;</option>";
		$comandoSql = "SELECT * FROM fornecedor WHERE deletado = 0";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			print("<select name='idFornecedor' id='idFornecedor' style='width:218px;'>
			$brancoP
			$todosP
			");
			while($linha = mysql_fetch_array($dados))
			{
				if($fornecedor == "$linha[id]")
				{
					$sele = "selected";
				}else
					$sele = "";
				print("<option value='$linha[id]' $sele>$linha[nomeFantasia]</option>");
			}
			print("</select>");
		}
	}
}

function montaComboDepartamento($depto,$branco,$todos)
{
	include("config.php"); // Inclui o arquivo de configuraçao do Banco de Dados.
	if(!conectaBancoDados()) {
		print("<center><strong>Não foi possível estabelecer conexão com o Banco de Dados!</strong></center>");
	}
	else
	{
		$comandoSql = "SELECT * FROM rhdepartamento WHERE deletado = 0";
		if($todos)
			$todosP = "<option value='0'>Todos</option>";
		if($branco)
			$brancoP = "<option value='-1'>&nbsp;</option>";
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if($dados)
		{
			print("<select name='depto' id='depto' style='width:218px;'>
			$brancoP
			$todosP");
			while($linha = mysql_fetch_array($dados))
			{
				if($depto == "$linha[id]")
				{
					$sele = "selected";
				}else
					$sele = "";
				print("<option value='$linha[id]' $sele>$linha[nome]</option>");
			}
			print("</select>");
		}
	}
}

/**
* Função responsável por devolver o nome de um determinado banco
* @author Rogério Giacomini de Almeida
* @version 1.0
* @param $selected
* @return codigo do banco
*/
function devolveBanco($codigoBanco){
	if($codigoBanco=="654")	return "BANCO A.J. RENNER S.A.";
	if($codigoBanco=="246")	return "BANCO ABC BRASIL S.A.";
	if($codigoBanco=="356")	return "BANCO ABN AMRO S.A.";
	if($codigoBanco=="025")	return "BANCO ALFA S/A.";
	if($codigoBanco=="213")	return "BANCO ARBI S.A.";
	if($codigoBanco=="029")	return "BANCO BANERJ S.A.";
	if($codigoBanco=="719")	return "BANCO BANIF PRIMUS S.A.";
	if($codigoBanco=="107")	return "BANCO BBM S.A.";
	if($codigoBanco=="291")	return "BANCO BCN S.A.";
	if($codigoBanco=="034")	return "BANCO BEA S.A.";
	if($codigoBanco=="048")	return "BANCO BEMGE S.A.";
	if($codigoBanco=="739")	return "BANCO BGN S.A.";
	if($codigoBanco=="096")	return "BANCO BM&F DE SERV. DE LIQUIDAÇÃO E CUSTODIA S.A.";
	if($codigoBanco=="394")	return "BANCO BMC S.A.";
	if($codigoBanco=="318")	return "BANCO BMG S.A.";
	if($codigoBanco=="116")	return "BANCO BNL DO BRASIL S.A.";
	if($codigoBanco=="752")	return "BANCO BNP PARIBAS BRASIL S.A.";
	if($codigoBanco=="231")	return "BANCO BOAVISTA INTERATLANTICO S.A-EM ABSORCAO";
	if($codigoBanco=="218")	return "BANCO BONSUCESSO S.A.";
	if($codigoBanco=="237")	return "BANCO BRADESCO S.A.";
	if($codigoBanco=="225")	return "BANCO BRASCAN S.A.";
	if($codigoBanco=="044")	return "BANCO BVA SA";
	if($codigoBanco=="263")	return "BANCO CACIQUE S.A.";
	if($codigoBanco=="222")	return "BANCO CALYON BRASIL S/A";
	if($codigoBanco=="412")	return "BANCO CAPITAL S.A.";
	if($codigoBanco=="266")	return "BANCO CEDULA S.A.";
	if($codigoBanco=="745")	return "BANCO CITIBANK S.A.";
	if($codigoBanco=="215")	return "BANCO COMERCIAL E DE INVESTIMENTO SUDAMERIS S.A";
	if($codigoBanco=="753")	return "BANCO COMERCIAL URUGUAI S.A.";
	if($codigoBanco=="756")	return "BANCO COOPERATIVO DO BRASIL S.A.";
	if($codigoBanco=="748")	return "BANCO COOPERATIVO SICREDI S.A. - BANSICREDI";
	if($codigoBanco=="721")	return "BANCO CREDIBEL S.A.";
	if($codigoBanco=="505")	return "BANCO CREDIT SUISSE FIRST BOSTON S.A.";
	if($codigoBanco=="229")	return "BANCO CRUZEIRO DO SUL S.A.";
	if($codigoBanco=="003")	return "BANCO DA AMAZONIA S.A.";
	if($codigoBanco=="707")	return "BANCO DAYCOVAL S.A.";
	if($codigoBanco=="495")	return "BANCO DE LA PROVINCIA DE BUENOS AIRES";
	if($codigoBanco=="494")	return "BANCO DE LA REPUBLICA ORIENTAL DEL URUGUAY";
	if($codigoBanco=="024")	return "BANCO DE PERNAMBUCO S.A.-BANDEPE";
	if($codigoBanco=="456")	return "BANCO DE TOKYO MITSUBISHI BRASIL S.A.";
	if($codigoBanco=="214")	return "BANCO DIBENS S.A.";
	if($codigoBanco=="001")	return "BANCO DO BRASIL S.A.";
	if($codigoBanco=="027")	return "BANCO DO ESTADO DE SANTA CATARINA S.A.";
	if($codigoBanco=="033")	return "BANCO DO ESTADO DE SAO PAULO S.A. - BANESPA";
	if($codigoBanco=="047")	return "BANCO DO ESTADO DE SERGIPE S.A.";
	if($codigoBanco=="035")	return "BANCO DO ESTADO DO CEARA S.A. BEC";
	if($codigoBanco=="036")	return "BANCO DO ESTADO DO MARANHAO S.A.-BEM";
	if($codigoBanco=="037")	return "BANCO DO ESTADO DO PARA S.A.";
	if($codigoBanco=="039")	return "BANCO DO ESTADO DO PIAUI S.A.-BEP";
	if($codigoBanco=="041")	return "BANCO DO ESTADO DO RIO GRANDE DO SUL S.A.";
	if($codigoBanco=="004")	return "BANCO DO NORDESTE DO BRASIL S.A.";
	if($codigoBanco=="743")	return "BANCO EMBLEMA S.A.";
	if($codigoBanco=="265")	return "BANCO FATOR S.A.";
	if($codigoBanco=="224")	return "BANCO FIBRA S.A.";
	if($codigoBanco=="626")	return "BANCO FICSA S.A.";
	if($codigoBanco=="175")	return "BANCO FINASA S.A.";
	if($codigoBanco=="252")	return "BANCO FININVEST S.A.";
	if($codigoBanco=="233")	return "BANCO GE CAPITAL S.A.";
	if($codigoBanco=="734")	return "BANCO GERDAU S.A.";
	if($codigoBanco=="612")	return "BANCO GUANABARA S.A.";
	if($codigoBanco=="063")	return "BANCO IBI S.A - BANCO MULTIPLO";
	if($codigoBanco=="604")	return "BANCO INDUSTRIAL DO BRASIL S.A.";
	if($codigoBanco=="320")	return "BANCO INDUSTRIAL E COMERCIAL S.A.";
	if($codigoBanco=="653")	return "BANCO INDUSVAL S.A.";
	if($codigoBanco=="630")	return "BANCO INTERCAP S.A.";
	if($codigoBanco=="249")	return "BANCO INVESTCRED UNIBANCO S.A.";
	if($codigoBanco=="341")	return "BANCO ITAU S.A.";
	if($codigoBanco=="074")	return "BANCO J. SAFRA S.A.";
	if($codigoBanco=="217")	return "BANCO JOHN DEERE S.A.";
	if($codigoBanco=="600")	return "BANCO LUSO BRASILEIRO S.A.";
	if($codigoBanco=="212")	return "BANCO MATONE S.A.";
	if($codigoBanco=="243")	return "BANCO MAXIMA S.A.";
	if($codigoBanco=="389")	return "BANCO MERCANTIL DO BRASIL S.A.";
	if($codigoBanco=="746")	return "BANCO MODAL S.A.";
	if($codigoBanco=="738")	return "BANCO MORADA S.A.";
	if($codigoBanco=="151")	return "BANCO NOSSA CAIXA S.A.";
	if($codigoBanco=="045")	return "BANCO OPPORTUNITY S.A.";
	if($codigoBanco=="208")	return "BANCO PACTUAL S.A.";
	if($codigoBanco=="623")	return "BANCO PANAMERICANO S.A.";
	if($codigoBanco=="611")	return "BANCO PAULISTA S.A.";
	if($codigoBanco=="650")	return "BANCO PEBB S.A.";
	if($codigoBanco=="613")	return "BANCO PECUNIA S.A.";
	if($codigoBanco=="643")	return "BANCO PINE S.A.";
	if($codigoBanco=="735")	return "BANCO POTTENCIAL S.A.";
	if($codigoBanco=="638")	return "BANCO PROSPER S.A.";
	if($codigoBanco=="747")	return "BANCO RABOBANK INTERNATIONAL BRASIL S.A.";
	if($codigoBanco=="216")	return "BANCO REGIONAL MALCON S.A.";
	if($codigoBanco=="633")	return "BANCO RENDIMENTO S.A.";
	if($codigoBanco=="741")	return "BANCO RIBEIRAO PRETO S.A.";
	if($codigoBanco=="453")	return "BANCO RURAL S.A.";
	if($codigoBanco=="422")	return "BANCO SAFRA S.A.";
	if($codigoBanco=="353")	return "BANCO SANTANDER BRASIL S.A.";
	if($codigoBanco=="008")	return "BANCO SANTANDER MERIDIONAL S.A.";
	if($codigoBanco=="351")	return "BANCO SANTANDER S.A.";
	if($codigoBanco=="250")	return "BANCO SCHAHIN S.A.";
	if($codigoBanco=="366")	return "BANCO SOCIETE GENERALE BRASIL S.A.";
	if($codigoBanco=="637")	return "BANCO SOFISA S.A.";
	if($codigoBanco=="347")	return "BANCO SUDAMERIS DO BRASIL S.A.";
	if($codigoBanco=="464")	return "BANCO SUMITOMO MITSUI BRASILEIRO S.A.";
	if($codigoBanco=="634")	return "BANCO TRIANGULO S.A.";
	if($codigoBanco=="247")	return "BANCO UBS S.A.";
	if($codigoBanco=="655")	return "BANCO VOTORANTIM S.A.";
	if($codigoBanco=="610")	return "BANCO VR S.A.";
	if($codigoBanco=="370")	return "BANCO WESTLB DO BRASIL  S.A.";
	if($codigoBanco=="219")	return "BANCO ZOGBI S.A.";
	if($codigoBanco=="062")	return "BANCO1.NET S.A.";
	if($codigoBanco=="028")	return "BANEB-EM ABSORCAO";
	if($codigoBanco=="021")	return "BANESTES S.A BANCO DO ESTADO DO ESPIRITO SANTO";
	if($codigoBanco=="479")	return "BANKBOSTON BANCO MULTIPLO S.A.";
	if($codigoBanco=="073")	return "BB BANCO POPULAR DO BRASIL";
	if($codigoBanco=="749")	return "BR BANCO MERCANTIL S.A.";
	if($codigoBanco=="070")	return "BRB - BANCO DE BRASILIA S.A.";
	if($codigoBanco=="104")	return "CAIXA ECONOMICA FEDERAL";
	if($codigoBanco=="487")	return "DEUTSCHE BANK S. A. - BANCO ALEMAO";
	if($codigoBanco=="210")	return "DRESDNER BANK LATEINAMERIKA AKTIENGESELLSCHAFT";
	if($codigoBanco=="399")	return "HSBC BANK BRASIL S.A.-BANCO MULTIPLO";
	if($codigoBanco=="076")	return "KDB DO BRASIL";
	if($codigoBanco=="065")	return "LEMON BANK BANCO MULTIPLO S.A.";
	if($codigoBanco=="030")	return "PARAIBAN-BANCO DA PARAIBA S.A.";
	if($codigoBanco=="254")	return "PARANA BANCO S.A.";
	if($codigoBanco=="409")	return "UNIBANCO - UNIAO DE BANCOS BRASILEIROS S.A.";
	if($codigoBanco=="230")	return "UNICARD BANCO MULTIPLO S.A.";
	if($codigoBanco=="999")	return "BANCO INEXISTENTE OU INDISPONÍVEL";
}
function montaComboBanco($name, $selected,$branco){
	$bancoS = "banco$selected";
	$$bancoS = " selected";

	print("
	<select name='$name' id='$name'>");
	if($branco)
		print("<option value='000'></option>");
	print("
			<option value='654' $banco654>BANCO A.J. RENNER S.A.</option>
			<option value='246' $banco246>BANCO ABC BRASIL S.A.</option>
			<option value='356' $banco356>BANCO ABN AMRO S.A.</option>
			<option value='025' $banco025>BANCO ALFA S/A.</option>
			<option value='213' $banco213>BANCO ARBI S.A.</option>
			<option value='029' $banco029>BANCO BANERJ S.A.</option>
			<option value='719' $banco719>BANCO BANIF PRIMUS S.A.</option>
			<option value='107' $banco107>BANCO BBM S.A.</option>
			<option value='291' $banco291>BANCO BCN S.A.</option>
			<option value='034' $banco034>BANCO BEA S.A.</option>
			<option value='048' $banco048>BANCO BEMGE S.A.</option>
			<option value='739' $banco739>BANCO BGN S.A.</option>
			<option value='096' $banco096>BANCO BM&F DE SERV. DE LIQUIDAÇÃO E CUSTODIA S.A.</option>
			<option value='394' $banco394>BANCO BMC S.A.</option>
			<option value='318' $banco318>BANCO BMG S.A.</option>
			<option value='116' $banco116>BANCO BNL DO BRASIL S.A.</option>
			<option value='752' $banco752>BANCO BNP PARIBAS BRASIL S.A.</option>
			<option value='231' $banco231>BANCO BOAVISTA INTERATLANTICO S.A-EM ABSORCAO</option>
			<option value='218' $banco218>BANCO BONSUCESSO S.A.</option>
			<option value='237' $banco237>BANCO BRADESCO S.A.</option>
			<option value='225' $banco225>BANCO BRASCAN S.A.</option>
			<option value='044' $banco044>BANCO BVA SA</option>
			<option value='263' $banco263>BANCO CACIQUE S.A.</option>
			<option value='222' $banco222>BANCO CALYON BRASIL S/A</option>
			<option value='412' $banco412>BANCO CAPITAL S.A.</option>
			<option value='266' $banco266>BANCO CEDULA S.A.</option>
			<option value='745' $banco745>BANCO CITIBANK S.A.</option>
			<option value='215' $banco215>BANCO COMERCIAL E DE INVESTIMENTO SUDAMERIS S.A</option>
			<option value='753' $banco753>BANCO COMERCIAL URUGUAI S.A.</option>
			<option value='756' $banco756>BANCO COOPERATIVO DO BRASIL S.A.</option>
			<option value='748' $banco748>BANCO COOPERATIVO SICREDI S.A. - BANSICREDI</option>
			<option value='721' $banco721>BANCO CREDIBEL S.A.</option>
			<option value='505' $banco505>BANCO CREDIT SUISSE FIRST BOSTON S.A.</option>
			<option value='229' $banco229>BANCO CRUZEIRO DO SUL S.A.</option>
			<option value='003' $banco003>BANCO DA AMAZONIA S.A.</option>
			<option value='707' $banco707>BANCO DAYCOVAL S.A.</option>
			<option value='495' $banco495>BANCO DE LA PROVINCIA DE BUENOS AIRES</option>
			<option value='494' $banco494>BANCO DE LA REPUBLICA ORIENTAL DEL URUGUAY</option>
			<option value='024' $banco024>BANCO DE PERNAMBUCO S.A.-BANDEPE</option>
			<option value='456' $banco456>BANCO DE TOKYO MITSUBISHI BRASIL S.A.</option>
			<option value='214' $banco214>BANCO DIBENS S.A.</option>
			<option value='001' $banco001>BANCO DO BRASIL S.A.</option>
			<option value='027' $banco027>BANCO DO ESTADO DE SANTA CATARINA S.A.</option>
			<option value='033' $banco033>BANCO DO ESTADO DE SAO PAULO S.A. - BANESPA</option>
			<option value='047' $banco047>BANCO DO ESTADO DE SERGIPE S.A.</option>
			<option value='035' $banco035>BANCO DO ESTADO DO CEARA S.A. BEC</option>
			<option value='036' $banco036>BANCO DO ESTADO DO MARANHAO S.A.-BEM</option>
			<option value='037' $banco037>BANCO DO ESTADO DO PARA S.A.</option>
			<option value='039' $banco039>BANCO DO ESTADO DO PIAUI S.A.-BEP</option>
			<option value='041' $banco041>BANCO DO ESTADO DO RIO GRANDE DO SUL S.A.</option>
			<option value='004' $banco004>BANCO DO NORDESTE DO BRASIL S.A.</option>
			<option value='743' $banco743>BANCO EMBLEMA S.A.</option>
			<option value='265' $banco265>BANCO FATOR S.A.</option>
			<option value='224' $banco224>BANCO FIBRA S.A.</option>
			<option value='626' $banco626>BANCO FICSA S.A.</option>
			<option value='175' $banco175>BANCO FINASA S.A.</option>
			<option value='252' $banco252>BANCO FININVEST S.A.</option>
			<option value='233' $banco233>BANCO GE CAPITAL S.A.</option>
			<option value='734' $banco734>BANCO GERDAU S.A.</option>
			<option value='612' $banco612>BANCO GUANABARA S.A.</option>
			<option value='063' $banco063>BANCO IBI S.A - BANCO MULTIPLO</option>
			<option value='604' $banco604>BANCO INDUSTRIAL DO BRASIL S.A.</option>
			<option value='320' $banco320>BANCO INDUSTRIAL E COMERCIAL S.A.</option>
			<option value='653' $banco653>BANCO INDUSVAL S.A.</option>
			<option value='630' $banco630>BANCO INTERCAP S.A.</option>
			<option value='249' $banco249>BANCO INVESTCRED UNIBANCO S.A.</option>
			<option value='341' $banco341>BANCO ITAU S.A.</option>
			<option value='074' $banco074>BANCO J. SAFRA S.A.</option>
			<option value='217' $banco217>BANCO JOHN DEERE S.A.</option>
			<option value='600' $banco600>BANCO LUSO BRASILEIRO S.A.</option>
			<option value='212' $banco212>BANCO MATONE S.A.</option>
			<option value='243' $banco243>BANCO MAXIMA S.A.</option>
			<option value='389' $banco389>BANCO MERCANTIL DO BRASIL S.A.</option>
			<option value='746' $banco746>BANCO MODAL S.A.</option>
			<option value='738' $banco738>BANCO MORADA S.A.</option>
			<option value='151' $banco151>BANCO NOSSA CAIXA S.A.</option>
			<option value='045' $banco045>BANCO OPPORTUNITY S.A.</option>
			<option value='208' $banco208>BANCO PACTUAL S.A.</option>
			<option value='623' $banco623>BANCO PANAMERICANO S.A.</option>
			<option value='611' $banco611>BANCO PAULISTA S.A.</option>
			<option value='650' $banco650>BANCO PEBB S.A.</option>
			<option value='613' $banco613>BANCO PECUNIA S.A.</option>
			<option value='643' $banco643>BANCO PINE S.A.</option>
			<option value='735' $banco735>BANCO POTTENCIAL S.A.</option>
			<option value='638' $banco638>BANCO PROSPER S.A.</option>
			<option value='747' $banco747>BANCO RABOBANK INTERNATIONAL BRASIL S.A.</option>
			<option value='216' $banco216>BANCO REGIONAL MALCON S.A.</option>
			<option value='633' $banco633>BANCO RENDIMENTO S.A.</option>
			<option value='741' $banco741>BANCO RIBEIRAO PRETO S.A.</option>
			<option value='453' $banco453>BANCO RURAL S.A.</option>
			<option value='422' $banco422>BANCO SAFRA S.A.</option>
			<option value='353' $banco353>BANCO SANTANDER BRASIL S.A.</option>
			<option value='008' $banco008>BANCO SANTANDER MERIDIONAL S.A.</option>
			<option value='351' $banco351>BANCO SANTANDER S.A.</option>
			<option value='250' $banco250>BANCO SCHAHIN S.A.</option>
			<option value='366' $banco366>BANCO SOCIETE GENERALE BRASIL S.A.</option>
			<option value='637' $banco637>BANCO SOFISA S.A.</option>
			<option value='347' $banco347>BANCO SUDAMERIS DO BRASIL S.A.</option>
			<option value='464' $banco464>BANCO SUMITOMO MITSUI BRASILEIRO S.A.</option>
			<option value='634' $banco634>BANCO TRIANGULO S.A.</option>
			<option value='247' $banco247>BANCO UBS S.A.</option>
			<option value='655' $banco655>BANCO VOTORANTIM S.A.</option>
			<option value='610' $banco610>BANCO VR S.A.</option>
			<option value='370' $banco370>BANCO WESTLB DO BRASIL  S.A.</option>
			<option value='219' $banco219>BANCO ZOGBI S.A.</option>
			<option value='062' $banco062>BANCO1.NET S.A.</option>
			<option value='028' $banco028>BANEB-EM ABSORCAO</option>
			<option value='021' $banco021>BANESTES S.A BANCO DO ESTADO DO ESPIRITO SANTO</option>
			<option value='479' $banco479>BANKBOSTON BANCO MULTIPLO S.A.</option>
			<option value='073' $banco073>BB BANCO POPULAR DO BRASIL</option>
			<option value='749' $banco749>BR BANCO MERCANTIL S.A.</option>
			<option value='070' $banco070>BRB - BANCO DE BRASILIA S.A.</option>
			<option value='104' $banco104>CAIXA ECONOMICA FEDERAL</option>
			<option value='487' $banco487>DEUTSCHE BANK S. A. - BANCO ALEMAO</option>
			<option value='210' $banco210>DRESDNER BANK LATEINAMERIKA AKTIENGESELLSCHAFT</option>
			<option value='399' $banco399>HSBC BANK BRASIL S.A.-BANCO MULTIPLO</option>
			<option value='076' $banco076>KDB DO BRASIL</option>
			<option value='065' $banco065>LEMON BANK BANCO MULTIPLO S.A.</option>
			<option value='030' $banco030>PARAIBAN-BANCO DA PARAIBA S.A.</option>
			<option value='254' $banco254>PARANA BANCO S.A.</option>
			<option value='409' $banco409>UNIBANCO - UNIAO DE BANCOS BRASILEIROS S.A.</option>
			<option value='230' $banco230>UNICARD BANCO MULTIPLO S.A.</option>
			<option value='999' $banco999>BANCO INEXISTENTE OU INDISPONÍVEL/option>
	</select>
	");
}
function testaInjection($variavel){
	if(eregi("http|www|ftp|.dat|.txt|.gif|wget|.php|.asp", $variavel))
    {
        return true;
    }else
	{
        return false;
    }
}
?>