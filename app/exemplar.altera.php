<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("titulo");         // exemplar App nao existe
    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
//    $flag_lido      = Arch::requestOrCookie("flag_lido");
Arch::deleteCookie("flag_lido");    // MARRETA ANALISAR
    $id_exemplar    = Arch::requestOrCookie("id_exemplar");
    $id_titulo      = Arch::requestOrCookie("id_titulo");
    $id_tradutor    = Arch::requestOrCookie("id_tradutor");
    $id_editora     = Arch::requestOrCookie("id_editora");
    $nro_edicao     = Arch::requestOrCookie("nro_edicao");
    $ano_publicacao = Arch::requestOrCookie("ano_publicacao");
    $data_entrada   = Arch::requestOrCookie("data_entrada");
    $nro_exemplar   = Arch::requestOrCookie("nro_exemplar");
    $nome_titulo    = Arch::requestOrCookie("nome_titulo");
    $tradutor       = Arch::requestOrCookie("tradutor");
    $editora        = Arch::requestOrCookie("editora");

    $msg = "";

    $exemplar = new Exemplar();
    $auditoria = new Auditoria();

    if ($action == 't') {               // dominio tradutor
    	header("Location: tradutor.dominio.php?callback=exemplar.altera.php");
    }    
    if ($action == 'e') {               // dominio editora
    	header("Location: editora.dominio.php?callback=exemplar.altera.php");
    }   
    if (strlen($flag_lido) == 0) {      // 1a vez Select from dB
        setcookie("flag_lido", "ja lido"); 
        $rs = $exemplar->selectId($id_centro , $id_exemplar); // from dB
        $reg = $rs->fetch();            // PDO
        $id_titulo      = $reg["id_titulo"];
        $id_tradutor    = $reg["id_tradutor"];
        $id_editora     = $reg["id_editora"];
        $nro_edicao     = $reg["nro_edicao"];  
        $ano_publicacao = $reg["ano_publicacao"];  
        $data_entrada   = $reg["data_entrada"];
        $nro_exemplar   = $reg["nro_exemplar"];
        $nome_titulo    = $reg["nome_titulo"];
        $tradutor       = $reg["tradutor"];
        $editora        = $reg["editora"];
    }

    if ($action == 'grava') {
        $msg = $exemplar->valida($id_centro, $id_titulo, $id_exemplar, $id_tradutor, $tradutor, $editora, $data_entrada, $nro_exemplar);     // validacao
        if (strlen($msg) == 0) {        // sem erros
            $message = $exemplar->update($id_centro, $id_exemplar, $id_tradutor, $id_editora, $nro_edicao, $ano_publicacao, $data_entrada, $nro_exemplar);
            if ($message->code < 0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Exemplar alterado</p>";
// ERRO congela  
//                $auditoria->report("Altera $id_centro, $id_exemplar, $id_tradutor, $id_editora, $nro_edicao, $ano_publicacao, $data_entrada, $nro_exemplar, $nome_titulo");

            }
            Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
include "./exemplar.form.php";
    if (! strpos($msg, "alterado")) {  // omite botao alterado
        echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
    }
    echo "<input type='hidden' name='id_titulo' value='$id_titulo'/>";
    echo "<button type='submit' class='butbase' formaction='exemplar.lista.php'>Volta</button>";
    echo "</form>";
Arch::endView(); 
?>
