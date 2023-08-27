<?php                   // centro.altera.php
// criado por GeraAltera em 22-08-2023 09:30:00
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.centro.php";
include "../classes/class.auditoria.php";

Arch::initController("centro"); 
    $operacao = "altera"; 
    $id_centro = Arch::session("id_centro"); 
    $id_centro = Arch::get("id_centro"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $nome_centro = Arch::requestOrCookie("nome_centro"); 
    $sigla_centro = Arch::requestOrCookie("sigla_centro"); 
    $telefone = Arch::requestOrCookie("telefone"); 
    $endereco = Arch::requestOrCookie("endereco"); 
    $cidade = Arch::requestOrCookie("cidade"); 
    $estado = Arch::requestOrCookie("estado"); 
    $cep = Arch::requestOrCookie("cep"); 

    $msg = ""; 

// instancia classe(s) 
    $centro = new Centro(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $centro->selectId($id_centro, $id_centro); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_centro = $reg["id_centro"]; 
        $nome_centro = $reg["nome_centro"]; 
        $sigla_centro = $reg["sigla_centro"]; 
        $telefone = $reg["telefone"]; 
        $endereco = $reg["endereco"]; 
        $cidade = $reg["cidade"]; 
        $estado = $reg["estado"]; 
        $cep = $reg["cep"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $centro->valida( 
// colunas a validar 
            $id_centro, 
            $nome_centro, 
            $sigla_centro, 
            $telefone, 
            $endereco, 
            $cidade, 
            $estado, 
            $cep); 

        if (strlen($msg) == 0) { 
            $err = $centro->update( 
// colunas a atualizar 
                $id_centro, 
                $nome_centro, 
                $sigla_centro, 
                $telefone, 
                $endereco, 
                $cidade, 
                $estado, 
                $cep); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Centro alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_centro, $nome_centro, $sigla_centro, $telefone, $endereco, $cidade, $estado, $cep"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./centro.form.php"; 

// botão altera - omite se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_centro'"; 
    echo "value='$id_centro'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("centro.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraAltera 22-08-2023 09:30:00</p>"; 
Arch::endView(); 
?> 
