<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.prateleira.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("prateleira");
    $id_centro      = Arch::session("id_centro");
    $id_prateleira     = Arch::requestOrCookie("id_prateleira");
    $cod_prateleira    = Arch::requestOrCookie("cod_prateleira");
    $cde_inicial    = Arch::requestOrCookie("cde_inicial");
    $cde_final      = Arch::requestOrCookie("cde_final");
    $callback       = Arch::requestOrCookie("callback");

    $action         = Arch::get("action");
    $msg = "";

    $prateleira = new Prateleira();
    $audit = new Auditoria();
        
    if ($action == 'grava') {
        $msg = $prateleira->valida($id_centro, $id_prateleira, $cod_prateleira, $cde_inicial, $cde_final);
        if (strlen($msg) == 0) {
            $message = $prateleira->insert($id_centro, $cod_prateleira, $cde_inicial, $cde_final);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Prateleira criada</p>";
                $audit->report("Cria $id_centro, $cod_prateleira, $cde_inicial, $cde_final");
            }
        }
    }

    if ($action == 'i') {               // dominio cde inicial
    	header("Location: cde.dominio.inicial.php?callback=prateleira.cria.php");        
    }

    if ($action == 'f') {               // dominio cde final
    	header("Location: cde.dominio.final.php?callback=prateleira.cria.php");        
    }


Arch::initView(TRUE);
include "./prateleira.form.php";

    if (! strpos($msg, "criado")) {     // omite botao cria
        echo "<button type='submit' name='action' value='grava' class='butbase'>Cria</button>";
    }
    echo "<input type='hidden' name='id_prateleira' value='$id_prateleira'/>";

    echo "<button type='submit' class='butbase' formaction=prateleira.lista.php>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
