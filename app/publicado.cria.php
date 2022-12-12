<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.publicado.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("publicado");
    $action         = Arch::get("action");
    $id_publicado   = Arch::requestOrCookie("id_publicado");
    $cod_cde        = Arch::requestOrCookie("cod_cde");
    $nome_titulo    = Arch::requestOrCookie("nome_titulo");

    $msg = "";

    $publicado = new Publicado();
    $audit = new Auditoria();
        
    if ($action == 'grava') {
        $msg = $publicado->valida($id_publicado, $cod_cde, $nome_titulo);
        if ( strlen($msg)==0) {
            $message = $publicado->insert($cod_cde, $nome_titulo);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Publicado criado</p>";
                $audit->report("Cria $cde, $titulo");
            }
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
        if (! strpos($msg, "criado")) {  // omite botao cria
            echo "<button type='submit' name='action' value='grava' class='butbase'>Cria</button>";
        }
        ?>
        <input type='hidden' name='id_publicado' value='<?php echo $id_publicado?>'/>

        <button type='submit' class='butbase' formaction='publicado.lista.php'>Volta</button>
    </form>

<?php Arch::endView(); 
?>
