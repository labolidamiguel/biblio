<?php                   // centro.exclui.php
// criado por GeraExclui em 22-08-2023 09:30:01
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.centro.php";
// include "../classes/class.auditoria.php"; 

Arch::initController("centro"); 
    $id_centro = Arch::session("id_centro"); 
    $id_centro = Arch::get("id_centro"); 
    $action = Arch::get("action"); 

// instancia classe(s) 
    $centro = new Centro(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $centro->selectId($id_centro, $id_centro); 
    $reg = $rs->fetch(); 
    $nome_centro = $reg["nome_centro"]; 
    $sigla_centro = $reg["sigla_centro"]; 
    $telefone = $reg["telefone"]; 
    $endereco = $reg["endereco"]; 
    $cidade = $reg["cidade"]; 
    $estado = $reg["estado"]; 
    $cep = $reg["cep"]; 
// valida integridade referencial 
    $msg = $centro->integridade($id_centro, $id_centro); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
// exclui instância 
            $err = $centro->delete($id_centro, $id_centro); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* Centro excluido</p>"; 
//                $auditoria->report("Exclui centro $id_centro, $id_centro"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Centro</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>Id</td><td>$id_centro</td></tr>"; 
    echo "<tr><td>Nome</td><td>$nome_centro</td></tr>"; 
    echo "<tr><td>Sigla</td><td>$sigla_centro</td></tr>"; 
    echo "<tr><td>Telefone</td><td>$telefone</td></tr>"; 
    echo "<tr><td>Endereco</td><td>$endereco</td></tr>"; 
    echo "<tr><td>Cidade</td><td>$cidade</td></tr>"; 
    echo "<tr><td>Estado</td><td>$estado</td></tr>"; 
    echo "<tr><td>CEP</td><td>$cep</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
// se não hover erro solicita confirmação 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_centro' "; 
        echo "value='$id_centro'/>"; 
// botão de confirmação 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("centro.lista.php"); 
    echo "</form>"; 
    echo "<p style='font-size:70%;'>GeraExclui 22-08-2023 09:30:01</p>"; 
Arch::endView(); 
?> 
