<?php
include "../common/arch.php";
include "../classes/class.app.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";
include "../common/funcoes.php";

Arch::initController("app");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_app     = Arch::requestOrCookie("id_app");
    $codigo     = Arch::requestOrCookie("codigo");
    $titulo     = Arch::requestOrCookie("titulo");
    $imagem     = Arch::requestOrCookie("imagem");
    $perfil     = Arch::requestOrCookie("perfil");
    $url        = Arch::requestOrCookie("url");
    $ordem      = Arch::requestOrCookie("ordem");
    $original = "";
    $msg = "";
    
    $App = new App();
    
    if (strlen($flag_lido) == 0) {           // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs  = $App->selectId($id_app); 
        $reg = $rs->fetch();            // PDO
        $codigo     = $reg["codigo"];
        $titulo     = $reg["titulo"];
        $imagem     = $reg["imagem"];
        $perfil     = $reg["perfil"];
        $url        = $reg["url"];
        $ordem      = $reg["ordem"];
    }

    if ($action == 'grava') {
        $msg = $App->valida($id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem);
        if (strlen($msg) == 0) {
            $audit = new Auditoria();
            $message = $App->update($id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* App alterado</p>";
                $audit->report("Altera $id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem");
            }
        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
include "./app.form.php";

    if (! strpos($msg, "alterado")) {  // omite botao altera
        echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
    }

//    echo "<input type='hidden' name='id_app' value='$id_app'/>";
    echo "<button type='submit' class='butbase' formaction='app.lista.php'>Volta</button>";
    echo "</form>";

Arch::endView(); 
?>
