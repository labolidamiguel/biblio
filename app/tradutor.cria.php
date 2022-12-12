<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.tradutor.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("tradutor");

    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
    $id_tradutor    = Arch::requestOrCookie("id_tradutor");
    $nome           = Arch::requestOrCookie("nome");
    $callback       = Arch::requestOrCookie("callback");

    $msg = "";
    $Tradutor = new Tradutor();
        
    if ($action == 'grava') {
        $msg = $Tradutor->valida($id_centro, $id_tradutor, $nome);

        if ( strlen($msg)==0) {
            $audit = new Auditoria();
            $message = $Tradutor->insert($id_centro, $nome);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Tradutor criado</p>";
                $audit->report("Cria $id_centro, $nome" );
            }
        }
    }
    
Arch::initView(TRUE);
?>
    <p class=appTitle2>Tradutor</p>

    <form method='get'>
        <p class=labelx>Nome</p>
        <input type='text' name='nome' value='<?php echo $nome?>' class='inputx'/>

        <br>
        <b><?php echo $msg ?></b> <br>  <!-- mensagens -->

        <?php 
        if (! strpos($msg, "criado")) {  // omite botao cria
            echo "<button type='submit' name='action' value='grava' class='butbase'>Cria</button>";
        }
        ?>
        <input type='hidden' name='id_tradutor' value='<?php echo $id_tradutor?>'/>

        <button type='submit' class='butbase' formaction='<?php echo $callback?>'>Volta</button>
    </form>

<?php Arch::endView(); 
?>