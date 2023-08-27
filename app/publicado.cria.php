<?php                   // publicado.cria.php
// criado por GeraCria em 14-08-2023 16:55:04
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.publicado.php";
include "../classes/class.auditoria.php";

Arch::initController("publicado"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mantém dados em cookies 
    $cod_cde = Arch::requestOrCookie("cod_cde"); 
    $nome_titulo = Arch::requestOrCookie("nome_titulo"); 

    $msg = ""; 

// instanciação de classes 
    $publicado = new Publicado(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $publicado->valida( 
// colunas a validar 
            $id_publicado, 
            $cod_cde, 
            $nome_titulo); 
        if (strlen($msg) == 0) { 
            $err = $publicado->insert( 
                $id_publicado, 
                $cod_cde, 
                $nome_titulo); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Publicado criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_publicado, $cod_cde, $nome_titulo"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./publicado.form.php"; 

// se criado omite o botão Cria 
    if (! strpos($msg, "criado")) { 
// botão Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_publicado'"; 
    echo "value='$id_publicado'/>"; 

// botão volta 
    botaoVolta("publicado.lista.php"); 
    echo "</form>"; 

Arch::endView(); 
?> 
