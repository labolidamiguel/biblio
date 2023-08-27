<?php                   // app.dominio.php 
// criado por GeraDominio em 21-08-2023 13:55:10
include "../common/arch.php"; 
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
// instancia classe(s) 
    $app = new App(); 
    $count = $app->getCount($id_centro, $pesq); 
// obtem registros 
    $rs = $app->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>App</p>"; 
    echo "<form>"; 
    echo "<div>"; 
// texto, botão apaga e botão pesquisa 
    botaoPesquisa($pesq); 
    echo "</div>"; 
    echo "</form>"; 
// monta lista na tabela html 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
// titulos colunas 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Codigo</th>"; 
    echo "<th align='left'>Titulo</th>"; 
    echo "<th align='left'>Imagem</th>"; 
    echo "<th align='left'>Perfil</th>"; 
    echo "<th align='left'>URL</th>"; 
    echo "<th align='left'>Ordem</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// para cada linha 
    while ($reg = $rs->fetch() ){ 
        $id_app = $reg["id_app"]; 
        $codigo = $reg["codigo"]; 
        $codigo_url = urlencode($codigo); 
        $titulo = $reg["titulo"]; 
        $titulo_url = urlencode($titulo); 
        $imagem = $reg["imagem"]; 
        $imagem_url = urlencode($imagem); 
        $perfil_app = $reg["perfil_app"]; 
        $perfil_app_url = urlencode($perfil_app); 
        $url = $reg["url"]; 
        $url_url = urlencode($url); 
        $ordem = $reg["ordem"]; 
        $ordem_url = urlencode($ordem); 
// evento on click 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_app=$id_app"; 
        echo "&codigo=$codigo_url"; 
        echo "&titulo=$titulo_url"; 
        echo "&imagem=$imagem_url"; 
        echo "&perfil_app=$perfil_app_url"; 
        echo "&url=$url_url"; 
        echo "&ordem=$ordem_url"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$id_app</td>"; 
        echo "<td>$codigo</td>"; 
        echo "<td>$titulo</td>"; 
        echo "<td>$imagem</td>"; 
        echo "<td>$perfil_app</td>"; 
        echo "<td>$url</td>"; 
        echo "<td>$ordem</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraDominio 21-08-2023 13:55:10</p>"; 
Arch::endView(); 
?> 
