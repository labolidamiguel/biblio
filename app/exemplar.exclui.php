<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";
include "../classes/class.auditoria.php";

Arch::initController("titulo");         // exemplar App nao existe
    $id_centro      = Arch::session("id_centro");
    $id_titulo      = Arch::get("id_titulo");
    $id_exemplar    = Arch::get("id_exemplar");
    $nome_titulo    = Arch::get("nome_titulo");
    $nome_tradutor  = Arch::get("nome_tradutor");
    $nome_editora   = Arch::get("nome_editora");
    $action         = Arch::get("action");
    $msg = "";

    $exemplar = new Exemplar();
    $audit = new Auditoria();

    $msg = $exemplar->integridade($id_centro, $id_exemplar);
    if (strlen($msg) == 0) {
        if ($action == 'confirma') {
            $err = $exemplar->delete($id_centro, $id_exemplar);
            if (strlen($err) > 0) {
                $msg="<p class=texred>
                * Erro na exclusão: $err</p>";
            }else{
                $msg="<p class=texgreen>
                * Exemplar excluido</p>";
                $audit->report("Exclui $id_centro, $id_exemplar, $id_titulo, $titulo, $tradutor, $editora");
            }
        }
    }

Arch::initView(TRUE);
?>
    <p class=appTitle2>Exemplar</p>
    <p class=appTitle4><?php echo $titulo?></p>
    <table class='tableraw'>
        <tr><td>Tradutor</td><td><?php echo $nome_tradutor; ?></td></tr>
        <tr><td>Editora</td><td><?php echo $nome_editora; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if (strlen($msg) == 0) { ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=confirma&id_titulo=<?php echo $id_titulo;?>&id_exemplar=<?php echo $id_exemplar;?>&nome_titulo=<?php echo $nome_titulo;?>&nome_tradutor=<?php echo $nome_tradutor;?>'><button class="butbase">Confirma</button></a>
    <?php } ?>
    <a href='exemplar.lista.php?id_titulo=<?php echo $id_titulo;?>'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>
