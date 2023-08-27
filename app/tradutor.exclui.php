<?php                   // tradutor.exclui.php
// criado por GeraExclui em 20-08-2023 16:25:31
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.tradutor.php";
// include "../classes/class.auditoria.php"; 

Arch::initController("tradutor"); 
    $id_centro = Arch::session("id_centro"); 
    $id_tradutor = Arch::get("id_tradutor"); 
    $action = Arch::get("action"); 

// instancia classe(s) 
    $tradutor = new Tradutor(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $tradutor->selectId($id_centro, $id_tradutor); 
    $reg = $rs->fetch(); 
    $nome_tradutor = $reg["nome_tradutor"]; 
// valida integridade referencial 
    $msg = $tradutor->integridade($id_centro, $id_tradutor); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
// exclui instância 
            $err = $tradutor->delete($id_centro, $id_tradutor); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* Tradutor excluido</p>"; 
//                $auditoria->report("Exclui tradutor $id_centro, $id_tradutor"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Tradutor</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>Id</td><td>$id_centro</td></tr>"; 
    echo "<tr><td>Id</td><td>$id_tradutor</td></tr>"; 
    echo "<tr><td>Nome</td><td>$nome_tradutor</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
// se não hover erro solicita confirmação 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_tradutor' "; 
        echo "value='$id_tradutor'/>"; 
// botão de confirmação 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("tradutor.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraExclui 20-08-2023 16:25:31</p>"; 
Arch::endView(); 
?> 
