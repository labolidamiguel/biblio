<?php
include "../common/arch.php";
include "../classes/class.app.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";
include "../common/funcoes.php";

Arch::initController("app");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_app     = Arch::requestOrCookie("id_app");
    $codigo     = Arch::requestOrCookie("codigo");
    $titulo     = Arch::requestOrCookie("titulo");
    $imagem     = Arch::requestOrCookie("imagem");
    $perfil     = Arch::requestOrCookie("perfil");
    $url        = Arch::requestOrCookie("url");
    $ordem      = Arch::requestOrCookie("ordem");
    $original = "";
    $msg = "";
    
    $App = new App();
    
    if (strlen($flag_lido) == 0) {           // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs  = $App->selectId($id_app); 
//        $reg = $rs->fetchArray();
        $reg = $rs->fetch();            // PDO
        $codigo     = $reg["codigo"];
        $titulo     = $reg["titulo"];
        $imagem     = $reg["imagem"];
        $perfil     = $reg["perfil"];
        $url        = $reg["url"];
        $ordem      = $reg["ordem"];
    }

    if ($action == 'grava') {
        $msg = $App->valida($id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem);
        if (strlen($msg) == 0) {
            $audit = new Auditoria();
            $message = $App->update($id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* App alterado</p>";
                $audit->report("Altera $id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem");
            }
        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
?>
    <form method='get'>
        <p class=appTitle2>App</p>
        <p class=labelx>Código</p>
        <input type='text' name='codigo' value='<?php echo $codigo?>' class='inputx'/>

        <p class=labelx>Título</p>
        <input type='text' name='titulo' value='<?php echo $titulo?>' class='inputx'/>

        <p class=labelx>Imagem</p>
        <input type='text' name='imagem' value='<?php echo $imagem?>' class='inputx'/>

        <p class=labelx>Perfil</p>
        <input type='text' name='perfil' value='<?php echo $perfil?>' class='inputx'/>

        <p class=labelx>URL</p>
        <input type='text' name='url' value='<?php echo $url?>' class='inputx'/>

        <p class=labelx>Ordem</p>
        <input type='text' name='ordem' value='<?php echo $ordem?>' class='inputx'/>
        <b><?php echo $msg ?></b> <br>  <!-- mensagem -->
        <?php 
        if (! strpos($msg, "alterado")) {  // omite botao altera
            echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
        ?>
        <input type='hidden' name='id_app' value='<?php echo $id_app?>'/>
        <button type='submit' class='butbase' formaction='app.lista.php'>Volta</button>
    </form>
<?php 
Arch::endView(); 
?>