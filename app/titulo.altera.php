<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.titulo.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("titulo");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_centro  = Arch::session("id_centro");
    $id_titulo  = Arch::requestOrCookie("id_titulo");
    $sigla      = Arch::requestOrCookie("sigla");
    $nome_titulo = Arch::requestOrCookie("nome_titulo");
    $id_autor   = Arch::requestOrCookie("id_autor");
    $id_espirito = Arch::requestOrCookie("id_espirito");
    $id_cde     = Arch::requestOrCookie("id_cde");
    $nro_volume = Arch::requestOrCookie("nro_volume");
    $resenha    = Arch::requestOrCookie("resenha");
    $autor      = Arch::requestOrCookie("autor");
    $espirito   = Arch::requestOrCookie("espirito");
    $cod_cde    = Arch::requestOrCookie("cod_cde");
    $msg = "";

    $titulo = new Titulo();
    $audit = new Auditoria();

    if ($action == 'a') {               // dominio autor
    	header("Location: autor.dominio.php?callback=titulo.altera.php");
    }
    if ($action == 'e') {               // dominio espirito
    	header("Location: espirito.dominio.php?callback=titulo.altera.php");
    }    
    if ($action == 'c') {               // dominio cde
        header("Location: buscacde.lista.php?callback=titulo.altera.php");        
    }    
    
    if (strlen($flag_lido) == 0) {           // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs = $titulo->selectId($id_centro , $id_titulo); // from dB
        $reg = $rs->fetch();            // PDO
        $nome_titulo = $reg["nome_titulo"];  
        $sigla      = $reg["sigla"];  
        $autor      = $reg["autor"];
        $espirito   = $reg["espirito"];  
        $cod_cde    = $reg["cod_cde"];  
        $nro_volume = $reg["nro_volume"];
        $resenha    = $reg["resenha"];
        $id_autor   = $reg["id_autor"];
        $id_espirito = $reg["id_espirito"];
        $id_cde     = $reg["id_cde"];
    }

    if ($action == 'grava') {
        $msg = $titulo->valida();
        if (strlen($msg) == 0) {        // sem erros
            $message = $titulo->update($id_centro, $id_titulo, $nome_titulo, $sigla, $id_autor, $id_espirito, $id_cde, $nro_volume, $resenha);
            if ($message->code < 0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Título alterado</p>";
                $audit->report("Atualiza $id_centro, $id_titulo, $nome_titulo, $sigla, $id_autor, $id_espirito, $id_cde, $nro_volume, $resenha");
            }
            Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
include "./titulo.form.php";
        if (! strpos($msg, "alterado")) {  // omite botao cria/atualiza
            echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
        ?>
        <input type='hidden' name='id_titulo' value='<?php echo $id_titulo?>'/>
        <button type='submit' class='butbase' formaction='titulo.lista.php'>Volta</button>
    </form>
<?php Arch::endView(); 
?>
