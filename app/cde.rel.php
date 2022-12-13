<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);             // suprime top header
    $nomeRelatorio = "Cadastro de CDE"; // TITULO rel.
    $tamcol=array('12','90'); // tamanho coluna
    $titcol=array('CDE','Descrição da Classe');

    $sql = 
    "SELECT 
        cde.cod_cde, 
        cde.classe
    FROM cde 
    WHERE cde.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
