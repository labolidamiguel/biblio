SELECT 
    cde.cod_cde, 
    titulo.nome_titulo, 
    autor.nome, 
    espirito.nome, 
    titulo.nro_volume,
    exemplar.nro_exemplar,
    (SELECT cod_estante FROM estante 
        WHERE estante.id_centro = 1 
        AND cde.cod_cde between estante.cde_inicial AND estante.cde_final)
FROM exemplar 
left join titulo on exemplar.id_titulo = titulo.id_titulo 
left join cde on titulo.id_cde = cde.id_cde 
left join autor on titulo.id_autor = autor.id_autor 
left join espirito on titulo.id_espirito = espirito.id_espirito 
WHERE exemplar.id_centro = 1
ORDER BY cde.cod_cde, titulo.nome_titulo, exemplar.nro_exemplar;
 