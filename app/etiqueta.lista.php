<?php
include "../common/arch.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";
include "../common/funcoes.php";

Arch::initController("etiqueta");
    $id_centro      = Arch::session("id_centro");
    $id_relatorio   = Arch::requestOrCookie("id_relatorio");
    $action         = Arch::requestOrCookie("action");
    $inicial        = Arch::requestOrCookie("inicial");
    $final          = Arch::requestOrCookie("final");
    $msg = "";

    $exemplar = new Exemplar();
    $rs = $exemplar->getIntervaloMinMax($id_centro);

    $minmax = $rs->fetch();             // PDO
    $min = $minmax["min"];
    $max = $minmax["max"];
    $count = $exemplar->getCountDataIntervalo($id_centro);
    $rs = $exemplar->getDataIntervalo($id_centro);

    if ($action == "valida") {
        $msg = valida($inicial, $final, $min, $max);
        if (strlen($msg) == 0) {
            $target = "etiqueta.rel.a4.php?callback=etiqueta.lista.php&inicial=$inicial&final=$final";
            $action = "ok";
            setcookie("action", "ok");
    	    header("Location: $target"); 
        }
    }

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
    <form>
        <p class=appTitle2>Etiquetas</p>
        Inicial
        <input type="hidden" name="action" value="valida">
        <input type="text" value="<?php echo $inicial ?>" name="inicial" id="inicial" class="inputq">
        &nbsp;&nbsp;Final
        <input type="text" value="<?php echo $final ?>" name="final" id="final" class="inputq">
        &nbsp;&nbsp;
        <input type="image" src="../layout/img/impb.ico" alt="Submit" width="26" height="26" class="butimg">
    </form>
<?php
    echo "<p class='blue'>&nbsp;&nbsp;";
    echo "Data $space10 $space10 $space5 Inicial $space10 Final</p>";//NOPAG

    echo "<div style='height:55%; overflow-y: scroll;'>";//NOPAG
    echo "<table class='table striped' style=\"width:98%\">";

    while($reg = $rs->fetch() ){        // PDO
        echo "<td>" . $reg["data_entrada"] . "</td>";
        echo "<td>" . $reg["inicial"] . "</td>";
        echo "<td>" . $reg["final"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo $msg;
    echo "<br>";

    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

    function valida($inicial, $final, $min, $max) {
        $msg = "";
        if (strlen($inicial) == 0) {
            $msg = $msg . "<p class=texred>* Inicial deve ser preenchido</p>";
        }
        if (strlen($final) == 0) {
            $msg = $msg . "<p class=texred>* Final deve ser preenchido</p>";
        }
        if (intval($inicial) < $min || intval($inicial) > $max) {
            $msg = $msg . "<p class=texred>* Inicial inválido</p>";
        }
        if (intval($final) < $min || intval($final) > $max) {
            $msg = $msg . "<p class=texred>* Final inválido</p>";
        }
        if (intval($inicial) >= intval($final)) {
            $msg = $msg . "<p class=texred>* Final deve ser maior que Inicial</p>";            
        }
        return $msg;
    }
Arch::endView();
?>
