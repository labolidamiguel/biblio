<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.autor.php";
include "../classes/class.auditoria.php";

Arch::initController("autor");
    $id_centro  = Arch::session("id_centro");
    $id_autor   = Arch::get("id_autor");
    $nome       = Arch::get("nome");
    $iniciais   = Arch::get("iniciais");
    $action     = Arch::get("action");
    $msg = "";

    $autor = new Autor();
    $auditoria = new Auditoria();
    
    $msg = $autor->integridade($id_centro, $id_autor);
    if (strlen($msg) == 0) {
        if ($action == 'Confirma') {
            $message = $autor->delete($id_centro, $id_autor);
            if ($message->code < 0) {
                $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
            }else{
                $msg="<p class=texgreen>* Autor excluido</p>";
                $auditoria->report("Exclui $id_centro, $id_autor, $nome, $iniciais");
            }
        }
    }

Arch::initView(TRUE);
    echo "<p class=appTitle2>Autor</p>";
    echo "<table class='tableraw'>";
    echo "<tr><td>Nome</td><td>" . $nome . "</td></tr>";
    echo "<tr><td>Iniciais</td><td>" . $iniciais . "</td></tr>";
    echo "</table>";
    echo $msg;
    echo "<br>";
    if (strlen($msg) == 0) {
        echo "<p class='texgreen'>* Confirma a exclusão?</p><br>";
        echo "<a href='?action=Confirma&id_autor=" . $id_autor . "&nome=" . $nome . "&iniciais=" . $iniciais . "'><button class='butbase'>Confirma</button></a>";
    }
    echo "<a href='autor.lista.php'><button class='butbase'>Volta</button></a>";

Arch::endView(); 
?>
