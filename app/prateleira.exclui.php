<?php                          // prateleira.exclui.php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.prateleira.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("prateleira");
    $id_centro  = Arch::session("id_centro");
    $id_prateleira = Arch::requestOrCookie("id_prateleira");
    $cod_prateleira = Arch::requestOrCookie("cod_prateleira");
    $cde_inicial = Arch::requestOrCookie("cde_inicial");
    $cde_final  = Arch::requestOrCookie("cde_final");
    $action     = Arch::get("action");
    $msg = "";

    $prateleira = new Prateleira();
    $audit = new Auditoria();
    
    $msg = $prateleira->integridade($id_centro, $id_prateleira);
    if (strlen($msg) == 0) {
        if ($action == 'Confirma') {
            $message = $prateleira->delete($id_centro, $id_prateleira);
            if ($message->code < 0) {
                $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
            }else{
                $msg="<p class=texgreen>* Prateleira excluida</p>";
                $audit->report("Exclui $id_centro, $id_prateleira, $cde_inicial, $cde_final");
            }
        }
    }

Arch::initView(TRUE);

    echo "<p class=appTitle2>Prateleira</p>";
    echo "<table class='tableraw'>";
    echo "<tr><td>Prateleira</td><td>$cod_prateleira</td></tr>";
    echo "<tr><td>CDE inicial</td><td>$cde_inicial</td></tr>";
    echo "<tr><td>CDE final</td><td>$cde_final</td></tr>";
    echo "</table>";
    echo $msg;
    echo "<br>";
    if (strlen($msg) == 0) {
        echo "<p class='texgreen'>* Confirma a exclusão?</p><br>";
        echo "<a href='?action=Confirma&id_prateleira=$id_prateleira&prateleira=$cod_prateleira'><button class='butbase'>Confirma</button></a>";
    }
    echo "<a href='prateleira.lista.php'><button class='butbase'>Volta</button></a>";

Arch::endView(); 
?>
