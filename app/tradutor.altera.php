<?php                   // tradutor.altera.php
// criado por GeraAltera em 20-08-2023 16:25:31
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.tradutor.php";
include "../classes/class.auditoria.php";

Arch::initController("tradutor"); 
    $operacao = "altera"; 
    $id_centro = Arch::session("id_centro"); 
    $id_tradutor = Arch::get("id_tradutor"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $nome_tradutor = Arch::requestOrCookie("nome_tradutor"); 

    $msg = ""; 

// instancia classe(s) 
    $tradutor = new Tradutor(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $tradutor->selectId($id_centro, $id_tradutor); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_centro = $reg["id_centro"]; 
        $id_tradutor = $reg["id_tradutor"]; 
        $nome_tradutor = $reg["nome_tradutor"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $tradutor->valida( 
// colunas a validar 
            $id_centro, 
            $id_tradutor, 
            $nome_tradutor); 

        if (strlen($msg) == 0) { 
            $err = $tradutor->update( 
// colunas a atualizar 
                $id_centro, 
                $id_tradutor, 
                $nome_tradutor); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Tradutor alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_centro, $id_tradutor, $nome_tradutor"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./tradutor.form.php"; 

// botão altera - omite se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_tradutor'"; 
    echo "value='$id_tradutor'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("tradutor.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraAltera 20-08-2023 16:25:31</p>"; 
Arch::endView(); 
?> 
