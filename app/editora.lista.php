<?php                   // editora.lista.php
// criado por GeraLista em 20-08-2023 15:26:49
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.editora.php";

Arch::initController("editora"); 
    $id_centro = Arch::session("id_centro"); 
    $pesq      = Arch::get("pesq"); 

// instancia classe(s) 
    $editora = new Editora(); 
    $count = $editora->getCount($id_centro, $pesq); 
    $rs = $editora->select($id_centro, $pesq); 
    Arch::deleteAllCookies(); 

Arch::initView(TRUE); 
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>Editora</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo $space10; 
    botaoCria("editora.cria.php", "editora.lista.php"); 
    echo "</div>"; 
    echo "</form>"; 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Nome</th>"; 
    echo "<th>&nbsp;</th><th>&nbsp;</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// fetch colunas da tabela 
    while($reg = $rs->fetch()) { 
        $id_centro = $reg["id_centro"]; 
        $id_editora = $reg["id_editora"]; 
        $nome_editora = $reg["nome_editora"]; 
// colunas tabela html 
        echo "<td>$id_editora</td>"; 
        echo "<td>$nome_editora</td>"; 
// botao altera 
        echo "<td><a href='editora.altera.php?"; 
        echo "id_editora=$id_editora"; 
        echo "&callback=editora.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/alte.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
// botao exclui 
        echo "<td><a href='editora.exclui.php?"; 
        echo "id_editora=$id_editora"; 
        echo "&callback=editora.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/excl.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraLista 20-08-2023 15:26:49</p>"; 
Arch::endView(); 
?> 
