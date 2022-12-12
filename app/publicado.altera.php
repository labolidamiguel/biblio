<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.publicado.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("publicado");
    $action         = Arch::get("action");
    $flag_lido      = Arch::requestOrCookie("flag_lido");
    $id_publicado   = Arch::requestOrCookie("id_publicado");
    $cod_cde        = Arch::requestOrCookie("cod_cde");
    $nome_titulo    = Arch::requestOrCookie("nome_titulo");
//Arch::deleteCookie("flag_lido"); // MARRETA
    $msg = "";
    $publicado = new Publicado();
    $audit = new Auditoria();
    
    if (strlen($flag_lido) == 0) {    // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs  = $publicado->selectId($id_publicado); 
        $reg = $rs->fetch();            // PDO
        $cod_cde        = $reg["cod_cde"];
        $nome_titulo    = $reg["nome_titulo"];
    }

    if ($action == 'grava') {
        $msg = $publicado->valida($id_publicado, $cod_cde, $nome_titulo);
        if (strlen($msg) == 0) {
            $message = $publicado->update($id_publicado, $cod_cde, $nome_titulo);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Publicado alterado</p>";
                $audit->report("Altera $id_publicado, $cod_cde, $nome_titulo");
            }
        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
?>
    <form method='get'>
        <p class=appTitle2>Publicado pela FEB</p>

        <p class=labelx>CDE</p>
        <input type='text' name='cod_cde' value='<?php echo $cod_cde?>' class='inputx'/>

        <p class=labelx>Título</p>
        <input type='text' name='nome_titulo' value='<?php echo $nome_titulo?>'  class='inputx'/>       

        <br><?php echo $msg ?><br>  <!-- mensagens -->
        <?php
        if (! strpos($msg, "alterado")) {  // omite botao altera
            echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
        ?>
        <input type='hidden' name='id_publicado' value='<?php echo $id_publicado?>'/>
        <button type='submit' class='butbase' formaction='publicado.lista.php'>Volta</button>
    </form>
<?php 
Arch::endView(); 
?>
