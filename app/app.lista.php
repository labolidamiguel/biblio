<?php
        error_reporting (E_ALL ^ E_NOTICE);
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";

Arch::initController("app");
    error_reporting (E_ALL ^ E_NOTICE);
    $app = new App();

    $count = $app->getCount($pesq);
    $rs = $app->select_all();

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<style>";
    echo ".tableFixHead {";
    echo "    overflow-y: auto;";
    echo "    height: 66%;";
    echo "}";
    echo ".tableFixHead thead th {";
    echo "    position: sticky;";
    echo "    top: 0;";
    echo "}";
    echo "table {";
    echo "    border-collapse: collapse;";
    echo "    width: 100%;";
    echo "    border:0px;";
    echo "}";
    echo "th,";
    echo "td {";
    echo "    padding: 8px 4px;";
    echo "    border: 0px solid #ccc;";
    echo "    text-align: left;";
    echo "}";
    echo "th {";
    echo "    background: #eee;";
    echo "	  color:#fff!important;";
    echo "    background-color:#2196F3!important";
    echo "}";
    echo "</style>";

    echo "<p class=appTitle2>App</p>";
    echo "<form>";
    echo "<div>";
    echo "<input type='text' value='$pesq' name='pesq' id='pesq' class='inputh'>";
    echo "<a href='?pesq='><img src='../layout/img/limp.ico' width='22' height='22' class='butimg'></a>"; //reset
    echo $space5;
    echo "<input type='image' src='../layout/img/pesq.ico' alt='Submit' width='22' height='22' class='butimg'>";
    echo "$space10 Cria";
    echo "<a href='app.cria.php'><img class='butimg'; alt='alt' src='../layout/img/cria.ico' style='width: 26px; margin-left:-2px; margin-bottom:1px;'></a>";
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>C&oacute;digo</th>";
    echo "<th>T&iacute;tulo App</th>";
    echo "<th>Perf</th>";
    echo "<th>URL</th>";
    echo "<th>Ord</th>";
    echo "<th></th>"; // altera
    echo "<th></th>"; // exclui
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while($reg = $rs->fetch() ){        // PDO
        $id_app     = $reg["id_app"];
        $codigo     = $reg["codigo"];
        $titulo     = $reg["titulo"];
        $perfil     = $reg["perfil"];
        $ordem      = $reg["ordem"];
        echo "<td>$codigo</td>";
        echo "<td>$titulo</td>";
//        echo "<td>" . $reg["imagem"] . "</td>";
        echo "<td>$perfil</td>";
        echo "<td>" . $reg["url"] . "</td>"; // URL
        echo "<td>$ordem</td>";
        echo "<td><a href='app.altera.php?id_app=$id_app'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='app.exclui.php?id_app=$id_app&codigo=$codigo&titulo=$titulo'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</body>";
    echo "</table>";
    echo "</div>";
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();

?>
