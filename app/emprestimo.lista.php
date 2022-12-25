<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.emprestimo.php";

Arch::initController("devolucao");      // DEVOLUÇÃO
    $id_centro  = Arch::session("id_centro");
    $id_emprestimo  = Arch::requestOrCookie("id_emprestimo");
    $pesq           = Arch::request("pesq") ;
    $action         = Arch::requestOrCookie("action") ;
//    Arch::deleteCookie("flag_lido");
    
    $emprestimo = new Emprestimo();

    $count = $emprestimo->getCount($id_centro, $pesq);
    $rs = $emprestimo->selectOrdDate($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Devolução</p>";
    echo "<form>";
    echo "<div>";
    botaoPesquisa($pesq);
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
//        echo "<th align='left'>Id</th>";
    echo "<th align='left'>Leitor</th>";
    echo "<th align='left'>Título</th>";
    echo "<th align='left'>Ex.</th>";
    echo "<th align='left'>Emprestado</th>";
//        echo "<th align='left'>Devol</th>";
    echo "<th align='left'></th>";
    echo "</tr>";
    echo "<thead>";

    while($reg = $rs->fetch()) {    // PDO
        $id_emprestimo = $reg["id_emprestimo"];
        echo "<tr>";
        echo "<td>" . $reg["leitor"]."</td>";
        echo "<td>" . $reg["nome_titulo"]."</td>";
        echo "<td>" . $reg["exemplar"]."</td>";
        echo "<td>" . $reg["emprestado"]."</td>";
//        echo "<td>" . $reg["devolvido"]."</td>";
        echo "<td><a href='emprestimo.altera.php?id_emprestimo=$id_emprestimo'><img border='0' alt='alt' src='../layout/img/devo1.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
        }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
