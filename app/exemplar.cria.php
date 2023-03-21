<?php
// exemplar.cria
// 20230320 chamada tradutor.dominio.php limpa pesq
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.estante.php";
include "../classes/class.exemplar.php";
include "../classes/class.titulo.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("titulo");         // exemplar App nao existe
    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
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
    $esta = "";

    $exemplar = new Exemplar();
    $estante = new Estante();
    $titulo = new Titulo();
    $audit = new Auditoria();

    $rs = $titulo->selectId($id_centro, $id_titulo);
    while($reg = $rs->fetch()){         // PDO
        $esta = $estante->getEstante($id_centro, $reg["cde"]);
    }

    if ($action == 't') {               // dominio tradutor
    	header('Location: tradutor.dominio.php?callback=exemplar.cria.php&pesq=');
    }    
    if ($action == 'e') {               // dominio editora
    	header("Location: editora.dominio.php?callback=exemplar.cria.php");
    }    

    if ($action == 'grava') {
        $msg = $exemplar->valida($id_centro, $id_titulo, $id_exemplar, $id_tradutor, $tradutor, $editora, $data_entrada, $nro_exemplar);
        if (strlen($msg) == 0) {        // sem erros
            $message = $exemplar->insert($id_centro, $id_titulo, $id_tradutor, $id_editora, $nro_edicao, $ano_publicacao, $data_entrada, $nro_exemplar);
            if ($message->code < 0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Exemplar criado</p>";
                $msg=$msg."<p class=texgreen>* Estante(s): $esta</p>";
                $audit->report("Cria $id_centro, $id_titulo, $id_tradutor, $id_editora, $nro_edicao, $ano_publicacao, $data_entrada, $nro_exemplar, $nome_titulo, $tradutor, $editora" );
            }
            Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
include "./exemplar.form.php";
        
    if (! strpos($msg, "criado")) {  // omite botao cria
        echo "<button type='submit' class='butbase' name='action' value='grava'>Cria</button>";
    }

    echo "<input type='hidden' name='id_titulo' value='$id_titulo'/>";
    echo "<button type='submit' class='butbase' formaction='exemplar.lista.php'>Volta</button>";
        
    echo "</form>";
Arch::endView(); 
?>
