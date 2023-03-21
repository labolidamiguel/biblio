<?php
// exemplar.rel.cde.php
// 20230320 incluido estante
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.estante.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);             // suprime top header
    $nomeRelatorio = "Exemplar ordenado por CDE"; // nome 
    $tamcol=array('8','30','16','10','3','3'); // tam.colunas
    $titcol=array('CDE','Título','Autor','Espírito','Vol','Ex');
    $sql = 
    "SELECT 
        cde.cod_cde, 
        titulo.nome_titulo, 
        autor.nome, 
        espirito.nome, 
        titulo.nro_volume,
        exemplar.nro_exemplar
    FROM exemplar 
    left join titulo on exemplar.id_titulo = titulo.id_titulo 
    left join cde on titulo.id_cde = cde.id_cde 
    left join autor on titulo.id_autor = autor.id_autor 
    left join espirito on titulo.id_espirito = espirito.id_espirito 
    WHERE exemplar.id_centro = $id_centro
    ORDER BY cde.cod_cde, titulo.nome_titulo, exemplar.nro_exemplar;";

include "../layout/inc.relatorio.epilogo.estante.php";

    Arch::endView(); 
?>
