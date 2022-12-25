<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.estante.php";

Arch::initController("estante");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("id_estante");
    Arch::deleteCookie("cod_estante");
    Arch::deleteCookie("cde_inicial");
    Arch::deleteCookie("cde_final");
    Arch::deleteCookie("flag_lido");
    $linxpage = 10;

    $estante = new Estante();

    $count = $estante->getCount($id_centro, $pesq);
    $rs = $estante->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Estante</p>";
    echo "<form>";
    echo "<div>";
    botaoPesquisa($pesq);
    echo $space10;
    botaoCria("estante.cria.php", "estante.lista.php");
    echo "</div>";
    echo "</form>";

    echo "<p class='blue'>&nbsp; Estante $space5 CDE inicial $space5 CDE final</p>";//NOPAG

    echo "<div style='height:55%; overflow-y: scroll;'>";//NOPAG
    echo "<table class='table striped' style=\"width:98%\">";

    while($reg = $rs->fetch() ){        // PDO
        $id_estante = $reg["id_estante"];
        $cod_estante  = $reg["cod_estante"];
        $cde_inicial  = $reg["cde_inicial"];
        $cde_final  = $reg["cde_final"];

        echo "<td>" . $cod_estante . "</td>";
        echo "<td>" . $cde_inicial . "</td>";
        echo "<td>" . $cde_final . "</td>";
        echo "<td><a href='estante.altera.php?id_estante=$id_estante'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='estante.exclui.php?id_estante=$id_estante&cod_estante=$cod_estante&cde_inicial=$cde_inicial&cde_final=$cde_final'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG
Arch::endView();
?>
