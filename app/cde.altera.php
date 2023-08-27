<?php                   // cde.altera.php
// criado por GeraAltera em 19-08-2023 11:37:40
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.cde.php";
include "../classes/class.auditoria.php";

Arch::initController("cde"); 
    $operacao = "altera"; 
    $id_centro = Arch::session("id_centro"); 
    $id_cde = Arch::get("id_cde"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $cod_cde = Arch::requestOrCookie("cod_cde"); 
    $clas_cde = Arch::requestOrCookie("clas_cde"); 

    $msg = ""; 

// instancia classe(s) 
    $cde = new Cde(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $cde->selectId($id_centro, $id_cde); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_centro = $reg["id_centro"]; 
        $id_cde = $reg["id_cde"]; 
        $cod_cde = $reg["cod_cde"]; 
        $clas_cde = $reg["clas_cde"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $cde->valida( 
// colunas a validar 
            $id_centro, 
            $id_cde, 
            $cod_cde, 
            $clas_cde); 

        if (strlen($msg) == 0) { 
            $err = $cde->update( 
// colunas a atualizar 
                $id_centro, 
                $id_cde, 
                $cod_cde, 
                $clas_cde); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Cde alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_centro, $id_cde, $cod_cde, $clas_cde"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./cde.form.php"; 

// botão altera - omite se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_cde'"; 
    echo "value='$id_cde'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("cde.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraAltera 19-08-2023 11:37:40</p>"; 
Arch::endView(); 
?> 
