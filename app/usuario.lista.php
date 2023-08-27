<?php                   // usuario.lista.php
// criado por GeraLista em 23-08-2023 08:56:42
include "../common/arch.php";
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.usuario.php";

Arch::initController("usuario"); 
    $id_centro = Arch::session("id_centro"); 
    $pesq      = Arch::get("pesq"); 

// instancia classe(s) 
    $usuario = new Usuario(); 
    $count = $usuario->getCount($id_centro, $pesq); 
    $rs = $usuario->select($id_centro, $pesq); 
    Arch::deleteAllCookies(); 

Arch::initView(TRUE); 
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 

    echo "<p class=appTitle2>Usuario</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo $space10; 
    botaoCria("usuario.cria.php", "usuario.lista.php"); 
    echo "</div>"; 
    echo "</form>"; 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Nome</th>"; 
    echo "<th align='left'>Perfis</th>"; 
    echo "<th>&nbsp;</th><th>&nbsp;</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// fetch colunas da tabela 
    while($reg = $rs->fetch()) { 
        $id_centro = $reg["id_centro"]; 
        $id_usuario = $reg["id_usuario"]; 
        $nome_usuario = $reg["nome_usuario"]; 
        $perfis_usuario = $reg["perfis_usuario"]; 
        if ($perfis_usuario == "13579") 
            continue; // ignora user root 
// colunas tabela html 
        echo "<td>$id_usuario</td>"; 
        echo "<td>$nome_usuario</td>"; 
        echo "<td>$perfis_usuario</td>"; 
// botao altera 
        echo "<td><a href='usuario.altera.php?"; 
        echo "id_usuario=$id_usuario"; 
        echo "&callback=usuario.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/alte.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
// botao exclui 
        echo "<td><a href='usuario.exclui.php?"; 
        echo "id_usuario=$id_usuario"; 
        echo "&callback=usuario.lista.php'>"; 
        echo "<img border='0' alt='alt'"; 
        echo "src='../layout/img/excl.ico'"; 
        echo "width='20' height='20'></a><br></td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraLista 23-08-2023 08:56:42</p>"; 
Arch::endView(); 
?> 
