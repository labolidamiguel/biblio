<?php                   // app.exclui.php
// criado por GeraExclui em 21-08-2023 13:55:10
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
// include "../classes/class.auditoria.php"; 

Arch::initController("app"); 
    $id_centro = Arch::session("id_centro"); 
    $id_app = Arch::get("id_app"); 
    $action = Arch::get("action"); 

// instancia classe(s) 
    $app = new App(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $app->selectId($id_app); 
    $reg = $rs->fetch(); 
    $codigo = $reg["codigo"]; 
    $titulo = $reg["titulo"]; 
    $imagem = $reg["imagem"]; 
    $perfil_app = $reg["perfil_app"]; 
    $url = $reg["url"]; 
    $ordem = $reg["ordem"]; 
// valida integridade referencial 
    $msg = $app->integridade($id_app); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
// exclui instância 
            $err = $app->delete($id_app); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* App excluido</p>"; 
//                $auditoria->report("Exclui app $id_centro, $id_app"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>App</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>Id</td><td>$id_app</td></tr>"; 
    echo "<tr><td>Codigo</td><td>$codigo</td></tr>"; 
    echo "<tr><td>Titulo</td><td>$titulo</td></tr>"; 
    echo "<tr><td>Imagem</td><td>$imagem</td></tr>"; 
    echo "<tr><td>Perfil</td><td>$perfil_app</td></tr>"; 
    echo "<tr><td>URL</td><td>$url</td></tr>"; 
    echo "<tr><td>Ordem</td><td>$ordem</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
// se não hover erro solicita confirmação 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_app' "; 
        echo "value='$id_app'/>"; 
// botão de confirmação 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("app.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraExclui 21-08-2023 13:55:10</p>"; 
Arch::endView(); 
?> 
