<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";

Arch::initController("titulo");   // exemplar App nao existe
//    Arch::deleteAllCookies();
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::get("pesq");
    $id_titulo  = Arch::requestOrCookie("id_titulo");
    $nome_titulo = Arch::requestOrCookie("nome_titulo");
    $titulotrunc = $nome_titulo;
    if (strlen($titulotrunc) > 40)
        $titulotrunc = substr($titulotrunc, 0, 40) . " ...";

    $exemplar = new Exemplar();

    $count = $exemplar->getCount($id_centro, $id_titulo);
    $rs = $exemplar->select($id_centro, $id_titulo);

Arch::initView(TRUE);
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>Exemplar(es)</p>";
    echo "<p class=appTitle4>$titulotrunc</p>";
    echo "<form>";
    echo "<div>";
//    botaoPesquisa($pesq);     //   d e s a t i v a d o
    echo $space10;
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
        $nome_editora  = $reg["nome_editora"];
        $nome_tradutor = $reg["nome_tradutor"];
        $nro_exemplar = $reg["nro_exemplar"];
        echo "<td>$id_exemplar</td>";
        echo "<td>$nome_editora</td>";
        echo "<td>$nome_tradutor</td>";
        echo "<td>$nro_exemplar</td>";
        echo "<td><a href='exemplar.altera.php";
        echo "?id_exemplar=$id_exemplar";
        echo "&id_titulo=$id_titulo";
        echo "&nome_titulo=$nome_titulo'>";
        echo "<img border='0' alt='alt' ";
        echo "src='../layout/img/alte.ico' ";
        echo "width='20' height='20'>";
        echo "</a><br></td>";

        echo "<td><a href='exemplar.exclui.php";
        echo "?id_titulo=$id_titulo";
        echo "&id_exemplar=$id_exemplar";
        echo "&nome_tradutor=$nome_tradutor";
        echo "&nome_editora=$nome_editora'>";
        echo "<img border='0' alt='excl' ";
        echo "src='../layout/img/excl.ico' ";
        echo "width='20' height='20'>";
        echo "</a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
