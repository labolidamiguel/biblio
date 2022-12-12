<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.espirito.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("espirito");

    $id_centro      = Arch::session("id_centro");
    $id_espirito    = Arch::get("id_espirito");
    $nome           = Arch::get("nome");

    $action         = Arch::get("action");
    $msg = "";
    
    $Espirito = new Espirito();

    $msg = $Espirito->integridade($id_centro, $id_espirito);
    if (strlen($msg) == 0) {
        if ($action == 'Confirma') {
            $audit = new Auditoria();
            $message = $Espirito->delete($id_centro, $id_espirito);
            if ( $message->code<0 ) {
                $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
            }else{
                $msg="<p class=texgreen>* Espirito excluido</p>";
                $audit->report("Exclui $id_centro, $id_espirito, $nome");
            }
        }
    }

Arch::initView(TRUE);
?>
    <p class=appTitle2>Espírito</p>
    <table class='tableraw'>
        <tr><td>Nome</td><td><?php echo $nome; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if (strlen($msg) == 0) { ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=Confirma&id_espirito=<?php echo $id_espirito;?>&nome=<?php echo $nome;?>'><button class="butbase">Confirma</button></a>
    <?php } ?>
    <a href='espirito.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>