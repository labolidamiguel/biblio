<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.centro.php";

Arch::initController("centro");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("id_centro");
    Arch::deleteCookie("nome");
    Arch::deleteCookie("sigla");
    Arch::deleteCookie("telefone");
    Arch::deleteCookie("endereco");
    Arch::deleteCookie("cidade");
    Arch::deleteCookie("estado");
    Arch::deleteCookie("cep");

    Arch::deleteCookie("flag_lido");
    
    $centro = new Centro();

    $count = $centro->getCount($pesq);
    $rs = $centro->select($pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<p class=appTitle2>Centro Espírita</p>";
    echo "<form>";
    echo "<div>";
    echo "<input type='text' value='$pesq' name='pesq' id='pesq' class='inputh'>";
    echo "<a href='?pesq='><img src='../layout/img/limp.ico' width='22' height='22' class='butimg'></a>"; // reset
    echo $space5;
    echo "<input type='image' src='../layout/img/pesq.ico' alt='Submit' width='22' height='22' class='butimg'>";
    echo "$space10 Cria";
    echo "<a href='centro.cria.php'><img border='0' class='butimg'; alt='alt' src='../layout/img/cria.ico' style='width: 26px; margin-left:-2px; margin-bottom:1px;'></a>";
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Id</th>";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left'>Sigla</th>";
    echo "<th align='left' colspan=2></td>";
    echo "</tr>";
    echo "</thead>";
    while($reg = $rs->fetch() ){        // PDO
        $id_centro  = $reg["id_centro"];
        $nome       = $reg["nome"];
        $sigla      = $reg["sigla"];
        echo "<td>$id_centro</td>";
        echo "<td>$nome</td>";
        echo "<td>$sigla</td>";
        echo "<td><a href='centro.altera.php?id_centro=$id_centro'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='centro.exclui.php?id_centro=$id_centro&nome=$nome&sigla=$sigla'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG
Arch::endView();
?>
