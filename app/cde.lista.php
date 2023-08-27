<?php                   // cde.lista.php
// criado por GeraLista em 19-08-2023 11:37:41
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.cde.php";

Arch::initController("cde"); 
    $id_centro = Arch::session("id_centro"); 
    $pesq      = Arch::get("pesq"); 

// instancia classe(s) 
    $cde = new Cde(); 
    $count = $cde->getCount($id_centro, $pesq); 
    $rs = $cde->select($id_centro, $pesq); 
    Arch::deleteAllCookies(); 

Arch::initView(TRUE); 
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>Cde</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo $space10; 
    botaoCria("cde.cria.php", "cde.lista.php"); 
    echo "</div>"; 
    echo "</form>"; 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>C&oacute;digo CDE</th>"; 
    echo "<th align='left'>Classe</th>"; 
    echo "<th>&nbsp;</th><th>&nbsp;</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// fetch colunas da tabela 
    while($reg = $rs->fetch()) { 
        $id_centro = $reg["id_centro"]; 
        $id_cde = $reg["id_cde"]; 
        $cod_cde = $reg["cod_cde"]; 
        $clas_cde = $reg["clas_cde"]; 
// colunas tabela html 
        echo "<td>$id_cde</td>"; 
        echo "<td>$cod_cde</td>"; 
        echo "<td>$clas_cde</td>"; 
// botao altera 
        echo "<td><a href='cde.altera.php?"; 
        echo "id_cde=$id_cde"; 
        echo "&callback=cde.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/alte.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
// botao exclui 
        echo "<td><a href='cde.exclui.php?"; 
        echo "id_cde=$id_cde"; 
        echo "&callback=cde.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/excl.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraLista 19-08-2023 11:37:41</p>"; 
Arch::endView(); 
?> 
