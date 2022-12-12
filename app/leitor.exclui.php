<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.leitor.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("leitor");
    $id_centro  = Arch::session("id_centro");
    $id_leitor  = Arch::get("id_leitor");
    $nome       = Arch::get("nome");
    $celular    = Arch::get("celular");
    $action     = Arch::get("action");
    $msg = "";

    $leitor = new Leitor();
    $audit = new Auditoria();

    $msg = $leitor->integridade($id_centro, $id_leitor);
    if (strlen($msg) == 0) {
        if ($action == 'Confirma') {
            $message=$leitor->delete($id_centro, $id_leitor);
            if ( $message->code<0 ) {
                $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
            }else{
                $msg="<p class=texgreen>* Leitor excluido</p>";
                $audit->report("Exclui $id_centro, $id_leitor, $nome, $celular");
            }
        }
    }

Arch::initView(TRUE);
?>
    <p class=appTitle2>Leitor</p>
    <table class='tableraw'>
        <tr><td>Nome</td><td><?php echo $nome; ?></td></tr>
        <tr><td>Celular</td><td><?php echo $celular; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if (strlen($msg) == 0) { ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=Confirma&id_leitor=<?php echo $id_leitor;?>&nome=<?php echo $nome;?>&celular=<?php echo $celular;?>'><button class="butbase">Confirma</button></a>
    <?php } ?>
    <a href='leitor.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>