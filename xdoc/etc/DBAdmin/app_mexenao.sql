PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
DROP TABLE app;
CREATE TABLE app(
    id_app  INTEGER      PRIMARY KEY   AUTOINCREMENT ,
    codigo  varchar(40)  NOT NULL ,
    titulo  varchar(40) ,
    imagem  varchar(40) ,
    perfil  varchar(40)  NOT NULL ,
    url     varchar(255) NOT NULL ,
    ordem   int NOT NULL
);
INSERT INTO "app" VALUES(1,'lista','','','1','Oculta',0);
INSERT INTO "app" VALUES(2,'ajuda','','','1','Oculta',0);
INSERT INTO "app" VALUES(3,'emprestimo','Empr&eacute;stimo','empr.ico','1','emprestimo.cria.php',10);
INSERT INTO "app" VALUES(4,'devolucao','Devolu&ccedil;&atilde;o','devo.ico','1','emprestimo.lista.php',15);
INSERT INTO "app" VALUES(5,'titulo','Livro','livr.ico','3','titulo.lista.php',20);
INSERT INTO "app" VALUES(6,'buscacde','Busca CDE','bcde.ico','3','buscacde.lista.php',25);
INSERT INTO "app" VALUES(7,'autor','Autor','ator.ico','5','autor.lista.php',30);
INSERT INTO "app" VALUES(8,'cde','CDE','cde.ico','5','cde.lista.php',35);
INSERT INTO "app" VALUES(9,'editora','Editora','edit.ico','5','editora.lista.php',40);
INSERT INTO "app" VALUES(10,'espirito','Esp&iacute;rito','ator.ico','5','espirito.lista.php',45);
INSERT INTO "app" VALUES(11,'leitor','Leitor','ator.ico','5','leitor.lista.php',50);
INSERT INTO "app" VALUES(12,'tradutor','Tradutor','ator.ico','5','tradutor.lista.php',55);
INSERT INTO "app" VALUES(13,'imprime','Imprime','impr.ico','7','imprime.lista.php',60);
INSERT INTO "app" VALUES(14,'etiqueta','Etiqueta','etiq.ico','7','etiqueta.lista.php',65);
INSERT INTO "app" VALUES(16,'estante','Estante','esta.ico','7','estante.lista.php',70);
INSERT INTO "app" VALUES(17,'usuario','Usu&aacute;rio','ator.ico','7','usuario.lista.php',75);
INSERT INTO "app" VALUES(18,'auditoria','Auditoria','audi.ico','7','auditoria.lista.php',78);
INSERT INTO "app" VALUES(19,'publicado','Public.FEB','feb.ico','9','publicado.lista.php',80);
INSERT INTO "app" VALUES(20,'app','App','apli.ico','9','app.lista.php',85);
INSERT INTO "app" VALUES(21,'centro','Centro','cent.ico','9','centro.lista.php',90);
INSERT INTO "app" VALUES(22,'log','Log','bug.ico','9','log.read.web.php',95);

COMMIT;
