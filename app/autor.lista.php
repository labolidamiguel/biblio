<?php                   // autor.lista.php
// criado por GeraLista em 19-08-2023 11:21:53
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.autor.php";

Arch::initController("autor"); 
    $id_centro = Arch::session("id_centro"); 
    $pesq      = Arch::get("pesq"); 

// instancia classe(s) 
    $autor = new Autor(); 
    $count = $autor->getCount($id_centro, $pesq); 
    $rs = $autor->select($id_centro, $pesq); 
    Arch::deleteAllCookies(); 

Arch::initView(TRUE); 
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>Autor</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo $space10; 
    botaoCria("autor.cria.php", "autor.lista.php"); 
    echo "</div>"; 
    echo "</form>"; 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Nome</th>"; 
    echo "<th align='left'>Inic</th>"; 
    echo "<th>&nbsp;</th><th>&nbsp;</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// fetch colunas da tabela 
    while($reg = $rs->fetch()) { 
        $id_centro = $reg["id_centro"]; 
        $id_autor = $reg["id_autor"]; 
        $nome_autor = $reg["nome_autor"]; 
        $iniciais = $reg["iniciais"]; 
// colunas tabela html 
        echo "<td>$id_autor</td>"; 
        echo "<td>$nome_autor</td>"; 
        echo "<td>$iniciais</td>"; 
// botao altera 
        echo "<td><a href='autor.altera.php?"; 
        echo "id_autor=$id_autor"; 
        echo "&callback=autor.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/alte.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
// botao exclui 
        echo "<td><a href='autor.exclui.php?"; 
        echo "id_autor=$id_autor"; 
        echo "&callback=autor.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/excl.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraLista 19-08-2023 11:21:53</p>"; 
Arch::endView(); 
?> 
