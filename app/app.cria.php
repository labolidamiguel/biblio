<?php
include "../common/arch.php";
include "../classes/class.app.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";
include "../common/funcoes.php";

Arch::initController("app");

    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $id_app     = Arch::requestOrCookie("id_app");
    $codigo     = Arch::requestOrCookie("codigo");
    $titulo     = Arch::requestOrCookie("titulo");
    $imagem     = Arch::requestOrCookie("imagem");
    $perfil     = Arch::requestOrCookie("perfil");
    $url        = Arch::requestOrCookie("url");
    $ordem      = Arch::requestOrCookie("ordem");
    $msg = "";

    $app = new App();
        
    if ($action == 'grava') {
        $msg = $app->valida($id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem);

        if ( strlen($msg)==0) {
            $audit = new Auditoria();
            $message = $app->insert($codigo, $titulo, $imagem, $perfil, $url, $ordem);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* App criado</p>";
                $audit->report("Cria $codigo, $titulo, $imagem, $perfil, $url, $ordem");
            }
        }
    }
    
Arch::initView(TRUE);
include "./app.form.php";

    if (! strpos($msg, "criado")) {  // omite botao cria
        echo "<button type='submit' name='action' value='grava' class='butbase'>Cria</button>";
    }

//    echo "<input type='hidden' name='id_app' value='$id_app'/>";

    echo "<button type='submit' class='butbase' formaction='app.lista.php'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
