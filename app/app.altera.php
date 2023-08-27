<?php                   // app.altera.php
// criado por GeraAltera em 21-08-2023 13:55:10
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.auditoria.php";

Arch::initController("app"); 
    $operacao = "altera"; 
    $id_app = Arch::get("id_app"); 
    $action    = Arch::get("action"); 
    $flag_lido = Arch::get("flag_lido"); 
// mantém dados em cookies 
    $codigo = Arch::requestOrCookie("codigo"); 
    $titulo = Arch::requestOrCookie("titulo"); 
    $imagem = Arch::requestOrCookie("imagem"); 
    $perfil_app = Arch::requestOrCookie("perfil_app"); 
    $url = Arch::requestOrCookie("url"); 
    $ordem = Arch::requestOrCookie("ordem"); 

    $msg = ""; 

// instancia classe(s) 
    $app = new App(); 
    $audit = new Auditoria(); 

// na primeira vez carrega do DB 
    if (strlen($flag_lido) == 0) { 
        $rs = $app->selectId($id_app); 
        $reg = $rs->fetch(); 
// obtém valores das colunas 
        $id_app = $reg["id_app"]; 
        $codigo = $reg["codigo"]; 
        $titulo = $reg["titulo"]; 
        $imagem = $reg["imagem"]; 
        $perfil_app = $reg["perfil_app"]; 
        $url = $reg["url"]; 
        $ordem = $reg["ordem"]; 
    } 
// validação 
    if ($action == "altera") { 
        $msg = $app->valida( 
// colunas a validar 
            $id_app, 
            $codigo, 
            $titulo, 
            $imagem, 
            $perfil_app, 
            $url, 
            $ordem); 

        if (strlen($msg) == 0) { 
            $err = $app->update( 
// colunas a atualizar 
                $id_app, 
                $codigo, 
                $titulo, 
                $imagem, 
                $perfil_app, 
                $url, 
                $ordem); 

            if (strlen($err) > 0) { 
                $msg = "<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen> 
                * App alterado</p>"; 
//                $audit->report( 
//                "Cria $id_centro, $id_app, $codigo, $titulo, $imagem, $perfil_app, $url, $ordem"); 
                Arch::deleteAllCookies(); 
            } 
        } 
    } 

Arch::initView(TRUE); 
include "./app.form.php"; 

// botão altera - omite se já foi alterado 
    if (! strpos($msg, "alterado")) { 
        echo "<button type='submit' name='action' "; 
        echo "value='altera' class='butbase'> 
        Altera</button>"; 
    } 
    echo "<input type='hidden' name='id_app'"; 
    echo "value='$id_app'/>"; 
    echo "<input type='hidden' name='flag_lido'"; 
    echo "value='lido'/>"; 

// botão volta 
    botaoVolta("app.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraAltera 21-08-2023 13:55:10</p>"; 
Arch::endView(); 
?> 
