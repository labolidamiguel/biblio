<?php
include "../common/arch.php";
include "../classes/class.app.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";
include "../common/funcoes.php";

Arch::initController("app");

    $id_app     = Arch::get("id_app");
    $codigo     = Arch::get("codigo");
    $titulo     = Arch::get("titulo");
    $imagem     = Arch::get("imagem");
    $perfil     = Arch::get("perfil");
    $url        = Arch::get("url");
    $ordem      = Arch::get("ordem");
    $action     = Arch::get("action");
    $msg = "";

    if ($action == 'confirma') {
        $App = new App();
        $audit = new Auditoria();
        $message=$App->delete($id_app);
        if ( $message->code<0 ) {
            $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
        }else{
            $msg="<p class=texgreen>* App excluido</p>";
            $audit->report("Exclui $id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem");
        }
    }
Arch::initView(TRUE);
    echo "<p class=appTitle2>App</p>";
    echo "<table class='tableraw'>";
    echo "<tr><td>Código</td><td>$codigo</td></tr>";
    echo "<tr><td>Título</td><td>$titulo</td></tr>";
    echo "</table>";
    echo "<b>$msg</b> <br><br>";
    if ($action == ""){
        echo "<p class='texgreen'>* Confirma a exclusão?</p> <br>";
        echo "<a href='?action=confirma&id_app=$id_app&codigo=$codigo&titulo=$titulo'><button class=butbase>Confirma</button></a>";
    }
    echo "<a href='app.lista.php'><button class='butbase'>Volta</button></a>";

Arch::endView(); 
?>
