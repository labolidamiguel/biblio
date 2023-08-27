<?php                   // app.lista.php
// criado por GeraLista em 21-08-2023 13:55:11
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 

Arch::initController("app"); 
    $id_centro = Arch::session("id_centro"); 
    $pesq      = Arch::get("pesq"); 

// instancia classe(s) 
    $app = new App(); 
    $count = $app->getCount($pesq); 
    $rs = $app->select($pesq); 
    Arch::deleteAllCookies(); 

Arch::initView(TRUE); 
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>App</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo $space10; 
    botaoCria("app.cria.php", "app.lista.php"); 
    echo "</div>"; 
    echo "</form>"; 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Codigo</th>"; 
    echo "<th align='left'>Titulo</th>"; 
    echo "<th align='left'>Perfil</th>"; 
    echo "<th align='left'>Ordem</th>"; 
    echo "<th>&nbsp;</th><th>&nbsp;</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// fetch colunas da tabela 
    while($reg = $rs->fetch()) { 
        $id_app = $reg["id_app"]; 
        $codigo = $reg["codigo"]; 
        $titulo = $reg["titulo"]; 
        $perfil_app = $reg["perfil_app"]; 
        $ordem = $reg["ordem"]; 
// colunas tabela html 
        echo "<td>$id_app</td>"; 
        echo "<td>$codigo</td>"; 
        echo "<td>$titulo</td>"; 
        echo "<td>$perfil_app</td>"; 
        echo "<td>$ordem</td>"; 
// botao altera 
        echo "<td><a href='app.altera.php?"; 
        echo "id_app=$id_app"; 
        echo "&callback=app.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/alte.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
// botao exclui 
        echo "<td><a href='app.exclui.php?"; 
        echo "id_app=$id_app"; 
        echo "&callback=app.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/excl.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraLista 21-08-2023 13:55:11</p>"; 
Arch::endView(); 
?> 
