<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.estante.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("estante");
    $id_centro  = Arch::session("id_centro");
    $id_estante = Arch::requestOrCookie("id_estante");
    $cod_estante = Arch::requestOrCookie("cod_estante");
    $cde_inicial = Arch::requestOrCookie("cde_inicial");
    $cde_final  = Arch::requestOrCookie("cde_final");
    $action     = Arch::get("action");
    $msg = "";

    $estante = new Estante();
    $audit = new Auditoria();
    
    $msg = $estante->integridade($id_centro, $id_estante);
    if (strlen($msg) == 0) {
        if ($action == 'Confirma') {
            $message = $estante->delete($id_centro, $id_estante);
            if ($message->code < 0) {
                $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
            }else{
                $msg="<p class=texgreen>* Estante excluido</p>";
                $audit->report("Exclui $id_centro, $id_estante, $cde_inicial, $cde_final");
            }
        }
    }

Arch::initView(TRUE);

    echo "<p class=appTitle2>Estante</p>";
    echo "<table class='tableraw'>";
    echo "<tr><td>Estante</td><td>$cod_estante</td></tr>";
    echo "<tr><td>CDE inicial</td><td>$cde_inicial</td></tr>";
    echo "<tr><td>CDE final</td><td>$cde_final</td></tr>";
    echo "</table>";
    echo $msg;
    echo "<br>";
    if (strlen($msg) == 0) {
        echo "<p class='texgreen'>* Confirma a exclusão?</p><br>";
        echo "<a href='?action=Confirma&id_estante=$id_estante&estante=$cod_estante'><button class='butbase'>Confirma</button></a>";
    }
    echo "<a href='estante.lista.php'><button class='butbase'>Volta</button></a>";

Arch::endView(); 
?>
