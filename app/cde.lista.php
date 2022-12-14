<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.cde.php";

Arch::initController("cde");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("id_cde");
    Arch::deleteCookie("cod_cde");
    Arch::deleteCookie("classe");
    Arch::deleteCookie("flag_lido");
    
    $cde = new Cde();
    $count = $cde->getCount($id_centro, $pesq);
    $rs = $cde->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<form>";
    echo "<div>";
    echo "<p class=appTitle2>Classificação Decimal Espírita</p>";
    botaoPesquisa($pesq);
    echo $space10;
    botaoCria("cde.cria.php", "cde.lista.php");
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left'>iniciais</th>";
    echo "<th align='left' colspan=2></td>";
    echo "</tr>";
    echo "</thead>";
    while($reg = $rs->fetch() ){        // PDO
        $id_cde     = $reg["id_cde"];
        $cod_cde    = $reg["cod_cde"];
        $classe     = $reg["classe"];
        echo "<td>" . $cod_cde . "</td>";
        echo "<td>" . $classe . "</td>";
        echo "<td><a href='cde.altera.php?id_cde=$id_cde'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='cde.exclui.php?id_cde=$id_cde&cod_cde=$cod_cde&classe=$classe'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG
Arch::endView();
?>
