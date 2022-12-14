<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);             // suprime top header
    $nomeRelatorio = "Cadastro de Leitor"; // TITULO rel.
    $tamcol=array('30','10','20','20','10','20'); // tam. col
    $titcol=array('Nome','Celular','e-mail','Endereço',        'CEP','Notas');
    $sql = 
    "SELECT 
        nome,
        celular,
        email,
        endereco,
        cep,
        notas
    FROM leitor
    WHERE leitor.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
