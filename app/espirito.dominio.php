<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.espirito.php";

Arch::initController("lista");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::requestOrCookie("action");
    $step       = Arch::requestOrCookie("step");
    $pesq       = Arch::requestOrCookie("pesq");
    $callback   = Arch::requestOrCookie("callback");

    $espirito = new Espirito();
    $count = $espirito->getCount($id_centro, $pesq);
    $rs = $espirito->select($id_centro, $pesq);
    
Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Espírito</p>";
    echo "<form>";
    echo "<div>";
    botaoPesquisa($pesq);
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "</tr>";
    echo "</thead>";

    while($reg = $rs->fetch()){         // PDO
        $nome = urlencode($reg["nome"]);
        echo "<tr onclick=window.location.href='".$callback."?id_espirito=".$reg["id_espirito"]."&nome=".$nome."&espirito=".$nome."&step=$step&action=$action'></a>";
        echo "<td>" . $reg["nome"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

    Arch::endView();
?>
