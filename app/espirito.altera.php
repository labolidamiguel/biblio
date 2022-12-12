<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.espirito.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("espirito");

    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_espirito = Arch::requestOrCookie("id_espirito");
    $nome       = Arch::requestOrCookie("nome");

    $msg = "";
    $Espirito = new Espirito();
    
    if (strlen($flag_lido) == 0) {           // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $Espirito->selectId($id_centro , $id_espirito); 
//        $reg = $rs->fetchArray();
        $reg = $rs->fetch();            // PDO
        $nome       = $reg["nome"];  
    }

    if ($action == 'grava') {
        $msg = $Espirito->valida($id_centro, $id_espirito, $nome);
        if (strlen($msg) == 0) {
            $audit = new Auditoria();
            $message = $Espirito->update($id_centro, $id_espirito, $nome);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Espirito alterado</p>";
                $audit->report("Altera $id_centro, $id_espirito, $nome");
            }

        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
?>
    <p class=appTitle2>Espírito</p>

    <form method='get'>
        <p class=labelx>Nome</p>
        <input type='text' name='nome' value='<?php echo $nome?>' class='inputx'/>
        <br>
        
        <b><?php echo $msg ?></b> <br>  <!-- mensagem -->

        <?php 
        if (! strpos($msg, "alterado")) {  // omite botao altera
            echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
        ?>
        <input type='hidden' name='id_espirito' value='<?php echo $id_espirito?>'/>
        <button type='submit' class='butbase' formaction='espirito.lista.php'>Volta</button>
    </form>
<?php 
Arch::endView(); 
?>