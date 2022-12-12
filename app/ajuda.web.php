<?php
include "../common/arch.php";
include "../classes/class.app.php";
Arch::initController("ajuda");
    $codigo_app = Arch::get("codigo_app");

Arch::initView(TRUE);

//echo "codigo_app=$codigo_app<br>";
    switch($codigo_app) {
    case "@": echo "<p class=appTitle2>Ajuda geral</p>";
        echo "<a href='?action=ok'><button name='codigo_app' class=butbase >Introdução</button></a>";
        echo "<a href='?action=ok'><button name='codigo_app' class=butbase >Como iniciar</button></a>";
        echo "<a href='?action=ok'><button name='codigo_app' class=butbase >Info Técnica</button></a>";
        echo "<br><hr>";
        break;
    case "lista": echo "não implementado";
        break;
    case "emprestimo": include "../layout/help/ajuda.emprestimo.php";
        break;
    case "devolucao": include "../layout/help/ajuda.devolucao.php";
        break;
    case "titulo":
    case "buscacde":
    case "autor":
    case "cde":
    case "editora":
    case "espirito":
    case "leitor":
    case "tradutor":
    case "imprime":
    case "etiqueta":
    case "relatorio":
    case "usuario":
    case "publicado":
    case "app":
    case "centro":
    case "log":
        echo "não implementado";
        break;
    }

Arch::endView();
?>