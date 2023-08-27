<?php                         // prateleira.lista.php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.prateleira.php";

Arch::initController("prateleira");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::get("pesq");
    Arch::deleteCookie("id_prateleira");
    Arch::deleteCookie("cod_prateleira");
    Arch::deleteCookie("cde_inicial");
    Arch::deleteCookie("cde_final");
    Arch::deleteCookie("flag_lido");
    $linxpage = 10;

    $prateleira = new Prateleira();

    $count = $prateleira->getCount($id_centro, $pesq);
    $rs = $prateleira->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Prateleira</p>";
    echo "<form>";
    echo "<div>";
    botaoPesquisa($pesq);
    echo $space10;
    botaoCria("prateleira.cria.php", "prateleira.lista.php");
    echo "</div>";
    echo "</form>";

//    echo "<div style='height:55%; overflow-y: scroll;'>";//NOPAG
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";

    echo "<thead>";
    echo "<tr class=\"blue\">";
//    echo "<th align='left'>Prate-<br>leira</th>";
    echo "<th align='left'>Prateleira</th>";
    echo "<th align='left'>CDE inicial</th>";
    echo "<th align='left'>CDE final</td>";
    echo "<th align='left' colspan=2></td>";//ico edit excl
    echo "</tr>";
    echo "</thead>";

    while($reg = $rs->fetch() ){        // PDO
        $id_prateleira  = $reg["id_prateleira"];
        $cod_prateleira = $reg["cod_prateleira"];
        $cde_inicial    = $reg["cde_inicial"];
        $cde_final      = $reg["cde_final"];

        echo "<td>" . $cod_prateleira . "</td>";
        echo "<td>" . $cde_inicial . "</td>";
        echo "<td>" . $cde_final . "</td>";
        echo "<td><a href='prateleira.altera.php?id_prateleira=$id_prateleira'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='prateleira.exclui.php?id_prateleira=$id_prateleira&cod_prateleira=$cod_prateleira&cde_inicial=$cde_inicial&cde_final=$cde_final'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG
Arch::endView();
?>
