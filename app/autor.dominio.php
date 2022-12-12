<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.autor.php";

Arch::initController("autor");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::requestOrCookie("action");
    $step       = Arch::requestOrCookie("step");
    $pesq       = Arch::requestOrCookie("pesq");
    $callback   = Arch::requestOrCookie("callback");

    $autor = new Autor();

    $count = $autor->getCount($id_centro, $pesq);
    $rs = $autor->select($id_centro, $pesq);
    
Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Autor</p>";
    echo "<form><div>";

    echo "<input type='hidden' name='callback' value=" . $callback . " id='callback' class='callback'>";
    echo "<input type='hidden' name='action' value=" . $action . " id='action' class='action'>";
    echo "<input type='hidden' name='step' value=" . $step . " id='step' class='step'>";

    echo "<input type='text' value='" . $pesq . "' name='pesq' id='pesq' class='inputh'>";
    echo "<a href='?pesq='><img src='../layout/img/limp.ico' width='22' height='22' class='butimg'></a>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<input type='image' src='../layout/img/pesq.ico' alt='Submit' width='22' height='22' class='butimg'>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "</div></form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left'>Iniciais</th>";
    echo "</tr>";
    echo "</thead>";
    while( $reg = $rs->fetch() ){       // PDO
        $nome = urlencode($reg["nome"]);
        $iniciais = substr($reg["iniciais"],0,2);
        echo "<tr onclick=window.location.href='$callback?id_autor=" . $reg["id_autor"] . "&autor=$nome'></a>";
        echo "<td>" . $reg["nome"] . "</td>";
        echo "<td> $iniciais </td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</form>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG
    Arch::endView();
?>
