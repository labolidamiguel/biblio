<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);
    $nomeRelatorio = "Títulos ordenados por Id"; // nome 
    $tamcol = array('6','30','30','10'); // tamanho coluna
    $titcol = array('Id','Título','Autor','CDE');

    $sql = "SELECT 
            titulo.id_titulo, 
            titulo.nome_titulo, 
            autor.nome_autor, 
            cde.cod_cde
            FROM titulo 
            LEFT JOIN autor 
            ON titulo.id_autor = autor.id_autor 
            LEFT JOIN cde 
            ON titulo.id_cde = cde.id_cde 
            WHERE titulo.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
