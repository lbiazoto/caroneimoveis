<?php
// Arquivo de configura�ao do Sistema.
$servidor = "mysql.caroneimoveis.com.br";			// Servidor que cont�m o Banco de Dados MySQL.
$bancoDados = "caroneimoveis";	// Banco de Dados que ser� utilizado.
$usuarioBd = "caroneimoveis";			// Usu�rio com acesso ao Banco de Dados.
$senhaBd = "carone123";				// Senha para o usu�rio fornecido.
$corFundoAmareloEscuro = "#FFFF99";
$corFundoAmareloClaro = "#FFFFCC";
$corFundoBranco = "#FFFFFF";

//Debug
$debugModeOn = false;

// Expira��o de sess�o
$minutosExpirarSessao = 0; // para nunca expirar utilize 0

//Dominios
$enderecoCompleto = "http://caroneimoveis.com.br";

//Emails
$smtp_email_padrao="smtp.caroneimoveis.com.br";
$endereco_email_padrao = "site@caroneimoveis.com.br";
$nome_email_padrao = "Equipe Carone Im�veis";
$endereco_email_destino = "contato@caroneimoveis.com.br";
//$endereco_email_destino = "deivid@betag.com.br";
$senha_email_padrao = "site09*";

// define com mensagem para erro para usu�rios que n�o possuem acesso a parte do sistema
define("NAO_AUTORIZADO","Desculpe, voc� n�o est� autorizado a acessar essa parte do sistema!");
define("ID_ACESSO","betag2010$enderecoCompleto");
?>