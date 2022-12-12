<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.leitor.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("leitor");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_leitor  = Arch::requestOrCookie("id_leitor");
    $nome       = Arch::requestOrCookie("nome");
    $celular    = Arch::requestOrCookie("celular");
    $email      = Arch::requestOrCookie("email");
    $endereco   = Arch::requestOrCookie("endereco");
    $cep        = Arch::requestOrCookie("cep");
    $notas      = Arch::requestOrCookie("notas");

    $msg = "";

    $leitor = new Leitor();
    $auditoria = new Auditoria();
    
    if (strlen($flag_lido) == 0) {   // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $leitor->selectId($id_centro , $id_leitor); 
        $reg = $rs->fetch();            // PDO
        $nome     = $reg["nome"];  
        $celular  = $reg["celular"];
        $email    = $reg["email"];
        $endereco = $reg["endereco"];
        $cep      = $reg["cep"];
        $notas    = $reg["notas"];
    }

    if ($action == 'grava') {
        $msg = $leitor->valida($id_centro, $id_leitor, $nome, $celular);
        if (strlen($msg) == 0) {
            $message = $leitor->update($id_centro, $id_leitor, $nome, $celular, $email, $endereco, $cep, $notas);
            if ($message->code < 0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Leitor alterado</p>";
                $auditoria->report("Altera $id_centro, $id_leitor, $nome, $celular, $email, $endereco, $cep, $notas");
            }

        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
include "./leitor.form.php";

    if (! strpos($msg, "alterado")) {  // omite botao altera
        echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
    }

    echo "<input type='hidden' name='id_leitor' value='$id_leitor'/>";
    echo "<button type='submit' class='butbase' formaction='leitor.lista.php'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
