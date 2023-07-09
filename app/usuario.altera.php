<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.usuario.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("usuario");

    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_usuario = Arch::requestOrCookie("id_usuario");
    $nome       = Arch::requestOrCookie("nome");
    $senha      = Arch::get("senha");
    $perfis     = Arch::requestOrCookie("perfis");
    $telefone   = Arch::get("telefone");
    $email      = Arch::get("email");
    $perf       = Arch::post("perf");   // Volta da selecao domain Perfil
    $msg = "";
    $Usuario = new Usuario();
    
    if ( $action == 'p' ) {             // Selecao domain perfil
    	header("Location: perfil.dominio.php?callback=usuario.altera.php&perfis=$perfis");
    }
    
    if (strlen($flag_lido) == 0) {           // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $Usuario->selectId($id_centro , $id_usuario); 
//        $reg = $rs->fetchArray();
        $reg = $rs->fetch();            // PDO
        $nome       = $reg["nome"];  
        $perfis     = $reg["perfis"];
        $telefone   = $reg["telefone"];  
        $email      = $reg["email"];
    }

    if ($action == 'grava') {
        $msg = $Usuario->valida2($id_usuario, $nome, $perfis, $telefone, $email);
        if (strlen($msg) == 0) {
            $audit = new Auditoria();
            $message = $Usuario->update2($id_centro, $id_usuario, $nome, $perfis, $telefone, $email);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Usuário alterado</p>";
                $audit->report("Altera $id_centro, $id_usuario, $nome, $perfis");
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
        <input type='text' name='perfis' class='inputx' value='<?php echo $perfis?>' readonly/>

        <input type='submit' name='action' value='p' class='buthidelist' style='background-image: url(../layout/img/alte2.ico); background-repeat:no-repeat; background-size:26px 26px;'>

        <p class=labelx>Telefone</p>
        <input type='text' name='telefone' class='inputx' value='<?php echo $telefone?>'/>

        <p class=labelx>Email</p>
        <input type='text' name='email' class='inputx' value='<?php echo $email?>'/>

        <br>
        
        <b><?php echo $msg ?></b> <br>  <!-- MESSAGE -->

        <?php 
        if (! strpos($msg, "alterado")) {  // omite botao altera
            echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
        ?>
        <input type='hidden' name='id_usuario' value='<?php echo $id_usuario?>'/>
        <button type='submit' class='butbase' formaction='usuario.lista.php'>Volta</button>
    </form>
<?php Arch::endView(); 
?>