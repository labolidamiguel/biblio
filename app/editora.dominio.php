<?php
    include "../common/arch.php";
    include "../common/funcoes.php";
    include "../classes/class.app.php";
    include "../classes/class.editora.php";

Arch::initController("lista");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::request("pesq");
    $callback   = Arch::requestOrCookie("callback");

    $editora = new Editora();

    $count = $editora->getCount($id_centro, $pesq);
    $rs = $editora->select($id_centro, $pesq);
    
Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Editora</p>";
    echo "<form>";
    echo "<div>";
    echo "<input type='hidden' value='$callback' name='callback' id='callback' class='callback'>";
    echo "<input type='text' value='$pesq' name='pesq' id='pesq' class='inputh'>";
    echo "<a href='?pesq='><img src='../layout/img/limp.ico' width='22' height='22' class='butimg'></a>"; // reset
    echo $space5;
    echo "<input type='image' src='../layout/img/pesq.ico' alt='Submit' width='22' height='22' class='butimg'>";
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "</tr>";
    echo "</thead>";
    while( $reg = $rs->fetch() ){       // PDO
        $nome = urlencode($reg["nome"]);
        echo "<tr onclick=window.location.href='".$callback."?id_editora=".$reg["id_editora"]."&editora=".$nome."'></a>";
        echo "<td>" . $reg["nome"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
