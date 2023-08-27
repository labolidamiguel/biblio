<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);
    $nomeRelatorio = "Cadastro de Autor"; // TITULO rel.
    $tamcol = array('60','8'); // tamanho coluna
    $titcol = array('Nome Autor','iniciais');

    $sql = "SELECT 
            autor.nome_autor, 
            autor.iniciais
            FROM autor 
            WHERE autor.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
