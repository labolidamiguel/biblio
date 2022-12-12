<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.publicado.php";

Arch::initController("publicado");
    $id_centro      = Arch::session("id_centro");
    $id_publicado   = Arch::session("id_publicado");
    $pesq           = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("id_publicado");
    Arch::deleteCookie("cod_cde");
    Arch::deleteCookie("nome_titulo");
    Arch::deleteCookie("flag_lido");
    
    $publicado = new Publicado();

    $count = $publicado->getCount($id_centro, $pesq);
    $rs = $publicado->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
    <form>
        <p class=appTitle2>Publicado pela FEB</p>
        <input type="text" value="<?php echo $pesq ?>" name="pesq" id="pesq" class="inputh">
        <a href="?pesq="><img src="../layout/img/limp.ico" width="22" height="22" class="butimg"></a> <!-- reset -->
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="image" src="../layout/img/pesq.ico" alt="Submit" width="22" height="22" class="butimg">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cria
        <a href='publicado.cria.php'><img border='0' class='butimg'; alt='alt' src='../layout/img/cria.ico' style='width: 26px; margin-left:-2px; margin-bottom:1px;'></a>
    </form>

<?php
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>CDE</th>";
    echo "<th align='left'>Título</th>";
    echo "<th align='left' colspan=2></td>";
    echo "</tr>";
    echo "</thead>";
    while($reg = $rs->fetch() ){        // PDO
        $id_publicado   = $reg["id_publicado"];
        $cod_cde        = $reg["cod_cde"];
        $nome_titulo    = $reg["nome_titulo"];

        echo "<td>$cod_cde</td>";
        echo "<td>$nome_titulo</td>";
        echo "<td><a href='publicado.altera.php?id_publicado=$id_publicado'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='publicado.exclui.php?id_publicado=$id_publicado&cod_cde=$cod_cde&nome_titulo=$nome_titulo'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
