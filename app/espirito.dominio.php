<?php                   // espirito.dominio.php 
// criado por GeraDominio em 20-08-2023 15:26:21
include "../common/arch.php"; 
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.espirito.php";

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
// instancia classe(s) 
    $espirito = new Espirito(); 
    $count = $espirito->getCount($id_centro, $pesq); 
// obtem registros 
    $rs = $espirito->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>Espirito</p>"; 
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
        $id_espirito = $reg["id_espirito"]; 
        $nome_espirito = $reg["nome_espirito"]; 
        $nome_espirito_url = urlencode($nome_espirito); 
// evento on click 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_espirito=$id_espirito"; 
        echo "&nome_espirito=$nome_espirito_url"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$id_espirito</td>"; 
        echo "<td>$nome_espirito</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraDominio 20-08-2023 15:26:21</p>"; 
Arch::endView(); 
?> 
