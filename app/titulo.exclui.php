<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.titulo.php";
include "../classes/class.auditoria.php";

Arch::initController("titulo");
    $id_centro  = Arch::session("id_centro");
    $id_titulo  = Arch::get("id_titulo");
    $nome_titulo = Arch::get("nome_titulo");
    $autor      = Arch::get("autor");
    $action     = Arch::get("action");
    $msg = "";

    $titulo = new Titulo();
    $audit = new Auditoria();

    $msg = $titulo->integridade($id_centro, $id_titulo);
    if (strlen($msg) == 0) {
        if ($action == 'confirma') {
            $err = $titulo->delete($id_centro, $id_titulo);
            if (strlen($err) > 0) {
                $msg="<p class=texred>* Erro na exclusão: $err</p>";
            }else{
                $msg="<p class=texgreen>* Título excluido</p>";
                $audit->report("Exclui $id_centro, $id_titulo, $nome_titulo, $autor");
            }
        }
    }
    
Arch::initView(TRUE);
    echo "<p class=appTitle2>Título</p>";
    echo "<table class='tableraw'>";
    echo "<tr><td>Título</td><td>$nome_titulo></td></tr>
        <tr><td>Autor</td><td>$autor</td></tr>";
    echo "</table>";
    echo "<b>$msg</b><br><br>";
    if (strlen($msg) == 0) {
        echo "<p class='texgreen'>* Confirma a exclusão?</p><br>";
        echo "<a href='?action=confirma&id_titulo=$id_titulo&nome_titulo='$nome_titulo'&autor='$autor'><button class='butbase'>Confirma</button></a>";
    }
    echo "<a href='titulo.lista.php'><button class='butbase'>Volta</button></a>";

Arch::endView(); 
?>
