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
    $flag_lido      = Arch::requestOrCookie("flag_lido");
    $id_tradutor    = Arch::requestOrCookie("id_tradutor");
    $nome           = Arch::requestOrCookie("nome");

    $msg = "";
    $Tradutor = new Tradutor();
    
    if (strlen($flag_lido) == 0) {           // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $Tradutor->selectId($id_centro , $id_tradutor); 
//        $reg = $rs->fetchArray();
        $reg = $rs->fetch();            // PDO
        $nome       = $reg["nome"];  
    }

    if ($action == 'grava') {
        $msg = $Tradutor->valida($id_centro, $id_tradutor, $nome);
        if (strlen($msg) == 0) {
            $audit = new Auditoria();
            $message = $Tradutor->update($id_centro, $id_tradutor, $nome);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Tradutor alterado</p>";
                $audit->report("Altera $id_centro, $id_tradutor, $nome");
            }

        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
?>
    <p class=appTitle2>Tradutor</p>

    <form method='get'>
        <p class=labelx>Nome</p>
        <input type='text' name='nome' value='<?php echo $nome?>' class='inputx'/>

        <br><?php echo $msg ?><br>  <!-- mensagem -->

        <?php 
        if (! strpos($msg, "alterado")) {  // omite botao altera
            echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
        ?>
        <input type='hidden' name='id_tradutor' value='<?php echo $id_tradutor?>'/>
        <button type='submit' class='butbase' formaction='tradutor.lista.php'>Volta</button>
    </form>
<?php 
Arch::endView(); 
?>