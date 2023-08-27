<?php                   // editora.dominio.php 
// criado por GeraDominio em 20-08-2023 15:26:49
include "../common/arch.php"; 
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.editora.php";

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
// instancia classe(s) 
    $editora = new Editora(); 
    $count = $editora->getCount($id_centro, $pesq); 
// obtem registros 
    $rs = $editora->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>Editora</p>"; 
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
    echo "<th align='left'>Nome</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// para cada linha 
    while ($reg = $rs->fetch() ){ 
        $id_editora = $reg["id_editora"]; 
        $nome_editora = $reg["nome_editora"]; 
        $nome_editora_url = urlencode($nome_editora); 
// evento on click 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_editora=$id_editora"; 
        echo "&nome_editora=$nome_editora_url"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$id_editora</td>"; 
        echo "<td>$nome_editora</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraDominio 20-08-2023 15:26:49</p>"; 
Arch::endView(); 
?> 
