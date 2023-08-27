<?php                   // cde.dominio.php 
// criado por GeraDominio em 19-08-2023 11:37:40
include "../common/arch.php"; 
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.cde.php";

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
// instancia classe(s) 
    $cde = new Cde(); 
    $count = $cde->getCount($id_centro, $pesq); 
// obtem registros 
    $rs = $cde->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>Cde</p>"; 
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
    echo "<th align='left'>C&oacute;digo CDE</th>"; 
    echo "<th align='left'>Classe</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// para cada linha 
    while ($reg = $rs->fetch() ){ 
        $id_cde = $reg["id_cde"]; 
        $cod_cde = $reg["cod_cde"]; 
        $clas_cde = $reg["clas_cde"]; 
// evento on click 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_cde=$id_cde"; 
        echo "&cod_cde=urlencode($cod_cde)"; 
        echo "&clas_cde=urlencode($clas_cde)"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$id_cde</td>"; 
        echo "<td>$cod_cde</td>"; 
        echo "<td>$clas_cde</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraDominio 19-08-2023 11:37:40</p>"; 
Arch::endView(); 
?> 
