<?php                   // publicado.lista.php
// criado por GeraLista em 14-08-2023 16:55:05
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.publicado.php";

Arch::initController("publicado"); 
    $id_centro = Arch::session("id_centro"); 
    $pesq      = Arch::get("pesq"); 

    $publicado = new Publicado(); 
    $count = $publicado->getCount($pesq); 
    $rs = $publicado->select($pesq); 
    Arch::deleteAllCookies(); 

Arch::initView(TRUE); 
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>Publicado</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo $space10; 
    botaoCria("publicado.cria.php", "publicado.lista.php"); 
    echo "</div>"; 
    echo "</form>"; 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Cod CDE</th>"; 
    echo "<th align='left'>Nome Titulo</th>"; 
    echo "<th>&nbsp;</th><th>&nbsp;</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// fetch colunas da tabela 
    while($reg = $rs->fetch()) { 
        $id_publicado = $reg["id_publicado"]; 
        $cod_cde = $reg["cod_cde"]; 
        $nome_titulo = $reg["nome_titulo"]; 
// colunas tabela html 
        echo "<td>$id_publicado</td>"; 
        echo "<td>$cod_cde</td>"; 
        echo "<td>$nome_titulo</td>"; 
// botao altera 
        echo "<td><a href='publicado.altera.php?"; 
        echo "id_publicado=$id_publicado"; 
        echo "&callback=publicado.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/alte.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
// botao exclui 
        echo "<td><a href='publicado.exclui.php?"; 
        echo "id_publicado=$id_publicado"; 
        echo "&callback=publicado.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/excl.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
Arch::endView(); 
?> 
