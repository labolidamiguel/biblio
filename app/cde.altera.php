<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.cde.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("cde");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_cde     = Arch::requestOrCookie("id_cde");
    $cod_cde    = Arch::requestOrCookie("cod_cde");
    $classe     = Arch::requestOrCookie("classe");
    $msg = "";

Arch::deleteCookie("flag_lido"); // MARRETA

    $cde = new Cde();
    $auditoria = new Auditoria();
    
    if (strlen($flag_lido) == 0) {      // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $cde->selectId($id_centro , $id_cde); 
        $reg = $rs->fetch();            // PDO
        $cod_cde  = $reg["cod_cde"];  
        $classe   = $reg["classe"];
    }

    if ($action == 'grava') {
        $msg = $cde->valida($id_centro, $id_cde, $cod_cde, $classe);
        if (strlen($msg) == 0) {
            $message = $cde->update($id_centro, $id_cde, $cod_cde, $classe);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Cde alterado</p>";
                $auditoria->report("Altera $id_centro, $id_cde, $cod_cde, $classe");
            }

        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
?>
    <p class=appTitle2>Classificação Decimal Espírita</p>

    <form method='get'>
        <p class=labelx>CDE</p>
        <input type='text' name='cod_cde' value='<?php echo $cod_cde?>' class='inputx'/>
        
        <p class=labelx>Classe</p>
        <input type='text' name='classe' value='<?php echo $classe?>' class='inputx'/>

        <b><?php echo $msg ?></b> <br>  <!-- mensagem -->

        <?php 
        if (! strpos($msg, "alterado")) {  // omite botao altera
            echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
        ?>
        <input type='hidden' name='id_cde' value='<?php echo $id_cde?>'/>
        <button type='submit' class='butbase' formaction='cde.lista.php'>Volta</button>
    </form>
<?php 
Arch::endView(); 
?>
