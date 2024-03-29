<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.prateleira.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");

include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);
    $nomeRelatorio = "Exemplar ordenado por Etiqueta"; // nome
    $tamcol = array(
        '8','3','3','3','3','28','14','10'); // tam.col
    $titcol = array(
    'CDE','Ini','Sig','Vol','Ex','T�tulo','Autor','Esp�rito');
        $sql = "SELECT 
                cde.cod_cde, 
                autor.iniciais,
                titulo.sigla, 
                titulo.nro_volume,
                exemplar.nro_exemplar,
                titulo.nome_titulo, 
                autor.nome_autor, 
                espirito.nome_espirito 
                FROM exemplar 
                LEFT JOIN titulo 
                ON exemplar.id_titulo = titulo.id_titulo 
                LEFT JOIN cde 
                ON titulo.id_cde = cde.id_cde 
                LEFT JOIN autor 
                ON titulo.id_autor = autor.id_autor 
                LEFT JOIN espirito 
                ON titulo.id_espirito = espirito.id_espirito 
                WHERE exemplar.id_centro = $id_centro
                ORDER BY cde.cod_cde, titulo.nome_titulo, 
                exemplar.nro_exemplar;";

include "../layout/inc.relatorio.epilogo.prateleira.php";

    Arch::endView(); 
?>
