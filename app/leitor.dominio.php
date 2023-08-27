<?php                   // leitor.dominio.php 
// criado por GeraDominio em 23-08-2023 10:03:43
include "../common/arch.php"; 
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.leitor.php";

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
// instancia classe(s) 
    $leitor = new Leitor(); 
    $count = $leitor->getCount($id_centro, $pesq); 
// obtem registros 
    $rs = $leitor->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>Leitor</p>"; 
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
    echo "<th align='left'>Cel</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// para cada linha 
    while ($reg = $rs->fetch() ){ 
        $id_leitor = $reg["id_leitor"]; 
        $nome_leitor = $reg["nome_leitor"]; 
        $nome_leitor_url = urlencode($nome_leitor); 
        $celular = $reg["celular"]; 
        $celular_url = urlencode($celular); 
// evento on click 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_leitor=$id_leitor"; 
        echo "&nome_leitor=$nome_leitor_url"; 
        echo "&celular=$celular_url"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$id_leitor</td>"; 
        echo "<td>$nome_leitor</td>"; 
        echo "<td>$celular</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraDominio 23-08-2023 10:03:43</p>"; 
Arch::endView(); 
?> 
