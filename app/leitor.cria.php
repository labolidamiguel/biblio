<?php
include "../common/arch.php";
include "../classes/class.app.php";
include "../classes/class.leitor.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";
include "../common/funcoes.php";

Arch::initController("leitor");
    $id_centro = Arch::session("id_centro");
    $action    = Arch::get("action");
    $id_leitor = Arch::requestOrCookie("id_leitor");
    $nome      = Arch::requestOrCookie("nome");
    $celular   = Arch::requestOrCookie("celular");
    $email     = Arch::requestOrCookie("email");
    $endereco  = Arch::requestOrCookie("endereco");
    $cep       = Arch::requestOrCookie("cep");
    $notas     = Arch::requestOrCookie("notas");
    $callback  = Arch::requestOrCookie("callback");

    $msg = "";

    $leitor = new Leitor();
    $audit = new Auditoria();
        
    if ($action == 'grava') {
        $msg = $leitor->valida($id_centro, $id_leitor, $nome, $celular);
        if ( strlen($msg)==0) {
            $message = $leitor->insert($id_centro, $nome, $celular, $email, $endereco, $cep, $notas);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Leitor criado</p>";
                $audit->report("Cria $id_centro, $nome, $celular, $email, $endereco, $cep, $notas");
//                $id_centro = $nome = $celular = $email = $endereco = $cep = $notas = "";
//                Arch::deleteAllCookies();
            }
        }
    }
    
Arch::initView(TRUE);
include "./leitor.form.php";

    if (! strpos($msg, "criado")) {  // omite botao cria
        echo "<button type='submit' name='action' ";
        echo "value='grava' class='butbase'>Cria</button>";
    }
    echo "<input type='hidden' name='id_leitor' ";
    echo "value='$id_leitor'/>";

    echo "<button type='submit' class='butbase' ";
    echo "formaction='$callback'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
