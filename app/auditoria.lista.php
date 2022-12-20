<?php
include "../common/arch.php";
include "../classes/class.app.php";
include "../classes/class.auditoria.php";
include "../common/funcoes.php";

Arch::initController("auditoria");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("flag_lido");
    
    $auditoria = new Auditoria();

    $count = $auditoria->getCount($id_centro, $pesq);
    $rs = $auditoria->select($id_centro, $pesq);

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

    echo "<p class=appTitle2>Auditoria</p>";
    echo "<form>";
    echo "<div>";
    botaoPesquisa($pesq);
    echo "$space10 Exclui&nbsp;";
    echo "<a href='auditoria.exclui.php?id_autor=$id_autor&nome=$nome&iniciais=$iniciais'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
    echo "</div>";
    echo "</form>";

    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Data$space10</th>";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left'>Aplicação</th>";
    echo "<th align='left'>Mens</td>";
    echo "<th align='left'></td>";
    echo "</tr>";
    echo "</thead>";

    while($reg = $rs->fetch() ){        // PDO
        $id_usuario = $reg["id_usuario"];
        $codigo_app = $reg["codigo_app"];
        $data       = $reg["data"];
        $hora       = $reg["hora"];
        $mensagem   = $reg["mensagem"];
        $nome       = $reg["nome"];
        echo "<td>$data</td>";
        echo "<td>$nome</td>";
        echo "<td>$codigo_app</td>";
        $aux = substr($mensagem,0,5);
        echo "<td>$aux</td>";
        echo "<td><a href='auditoria.detalhe.php?nome=$nome&app=$codigo_app&mensagem=$mensagem'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>