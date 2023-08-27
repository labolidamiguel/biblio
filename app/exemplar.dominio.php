<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";
include "../classes/class.emprestimo.php";

Arch::initController("lista");          // antes exemplar
    $id_centro  = Arch::session("id_centro");
    $id_titulo  = Arch::requestOrCookie("id_titulo");
    $titulo     = Arch::requestOrCookie("titulo");
    $callback   = Arch::requestOrCookie("callback");

    $exemplar = new Exemplar();
    $emprestimo = new Emprestimo();

    if (strlen($id_titulo) == 0) {
        $msg = "<p class=texred>
        * Deve antes escolher o Título</p>";
        $target = "emprestimo.cria.php?msg=$msg";
    	header("Location: $target"); 
    }
    $count = $exemplar->getCount($id_centro, $id_titulo);
    $rs = $exemplar->select($id_centro, $id_titulo);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<p class=apptitle2>Exemplar(es)</p>";
    echo "<p class=apptitle4>&nbsp;&nbsp;$titulo</p>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Id</th>";
    echo "<th align='left'>Editora</th>";
    echo "<th align='left'>Tradutor</th>";
    echo "<th align='left'>N.Ex</th>";
    echo "<th align='left'>Situação</td>";
    echo "</tr>";
    echo "</thead>";

    while($reg = $rs->fetch()) {        // PDO
    $id_exemplar    = $reg["id_exemplar"];
    $nro_exemplar   = $reg["nro_exemplar"];
        $emp = $emprestimo->emprestado($id_centro, $id_exemplar);
        $situacao = ($emp == 0) ? "" : "emprestado";
        echo "<tr onclick=window.location.href='$callback?id_exemplar=$id_exemplar&nro_exemplar=$nro_exemplar&situacao=$situacao&msg='></a>";
        echo "<td>" . $reg["id_exemplar"] . "</td>";
        echo "<td>" . $reg["editora"]  . "</td>";
        echo "<td>" . $reg["tradutor"] . "</td>";
        echo "<td>" . $reg["nro_exemplar"] . "</td>";
        echo "<td>" . $situacao . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
