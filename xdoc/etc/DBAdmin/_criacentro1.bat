set sql3=C:\Z_INSTAL\C\sqlite3.exe

del biblio.db

%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/app.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/auditoria.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/autor.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/cde.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/centro.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/editora.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/emprestimo.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/espirito.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/estante.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/exemplar.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/leitor.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/publicado.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/relatorio.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/titulo.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/tradutor.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/usuario.sql"

%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/titulo_resenha_update.sql"
%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/titulo_resenha_update_20200805.sql"

%sql3% biblio.db ".read C:/Source/PHP/Biblio/doc/sql/sqlite/estatistic.sql"
rem = = = Centro 1 criado = = =
pause
