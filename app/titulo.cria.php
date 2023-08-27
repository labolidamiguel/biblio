<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.titulo.php";
include "../classes/class.auditoria.php";

Arch::initController("titulo");
    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
    $id_titulo  = Arch::requestOrCookie("id_titulo");
    $sigla      = Arch::requestOrCookie("sigla");
    $nome_titulo = Arch::requestOrCookie("nome_titulo");
    $id_autor   = Arch::requestOrCookie("id_autor");
    $id_espirito = Arch::requestOrCookie("id_espirito");
    $id_cde     = Arch::requestOrCookie("id_cde");
    $nro_volume = Arch::requestOrCookie("nro_volume");
    $resenha    = Arch::requestOrCookie("resenha");

    $nome_autor = Arch::requestOrCookie("nome_autor");
    $nome_espirito = Arch::requestOrCookie("nome_espirito");
    $cod_cde    = Arch::requestOrCookie("cod_cde");

    $msg = "";

    $titulo = new Titulo();
    $audit = new Auditoria();

    if ($action == 'a') {               // dominio autor
    	header("Location: autor.dominio.php?callback=titulo.cria.php");
    }
    if ($action == 'e') {               // dominio espirito
    	header("Location: espirito.dominio.php?callback=titulo.cria.php");
    }    
    if ($action == 'c') {               // dominio cde
    	header("Location: buscacde.lista.php?callback=titulo.cria.php");        
    }    

    if ($action == 'grava') {
        $msg = $titulo->valida();
        if (strlen($msg) == 0) {        // sem erros
            $err = $titulo->insert($id_centro, $nome_titulo, $sigla, $id_autor, $id_espirito, $id_cde, $nro_volume, $resenha);
            if (strlen($err) > 0) {
                $msg="<p class=texred>Problemas: $err ";
            }else{
                $msg="<p class=texgreen>* Título criado</p>";
                $audit->report("Cria $id_centro, $nome_titulo, $sigla, $id_autor, $id_espirito, $id_cde, $nro_volume, $resenha");
            }
            Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
include "./titulo.form.php";
        
        if (! strpos($msg, "criado")) {  // omite botao cria/atualiza
            echo "<button type='submit' class='butbase' name='action' value='grava'>Cria</button>";
        }
        ?>
        <input type='hidden' name='id_titulo' value='<?php echo $id_titulo?>'/>
        <button type='submit' class='butbase' formaction='titulo.lista.php'>Volta</button>
    </form>
<?php Arch::endView(); 
?>
