<?php                   // usuario.exclui.php
// criado por GeraExclui em 23-08-2023 08:56:42
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.usuario.php";
// include "../classes/class.auditoria.php"; 

Arch::initController("usuario"); 
    $id_centro = Arch::session("id_centro"); 
    $id_usuario = Arch::get("id_usuario"); 
    $action = Arch::get("action"); 

// instancia classe(s) 
    $usuario = new Usuario(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $usuario->selectId($id_centro, $id_usuario); 
    $reg = $rs->fetch(); 
    $nome_usuario = $reg["nome_usuario"]; 
    $perfis_usuario = $reg["perfis_usuario"]; 
    $senha = $reg["senha"]; 
    $telefone = $reg["telefone"]; 
    $email = $reg["email"]; 
// valida integridade referencial 
    $msg = $usuario->integridade($id_centro, $id_usuario); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
// exclui instância 
            $err = $usuario->delete($id_centro, $id_usuario); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* Usuario excluido</p>"; 
//                $auditoria->report("Exclui usuario $id_centro, $id_usuario"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Usuario</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>Id centro</td><td>$id_centro</td></tr>"; 
    echo "<tr><td>Id usuario</td><td>$id_usuario</td></tr>"; 
    echo "<tr><td>Nome</td><td>$nome_usuario</td></tr>"; 
    echo "<tr><td>Perfis</td><td>$perfis_usuario</td></tr>"; 
    echo "<tr><td>Telefone</td><td>$telefone</td></tr>"; 
    echo "<tr><td>Email</td><td>$email</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
// se não hover erro solicita confirmação 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_usuario' "; 
        echo "value='$id_usuario'/>"; 
// botão de confirmação 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("usuario.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraExclui 23-08-2023 08:56:42</p>"; 
Arch::endView(); 
?> 
