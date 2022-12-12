<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.editora.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("editora");

    $id_centro  = Arch::session("id_centro");
    $id_editora   = Arch::get("id_editora");
    $nome       = Arch::get("nome");

    $action     = Arch::get("action");
    $msg = "";

    $Editora = new Editora();

    $msg = $Editora->integridade($id_centro, $id_editora);
    if (strlen($msg) == 0) {
        if ($action == 'Confirma') {
            $audit = new Auditoria();
            $message = $Editora->delete($id_centro, $id_editora);
            if ( $message->code<0 ) {
                $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
            }else{
                $msg="<p class=texgreen>* Editora excluido</p>";
                $audit->report("Exclui editora $id_centro, $id_editora, $nome");
            }
        }
    }

Arch::initView(TRUE);
?>
    <p class=appTitle2>Editora</p>
    <table class='tableraw'>
        <tr><td>Nome</td><td><?php echo $nome; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if (strlen($msg) == 0) { ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=Confirma&id_editora=<?php echo $id_editora;?>&nome=<?php echo $nome;?>'><button class="butbase">Confirma</button></a>
    <?php } ?>
    <a href='editora.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>