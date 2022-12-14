<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
    $linxpage       = 10;               // linhas por pagina
    $id_centro      = Arch::session("id_centro");
    $action         = Arch::requestOrCookie("action");

Arch::initView(TRUE);
    echo "<p class=appTitle2>Impressão</p>";
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left'>Operação</td>";
    echo "</tr>";
    echo "</thead>";

    echo "<tr><td>Exemplar por CDE</td>";
    ref('exemplar.rel.cde.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Exemplar por Etiqueta</td>";
    ref('exemplar.rel.etiq.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Título por Id</td>";
    ref('titulo.rel.id.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Cadastro de Autor</td>";
    ref('autor.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Cadastro de CDE</td>";
    ref('cde.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Cadastro de Editora</td>";
    ref('editora.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Cadastro de Espírito</td>";
    ref('espirito.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Cadastro de Estante</td>";
    ref('estante.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Cadastro de Leitor</td>";
    ref('leitor.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Cadastro de Tradutor</td>";
    ref('tradutor.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Cadastro de Usuário</td>";
    ref('usuario.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>CDE Publicado pela FEB</td>";
    ref('publicado.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Empréstimo</td>";
    ref('emprestimo.rel.php',$id_centro);
    echo "</tr>";

    echo "<tr><td>Auditoria</td>";
    ref('auditoria.rel.php',$id_centro);
    echo "</tr>";

    echo "</div>";
    echo "</table>";

function ref($url,$id_centro) {
    echo "<td><a href='$url?id_centro=$id_centro'><img border='0' alt='alt' src='../layout/img/impb.ico' width='20' height='20'></a><br></td>";
}

Arch::endView();
?>
