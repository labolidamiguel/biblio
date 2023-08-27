<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);
    $nomeRelatorio = "Cadastro de Tradutor"; // TITULO rel.
    $tamcol = array('60'); // tamanho coluna
    $titcol = array('Nome');

    $sql = "SELECT 
            nome_tradutor
            FROM tradutor 
            WHERE tradutor.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
