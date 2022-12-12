<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.espirito.php";

Arch::initController("espirito");
    $id_centro  = Arch::session("id_centro");
    $pesq     = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("id_espirito");
    Arch::deleteCookie("nome");
    Arch::deleteCookie("flag_lido");
    
    $espirito = new Espirito();

    $count = $espirito->getCount($id_centro, $pesq);
    $rs = $espirito->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
    <p class=appTitle2>Espírito</p>
    <form>
    <div>
        <input type="text" value="<?php echo $pesq ?>" name="pesq" id="pesq" class="inputh">
        <a href="?pesq="><img src="../layout/img/limp.ico" width="22" height="22" class="butimg"></a> <!-- reset -->
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="image" src="../layout/img/pesq.ico" alt="Submit" width="22" height="22" class="butimg">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cria
        <a href='espirito.cria.php?callback=espirito.lista.php'><img border='0' class='butimg'; alt='alt' src='../layout/img/cria.ico' style='width: 26px; margin-left:-2px; margin-bottom:1px;'></a>
    </div>
    </form>

<?php
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left' colspan=2></td>";
    echo "</tr>";
    echo "</thead>";
    while($reg = $rs->fetch() ){        // PDO
        $id_espirito   = $reg["id_espirito"];
        $nome       = $reg["nome"];
        echo "<td>" . $nome . "</td>";
        echo "<td><a href='espirito.altera.php?id_espirito=$id_espirito'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='espirito.exclui.php?id_espirito=$id_espirito&nome=$nome'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>