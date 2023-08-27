<?php                   // tradutor.cria.php
// criado por GeraCria em 20-08-2023 16:25:31
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.tradutor.php";
include "../classes/class.auditoria.php";

Arch::initController("tradutor"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mantém dados em cookies 
    $id_tradutor = Arch::requestOrCookie("id_tradutor"); 
    $nome_tradutor = Arch::requestOrCookie("nome_tradutor"); 

    $msg = ""; 

// instancia classe(s) 
    $tradutor = new Tradutor(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $tradutor->valida( 
// colunas a validar 
            $id_centro, 
            $id_tradutor, 
            $nome_tradutor); 
        if (strlen($msg) == 0) { 
// cria nova instância 
            $err = $tradutor->insert( 
                $id_centro, 
                $id_tradutor, 
                $nome_tradutor); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Tradutor criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_centro, $id_tradutor, $nome_tradutor"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./tradutor.form.php"; 

// se criado omite o botão Cria 
    if (! strpos($msg, "criado")) { 
// botão Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_tradutor'"; 
    echo "value='$id_tradutor'/>"; 

// botão volta 
    botaoVolta("tradutor.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraCria 20-08-2023 16:25:31</p>"; 
Arch::endView(); 
?> 
