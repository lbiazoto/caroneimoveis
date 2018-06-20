DELETE FROM backup;
DELETE FROM cases;
INSERT INTO cases VALUES ( '1', 'Case 1 222', 'Descrição do primeiro case

2222

agora com pdf', 'acf12971d48a8f862524785714be8319161.pdf', '1', '0', '0', '2009-09-08 15:58:25', '-1', '2009-09-08 15:50:49');
DELETE FROM downloads;
INSERT INTO downloads VALUES ( '1', 'Primeiro Download 222', 'Descrição do primeiro download

2222

Agora um cachorro', '7094b72f193beac6a5326bd9b52ce3d8102.jpg', '1', '0', '-1', '2009-09-08 16:30:17', '-1', '2009-09-08 16:25:05');
DELETE FROM eventos;
INSERT INTO eventos VALUES ( '1', 'Primeiro Evento 222', 'Descrição para o primeiro evento cadsatrado.


222

Outra música!', '2c16492acf42d825b1ecbb9a2a515164224.mp3', '1', '0', '0', '2009-09-08 16:18:48', '-1', '2009-09-08 16:15:42');
DELETE FROM menu;
INSERT INTO menu VALUES ( '1', 'Cadastrar', '1', 'usuarios', 'cadastrar', '1');
INSERT INTO menu VALUES ( '2', 'Listar', '1', 'usuarios', 'listar', '2');
INSERT INTO menu VALUES ( '4', 'Realizar Backup', '2', 'backup', 'cadastrar', '1');
INSERT INTO menu VALUES ( '5', 'Listar', '2', 'backup', 'listar', '3');
INSERT INTO menu VALUES ( '8', 'Restaurar', '2', 'restaurar', 'local', '5');
INSERT INTO menu VALUES ( '9', 'Meus Dados', '3', 'meusDados', 'detalhes', '1');
INSERT INTO menu VALUES ( '10', 'Exportar', '4', 'newsletter', 'exportar', '1');
INSERT INTO menu VALUES ( '12', 'Cadastrar', '5', 'revistas', 'cadastrar', '1');
INSERT INTO menu VALUES ( '13', 'Listar', '5', 'revistas', 'listar', '2');
INSERT INTO menu VALUES ( '14', 'Cadastrar', '6', 'cases', 'cadastrar', '1');
INSERT INTO menu VALUES ( '15', 'Listar', '6', 'cases', 'listar', '2');
INSERT INTO menu VALUES ( '16', 'Cadastrar', '7', 'novidades', 'cadastrar', '1');
INSERT INTO menu VALUES ( '17', 'Listar', '7', 'novidades', 'listar', '2');
INSERT INTO menu VALUES ( '18', 'Cadastrar', '8', 'eventos', 'cadastrar', '1');
INSERT INTO menu VALUES ( '19', 'Listar', '8', 'eventos', 'listar', '2');
INSERT INTO menu VALUES ( '20', 'Cadastrar', '9', 'downloads', 'cadastrar', '1');
INSERT INTO menu VALUES ( '21', 'Listar', '9', 'downloads', 'listar', '2');
DELETE FROM modulos;
INSERT INTO modulos VALUES ( '1', 'usuarios', 'Usuários', '1', 'usuarios.png');
INSERT INTO modulos VALUES ( '2', 'backup', 'Backup', '2', 'backup.png');
INSERT INTO modulos VALUES ( '3', 'opcoes', 'Opções', '3', 'opcoes.png');
INSERT INTO modulos VALUES ( '4', 'newsletter', 'Newsletter', '4', 'newsletter.png');
INSERT INTO modulos VALUES ( '5', 'revistas', 'Revistas', '5', 'revistas.png');
INSERT INTO modulos VALUES ( '6', 'cases', 'Cases', '6', 'cases.png');
INSERT INTO modulos VALUES ( '7', 'novidades', 'Novidades', '7', 'novidades.png');
INSERT INTO modulos VALUES ( '8', 'eventos', 'Eventos', '8', 'eventos.png');
INSERT INTO modulos VALUES ( '9', 'downloads', 'Downloads', '9', 'downloads.png');
DELETE FROM newsletter;
DELETE FROM novidades;
INSERT INTO novidades VALUES ( '1', 'Primeira novidade 2', 'Descrição da primeira novidade.

Agora um pdf', 'd0dcbe02d3606594405eef0b2c142a9e856.pdf', '1', '0', '0', '2009-09-08 16:08:16', '-1', '2009-09-08 16:06:23');
DELETE FROM permissoes;
INSERT INTO permissoes VALUES ( '7', '1', '6', '0');
INSERT INTO permissoes VALUES ( '8', '1', '9', '0');
INSERT INTO permissoes VALUES ( '9', '1', '8', '0');
INSERT INTO permissoes VALUES ( '10', '1', '7', '0');
INSERT INTO permissoes VALUES ( '11', '1', '3', '0');
INSERT INTO permissoes VALUES ( '12', '1', '5', '0');
INSERT INTO permissoes VALUES ( '13', '2', '6', '0');
INSERT INTO permissoes VALUES ( '14', '2', '9', '0');
INSERT INTO permissoes VALUES ( '15', '2', '8', '0');
INSERT INTO permissoes VALUES ( '16', '2', '3', '0');
INSERT INTO permissoes VALUES ( '17', '3', '9', '0');
INSERT INTO permissoes VALUES ( '18', '3', '3', '0');
DELETE FROM revistas;
INSERT INTO revistas VALUES ( '1', 'Revista Uno 2 333', 'Descrição Revista Uno

Agora com txt

333', '14e2e2960d4412975b9bde3b89a882ef589.txt', '1', '0', '0', '2009-09-08 15:41:08', '-1', '2009-09-08 15:12:24');
DELETE FROM submenu;
INSERT INTO submenu VALUES ( '2', '2', 'Listar', '2', 'grupousuario', 'listar');
INSERT INTO submenu VALUES ( '3', '3', 'Cadastrar', '1', 'usuario', 'cadastrar');
INSERT INTO submenu VALUES ( '4', '3', 'Listar', '2', 'usuario', 'listar');
INSERT INTO submenu VALUES ( '8', '4', 'Usuários', '1', 'relatorioUsuarios', '');
INSERT INTO submenu VALUES ( '9', '4', 'Acessos', '2', 'acessos', '');
INSERT INTO submenu VALUES ( '10', '5', 'Manual', '1', 'backup', '');
INSERT INTO submenu VALUES ( '11', '5', 'Automático', '-2147483646', 'automatico', '');
INSERT INTO submenu VALUES ( '12', '5', 'Restaurar', '3', 'restaurar', '');
DELETE FROM ultimoacesso;
INSERT INTO ultimoacesso VALUES ( '1', '-1', '2009-09-08 09:25:20', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '2', '-1', '2009-09-08 13:43:32', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '3', '-1', '2009-09-08 17:12:10', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '4', '1', '2009-09-08 17:12:58', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '5', '1', '2009-09-08 17:15:11', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '6', '-1', '2009-09-08 17:16:47', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '7', '1', '2009-09-08 17:16:56', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '8', '-1', '2009-09-08 17:17:08', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '9', '1', '2009-09-08 17:17:26', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '10', '-1', '2009-09-08 17:17:35', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '11', '2', '2009-09-08 17:18:17', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '12', '-1', '2009-09-08 17:18:23', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '13', '3', '2009-09-08 17:19:39', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '14', '-1', '2009-09-10 15:51:20', '192.168.10.103');
INSERT INTO ultimoacesso VALUES ( '15', '-1', '2009-09-10 15:53:49', '192.168.10.103');
DELETE FROM upload;
INSERT INTO upload VALUES ( '1', '5');
DELETE FROM usuario;
INSERT INTO usuario VALUES ( '-1', 'Administrador', 'admin', 'admin', 'rogerio@betag.com.br', '1', '0', '2009-06-12', '-1', '0', '');
INSERT INTO usuario VALUES ( '1', 'Rogério Giacomini', 'rogerio', 'rogerio', 'rogerio@betag.com.br', '5', '0', '2009-09-08', '-1', '-1', '2009-09-08');
INSERT INTO usuario VALUES ( '2', 'Novo user', 'novousuario', 'novousuario', 'novouser@novouser.com.br', '0', '0', '2009-09-08', '-1', '0', '');
INSERT INTO usuario VALUES ( '3', 'Novo user 2', 'novo2', 'novo2', 'novo2@novo3.com.br', '9', '0', '2009-09-08', '-1', '0', '');
