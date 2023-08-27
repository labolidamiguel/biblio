<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";

Arch::initController("usuario");
    $id_centro  = Arch::session("id_centro");
	$id_usuario = Arch::get("id_usuario") ;
	$perfis     = Arch::get("perfis");
    $callback   = Arch::requestOrCookie("callback");
    $action     = Arch::get("action");

    if (strcmp($action, "ok") == 0) {
//        Arch::deleteCookie("action");
//        Arch::deleteCookie("callback");
        $perfis = getPerfis();
        header("Location: $callback?perfis=$perfis");
    }

    $app = new App();
    $rs = $app->select_group_perfis();

Arch::initView(TRUE);
    echo "<form method='get'>";
// cria checkbox
    echo "<p class=appTitle2>Usuário</p><br>";
    echo "<table class='table striped' "; 
    echo "style=\"width:98%\">";
    echo "<tr class=\"blue\">";
    echo "<th align='left' colspan='2'>Perfil</th>";
    echo "<th>Aplicações</th>";
    echo "</tr>";
    while($reg = $rs->fetch()) {    // PDO
        $perf = $reg["perfis"];
        if ($perf == "0") continue; // bypass app oculta
        if ($perf == "9") continue; // bypass cria root
        echo "<tr>";
        echo "<td>";
        echo "<input type='checkbox' name='perf$perf'
                value='$perf' class='check'";
            if (strpos($perfis, $perf) === FALSE) {}
            else{echo " CHECKED";
            }
        echo "></td>";
        echo "<td>";
        echo $perf;
        echo "</td>";
        echo "<td>";
        $rst = $app->select_titulos_por_perfis($perf);
        while($rtit = $rst->fetch()) {    // PDO
            $tit = $rtit["titulo"];
            if (strlen($tit) > 0)
                echo $tit . "&nbsp;&nbsp;";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";
    echo "<input type='hidden' name='action' value='ok'>";
    echo "<input type='hidden' name='perfis' value='$perfis'>";
    echo "<input type='hidden' name='flag_lido' value='lido'>";
    echo "<input type='submit' class='butbase' value='OK' ";

    echo " formaction='perfis.dominio.php'>";
//    echo " formaction='$callback'>";

    echo "</form>";
/*
    function cria_checkbox($App, $perfis, $rs) {
        echo "<p class=appTitle2>Usuário</p>";
        echo "<table class='table striped' "; 
        echo "style=\"width:98%\">";
        echo "<tr class=\"blue\">";
        echo "<th align='left' colspan='2'>Perfil</th>";
        echo "<th>Aplicações</th>";
        echo "</tr>";
        echo "<tr>";
        $buf = "";
// select_group_perfis
        while($reg = $rs->fetch()) {    // PDO
            $perf = $reg["perfis"];
            if ($perf == "0") continue; // bypass app oculta
            if ($perf == "9") continue; // bypass cria root
            echo "<td>";
            echo "<input type='checkbox' name='perf$perf'
                value='$perf' class='check'";
            if (strpos($perfis, $perf) === FALSE) {}
            else{echo " CHECKED";
            }
            echo "></td>";
            echo "<td>$perf</td>";
            $rp = $app->select_perfis($reg["perfis"]);
            echo "<td>";
            $buf = "";
// descr. aplic
            while($rep = $rp->fetch()){ // PDO
                if (strlen($buf) > 0
                &&  strlen($rep["titulo"]) > 0) { 
                    $buf = $buf.", ";
                }
                $buf = $buf.$rep["titulo"];
            }
            echo "$buf.</td></tr>";
        }
        echo "</table>";
    }
*/
    function getPerfis() {
        $perfis = "";
        for ($i=0; $i<10; $i++) {
            $per = "perf".$i;
            if (isset($_GET[$per])) {
                $perfis = $perfis . $i;
            }
        }
        return $perfis;
    }

    Arch::endView();
?>
