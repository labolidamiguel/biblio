<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.espirito.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("espirito");

    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
    $id_espirito    = Arch::requestOrCookie("id_espirito");
    $nome           = Arch::requestOrCookie("nome");
    $callback       = Arch::requestOrCookie("callback");

    $msg = "";
    $Espirito = new Espirito();
        
    if ($action == 'grava') {
        $msg = $Espirito->valida($id_centro, $id_espirito, $nome);

        if ( strlen($msg)==0) {
            $audit = new Auditoria();
            $message = $Espirito->insert($id_centro, $nome);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Espírito criado</p>";
                $audit->report("Cria $id_centro, $nome");
            }
        }
    }
    
Arch::initView(TRUE);
?>
    <p class=appTitle2>Espírito</p>

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
        <input type='hidden' name='id_espirito' value='<?php echo $id_espirito?>'/>

        <button type='submit' class='butbase' formaction='<?php echo $callback?>'>Volta</button>
    </form>

<?php Arch::endView(); 
?>