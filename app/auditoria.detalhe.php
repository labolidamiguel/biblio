<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.auditoria.php";

Arch::initController("auditoria");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $nome       = Arch::get("nome");
    $app        = Arch::get("app");
    $mensagem   = Arch::get("mensagem");
    
Arch::initView(TRUE);
    echo "<p class=appTitle2>Auditoria</p>";
    echo "<form method='get'>";

    echo "<p class=labelx>Nome</p>";
    echo "$nome";
        
    echo "<p class=labelx>App</p>";
    echo "$app";
    echo "<p class=labelx>Mensagem</p>";
    echo "<p class=labelx>$mensagem</p>";


    echo "<button type='submit' class='butbase' formaction='auditoria.lista.php'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
