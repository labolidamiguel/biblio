<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.publicado.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("publicado");
    $id_publicado = Arch::get("id_publicado");
    $cod_cde      = Arch::get("cod_cde");
    $nome_titulo  = Arch::get("nome_titulo");
    $action       = Arch::get("action");
    $msg = "";

    $publicado = new Publicado();
    $audit = new Auditoria();

    if ($action == 'confirma') {
        $message=$publicado->delete($id_publicado);
        if ( $message->code<0 ) {
            $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
        }else{
            $msg="<p class=texgreen>* Publicado excluido</p>";
            $audit->report("Exclui $id_publicado, $cod_cde, $nome_titulo");
        }
    }
Arch::initView(TRUE);
?>
    <p class=appTitle2>Publicado pela FEB</p>
    <table class='tableraw'>
        <tr><td>CDE</td><td><?php echo $cod_cde; ?></td></tr>
        <tr><td>Título</td><td><?php echo $nome_titulo; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if ($action == ""){ ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=confirma&id_publicado=<?php echo $id_publicado?>&cod_cde=<?php echo $cod_cde?>&nome_titulo=<?php echo $nome_titulo?>'><button class=butbase>Confirma</button></a>
    <?php } ?>
    <a href='publicado.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>