<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.leitor.php";

Arch::initController("leitor");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("id_leitor");
    Arch::deleteCookie("nome");
    Arch::deleteCookie("celular");
    Arch::deleteCookie("email");
    Arch::deleteCookie("endereco");
    Arch::deleteCookie("cep");
    Arch::deleteCookie("notas");
    Arch::deleteCookie("flag_lido");
    
    $leitor = new Leitor();

    $count = $leitor->getCount($id_centro, $pesq);
    $rs = $leitor->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Leitor</p>";
    echo "<form>";
    echo "<div>";
    botaoPesquisa($pesq);
    echo $space10;
    botaoCria("leitor.cria.php", "leitor.lista.php");
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left'>Celular$space10</th>";
    echo "<th align='left' colspan=2></td>";
    echo "</tr>";
    echo "</thead>";
    while($reg = $rs->fetch()){         // PDO
        $id_leitor  = $reg["id_leitor"];
        $nome       = $reg["nome"];
        $celular    = $reg["celular"];
        echo "<td>" . $nome . "</td>";
        echo "<td>" . $celular . "</td>";
        echo "<td><a href='leitor.altera.php?id_leitor=$id_leitor'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='leitor.exclui.php?id_leitor=$id_leitor&nome=$nome&celular=$celular'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
