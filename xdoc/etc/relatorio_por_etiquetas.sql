SELECT 
cde.cde AS CDE,
autor.iniciais AS Aut,
titulo.sigla AS Tt,
titulo.nro_volume AS Vol,
exemplar.nro_exemplar AS Ex,
titulo.titulo AS Título
FROM exemplar 
LEFT JOIN titulo ON titulo.id_titulo = exemplar.id_titulo
LEFT JOIN cde ON cde.id_cde = titulo.id_cde
LEFT JOIN autor ON autor.id_autor = titulo.id_autor
ORDER BY
cde.cde, autor.iniciais,
titulo.sigla,
titulo.nro_volume,
exemplar.nro_exemplar;

/* CDE separado */
select exemplar.id_exemplar as idex, 
substr(cde.cde,1,2) as cde1,
substr(cde.cde,4,2) as cde2,
substr(cde.cde,7,2) as cde3,
substr(autor.nome,1,10) as nom1,
substr(autor.nome,11,10) as nom2,
autor.iniciais as inic,
substr(titulo.titulo,1,10) as tit1,
substr(titulo.titulo,11,10) as tit2,
titulo.sigla as sigl,
titulo.nro_volume as volu,
exemplar.nro_exemplar as exem
from exemplar 
left join titulo on titulo.id_titulo = exemplar.id_titulo
left join cde on cde.id_cde = titulo.id_cde
left join autor on autor.id_autor = titulo.id_autor
where exemplar.id_exemplar >= 1 and exemplar.id_exemplar <= 4;
