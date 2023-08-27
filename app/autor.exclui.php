<?php                   // autor.exclui.php
// criado por GeraExclui em 19-08-2023 11:21:53
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.autor.php";
// include "../classes/class.auditoria.php"; 

Arch::initController("autor"); 
    $id_centro = Arch::session("id_centro"); 
    $id_autor = Arch::get("id_autor"); 
    $action = Arch::get("action"); 

// instancia classe(s) 
    $autor = new Autor(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $autor->selectId($id_centro, $id_autor); 
    $reg = $rs->fetch(); 
    $nome_autor = $reg["nome_autor"]; 
    $iniciais = $reg["iniciais"]; 
// valida integridade referencial 
    $msg = $autor->integridade($id_centro, $id_autor); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
// exclui instância 
            $err = $autor->delete($id_centro, $id_autor); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* Autor excluido</p>"; 
//                $auditoria->report("Exclui autor $id_centro, $id_autor"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Autor</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>idCentro</td><td>$id_centro</td></tr>"; 
    echo "<tr><td>Id</td><td>$id_autor</td></tr>"; 
    echo "<tr><td>Nome</td><td>$nome_autor</td></tr>"; 
    echo "<tr><td>Inic</td><td>$iniciais</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
// se não hover erro solicita confirmação 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_autor' "; 
        echo "value='$id_autor'/>"; 
// botão de confirmação 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("autor.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraExclui 19-08-2023 11:21:53</p>"; 
Arch::endView(); 
?> 
