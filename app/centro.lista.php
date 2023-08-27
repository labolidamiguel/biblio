<?php                   // centro.lista.php
// criado por GeraLista em 22-08-2023 09:30:01
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.centro.php";

Arch::initController("centro"); 
    $id_centro = Arch::session("id_centro"); 
    $pesq      = Arch::get("pesq"); 

// instancia classe(s) 
    $centro = new Centro(); 
    $count = $centro->getCount($pesq); 
    $rs = $centro->select($pesq); 
    Arch::deleteAllCookies(); 

Arch::initView(TRUE); 
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>Centro</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo $space10; 
    botaoCria("centro.cria.php", "centro.lista.php"); 
    echo "</div>"; 
    echo "</form>"; 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
    echo "<th align='left'>Nome</th>"; 
    echo "<th align='left'>Sigla</th>"; 
    echo "<th align='left'>Estado</th>"; 
    echo "<th>&nbsp;</th><th>&nbsp;</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// fetch colunas da tabela 
    while($reg = $rs->fetch()) { 
        $id_centro = $reg["id_centro"]; 
        $nome_centro = $reg["nome_centro"]; 
        $sigla_centro = $reg["sigla_centro"]; 
        $estado = $reg["estado"]; 
// colunas tabela html 
        echo "<td>$nome_centro</td>"; 
        echo "<td>$sigla_centro</td>"; 
        echo "<td>$estado</td>"; 
// botao altera 
        echo "<td><a href='centro.altera.php?"; 
        echo "id_centro=$id_centro"; 
        echo "&callback=centro.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/alte.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
// botao exclui 
        echo "<td><a href='centro.exclui.php?"; 
        echo "id_centro=$id_centro"; 
        echo "&callback=centro.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/excl.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraLista 22-08-2023 09:30:01</p>"; 
Arch::endView(); 
?> 
