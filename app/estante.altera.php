<?php                                   // estante.altera.php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.estante.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("estante");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_estante = Arch::requestOrCookie("id_estante");
    $cod_estante = Arch::requestOrCookie("cod_estante");
    $cde_inicial = Arch::requestOrCookie("cde_inicial");
    $cde_final  = Arch::requestOrCookie("cde_final");
    
    $msg = "";
    $estante = new Estante();
    $audit = new Auditoria();
    
    if (strlen($flag_lido) == 0) {     // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $estante->selectId($id_centro , $id_estante); 
        $reg = $rs->fetch();            // PDO
        $id_estante = $reg["id_estante"];
        $cod_estante    = $reg["cod_estante"];
        $cde_inicial = $reg["cde_inicial"];
        $cde_final  = $reg["cde_final"];
    }

    if ($action == 'grava') {
        $msg = $estante->valida($id_centro, $id_estante, $cod_estante, $cde_inicial, $cde_final);
        if (strlen($msg) == 0) {
            $message = $estante->update($id_centro, $id_estante, $cod_estante, $cde_inicial, $cde_final);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Prateleira alterada</p>";
                $audit->report("Altera $id_centro, $id_estante, $cod_estante, $cde_inicial, $cde_final");
            }

        Arch::deleteAllCookies();
        }
    }

    if ($action == 'i') {               // dominio cde inicial
    	header("Location: cde.dominio.inicial.php?callback=estante.altera.php");        
    }
    if ($action == 'f') {               // dominio cde final
    	header("Location: cde.dominio.final.php?callback=estante.altera.php");        
    }
    
Arch::initView(TRUE);
include "./estante.form.php";

    if (! strpos($msg, "alterado")) {  // omite botao altera
        echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
    echo "<input type='hidden' name='id_estante' value='$id_estante'/>";
    echo "<button type='submit' class='butbase' formaction='estante.lista.php'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
