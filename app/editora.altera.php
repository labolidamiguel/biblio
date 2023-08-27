<?php                   // editora.altera.php
// criado por GeraAltera em 20-08-2023 15:26:48
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.editora.php";
include "../classes/class.auditoria.php";

Arch::initController("editora"); 
    $operacao = "altera"; 
    $id_centro = Arch::session("id_centro"); 
    $id_editora = Arch::get("id_editora"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $nome_editora = Arch::requestOrCookie("nome_editora"); 

    $msg = ""; 

// instancia classe(s) 
    $editora = new Editora(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $editora->selectId($id_centro, $id_editora); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_centro = $reg["id_centro"]; 
        $id_editora = $reg["id_editora"]; 
        $nome_editora = $reg["nome_editora"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $editora->valida( 
// colunas a validar 
            $id_centro, 
            $id_editora, 
            $nome_editora); 

        if (strlen($msg) == 0) { 
            $err = $editora->update( 
// colunas a atualizar 
                $id_centro, 
                $id_editora, 
                $nome_editora); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Editora alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_centro, $id_editora, $nome_editora"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./editora.form.php"; 

// botão altera - omite se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_editora'"; 
    echo "value='$id_editora'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("editora.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraAltera 20-08-2023 15:26:48</p>"; 
Arch::endView(); 
?> 
