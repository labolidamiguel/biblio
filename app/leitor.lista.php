<?php                   // leitor.lista.php
// criado por GeraLista em 23-08-2023 10:03:43
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.leitor.php";

Arch::initController("leitor"); 
    $id_centro = Arch::session("id_centro"); 
    $pesq      = Arch::get("pesq"); 

// instancia classe(s) 
    $leitor = new Leitor(); 
    $count = $leitor->getCount($id_centro, $pesq); 
    $rs = $leitor->select($id_centro, $pesq); 
    Arch::deleteAllCookies(); 

Arch::initView(TRUE); 
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>Leitor</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo $space10; 
    botaoCria("leitor.cria.php", "leitor.lista.php"); 
    echo "</div>"; 
    echo "</form>"; 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Nome</th>"; 
    echo "<th align='left'>Cel</th>"; 
    echo "<th>&nbsp;</th><th>&nbsp;</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// fetch colunas da tabela 
    while($reg = $rs->fetch()) { 
        $id_centro = $reg["id_centro"]; 
        $id_leitor = $reg["id_leitor"]; 
        $nome_leitor = $reg["nome_leitor"]; 
        $celular = $reg["celular"]; 
// colunas tabela html 
        echo "<td>$id_leitor</td>"; 
        echo "<td>$nome_leitor</td>"; 
        echo "<td>$celular</td>"; 
// botao altera 
        echo "<td><a href='leitor.altera.php?"; 
        echo "id_leitor=$id_leitor"; 
        echo "&callback=leitor.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/alte.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
// botao exclui 
        echo "<td><a href='leitor.exclui.php?"; 
        echo "id_leitor=$id_leitor"; 
        echo "&callback=leitor.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/excl.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraLista 23-08-2023 10:03:43</p>"; 
Arch::endView(); 
?> 
