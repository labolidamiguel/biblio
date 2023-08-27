<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";

Arch::initController("usuario");

    $id_centro  = Arch::session("id_centro");
	$id_usuario = Arch::requestOrCookie("id_usuario") ;
	$nome       = Arch::requestOrCookie("nome");
	$perfis     = Arch::requestOrCookie("perfis");
    $callback   = Arch::requestOrCookie("callback");
    $action     = Arch::requestOrCookie("action");

    if ($action == "ok") {
        Arch::deleteCookie("action");
        $perfis = getPerfis();
        header("Location: $callback?perfis=$perfis");
    }
    $App = new App();
    $rs = $App->select_group_perfil();

Arch::initView(TRUE);
    echo "<form method='get'>";
    cria_checkbox($App, $perfis, $rs);
    echo "<br>";
    echo "<input type='hidden' name='action' value='ok'>";
    echo "<input type='submit' class='butbase' value='OK' formaction='perfil.dominio.php'>";
    echo "</form>";

    function cria_checkbox($App, $perfis, $rs) {
        echo "<p class=appTitle2>Usuário</p>";
        echo "<table class='table striped' style=\"width:98%\">";
        echo "<tr class=\"blue\">";
        echo "<th align='left' colspan='2'>Perfil</th>";
        echo "<th>Aplicações</th>";
        echo "</tr>";
        echo "<tr>";
        $buf = "";
//        while($reg = $rs->fetchArray()) { // select_group_perfil
        while($reg = $rs->fetch()) {    // PDO
            $perf = $reg["perfil"];
            if ($perf == "0") continue; // bypass criacao app ocultas
            if ($perf == "9") continue; // bypass criacao usuario=root
            echo "<td>";
            echo "<input type='checkbox' name='perf$perf' value='$perf' class='check'";
            if (strpos($perfis, $perf) === FALSE) {}
            else{echo " CHECKED";
            }
            echo "></td>";
            echo "<td>$perf</td>";
            $rp = $App->select_perfil($reg["perfil"]);
            echo "<td>";
            $buf = "";
//            while($rep = $rp->fetchArray()) { // descr. aplic
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

    function getPerfis() {
        $perfil = "";
        for ($i=0; $i<10; $i++) {
            $per = "perf".$i;
            if (isset($_GET[$per])) {
                $perfil = $perfil . $i;
            }
        }
        return $perfil;
    }

    Arch::endView();
?>