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
?>
    <p class=appTitle2>App</p>
    <table class='tableraw'>
        <tr><td>Código</td><td><?php echo $codigo; ?></td></tr>
        <tr><td>Título</td><td><?php echo $titulo; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if ($action == ""){ ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=confirma&id_app=<?php echo $id_app?>&codigo=<?php echo $codigo?>&titulo=<?php echo $titulo?>'><button class=butbase>Confirma</button></a>
    <?php } ?>
    <a href='app.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>