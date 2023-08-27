<?php                   // autor.dominio.php 
// criado por GeraDominio em 20-08-2023 14:57:47
include "../common/arch.php"; 
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.autor.php";

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
// instancia classe(s) 
    $autor = new Autor(); 
    $count = $autor->getCount($id_centro, $pesq); 
// obtem registros 
    $rs = $autor->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>Autor</p>"; 
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
    echo "<th align='left'>Inic</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// para cada linha 
    while ($reg = $rs->fetch() ){ 
        $id_autor = $reg["id_autor"]; 
        $nome_autor = $reg["nome_autor"]; 
        $nome_autor_url = urlencode($nome_autor); 
        $iniciais = $reg["iniciais"]; 
        $iniciais_url = urlencode($iniciais); 
// evento on click 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_autor=$id_autor"; 
        echo "&nome_autor=$nome_autor_url"; 
        echo "&iniciais=$iniciais_url"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$id_autor</td>"; 
        echo "<td>$nome_autor</td>"; 
        echo "<td>$iniciais</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraDominio 20-08-2023 14:57:47</p>"; 
Arch::endView(); 
?> 
