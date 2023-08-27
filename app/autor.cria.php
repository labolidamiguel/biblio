<?php                   // autor.cria.php
// criado por GeraCria em 19-08-2023 11:21:53
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.autor.php";
include "../classes/class.auditoria.php";

Arch::initController("autor"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mantém dados em cookies 
    $id_autor = Arch::requestOrCookie("id_autor"); 
    $nome_autor = Arch::requestOrCookie("nome_autor"); 
    $iniciais = Arch::requestOrCookie("iniciais"); 

    $msg = ""; 

// instancia classe(s) 
    $autor = new Autor(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $autor->valida( 
// colunas a validar 
            $id_centro, 
            $id_autor, 
            $nome_autor, 
            $iniciais); 
        if (strlen($msg) == 0) { 
// cria nova instância 
            $err = $autor->insert( 
                $id_centro, 
                $id_autor, 
                $nome_autor, 
                $iniciais); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Autor criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_centro, $id_autor, $nome_autor, $iniciais"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./autor.form.php"; 

// se criado omite o botão Cria 
    if (! strpos($msg, "criado")) { 
// botão Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_autor'"; 
    echo "value='$id_autor'/>"; 

// botão volta 
    botaoVolta("autor.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraCria 19-08-2023 11:21:53</p>"; 
Arch::endView(); 
?> 
