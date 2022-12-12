<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.usuario.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("usuario");
    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
    $id_usuario     = Arch::requestOrCookie("id_usuario");
    $nome           = Arch::requestOrCookie("nome");
    $senha          = Arch::requestOrCookie("senha");
    $perfis         = Arch::requestOrCookie("perfis");

    $perf           = Arch::post("perf"); // ret domain perfil
    $msg = "";

    $usuario = new Usuario();
    $audit = new Auditoria();
    
    if ( $action == 'p' ) {             // Selecao domain perfil
    	header("Location: perfil.dominio.php?callback=usuario.cria.php&perfis=$perfis");
    }
        
    if ($action == 'grava') {
        $msg = $usuario->valida($id_usuario, $nome, $perfis, $senha);

        if ( strlen($msg)==0) {
            $senhasha = hash('sha1', $senha );
            $message = $usuario->insert($id_centro, $nome, $perfis, $senhasha);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Usuário criado</p>";
                $audit->report("Cria $id_centro, $nome, $perfis" );
            }
            Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
?>
    <p class=appTitle2>Usuário</p>

    <form name="myform" method='get'>
        <p class=labelx>Nome</p>
        <input type='text' name='nome' class='inputx' value='<?php echo $nome?>'/>
        
        <p class=labelx>Perfis</p>
        <input type='text' name='perfis'  value='<?php echo $perfis?>' class='inputx' readonly/>
        <input type='submit' name='action' value='p' class='buthidelist' style='background-image: url(../layout/img/alte2.ico); background-repeat:no-repeat; background-size:26px 26px;'>

        <p class=labelx>Senha</p>
        <input type='text' name='senha' value='<?php echo $senha?>' class='inputx'/>
        <br>
        <b><?php echo $msg ?></b> <br>  <!-- MESSAGE -->

        <?php 
        if (! strpos($msg, "criado")) {  // omite botao cria
            echo "<button type='submit' class='butbase' name='action' value='grava'>Cria</button>";
        }
        ?>
        <input type='hidden' name='id_usuario' value='<?php echo $id_usuario?>'/>

        <button type='submit' class='butbase' formaction='usuario.lista.php'>Volta</button>
    </form>

<?php Arch::endView(); 
?>
