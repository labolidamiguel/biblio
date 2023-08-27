set sql3=C:\Z_INSTAL\C\sqlite3.exe
set /p id="Entre id_centro: "
echo id_centro: %id%

echo off
echo :
echo leitor:
%sql3% biblio.db "select * from leitor where id_centro = %id%;"
echo :
echo autor:
%sql3% biblio.db "select * from autor where id_centro = %id%;"
echo :
echo espirito:
%sql3% biblio.db "select * from espirito where id_centro = %id%;"
echo :
echo titulo(raw):
%sql3% biblio.db "select * from titulo where id_centro = %id%;"
echo titulo:
%sql3% biblio.db "SELECT titulo.id_centro, titulo.id_titulo, titulo.titulo, titulo.sigla, autor.nome, espirito.nome, cde.cde, titulo.nro_volume, titulo.resenha FROM titulo left join autor on titulo.id_autor = autor.id_autor left join espirito on titulo.id_espirito = espirito.id_espirito left join cde on titulo.id_cde = cde.id_cde where titulo.id_centro = %id%;"
echo :
echo tradutor:
%sql3% biblio.db "select * from tradutor where id_centro = %id%;"
echo :
echo editora:
%sql3% biblio.db "select * from editora where id_centro = %id%;"
echo :
echo exemplar(raw):
%sql3% biblio.db "select * from exemplar where id_centro = %id%;"
echo exemplar:
%sql3% biblio.db "SELECT exemplar.id_centro, exemplar.id_exemplar, titulo.titulo, tradutor.nome, editora.nome, exemplar.nro_edicao, exemplar.ano_publicacao, exemplar.data_entrada, exemplar.nro_exemplar FROM exemplar LEFT JOIN titulo ON titulo.id_titulo = exemplar.id_titulo LEFT JOIN editora ON editora.id_editora = exemplar.id_editora LEFT JOIN tradutor ON tradutor.id_tradutor = exemplar.id_tradutor LEFT JOIN emprestimo ON emprestimo.id_exemplar = exemplar.id_exemplar WHERE exemplar.id_centro = %id%;"
echo :
pause
