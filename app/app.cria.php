<?php                   // app.cria.php
// criado por GeraCria em 21-08-2023 13:55:10
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.auditoria.php";

Arch::initController("app"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mantém dados em cookies 
    $id_app = Arch::requestOrCookie("id_app"); 
    $codigo = Arch::requestOrCookie("codigo"); 
    $titulo = Arch::requestOrCookie("titulo"); 
    $imagem = Arch::requestOrCookie("imagem"); 
    $perfil_app = Arch::requestOrCookie("perfil_app"); 
    $url = Arch::requestOrCookie("url"); 
    $ordem = Arch::requestOrCookie("ordem"); 

    $msg = ""; 

// instancia classe(s) 
    $app = new App(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $app->valida( 
// colunas a validar 
            $id_app, 
            $codigo, 
            $titulo, 
            $imagem, 
            $perfil_app, 
            $url, 
            $ordem); 
        if (strlen($msg) == 0) { 
// cria nova instância 
            $err = $app->insert( 
                $id_app, 
                $codigo, 
                $titulo, 
                $imagem, 
                $perfil_app, 
                $url, 
                $ordem); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * App criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_app, $codigo, $titulo, $imagem, $perfil_app, $url, $ordem"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./app.form.php"; 

// se criado omite o botão Cria 
    if (! strpos($msg, "criado")) { 
// botão Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_app'"; 
    echo "value='$id_app'/>"; 

// botão volta 
    botaoVolta("app.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraCria 21-08-2023 13:55:10</p>"; 
Arch::endView(); 
?> 
