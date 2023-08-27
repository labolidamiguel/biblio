<?php                   // publicado.altera.php
// criado por GeraAltera em 14-08-2023 16:55:04
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.publicado.php";
include "../classes/class.auditoria.php";

Arch::initController("publicado"); 
    $operacao = "altera"; 
    $id_publicado = Arch::get("id_publicado"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $cod_cde = Arch::requestOrCookie("cod_cde"); 
    $nome_titulo = Arch::requestOrCookie("nome_titulo"); 

    $msg = ""; 

    $publicado = new Publicado(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $publicado->selectId($id_publicado); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_publicado = $reg["id_publicado"]; 
        $cod_cde = $reg["cod_cde"]; 
        $nome_titulo = $reg["nome_titulo"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $publicado->valida( 
// colunas a validar 
            $id_publicado, 
            $cod_cde, 
            $nome_titulo); 

        if (strlen($msg) == 0) { 
            $err = $publicado->update( 
// colunas a atualizar 
                $id_publicado, 
                $cod_cde, 
                $nome_titulo); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Publicado alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_publicado, $cod_cde, $nome_titulo"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./publicado.form.php"; 

// botão altera - omitido se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_publicado'"; 
    echo "value='$id_publicado'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("publicado.lista.php"); 
    echo "</form>"; 

Arch::endView(); 
?> 
