<?php                   // cde.exclui.php
// criado por GeraExclui em 19-08-2023 11:37:41
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.cde.php";
// include "../classes/class.auditoria.php"; 

Arch::initController("cde"); 
    $id_centro = Arch::session("id_centro"); 
    $id_cde = Arch::get("id_cde"); 
    $action = Arch::get("action"); 

// instancia classe(s) 
    $cde = new Cde(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $cde->selectId($id_centro, $id_cde); 
    $reg = $rs->fetch(); 
    $cod_cde = $reg["cod_cde"]; 
    $clas_cde = $reg["clas_cde"]; 
// valida integridade referencial 
    $msg = $cde->integridade($id_centro, $id_cde); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
// exclui instância 
            $err = $cde->delete($id_centro, $id_cde); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* Cde excluido</p>"; 
//                $auditoria->report("Exclui cde $id_centro, $id_cde"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Cde</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>Id</td><td>$id_centro</td></tr>"; 
    echo "<tr><td>Id</td><td>$id_cde</td></tr>"; 
    echo "<tr><td>C&oacute;digo CDE</td><td>$cod_cde</td></tr>"; 
    echo "<tr><td>Classe</td><td>$clas_cde</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
// se não hover erro solicita confirmação 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_cde' "; 
        echo "value='$id_cde'/>"; 
// botão de confirmação 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("cde.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraExclui 19-08-2023 11:37:41</p>"; 
Arch::endView(); 
?> 
