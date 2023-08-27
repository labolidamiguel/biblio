<?php                   // autor.altera.php
// criado por GeraAltera em 19-08-2023 11:21:52
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.autor.php";
include "../classes/class.auditoria.php";

Arch::initController("autor"); 
    $operacao = "altera"; 
    $id_centro = Arch::session("id_centro"); 
    $id_autor = Arch::get("id_autor"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $nome_autor = Arch::requestOrCookie("nome_autor"); 
    $iniciais = Arch::requestOrCookie("iniciais"); 

    $msg = ""; 

// instancia classe(s) 
    $autor = new Autor(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $autor->selectId($id_centro, $id_autor); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_centro = $reg["id_centro"]; 
        $id_autor = $reg["id_autor"]; 
        $nome_autor = $reg["nome_autor"]; 
        $iniciais = $reg["iniciais"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $autor->valida( 
// colunas a validar 
            $id_centro, 
            $id_autor, 
            $nome_autor, 
            $iniciais); 

        if (strlen($msg) == 0) { 
            $err = $autor->update( 
// colunas a atualizar 
                $id_centro, 
                $id_autor, 
                $nome_autor, 
                $iniciais); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Autor alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_centro, $id_autor, $nome_autor, $iniciais"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./autor.form.php"; 

// botão altera - omite se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_autor'"; 
    echo "value='$id_autor'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("autor.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraAltera 19-08-2023 11:21:52</p>"; 
Arch::endView(); 
?> 
