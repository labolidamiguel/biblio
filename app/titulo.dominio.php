<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.prateleira.php";
include "../classes/class.titulo.php";

Arch::initController("lista");  // antes titulo
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::get("pesq") ;
    $callback   = Arch::get("callback") ;

    $titulo = new Titulo();
    $prateleira = new Prateleira();

    $count = $titulo->getCount($id_centro, $pesq);
    $rs = $titulo->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<p class=appTitle2>T&iacute;tulo</p>";
    echo "<form>";

    echo "<div>";
    echo "<input type='hidden' value='$callback' name='callback' id='callback' class='callback'>";
    echo "<input type='text' value='$pesq' name='pesq' id='pesq' class='inputh'>";
    echo "<a href='?pesq='><img src='../layout/img/limp.ico' width='22' height='22' class='butimg'></a>"; // reset
    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<input type='image' src='../layout/img/pesq.ico' alt='pesq' width='22' height='22' class='butimg'>";
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\'blue\'>";
    echo "<th align='left'>Título</th>";
    echo "<th align='left'>CDE</th>";
    echo "<th align='left'>Est.</th>";
    echo "</tr>";
    echo "</thead>";
    while($reg = $rs->fetch()) {        // PDO
        $tit = $reg["nome_titulo"];
        $cde = $reg["cod_cde"];
        $est = $prateleira->getPrateleira($id_centro, $cde);
        $nome_titulo = str_replace(" ","%20",$reg["nome_titulo"]);
        if ($callback == "emprestimo.cria.php") { // apaga exemplar
            echo "<tr onclick=window.location.href='$callback?id_titulo=".$reg["id_titulo"]."&nome_titulo=$nome_titulo&id_exemplar=&nro_exemplar=&msg='></a>";
        }else{
            echo "<tr onclick=window.location.href='".$callback."?id_titulo=".$reg["id_titulo"]."&nome_titulo=".$nome_titulo."'></a>";
        }
        echo "<td>" . $tit . "</td>";
        echo "<td>" . $cde . "</td>";
        echo "<td>" . $est . "</td>"; // prateleira
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
