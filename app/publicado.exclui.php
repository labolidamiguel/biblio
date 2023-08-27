<?php                   // publicado.exclui.php
// criado por GeraExclui em 14-08-2023 16:55:04
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.publicado.php";
// include "../classes/class.auditoria.php"; 

Arch::initController("publicado"); 
    $id_centro = Arch::session("id_centro"); 
    $id_publicado = Arch::get("id_publicado"); 
    $action = Arch::get("action"); 

// instanciação de classes 
    $publicado = new Publicado(); 
//    $auditoria = new Auditoria(); 
// obtém dados das colunas 
    $rs = $publicado->selectId($id_publicado); 
    $reg = $rs->fetch(); 
    $cod_cde = $reg["cod_cde"]; 
    $nome_titulo = $reg["nome_titulo"]; 
// valida integridade referencial 
    $msg = $publicado->integridade($id_publicado); 
    if (strlen($msg) == 0) { 
        if ($action == 'Confirma') { 
            $err = $publicado->delete($id_publicado); 
            if (strlen($err) > 0) { 
                $msg="<p class=texred> 
                * Erro $err</p>"; 
            }else{ 
                $msg="<p class=texgreen>* Publicado excluido</p>"; 
//                $auditoria->report("Exclui publicado $id_centro, $id_publicado"); 
// desabilitada temporariamente
            } 
        } 
    } 

Arch::initView(TRUE); 
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Publicado</p>"; 
    echo "<table class='tableraw'>"; 
// colunas a exibir 
    echo "<tr><td>Id</td><td>$id_publicado</td></tr>"; 
    echo "<tr><td>Cod CDE</td><td>$cod_cde</td></tr>"; 
    echo "<tr><td>Nome Titulo</td><td>$nome_titulo</td></tr>"; 
    echo "</table>"; 
    echo "<b>$msg</b> <br><br>"; 
    if (strlen($msg) == 0) { 
        echo "<p class='texgreen'>"; 
        echo "* Confirma a exclusão?</p> <br>"; 
        echo "<input type='hidden' name='action' "; 
        echo "value='Confirma'/>";  
        echo "<input type='hidden' name='id_publicado' "; 
        echo "value='$id_publicado'/>"; 
        echo "<button type='submit' "; 
        echo "class='butbase' "; 
        echo "formaction='"; 
        echo "'>Confirma</button>"; 
    } 
// botão Volta 
    botaoVolta("publicado.lista.php"); 
    echo "</form>"; 

Arch::endView(); 
?> 
