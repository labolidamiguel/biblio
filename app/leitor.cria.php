<?php                   // leitor.cria.php
// criado por GeraCria em 23-08-2023 10:03:42
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.leitor.php";
include "../classes/class.auditoria.php";

Arch::initController("leitor"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mantém dados em cookies 
    $id_leitor = Arch::requestOrCookie("id_leitor"); 
    $nome_leitor = Arch::requestOrCookie("nome_leitor"); 
    $celular = Arch::requestOrCookie("celular"); 
    $email = Arch::requestOrCookie("email"); 
    $endereco = Arch::requestOrCookie("endereco"); 
    $cep = Arch::requestOrCookie("cep"); 
    $notas = Arch::requestOrCookie("notas"); 

    $msg = ""; 

// instancia classe(s) 
    $leitor = new Leitor(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $leitor->valida( 
// colunas a validar 
            $id_centro, 
            $id_leitor, 
            $nome_leitor, 
            $celular, 
            $email, 
            $endereco, 
            $cep, 
            $notas); 
        if (strlen($msg) == 0) { 
// cria nova instância 
            $err = $leitor->insert( 
                $id_centro, 
                $id_leitor, 
                $nome_leitor, 
                $celular, 
                $email, 
                $endereco, 
                $cep, 
                $notas); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Leitor criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_centro, $id_leitor, $nome_leitor, $celular, $email, $endereco, $cep, $notas"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./leitor.form.php"; 

// se criado omite o botão Cria 
    if (! strpos($msg, "criado")) { 
// botão Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_leitor'"; 
    echo "value='$id_leitor'/>"; 

// botão volta 
    botaoVolta("leitor.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraCria 23-08-2023 10:03:42</p>"; 
Arch::endView(); 
?> 
