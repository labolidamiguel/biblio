<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.autor.php";
include "../classes/class.auditoria.php";

Arch::initController("autor");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_autor   = Arch::requestOrCookie("id_autor");
    $nome       = Arch::requestOrCookie("nome");
    $iniciais   = Arch::requestOrCookie("iniciais");
    $msg = "";

    $autor = new Autor();
    $auditoria = new Auditoria();

    if (strlen($flag_lido) == 0) {   // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $autor->selectId($id_centro , $id_autor); 
        $reg = $rs->fetch();            // PDO
        $nome       = $reg["nome"];  
        $iniciais   = $reg["iniciais"];
    }

    if ($action == 'grava') {
        $msg = $autor->valida_altera($id_centro, $id_autor, $nome, $iniciais);
        if (strlen($msg) == 0) {
            $message = $autor->update($id_centro, $id_autor, $nome, $iniciais);
            if ($message->code < 0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Autor alterado</p>";
                $auditoria->report("Altera $id_centro, $id_autor, $nome, $iniciais");
            }
        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
    echo "<p class=appTitle2>Autor</p>";
    echo "<form method='get'>";

    echo "<p class=labelx>Nome</p>";
    echo "<input type='text' name='nome' value='" . $nome . "' class='inputx'/>";
        
    echo "<p class=labelx>Iniciais</p>";
    echo "<input type='text' name='iniciais' value='" . $iniciais . "' class='inputx'/>";

    echo "<b>" . $msg . "</b> <br>";    // mensagens

    if (! strpos($msg, "alterado")) {  // omite botao altera
        echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
    }

    echo "<input type='hidden' name='id_autor' value='" . $id_autor . "'/>";
    echo "<button type='submit' class='butbase' formaction='autor.lista.php'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
