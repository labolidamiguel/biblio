<?php                   // tradutor.lista.php
// criado por GeraLista em 20-08-2023 16:25:32
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.tradutor.php";

Arch::initController("tradutor"); 
    $id_centro = Arch::session("id_centro"); 
    $pesq      = Arch::get("pesq"); 

// instancia classe(s) 
    $tradutor = new Tradutor(); 
    $count = $tradutor->getCount($id_centro, $pesq); 
    $rs = $tradutor->select($id_centro, $pesq); 
    Arch::deleteAllCookies(); 

Arch::initView(TRUE); 
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>Tradutor</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo $space10; 
    botaoCria("tradutor.cria.php", "tradutor.lista.php"); 
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
        $id_tradutor = $reg["id_tradutor"]; 
        $nome_tradutor = $reg["nome_tradutor"]; 
// colunas tabela html 
        echo "<td>$id_tradutor</td>"; 
        echo "<td>$nome_tradutor</td>"; 
// botao altera 
        echo "<td><a href='tradutor.altera.php?"; 
        echo "id_tradutor=$id_tradutor"; 
        echo "&callback=tradutor.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/alte.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
// botao exclui 
        echo "<td><a href='tradutor.exclui.php?"; 
        echo "id_tradutor=$id_tradutor"; 
        echo "&callback=tradutor.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/excl.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraLista 20-08-2023 16:25:32</p>"; 
Arch::endView(); 
?> 
