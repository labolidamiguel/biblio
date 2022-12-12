<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.estante.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("estante");
    $id_centro      = Arch::session("id_centro");
    $id_estante     = Arch::requestOrCookie("id_estante");
    $cod_estante    = Arch::requestOrCookie("cod_estante");
    $cde_inicial    = Arch::requestOrCookie("cde_inicial");
    $cde_final      = Arch::requestOrCookie("cde_final");
    $callback       = Arch::requestOrCookie("callback");

    $action         = Arch::get("action");
    $msg = "";

    $estante = new Estante();
    $audit = new Auditoria();
        
    if ($action == 'grava') {
        $msg = $estante->valida($id_centro, $id_estante, $cod_estante, $cde_inicial, $cde_final);
        if (strlen($msg) == 0) {
            $message = $estante->insert($id_centro, $cod_estante, $cde_inicial, $cde_final);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Estante criado</p>";
                $audit->report("Cria $id_centro, $cod_estante, $cde_inicial, $cde_final");
            }
        }
    }

    if ($action == 'i') {               // dominio cde inicial
    	header("Location: cde.dominio.inicial.php?callback=estante.cria.php");        
    }

    if ($action == 'f') {               // dominio cde final
    	header("Location: cde.dominio.final.php?callback=estante.cria.php");        
    }


Arch::initView(TRUE);
include "./estante.form.php";

    if (! strpos($msg, "criado")) {     // omite botao cria
        echo "<button type='submit' name='action' value='grava' class='butbase'>Cria</button>";
    }
    echo "<input type='hidden' name='id_estante' value='$id_estante'/>";

    echo "<button type='submit' class='butbase' formaction=estante.lista.php>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
