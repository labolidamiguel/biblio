<?php                   // editora.cria.php
// criado por GeraCria em 20-08-2023 15:26:48
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.editora.php";
include "../classes/class.auditoria.php";

Arch::initController("editora"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mantém dados em cookies 
    $id_editora = Arch::requestOrCookie("id_editora"); 
    $nome_editora = Arch::requestOrCookie("nome_editora"); 

    $msg = ""; 

// instancia classe(s) 
    $editora = new Editora(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $editora->valida( 
// colunas a validar 
            $id_centro, 
            $id_editora, 
            $nome_editora); 
        if (strlen($msg) == 0) { 
// cria nova instância 
            $err = $editora->insert( 
                $id_centro, 
                $id_editora, 
                $nome_editora); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Editora criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_centro, $id_editora, $nome_editora"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./editora.form.php"; 

// se criado omite o botão Cria 
    if (! strpos($msg, "criado")) { 
// botão Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_editora'"; 
    echo "value='$id_editora'/>"; 

// botão volta 
    botaoVolta("editora.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraCria 20-08-2023 15:26:48</p>"; 
Arch::endView(); 
?> 
