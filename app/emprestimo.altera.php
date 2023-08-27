<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.auditoria.php";
include "../classes/class.emprestimo.php";
include "../classes/class.prateleira.php";

Arch::initController("devolucao");      // DEVOLUÇÃO
    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
    $id_emprestimo  = Arch::requestOrCookie("id_emprestimo");
    $nome_titulo    = Arch::requestOrCookie("nome_titulo");
    $iniciais       = Arch::requestOrCookie("iniciais");
    $msg = "";

    $emprestimo = new Emprestimo();
    $prateleira = new Prateleira();
//    $auditoria = new Auditoria();

    $rs = $emprestimo->getEmprestimo(
            $id_centro, $id_emprestimo); 
    $reg = $rs->fetch();            // PDO
    $nome_leitor    = $reg["nome_leitor"];  
    $nome_titulo    = $reg["nome_titulo"];  
    $emprestado     = $reg["emprestado"];

    if ($action == 'ok') {
        $err = $emprestimo->update($id_centro, $id_emprestimo);
        if (strlen($err) > 0) {
            $msg="<p class=texred>Problemas $err</p>";
        }else{
            $msg="<p class=texgreen>* Devolução realizada</p>";
//            $auditoria->report("Altera $id_centro, $id_emprestimo");
        }
        Arch::deleteAllCookies();
    }
    
Arch::initView(TRUE);
    if (strlen($action) == 0
    ||  $action == "valida") {
        echo "<p class=apptitle2>Devolução</p>";
        echo "<p>Verifique se os dados são corretos</p>";
        echo "<table class='tableraw'>";
        echo "<tr>";
        echo "<td>Nome do Leitor</td><td>".$reg["nome_leitor"]."</td>";
        echo "</tr><tr>";
        echo "<td>T&iacute;tulo do Livro</td><td>".$reg["nome_titulo"]."</td>";
        echo "</tr><tr>";
        echo "<td>Número do Volume</td><td>".$reg["nro_volume"]."</td>";
        echo "</tr><tr>";
        echo "<td>CDE</td><td>".$reg["cod_cde"]."</td>";
        echo "</tr><tr>";
        echo "<td>Classe CDE</td><td>".$reg["clas_cde"]."</td>";
        echo "</tr><tr>";
        echo "<td>Nro do Exemplar</td><td>".$reg["nro_exemplar"]."</td>";
        echo "</tr><tr>";
        echo "<td>Data do empréstimo</td><td>".$reg["emprestado"]."</td>";
        echo "</tr><tr>";
        $esta = $prateleira->getPrateleira($id_centro, $reg["cod_cde"]);
        echo "<td>Prateleira(s)</td><td>".$esta."</td>";
        echo "</tr>";
        echo "</table>";

        echo "<a href='emprestimo.altera.php?action=ok'><button class=butbase id='empresta'>Ok</button></a>";

        echo "<a href='emprestimo.lista.php?action=cancel'><button class=butbase id='empresta'>Cancela</button></a>";
    }

    if ($action=="ok") {
        echo "<p class='texgreen'> Operação bem sucedida</p>";
    }

    if ($action=="cancel") {
        echo "<p class='texred'> Operação cancelada</p>";
    }

Arch::endView(); 
?>
