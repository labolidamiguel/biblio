<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.autor.php";
include "../classes/class.auditoria.php";

Arch::initController("autor");

    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
    $id_autor       = Arch::requestOrCookie("id_autor");
    $nome           = Arch::requestOrCookie("nome");
    $iniciais       = Arch::requestOrCookie("iniciais");
    $callback       = Arch::requestOrCookie("callback");

    $msg = "";
    $autor = new Autor();
    $auditoria = new Auditoria();
        
    if ($action == 'grava') {
        $msg = $autor->valida_cria($id_centro, $id_autor, $nome, $iniciais);
        if (strlen($msg) == 0) {
            $message = $autor->insert($id_centro, $nome, $iniciais);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Autor criado</p>";
                $auditoria->report("Cria $id_centro, $nome, $iniciais");
            }
        }
    }
    
Arch::initView(TRUE);
    echo "<p class=appTitle2>Autor</p>";
    echo "<form method='get'>";

    echo "<p class=labelx>Nome</p>";
    echo "<input type='text' name='nome' value='$nome' class='inputx'/>";

    echo "<p class=labelx>Iniciais</p>";
    echo "<input type='text' name='iniciais' value='$iniciais' class='inputx'/>";

    echo "<br>";
    echo "<b>" . $msg . "</b><br>";     // mensagens

    if (! strpos($msg, "criado")) {     // omite botao cria
        echo "<button type='submit' name='action' value='grava' class='butbase'>Cria</button>";
    }
    echo "<input type='hidden' name='id_autor' value='" . $id_autor . "'/>";

    echo "<button type='submit' class='butbase' ";
    echo "formaction='$callback'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
