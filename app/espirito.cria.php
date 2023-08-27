<?php                   // espirito.cria.php
// criado por GeraCria em 20-08-2023 15:26:21
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.espirito.php";
include "../classes/class.auditoria.php";

Arch::initController("espirito"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mantém dados em cookies 
    $id_espirito = Arch::requestOrCookie("id_espirito"); 
    $nome_espirito = Arch::requestOrCookie("nome_espirito"); 

    $msg = ""; 

// instancia classe(s) 
    $espirito = new Espirito(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $espirito->valida( 
// colunas a validar 
            $id_centro, 
            $id_espirito, 
            $nome_espirito); 
        if (strlen($msg) == 0) { 
// cria nova instância 
            $err = $espirito->insert( 
                $id_centro, 
                $id_espirito, 
                $nome_espirito); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Espirito criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_centro, $id_espirito, $nome_espirito"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./espirito.form.php"; 

// se criado omite o botão Cria 
    if (! strpos($msg, "criado")) { 
// botão Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_espirito'"; 
    echo "value='$id_espirito'/>"; 

// botão volta 
    botaoVolta("espirito.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraCria 20-08-2023 15:26:21</p>"; 
Arch::endView(); 
?> 
