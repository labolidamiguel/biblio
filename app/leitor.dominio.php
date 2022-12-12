<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.leitor.php";

Arch::initController("lista");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::request("pesq");
    $callback   = Arch::requestOrCookie("callback");

    $leitor = new Leitor();

    $rs = $leitor->select($id_centro, $pesq);
    $count = $leitor->getCount($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Leitor</p>";
    echo "<form>";
    echo "<div>";
/*
    echo "<input type='hidden' value='$callback name='callback' id='callback' class='callback'>";
*/

    botaoPesquisa($pesq);
    echo $space10;
    botaoCria("leitor.cria.php", $callback);
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left'>Celular</th>";
    echo "</tr>";
    echo "</thead>";

    while ($reg = $rs->fetch() ){       // PDO
        $nome = urlencode($reg["nome"]);
        echo "<tr onclick=window.location.href='".$callback."?id_leitor=".$reg["id_leitor"]."&leitor=".$nome."&step=&action='></a>";
        echo "<td>" . $reg["nome"] . "</td>";
        echo "<td>" . $reg["celular"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
