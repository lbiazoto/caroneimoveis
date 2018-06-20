<?php
// Arquivo de configuraзao do Sistema.
$servidor = "mysql.caroneimoveis.com.br";			// Servidor que contйm o Banco de Dados MySQL.
$bancoDados = "caroneimoveis";	// Banco de Dados que serб utilizado.
$usuarioBd = "caroneimoveis";			// Usuбrio com acesso ao Banco de Dados.
$senhaBd = "carone123";				// Senha para o usuбrio fornecido.
$corFundoAmareloEscuro = "#FFFF99";
$corFundoAmareloClaro = "#FFFFCC";
$corFundoBranco = "#FFFFFF";

//Debug
$debugModeOn = false;

// Expiraзгo de sessгo
$minutosExpirarSessao = 0; // para nunca expirar utilize 0

//Dominios
$enderecoCompleto = "http://caroneimoveis.com.br";

//Emails
$smtp_email_padrao="smtp.caroneimoveis.com.br";
$endereco_email_padrao = "site@caroneimoveis.com.br";
$nome_email_padrao = "Equipe Carone Imуveis";
$endereco_email_destino = "contato@caroneimoveis.com.br";
//$endereco_email_destino = "deivid@betag.com.br";
$senha_email_padrao = "site09*";

// define com mensagem para erro para usuбrios que nгo possuem acesso a parte do sistema
define("NAO_AUTORIZADO","Desculpe, vocк nгo estб autorizado a acessar essa parte do sistema!");
define("ID_ACESSO","betag2010$enderecoCompleto");
?>