<?php                   // usuario.altera.php
// criado por GeraAltera em 23-08-2023 08:56:41
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.usuario.php";
include "../classes/class.auditoria.php";

Arch::initController("usuario"); 
    $operacao = "altera"; 
    $id_centro = Arch::session("id_centro"); 
    $id_usuario = Arch::get("id_usuario"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $nome_usuario = Arch::requestOrCookie("nome_usuario"); 
    $perfis_usuario = Arch::requestOrCookie("perfis_usuario"); 
    $senha = Arch::requestOrCookie("senha"); 
    $telefone = Arch::requestOrCookie("telefone"); 
    $email = Arch::requestOrCookie("email"); 

    $msg = ""; 

// instancia classe(s) 
    $usuario = new Usuario(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $usuario->selectId($id_centro, $id_usuario); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_centro = $reg["id_centro"]; 
        $id_usuario = $reg["id_usuario"]; 
        $nome_usuario = $reg["nome_usuario"]; 
        $perfis_usuario = $reg["perfis_usuario"]; 
        $senha = $reg["senha"]; 
        $telefone = $reg["telefone"]; 
        $email = $reg["email"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $usuario->valida( 
// colunas a validar 
            $id_centro, 
            $id_usuario, 
            $nome_usuario, 
            $perfis_usuario, 
            $senha, 
            $telefone, 
            $email); 

        if (strlen($msg) == 0) { 
            $err = $usuario->update( 
// colunas a atualizar 
                $id_centro, 
                $id_usuario, 
                $nome_usuario, 
                $perfis_usuario, 
                $senha, 
                $telefone, 
                $email); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * Usuario alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_centro, $id_usuario, $nome_usuario, $perfis_usuario, $senha, $telefone, $email"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./usuario.form.php"; 

// botão altera - omite se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_usuario'"; 
    echo "value='$id_usuario'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("usuario.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraAltera 23-08-2023 08:56:41</p>"; 
Arch::endView(); 
?> 
