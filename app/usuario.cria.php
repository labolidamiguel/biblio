<?php                   // usuario.cria.php
// criado por GeraCria em 23-08-2023 08:56:42
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.usuario.php";
include "../classes/class.auditoria.php";

Arch::initController("usuario"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mant�m dados em cookies 
    $id_usuario = Arch::requestOrCookie("id_usuario"); 
    $nome_usuario = Arch::requestOrCookie("nome_usuario"); 
    $perfis_usuario = Arch::requestOrCookie("perfis_usuario"); 
    $senha = Arch::requestOrCookie("senha"); 
    $telefone = Arch::requestOrCookie("telefone"); 
    $email = Arch::requestOrCookie("email"); 

    $msg = ""; 

// instancia classe(s) 
    $usuario = new Usuario(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $usuario->valida( 
// colunas a validar 
            $id_centro, 
            $id_usuario, 
            $nome_usuario, 
            $perfis_usuario, 
            $senha, 
            $telefone, 
            $email); 
        if (strlen($msg) == 0) { 
// codifica password 
            $senha = hash('sha1', $senha); 
// cria nova inst�ncia 
            $err = $usuario->insert( 
                $id_centro, 
                $id_usuario, 
                $nome_usuario, 
                $perfis_usuario, 
                $senha, 
                $telefone, 
                $email); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Usuario criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_centro, $id_usuario, $nome_usuario, $perfis_usuario, $senha, $telefone, $email"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./usuario.form.php"; 

// se criado omite o bot�o Cria 
    if (! strpos($msg, "criado")) { 
// bot�o Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_usuario'"; 
    echo "value='$id_usuario'/>"; 

// bot�o volta 
    botaoVolta("usuario.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraCria 23-08-2023 08:56:42</p>"; 
Arch::endView(); 
?> 
