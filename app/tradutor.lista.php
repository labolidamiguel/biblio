<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.tradutor.php";

Arch::initController("tradutor");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("id_tradutor");
    Arch::deleteCookie("nome");
    Arch::deleteCookie("flag_lido");
    
    $tradutor = new Tradutor();

    $count = $tradutor->getCount($id_centro, $pesq);
    $rs = $tradutor->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Tradutor</p>";
    echo "<form>";
    echo "<div>";
    botaoPesquisa($pesq);
    echo $space10;
    botaoCria("tradutor.cria.php", "tradutor.lista.php");
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
//    echo "<th align='left'>Id</th>";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left' colspan=2></td>";
    echo "</tr>";
    echo "</thead>";

    while($reg = $rs->fetch() ){        // PDO
        $id_tradutor    = $reg["id_tradutor"];
        $nome           = $reg["nome"];
        echo "<td>" . $nome . "</td>";

        echo "<td><a href='tradutor.altera.php?id_tradutor=$id_tradutor'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='tradutor.exclui.php?id_tradutor=$id_tradutor&nome=$nome'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>