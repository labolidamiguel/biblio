<?php                   // leitor.altera.php
// criado por GeraAltera em 23-08-2023 10:03:42
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.leitor.php";
include "../classes/class.auditoria.php";

Arch::initController("leitor"); 
    $operacao = "altera"; 
    $id_centro = Arch::session("id_centro"); 
    $id_leitor = Arch::get("id_leitor"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $nome_leitor = Arch::requestOrCookie("nome_leitor"); 
    $celular = Arch::requestOrCookie("celular"); 
    $email = Arch::requestOrCookie("email"); 
    $endereco = Arch::requestOrCookie("endereco"); 
    $cep = Arch::requestOrCookie("cep"); 
    $notas = Arch::requestOrCookie("notas"); 

    $msg = ""; 

// instancia classe(s) 
    $leitor = new Leitor(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $leitor->selectId($id_centro, $id_leitor); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_centro = $reg["id_centro"]; 
        $id_leitor = $reg["id_leitor"]; 
        $nome_leitor = $reg["nome_leitor"]; 
        $celular = $reg["celular"]; 
        $email = $reg["email"]; 
        $endereco = $reg["endereco"]; 
        $cep = $reg["cep"]; 
        $notas = $reg["notas"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $leitor->valida( 
// colunas a validar 
            $id_centro, 
            $id_leitor, 
            $nome_leitor, 
            $celular, 
            $email, 
            $endereco, 
            $cep, 
            $notas); 

        if (strlen($msg) == 0) { 
            $err = $leitor->update( 
// colunas a atualizar 
                $id_centro, 
                $id_leitor, 
                $nome_leitor, 
                $celular, 
                $email, 
                $endereco, 
                $cep, 
                $notas); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Leitor alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_centro, $id_leitor, $nome_leitor, $celular, $email, $endereco, $cep, $notas"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./leitor.form.php"; 

// botão altera - omite se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_leitor'"; 
    echo "value='$id_leitor'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("leitor.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraAltera 23-08-2023 10:03:42</p>"; 
Arch::endView(); 
?> 
