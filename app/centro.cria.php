<?php                   // centro.cria.php
// criado por GeraCria em 22-08-2023 09:30:01
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.centro.php";
include "../classes/class.auditoria.php";

Arch::initController("centro"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mantém dados em cookies 
    $nome_centro = Arch::requestOrCookie("nome_centro"); 
    $sigla_centro = Arch::requestOrCookie("sigla_centro"); 
    $telefone = Arch::requestOrCookie("telefone"); 
    $endereco = Arch::requestOrCookie("endereco"); 
    $cidade = Arch::requestOrCookie("cidade"); 
    $estado = Arch::requestOrCookie("estado"); 
    $cep = Arch::requestOrCookie("cep"); 

    $msg = ""; 

// instancia classe(s) 
    $centro = new Centro(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $centro->valida( 
// colunas a validar 
            $id_centro, 
            $nome_centro, 
            $sigla_centro, 
            $telefone, 
            $endereco, 
            $cidade, 
            $estado, 
            $cep); 
        if (strlen($msg) == 0) { 
// cria nova instância 
            $err = $centro->insert( 
                $id_centro, 
                $nome_centro, 
                $sigla_centro, 
                $telefone, 
                $endereco, 
                $cidade, 
                $estado, 
                $cep); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Centro criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_centro, $nome_centro, $sigla_centro, $telefone, $endereco, $cidade, $estado, $cep"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./centro.form.php"; 

// se criado omite o botão Cria 
    if (! strpos($msg, "criado")) { 
// botão Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_centro'"; 
    echo "value='$id_centro'/>"; 

// botão volta 
    botaoVolta("centro.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraCria 22-08-2023 09:30:01</p>"; 
Arch::endView(); 
?> 
