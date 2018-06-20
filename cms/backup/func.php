<?php
function removeBackup($id, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$idUsuario=devolveIdUsuario($login);
		$comando = "UPDATE backup SET deletado='1', idUsuarioAtualizou='$idUsuario', dataAtualizacao=now() WHERE id='$id'";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
function adicionaBackup($nome,$login, $arquivo)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
				$idUsuario=devolveIdUsuario($login);
				$comando = "INSERT INTO backup(nome, dataBackup, idUsuario, arquivo)
										VALUES('$nome', now(), '$idUsuario', '$arquivo')";
				debug($comando);
				$dados = mysql_db_query($bancoDados, $comando);
				if ($dados)
				{
					return true;
				}
	}
	return false;
}
function backupBaseDados()
{
	set_time_limit(200);

	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		mysql_select_db($bancoDados);
		$arquivo = "backup/backup/backup-".date("d-m-Y-H-i-s").".sql";
		$back = fopen($arquivo,"w");
		$res = mysql_list_tables($bancoDados);
		while ($row = mysql_fetch_row($res))
		{
			$table = $row[0];
			$comando = "SHOW CREATE TABLE $table";
			debug($comando);
			$res2 = mysql_query($comando);
			while ( $lin = mysql_fetch_row($res2))
			{
				fwrite($back,"DELETE FROM ".$table.";\n");
				$comando2 = "SELECT * FROM $table";
				debug($comando2);
				$res3 = mysql_query($comando2);
				while($r=mysql_fetch_row($res3))
				{
					$sql="INSERT INTO $table VALUES (";

						for($j=0; $j<mysql_num_fields($res3);$j++)
						{
							if(!isset($r[$j]))
								$sql .= " '',";
							elseif($r[$j] != "")
								$sql .= " '".addslashes($r[$j])."',";
							else
								$sql .= " '',";
						}
						$sql = ereg_replace(",$", "", $sql);
						$sql .= ");\n";
						fwrite($back,$sql);
				}
			}
		}
		fclose($back);

		return($arquivo);
	}
}
function devolveListaBackups($tipo, $index, $mark, $where, $oder, $titulo, $post)
{
	include("./config.php");

	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$cont=0;
		$comandoSql = "SELECT id, date_format(dataBackup, '%d/%m/%Y') as dataF, date_format(dataBackup, '%H:%i:%s') as horaF, nome, arquivo FROM backup $where LIMIT $index,25";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				print("<div align='right'>Registros: ($numero encontrados)</div>");
				devolveNavegacao($index, "index.php?modulo=backup&acao=backup&tipo=listar", $where, $mark, "backup", $post);
				print("
				<table width='100%' id='gradient-style'>
					<tr>
						<th align='left' width='20%'>Data de Cadastro</th>
						<th align='left' width='35%'>Hora</th>
						<th align='left' width='35%'>Nome</th>
						<th colspan='3'>&nbsp;</th>
					</tr>
				");
				while ($linha = mysql_fetch_array($dados))
				{
					print("
						<tr>
							<td>$linha[dataF]</td>
							<td>$linha[horaF]</td>
							<td>$linha[nome]</td>
							<td width='24'><a href='index.php?modulo=backup&acao=backup&tipo=listar&modo=restaurar&id=$linha[id]&file=$linha[arquivo]' onclick='alert(\"Por motivos de segurança será gerado um backup antes de restaurar o antigo.\"); return confirmaExclusao(\"Você tem certeza que deseja restaurar este backup?\");'><img src='imagens/carregar.png' title='Restaurar Backup' border='0'></a></td>
							<td width='24'><a href='$linha[arquivo]' target='_blank'><img src='imagens/salvar.png' title='Salvar Backup' border='0'></a></td>
							<td width='24'><a href='index.php?modulo=backup&acao=backup&tipo=remover&id=$linha[id]' onClick=\"return confirmaExclusao();\"><img src='imagens/delete.png' border='0' title='Excluir Backup'></a></td>
						</tr>
					");
				}
				print("
				</table>
				");
				devolveNavegacao($index, "index.php?modulo=backup&acao=backup&tipo=listar", $where, $mark, "backup", $post);
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='35%'>Hora</th>
							<th align='left' width='35%'>Nome</th>
							<th colspan='2'>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='5'>
								Nenhum registro de backups cadastrados.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibiçao dos backups!</strong></center>");
	}
}
function agendaBackup($seg, $ter, $qua, $qui, $sex, $sab, $dom, $login)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		$idUsuario=devolveIdUsuario($login);
		$comando = "UPDATE backupagendamento SET seg='$seg',ter='$ter',qua='$qua',qui='$qui',sex='$sex',sab='$sab',dom='$dom',idUsuario='$idUsuario', dataAtualizacao=now() WHERE id='1'";
		debug($comando);
		$dados = mysql_db_query($bancoDados, $comando);
		if ($dados)
		{
			return true;
		}
	}
	return false;
}
function devolveListaBackupsRestaurar()
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else {
		$cont=0;
		$comandoSql = "SELECT id, date_format(dataBackup, '%d/%m/%Y') as dataF, date_format(dataBackup, '%H:%i:%s') as horaF, nome, arquivo FROM backup WHERE deletado = 0 ORDER BY id DESC";
		debug($comandoSql);
		$dados = mysql_db_query($bancoDados, $comandoSql);
		if ($dados)
		{
			$numero = mysql_num_rows($dados);
			if($numero!=0)
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th width='20%'>Data de Cadastro</th>
							<th width='35%'>Hora</th>
							<th width='35%'>Nome</th>
							<th colspan='2'>&nbsp;</th>
						</tr>
						");
						while ($linha = mysql_fetch_array($dados))
						{
							print("
								<tr>
									<td>$linha[dataF]</td>
									<td>$linha[horaF]</td>
									<td>$linha[nome]</td>
									<td width='24'><a href='index.php?modulo=backup&acao=restaurar&tipo=remoto&modo=restaurar&id=$linha[id]&file=$linha[arquivo]' onclick='alert(\"Por motivos de segurança será gerado um backup antes de restaurar o antigo.\"); return confirmaExclusao(\"Você tem certeza que deseja restaurar este backup?\");'><img src='imagens/carregar.png' title='Restaurar Backup' border='0'></a></td>
									<td width='24'><a href='index.php?modulo=backup&acao=restaurar&tipo=remoto&modo=remover&id=$linha[id]' onClick=\"return confirmaExclusao();\"><img src='imagens/delete.png' border='0' title='Excluir backup'></a></td>
								</tr>
							");
						}
						print("
					</table>
					<table width='95%'>
						<tr>
							<td align='right'>
								<fieldset style='width:145px; text-align:left;'>
									<legend>Legenda</legend>
									<table cellpadding='2' cellspacing='2' align='right'>
										<tr>
											<td align='center' valign='middle'><img src='imagens/carregar.png' border='0' title='Restaurar backup' alt='Restaurar backup'></td>
											<td align='left' valign='middle'>Restaurar backup</td>
										</tr>
										<tr>
											<td align='center' valign='middle'><img src='imagens/delete.png' border='0' title='Excluir backup' alt='Excluir backup'></td>
											<td align='left' valign='middle'>Excluir backup</td>
										</tr>
									</table>
								</fieldset>
							</td>
						</tr>
					</table>
				");
			}
			else
			{
				print("
					<table width='100%' id='gradient-style'>
						<tr>
							<th align='left' width='20%'>Data de Cadastro</th>
							<th align='left' width='35%'>Hora</th>
							<th align='left' width='35%'>Nome</th>
							<th colspan='2'>&nbsp;</th>
						</tr>
						<tr>
							<td colspan='5'>
								Nenhum registro de backups cadastrados.
							</td>
						</tr>
					</table>
				");
			}
		}
		else
			print("<center><strong>Erro na exibiçao dos backups!</strong></center>");
	}
}
function restauraBackup($file,$login,$id)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		//backup antes de restaurar
		$arquivo = backupBaseDados();
		$retorno=adicionaBackup("Automático - Restauração Remota",$_SESSION['login'], $arquivo);

		set_time_limit(1200);
	   	$abraArq = fopen($file, "r");
		if ($abraArq)
		{

			while($valores = fgetcsv($abraArq,1000,"\n"))
			{
				$comando = "$valores[0]";
				$dados = mysql_db_query($bancoDados, $comando);
			}
			return true;
		}
	}
	return false;
}
function restauraBackupLocal($file,$login,$id)
{
	include("./config.php");
	if (!conectaBancoDados())
		print("<center><strong>Nao foi possível estabelecer conexao com o Banco de Dados!</strong></center>");
	else
	{
		//backup antes de restaurar
		$arquivo = backupBaseDados();
		$retorno = adicionaBackup("Automático - Restauração Local",$_SESSION['login'], $arquivo);

		set_time_limit(1200);
	   	$abraArq = fopen($file, "r");
		if ($abraArq)
		{

			while($valores = fgetcsv($abraArq,1000,"\n"))
			{
				$comando = "$valores[0]";
				debug($comando);
				$dados = mysql_db_query($bancoDados, $comando);
			}
			return true;
		}else
			return false;
	}
}
?>