<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.espirito.php";

Arch::initController("lista");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::requestOrCookie("action");
    $step       = Arch::requestOrCookie("step");
    $pesq       = Arch::requestOrCookie("pesq");
    $callback   = Arch::requestOrCookie("callback");

    $espirito = new Espirito();
    $count = $espirito->getCount($id_centro, $pesq);
    $rs = $espirito->select($id_centro, $pesq);
    
Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
    <p class=appTitle2>Espirito</p>
    <form>
    <div>
        <input type="hidden" value="<?php echo $callback ?>" name="callback" id="callback" class="callback">
        <input type="text" value="<?php echo $pesq ?>" name="pesq" id="pesq" class="inputh">
        <a href="?pesq="><img src="../layout/img/limp.ico" width="22" height="22" class="butimg"></a> <!-- reset -->
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="image" src="../layout/img/pesq.ico" alt="Submit" width="22" height="22" class="butimg">
    </div>
    </form>

<?php
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "</tr>";
    echo "</thead>";

    while($reg = $rs->fetch()){         // PDO
        $nome = urlencode($reg["nome"]);
        echo "<tr onclick=window.location.href='".$callback."?id_espirito=".$reg["id_espirito"]."&nome=".$nome."&espirito=".$nome."&step=$step&action=$action'></a>";
        echo "<td>" . $reg["nome"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

    Arch::endView();
?>
