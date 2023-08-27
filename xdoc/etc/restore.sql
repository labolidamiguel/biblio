-- Este arquivo restore.sql(SQL) eh lido pelo programa restore.php (PHP).
-- NAO DEVE SER DELETADO.
-- PODE COMMENTAR TODAS AS LINHAS.




-- DROP TABLE add ;
-- 
-- CREATE TABLE app(
-- 	id_app  INTEGER      PRIMARY KEY   AUTOINCREMENT ,
-- 	codigo  varchar(40)  NOT NULL ,
-- 	titulo  varchar(40)  NOT NULL ,
-- 	imagem  varchar(40)  NOT NULL ,
-- 	perfil  varchar(40)  NOT NULL , 
-- 	url     varchar(255) NOT NULL ,
-- 	ordem   int NOT NULL 
-- );
-- 
-- INSERT INTO "app" VALUES(1,'emprestimo','Empréstimo','empr.ico','2','emprestimo.web.php?action=clean',20);
-- INSERT INTO "app" VALUES(2,'devolucao','Devolução','devo.ico','2','devolucao.web.php',30);
-- INSERT INTO "app" VALUES(3,'tradutor','Tradutor','ator.ico','3','tradutor.web.php?action=clean',10);
-- INSERT INTO "app" VALUES(4,'leitor','Leitor','ator.ico','3','leitor.crud.read.web.php?action=clean',40);
-- INSERT INTO "app" VALUES(5,'titulo','Título','titu.ico','3','titulo.crud.read.web.php?action=clean',50);
-- INSERT INTO "app" VALUES(6,'exemplar','Exemplar','exem.ico','3','exemplar.lista.web.php',60);
-- INSERT INTO "app" VALUES(7,'espirito','Espírito','ator.ico','3','espirito.web.php',70);
-- INSERT INTO "app" VALUES(8,'autor','Autor','ator.ico','3','autor.web.php',80);
-- INSERT INTO "app" VALUES(9,'cde','CDE','cde.ico','3','cde.web.php',90);
-- INSERT INTO "app" VALUES(10,'pesquisa','Pesquisa','pesq.ico','3','pesquisa.web.php',100);
-- INSERT INTO "app" VALUES(11,'editora','Editora','edit.ico','3','editora.web.php',110);
-- INSERT INTO "app" VALUES(12,'feb','Public. FEB','feb.ico','4','publicado.web.php',120);
-- INSERT INTO "app" VALUES(13,'ajuda','Ajuda','ajud.ico','0','ajuda.web.php',300);
-- INSERT INTO "app" VALUES(14,'sair','Sair','sair.ico','0','logoff.web.php',310);
-- INSERT INTO "app" VALUES(15,'config','Config','conf.ico','7','config.web.php',400);
-- INSERT INTO "app" VALUES(16,'usuario','Usuário','ator.ico','7','usuario.crud.read.web.php?action=clean',410);
-- INSERT INTO "app" VALUES(17,'app','App','apli.ico','9','app.crud.read.web.php?action=clean',420);
-- INSERT INTO "app" VALUES(18,'centro','Centro','home.ico','9','centro.web.php',430);
-- INSERT INTO "app" VALUES(19,'buscacde','Busca CDE','bcde.ico','3','buscacde.web.php',440);
-- INSERT INTO "app" VALUES(20,'etiqueta','Etiquetas','etiq.ico','7','etiqueta.web.php',450);
