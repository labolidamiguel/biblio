<?php                                   // usuario.rel.php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);         // suprime top header
    $nomeRelatorio = "Cadastro de Usuário"; // TITULO rel.
    $tamcol = array('30','10','14','50'); // tam. col
    $titcol = array('Nome','Perfis','Telefone','Email');
    $sql = "SELECT 
            nome_usuario,
            perfis,
            telefone,
            email
            FROM usuario
            WHERE usuario.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
