<?php                   // Publicado.dominio.php 
// criado por GeraDominio em 14-08-2023 16:55:04
    include "../common/arch.php"; 
    include "../common/funcoes.php"; 
    include "../classes/class.app.php"; 
    include "../classes/class.publicado.php"; 

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
// obtem registros 
    $publicado = new Publicado(); 
    $count = $publicado->getCount($id_centro, $pesq); 
    $rs = $publicado->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>Publicado</p>"; 
    echo "<form>"; 
    echo "<div>"; 
    botaoPesquisa($pesq); 
    echo "</div>"; 
    echo "</form>"; 
// monta lista na tabela html 
    echo "<div class='tableFixHead'>"; 
    echo "<table>"; 
    echo "<thead>"; 
    echo "<tr class='blue'>"; 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Cod CDE</th>"; 
    echo "<th align='left'>Nome Titulo</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// para cada linha 
    while ($reg = $rs->fetch() ){ 
        $id_publicado = $reg["id_publicado"]; 
        $cod_cde = $reg["cod_cde"]; 
        $nome_titulo = $reg["nome_titulo"]; 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_publicado=$id_publicado"; 
        echo "&cod_cde=urlencode($cod_cde)"; 
        echo "&nome_titulo=urlencode($nome_titulo)"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$id_publicado</td>"; 
        echo "<td>$cod_cde</td>"; 
        echo "<td>$nome_titulo</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 

Arch::endView(); 
?> 
