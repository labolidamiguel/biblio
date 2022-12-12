<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.titulo.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

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
            $message=$titulo->delete($id_centro, $id_titulo);
            if ($message->code < 0) {
                $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
            }else{
                $msg="<p class=texgreen>* Título excluido</p>";
                $audit->report("Exclui $id_centro, $id_titulo, $titulo, $autor");
            }
        }
    }
    
Arch::initView(TRUE);
?>
    <p class=appTitle2>Título</p>
    <table class='tableraw'>
        <tr><td>Título</td><td><?php echo $titulo; ?></td></tr>
        <tr><td>Autor</td><td><?php echo $autor; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if (strlen($msg) == 0) { ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=confirma&id_titulo=<?php echo $id_titulo;?>&titulo=<?php echo $titulo;?>&autor=<?php echo $autor;?>'><button class="butbase">Confirma</button></a>
    <?php } ?>
    <a href='titulo.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>
