<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
    $linxpage       = 10;               // linhas por pagina
    $id_centro      = Arch::session("id_centro");
    $action         = Arch::requestOrCookie("action");
    $page           = Arch::requestOrCookie("page");

Arch::initView(TRUE);
    echo "<p class=appTitle2>Impressão</p>";
    echo "<table class='table striped' style=\"width:98%\">";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left'>Operação</td>";
    echo "</tr>";

    echo "<tr><td>Exemplar por CDE</td>";
    echo "<td><a href='exemplar.rel.cde.php?id_centro=$id_centro'><img border='0' alt='alt' src='../layout/img/impb.ico' width='20' height='20'></a><br></td>";
    echo "</tr>";

    echo "<tr><td>Exemplar por Etiqueta</td>";
    echo "<td><a href='exemplar.rel.etiq.php?id_centro=$id_centro'><img border='0' alt='alt' src='../layout/img/impb.ico' width='20' height='20'></a><br></td>";
    echo "</tr>";

    echo "<tr><td>Título por Id</td>";
    echo "<td><a href='titulo.rel.id.php?id_centro=$id_centro'><img border='0' alt='alt' src='../layout/img/impb.ico' width='20' height='20'></a><br></td>";
    echo "</tr>";

    echo "</table>";

Arch::endView();
?>
