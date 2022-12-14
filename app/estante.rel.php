<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);
    $nomeRelatorio = "Cadastro de Estante"; // TITULO rel.
    $tamcol=array('6','11','11'); // tamanho coluna
    $titcol=array('Código','CDE inicial','CDE final');

    $sql = 
    "SELECT 
        cod_estante, 
        cde_inicial,
        cde_final
    FROM estante 
    WHERE estante.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
