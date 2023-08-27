<?php                   // editora.exclui.php
// criado por GeraExclui em 20-08-2023 15:26:49
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.editora.php";
// include "../classes/class.auditoria.php"; 

Arch::initController("editora"); 
    $id_centro = Arch::session("id_centro"); 
    $id_editora = Arch::get("id_editora"); 
    $action = Arch::get("action"); 

// instancia classe(s) 
    $editora = new Editora(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $editora->selectId($id_centro, $id_editora); 
    $reg = $rs->fetch(); 
    $nome_editora = $reg["nome_editora"]; 
// valida integridade referencial 
    $msg = $editora->integridade($id_centro, $id_editora); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
// exclui instância 
            $err = $editora->delete($id_centro, $id_editora); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* Editora excluido</p>"; 
//                $auditoria->report("Exclui editora $id_centro, $id_editora"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Editora</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>Id</td><td>$id_centro</td></tr>"; 
    echo "<tr><td>Id</td><td>$id_editora</td></tr>"; 
    echo "<tr><td>Nome</td><td>$nome_editora</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
// se não hover erro solicita confirmação 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_editora' "; 
        echo "value='$id_editora'/>"; 
// botão de confirmação 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("editora.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraExclui 20-08-2023 15:26:49</p>"; 
Arch::endView(); 
?> 
