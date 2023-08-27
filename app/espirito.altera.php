<?php                   // espirito.altera.php
// criado por GeraAltera em 20-08-2023 15:26:21
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.espirito.php";
include "../classes/class.auditoria.php";

Arch::initController("espirito"); 
    $operacao = "altera"; 
    $id_centro = Arch::session("id_centro"); 
    $id_espirito = Arch::get("id_espirito"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $nome_espirito = Arch::requestOrCookie("nome_espirito"); 

    $msg = ""; 

// instancia classe(s) 
    $espirito = new Espirito(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $espirito->selectId($id_centro, $id_espirito); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_centro = $reg["id_centro"]; 
        $id_espirito = $reg["id_espirito"]; 
        $nome_espirito = $reg["nome_espirito"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $espirito->valida( 
// colunas a validar 
            $id_centro, 
            $id_espirito, 
            $nome_espirito); 

        if (strlen($msg) == 0) { 
            $err = $espirito->update( 
// colunas a atualizar 
                $id_centro, 
                $id_espirito, 
                $nome_espirito); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Espirito alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_centro, $id_espirito, $nome_espirito"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./espirito.form.php"; 

// botão altera - omite se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_espirito'"; 
    echo "value='$id_espirito'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("espirito.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraAltera 20-08-2023 15:26:21</p>"; 
Arch::endView(); 
?> 
