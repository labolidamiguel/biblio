<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);
    $nomeRelatorio = "CDE Publicado pela FEB"; // TITULO rel.
    $tamcol=array('10','60'); // tamanho coluna
    $titcol=array('CDE','Nome');

    $sql = 
    "SELECT 
        cod_cde,
        nome_titulo
    FROM publicado;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
