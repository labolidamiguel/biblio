<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);             // suprime top header
    $nomeRelatorio = "Cadastro de Editora"; // TITULO rel.
    $tamcol=array('90'); // tamanho coluna
    $titcol=array('Nome da Editora');
    $sql = 
    "SELECT 
        editora.nome 
    FROM editora 
    WHERE editora.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
