<?php                   // espirito.exclui.php
// criado por GeraExclui em 20-08-2023 15:26:21
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.espirito.php";
// include "../classes/class.auditoria.php"; 

Arch::initController("espirito"); 
    $id_centro = Arch::session("id_centro"); 
    $id_espirito = Arch::get("id_espirito"); 
    $action = Arch::get("action"); 

// instancia classe(s) 
    $espirito = new Espirito(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $espirito->selectId($id_centro, $id_espirito); 
    $reg = $rs->fetch(); 
    $nome_espirito = $reg["nome_espirito"]; 
// valida integridade referencial 
    $msg = $espirito->integridade($id_centro, $id_espirito); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
// exclui instância 
            $err = $espirito->delete($id_centro, $id_espirito); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* Espirito excluido</p>"; 
//                $auditoria->report("Exclui espirito $id_centro, $id_espirito"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Espirito</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>Id</td><td>$id_centro</td></tr>"; 
    echo "<tr><td>Id</td><td>$id_espirito</td></tr>"; 
    echo "<tr><td>Nome</td><td>$nome_espirito</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
// se não hover erro solicita confirmação 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_espirito' "; 
        echo "value='$id_espirito'/>"; 
// botão de confirmação 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("espirito.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraExclui 20-08-2023 15:26:21</p>"; 
Arch::endView(); 
?> 
