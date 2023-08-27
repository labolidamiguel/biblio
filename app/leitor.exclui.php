<?php                   // leitor.exclui.php
// criado por GeraExclui em 23-08-2023 10:03:43
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.leitor.php";
// include "../classes/class.auditoria.php"; 

Arch::initController("leitor"); 
    $id_centro = Arch::session("id_centro"); 
    $id_leitor = Arch::get("id_leitor"); 
    $action = Arch::get("action"); 

// instancia classe(s) 
    $leitor = new Leitor(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $leitor->selectId($id_centro, $id_leitor); 
    $reg = $rs->fetch(); 
    $nome_leitor = $reg["nome_leitor"]; 
    $celular = $reg["celular"]; 
    $email = $reg["email"]; 
    $endereco = $reg["endereco"]; 
    $cep = $reg["cep"]; 
    $notas = $reg["notas"]; 
// valida integridade referencial 
    $msg = $leitor->integridade($id_centro, $id_leitor); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
// exclui instância 
            $err = $leitor->delete($id_centro, $id_leitor); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* Leitor excluido</p>"; 
//                $auditoria->report("Exclui leitor $id_centro, $id_leitor"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Leitor</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>idCentro</td><td>$id_centro</td></tr>"; 
    echo "<tr><td>Id</td><td>$id_leitor</td></tr>"; 
    echo "<tr><td>Nome</td><td>$nome_leitor</td></tr>"; 
    echo "<tr><td>Cel</td><td>$celular</td></tr>"; 
    echo "<tr><td>E-Mail</td><td>$email</td></tr>"; 
    echo "<tr><td>Endereço</td><td>$endereco</td></tr>"; 
    echo "<tr><td>CEP</td><td>$cep</td></tr>"; 
    echo "<tr><td>Notas</td><td>$notas</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
// se não hover erro solicita confirmação 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_leitor' "; 
        echo "value='$id_leitor'/>"; 
// botão de confirmação 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("leitor.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraExclui 23-08-2023 10:03:43</p>"; 
Arch::endView(); 
?> 
