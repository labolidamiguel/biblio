<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.autor.php";

Arch::initController("autor");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("id_autor");
    Arch::deleteCookie("nome");
    Arch::deleteCookie("iniciais");
    Arch::deleteCookie("flag_lido");
    
    $autor = new Autor();

    $count = $autor->getCount($id_centro, $pesq);
    $rs = $autor->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<p class=appTitle2>Autor</p>";
    echo "<form>";
    echo "<div>";

    echo "<input type='text' value='$pesq' name='pesq' id='pesq' class='inputh'>";
    echo "<a href='?pesq='><img src='../layout/img/limp.ico' width='22' height='22' class='butimg'></a>"; // reset
    echo $space5;
    echo "<input type='image' src='../layout/img/pesq.ico' alt='Submit' width='22' height='22' class='butimg'>";

    echo "$space10 Cria";
    echo "<a href='autor.cria.php?callback=autor.lista.php'><img border='0' class='butimg'; alt='alt' src='../layout/img/cria.ico' style='width: 26px; margin-left:-2px; margin-bottom:1px;'></a>";
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
        $id_autor   = $reg["id_autor"];
        $nome       = $reg["nome"];
        $iniciais   = substr($reg["iniciais"],0,2);
        echo "<td>" . $nome . "</td>";
        echo "<td>" . $iniciais . "</td>";
        echo "<td><a href='autor.altera.php?id_autor=$id_autor'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='autor.exclui.php?id_autor=$id_autor&nome=$nome&iniciais=$iniciais'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
