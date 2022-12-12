<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.cde.php";

Arch::initController("cde");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::request("action");
    $step       = Arch::request("step");
    $search     = Arch::request("search");
    $callback   = Arch::requestOrCookie("callback");

    $cde = new Cde();
    $count = $cde->getCount($id_centro, $search);
    $rs = $cde->select($id_centro, $search);
    
Arch::initView(TRUE);

?>
    <p class=appTitle2>Classificação Decimal Espírita</p>
    <form>
    <div>
        <input type="hidden" value="<?php echo $callback ?>" name="callback" id="callback" class="callback">
        <input type="text" value="<?php echo $search ?>" name="search" id="search" class="inputh">
        <input type="image" src="../layout/img/pesq.ico" alt="Submit" width="22" height="22" class="butimg">
    </div>
    </form>

<?php
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>CDE</th>";
    echo "<th align='left'>Classe</th>";
    echo "</tr>";
    echo "<thead>";
    while( $reg = $rs->fetch()){        // PDO
        $cod_cde = $reg["cde"];
        echo "<tr onclick=window.location.href='$callback?id_cde=".$reg["id_cde"]."&cde_final=".$reg["cod_cde"]."&step=$step&action=$action'></a>";
        echo "<td>" . $reg["cod_cde"] . "</td>";
        echo "<td>" . $reg["classe"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    echo "&nbsp;&nbsp;&nbsp;($count itens)";
Arch::endView();
?>
