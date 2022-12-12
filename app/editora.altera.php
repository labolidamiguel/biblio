<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.editora.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("editora");

    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_editora = Arch::requestOrCookie("id_editora");
    $nome       = Arch::requestOrCookie("nome");

    $msg = "";
    $Editora = new Editora();
    
    if (strlen($flag_lido) == 0) {           // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $Editora->selectId($id_centro , $id_editora); 
//        $reg = $rs->fetchArray();
        $reg = $rs->fetch();            // PDO
        $nome = $reg["nome"];  
    }

    if ($action == 'grava') {
        $msg = $Editora->valida($id_centro, $id_editora, $nome);
        if (strlen($msg) == 0) {
            $audit = new Auditoria();
            $message = $Editora->update($id_centro, $id_editora, $nome);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Editora alterado</p>";
                $audit->report("Altera $id_centro, $id_editora, $nome");
            }

        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
?>
    <p class=appTitle2>Editora</p>

    <form method='get'>
        <p class=labelx>Nome</p>
        <input type='text' name='nome' value='<?php echo $nome?>' class='inputx'/>
        
        <b><?php echo $msg ?></b> <br>  <!-- mensagem -->

        <?php 
        if (! strpos($msg, "alterado")) {  // omite botao altera
            echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
        ?>
        <input type='hidden' name='id_editora' value='<?php echo $id_editora?>'/>
        <button type='submit' class='butbase' formaction='editora.lista.php'>Volta</button>
    </form>
<?php 
Arch::endView(); 
?>