<?php                   // cde.cria.php
// criado por GeraCria em 19-08-2023 11:37:40
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php";
include "../classes/class.cde.php";
include "../classes/class.auditoria.php";

Arch::initController("cde"); 
    $operacao = "cria"; 
    $id_centro = Arch::session("id_centro"); 
    $action    = Arch::get("action"); 
// mantém dados em cookies 
    $id_cde = Arch::requestOrCookie("id_cde"); 
    $cod_cde = Arch::requestOrCookie("cod_cde"); 
    $clas_cde = Arch::requestOrCookie("clas_cde"); 

    $msg = ""; 

// instancia classe(s) 
    $cde = new Cde(); 
    $audit = new Auditoria(); 

    if ($action == 'grava') { 
        $msg = $cde->valida( 
// colunas a validar 
            $id_centro, 
            $id_cde, 
            $cod_cde, 
            $clas_cde); 
        if (strlen($msg) == 0) { 
// cria nova instância 
            $err = $cde->insert( 
                $id_centro, 
                $id_cde, 
                $cod_cde, 
                $clas_cde); 
            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Cde criado</p>"; 
                $audit->report( 
                "Cria $id_centro, $id_centro, $id_cde, $cod_cde, $clas_cde"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./cde.form.php"; 

// se criado omite o botão Cria 
    if (! strpos($msg, "criado")) { 
// botão Cria 
        echo "<button type='submit' name='action' "; 
        echo "value='grava' class='butbase'>"; 
        echo "Cria</button>"; 
    } 
    echo "<input type='hidden' name='id_cde'"; 
    echo "value='$id_cde'/>"; 

// botão volta 
    botaoVolta("cde.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraCria 19-08-2023 11:37:40</p>"; 
Arch::endView(); 
?> 
