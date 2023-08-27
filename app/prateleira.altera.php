<?php                           // prateleira.altera.php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.prateleira.php";
include "../classes/class.auditoria.php";

Arch::initController("prateleira");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_prateleira = Arch::requestOrCookie("id_prateleira");
    $cod_prateleira = Arch::requestOrCookie("cod_prateleira");
    $cde_inicial = Arch::requestOrCookie("cde_inicial");
    $cde_final  = Arch::requestOrCookie("cde_final");
    
    $msg = "";
    $prateleira = new Prateleira();
    $audit = new Auditoria();
    
    if (strlen($flag_lido) == 0) {     // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $prateleira->selectId($id_centro , $id_prateleira); 
        $reg = $rs->fetch();            // PDO
        $id_prateleira  = $reg["id_prateleira"];
        $cod_prateleira = $reg["cod_prateleira"];
        $cde_inicial    = $reg["cde_inicial"];
        $cde_final      = $reg["cde_final"];
    }

    if ($action == 'grava') {
        $msg = $prateleira->valida($id_centro, $id_prateleira, $cod_prateleira, $cde_inicial, $cde_final);
        if (strlen($msg) == 0) {
            $err = $prateleira->update(
                $id_centro, $id_prateleira, $cod_prateleira, 
                $cde_inicial, $cde_final);
            if (strlen($err) > 0) {
                $msg="<p class=texred>Problemas $err</p>";
            }else{
                $msg="<p class=texgreen>
                * Prateleira alterada</p>";
                $audit->report("Altera $id_centro, $id_prateleira, $cod_prateleira, $cde_inicial, $cde_final");
            }

        Arch::deleteAllCookies();
        }
    }

    if ($action == 'i') {               // dominio cde inicial
    	header("Location: cde.dominio.inicial.php?callback=prateleira.altera.php");        
    }
    if ($action == 'f') {               // dominio cde final
    	header("Location: cde.dominio.final.php?callback=prateleira.altera.php");        
    }
    
Arch::initView(TRUE);
include "./prateleira.form.php";

    if (! strpos($msg, "alterado")) {  // omite botao altera
        echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
    echo "<input type='hidden' name='id_prateleira' value='$id_prateleira'/>";
    echo "<button type='submit' class='butbase' formaction='prateleira.lista.php'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
