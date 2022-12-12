<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.tradutor.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("tradutor");

    $id_centro    = Arch::session("id_centro");
    $id_tradutor  = Arch::get("id_tradutor");
    $nome         = Arch::get("nome");

    $action       = Arch::get("action");
    $msg = "";

    $Tradutor = new Tradutor();

    $msg = $Tradutor->integridade($id_centro, $id_tradutor);
    if (strlen($msg) == 0) {
        if ($action == 'Confirma') {
            $message = $Tradutor->delete($id_centro, $id_tradutor);
            if ($message->code < 0) {
                $msg = "<p class=texred>* Erro na exclusão</p>" . $message->description;
            }else{
                $msg = "<p class=texgreen>* Tradutor excluido</p>";
                $audit = new Auditoria();
                $audit->report("Exclui $id_centro, $id_tradutor, $nome");
            }
        }
    }

Arch::initView(TRUE);
?>
    <p class=appTitle2>Tradutor</p>
    <table class='tableraw'>
        <tr><td>Nome</td><td><?php echo $nome; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if (strlen($msg) == 0) { ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=Confirma&id_tradutor=<?php echo $id_tradutor;?>&nome=<?php echo $nome;?>'><button class="butbase">Confirma</button></a>
    <?php } ?>
    <a href='tradutor.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>