<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";

Arch::initController("titulo");   // exemplar App nao existe
//    Arch::deleteAllCookies();
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    $id_titulo  = Arch::get("id_titulo");
    $nome_titulo = Arch::get("nome_titulo");
    $titulotrunc = $nome_titulo;
    if (strlen($titulotrunc) > 40)
        $titulotrunc = substr($titulotrunc, 0, 40) . " ...";

    $exemplar = new Exemplar();

    $count = $exemplar->getCount($id_centro, $id_titulo);
    $rs = $exemplar->select($id_centro, $id_titulo);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>Exemplar(es)</p>";
    echo "<p class=appTitle4>$titulotrunc</p>";
    echo "<form>";
    echo "<div>";
    botaoPesquisa($pesq);
    echo $space10;
    botaoCria("exemplar.cria.php","exemplar.lista.php&id_titulo=$id_titulo&nome_titulo=$nome_titulo");
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Id</th>";
    echo "<th align='left'>Editora</th>";
    echo "<th align='left'>Tradutor</th>";
    echo "<th align='left'>N.Ex</th>";
    echo "<th align='left' colspan=2></td>";
    echo "</tr>";
    echo "</thead>";

    while($reg = $rs->fetch() ){        // PDO
        $id_exemplar  = $reg["id_exemplar"];
        $id_titulo    = $reg["id_titulo"];
        $editora      = $reg["editora"];
        $tradutor     = $reg["tradutor"];
        $nro_exemplar = $reg["nro_exemplar"];
        echo "<td>" . $id_exemplar . "</td>";
        echo "<td>" . $editora . "</td>";
        echo "<td>" . $tradutor . "</td>";
        echo "<td>" . $nro_exemplar . "</td>";
        echo "<td><a href='exemplar.altera.php?id_exemplar=$id_exemplar&id_titulo=$id_titulo&nome_titulo=$nome_titulo'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";

        echo "<td><a href='exemplar.exclui.php?id_titulo=$id_titulo&id_exemplar=$id_exemplar&tradutor=$tradutor&editora=$editora'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
