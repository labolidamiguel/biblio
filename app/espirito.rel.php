<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);
    $nomeRelatorio = "Cadastro de Espírito"; // TITULO rel.
    $tamcol = array('2', '60'); // tamanho coluna
    $titcol = array('Id', 'Nome');

    $sql = "SELECT 
            id_espirito,
            nome_espirito
            FROM espirito
            WHERE espirito.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
