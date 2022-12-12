<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.titulo.php";

Arch::initController("titulo");
    Arch::deleteAllCookies();
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("nome_titulo");
    Arch::deleteCookie("sigla");
    Arch::deleteCookie("autor");
    Arch::deleteCookie("espirito");

    $titulo = new Titulo();

    $count = $titulo->getCount($id_centro, $pesq);
    $rs = $titulo->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
    <p class=appTitle2>Título</p>
    <form>
    <div>
        <input type="text" value="<?php echo $pesq ?>" name="pesq" id="pesq" class="inputh">
        <a href="?pesq="><img src="../layout/img/limp.ico" width="22" height="22" class="butimg"></a> <!-- reset -->
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="image" src="../layout/img/pesq.ico" alt="Submit" width="22" height="22" class="butimg">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cria
        <a href='titulo.cria.php'><img border='0' class='butimg'; alt='alt' src='../layout/img/cria.ico' style='width: 26px; margin-left:-2px; margin-bottom:1px;'></a>
    </div>
    </form>

<?php
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Id</th>";
    echo "<th align='left'>Título</th>";
    echo "<th align='left'>Autor</th>";
    echo "<th align='left' colspan=3></td>";
    echo "</tr>";
    echo "</thead>";
    while($reg = $rs->fetch() ){        // PDO
        $id_titulo      = $reg["id_titulo"];
        $nome_titulo    = $reg["nome_titulo"];
        $autor          = $reg["autor"];
        echo "<td>" . $id_titulo . "</td>";
        echo "<td>" . $nome_titulo . "</td>";
        echo "<td>" . $autor . "</td>";

        echo "<td><a href='exemplar.lista.php?id_titulo=$id_titulo&nome_titulo=$nome_titulo'><img border='0' alt='exem' src='../layout/img/exem.ico' width='20' height='20'></a><br></td>";

        echo "<td><a href='titulo.altera.php?id_titulo=$id_titulo'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";

        echo "<td><a href='titulo.exclui.php?id_titulo=$id_titulo&nome_titulo=$nome_titulo&autor=$autor'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
