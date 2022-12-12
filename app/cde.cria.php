<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.cde.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("cde");
    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
    $id_cde         = Arch::requestOrCookie("id_cde");
    $cod_cde        = Arch::requestOrCookie("cod_cde");
    $classe         = Arch::requestOrCookie("classe");
    $callback       = Arch::requestOrCookie("callback");
    $msg = "";

    $cde = new Cde();
    $audit = new Auditoria();

    if ($action == 'grava') {
        $msg = $cde->valida($id_centro, $id_cde, $cod_cde, $classe);
        if ( strlen($msg)==0) {
            $message = $cde->insert($id_centro, $cod_cde, $classe);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* CDE criado</p>";
                $audit->report("Cria $id_centro, $cod_cde, $classe");
            }
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
        <br>
        <b><?php echo $msg ?></b> <br>  <!-- mensagens -->

        <?php 
        if (! strpos($msg, "criado")) {  // omite botao cria
            echo "<button type='submit' name='action' value='grava' class='butbase'>Cria</button>";
        }
        ?>
        <input type='hidden' name='id_cde' value='<?php echo $id_cde?>'/>

        <button type='submit' class='butbase' formaction='<?php echo $callback?>'>Volta</button>
    </form>

<?php Arch::endView(); 
?>