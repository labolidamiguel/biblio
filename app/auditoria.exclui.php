<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.auditoria.php";

Arch::initController("auditoria");

    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
    $data1          = Arch::get("data1");
    $data2          = Arch::get("data2");
    $msg = "";

    $auditoria = new Auditoria();
        
    if ($action == 'exclui') {
        $msg = $auditoria->valida($id_centro, $data1, $data2);
        if (strlen($msg) == 0) {
            $message = $auditoria->delete($id_centro, $data1, $data2);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Excluido</p>";
                $auditoria->report("Cria $id_centro, $data1, $data2");
            }
        }
        Arch::deleteAllCookies();
    }
    
Arch::initView(TRUE);
    echo "<p class=appTitle2>Auditoria</p>";
    echo "<form method='get'>";
    echo "&nbsp;&nbsp;de&nbsp;";        // de
    echo "<input type='date' name='data1' value='$data1' class='inputd'>";
    echo "<br>";
    echo "&nbsp;até&nbsp;";             // ate
    echo "<input type='date' name='data2' value='$data2' class='inputd'>";
    echo "<br>";
    echo "&nbsp;";
    if (strlen($msg) == 0) {
        echo "<p class='texgreen'>* Confirma a exclusão?</p><br>";
    }
    echo "<br>";
    echo "<b>" . $msg . "</b><br>";     // mensagens

    if (! strpos($msg, "xcluido")) {    // omite botao cria
        echo "<button type='submit' name='action' value='exclui' class='butbase'>Excluir</button>";
    }
    echo "<button type='submit' class='butbase' formaction='auditoria.lista.php'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
