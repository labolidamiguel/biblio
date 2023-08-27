<?php                   // Prateleira.dominio.php 
// criado por GeraDominio em 17-08-2023 11:01:39
    include "../common/arch.php"; 
    include "../common/funcoes.php"; 
    include "../classes/class.app.php"; 
    include "../classes/class.prateleira.php"; 

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
    $target     = Arch::get("target"); 
    $source     = Arch::get("source"); 
// instancia classe(s) 
    $prateleira = new Prateleira(); 
    $count = $prateleira->getCount($id_centro, $pesq); 
// obtem registros 
    $rs = $prateleira->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>Prateleira</p>"; 
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
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Id</th>"; 
    echo "<th align='left'>Cod prateleira</th>"; 
    echo "<th align='left'>Cde inicial</th>"; 
    echo "<th align='left'>Cde final</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// para cada linha 
    while ($reg = $rs->fetch() ){ 
        $id_prateleira = $reg["id_prateleira"]; 
        $cod_prateleira = $reg["cod_prateleira"]; 
        $cde_inicial = $reg["cde_inicial"]; 
        $cde_final = $reg["cde_final"]; 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_prateleira=$id_prateleira"; 
        echo "&$target=$source"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$id_centro</td>"; 
        echo "<td>$id_prateleira</td>"; 
        echo "<td>$cod_prateleira</td>"; 
        echo "<td>$cde_inicial</td>"; 
        echo "<td>$cde_final</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraDominio 17-08-2023 11:01:39</p>"; 
Arch::endView(); 
?> 
