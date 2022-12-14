<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);             // suprime top header
    $nomeRelatorio = "Cadastro de Usuário"; // TITULO rel.
    $tamcol=array('40','10'); // tam. col
    $titcol=array('Nome','perfis',        'CEP','Notas');
    $sql = 
    "SELECT 
        nome,
        perfis
    FROM usuario
    WHERE usuario.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
