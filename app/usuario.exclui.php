<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.usuario.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("usuario");
    $id_centro  = Arch::session("id_centro");
    $id_usuario = Arch::get("id_usuario");
    $nome       = Arch::get("nome");
    $perfis     = Arch::get("perfis");
    $action     = Arch::get("action");
    $telefone   = Arch::get("telefone");
    $email      = Arch::get("email");
    $msg = "";

    if ($action == 'Confirma') {
        $Usuario = new Usuario();
        $audit = new Auditoria();
        $message=$Usuario->delete($id_centro, $id_usuario);
        if ( $message->code<0 ) {
            $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
        }else{
            $msg="<p class=texgreen>* Usuário excluido</p>";
            $audit->report("Exclui $id_centro, $id_usuario, $nome, $perfis" );
        }
    }
Arch::initView(TRUE);
?>
    <p class=appTitle2>Usu&aacute;rio</p>
    <table class='tableraw'>
        <tr><td>Nome</td><td><?php echo $nome; ?></td></tr>
        <tr><td>Perfis</td><td><?php echo $perfis; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if ($action==""){ ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=Confirma&id_usuario=<?php echo $id_usuario;?>&nome=<?php echo $nome;?>&perfis=<?php echo $perfis;?>'><button class="butbase">Confirma</button></a>
    <?php } ?>
    <a href='usuario.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>