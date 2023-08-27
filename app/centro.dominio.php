<?php                   // centro.dominio.php 
// criado por GeraDominio em 22-08-2023 09:30:01
include "../common/arch.php"; 
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.centro.php";

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
// instancia classe(s) 
    $centro = new Centro(); 
    $count = $centro->getCount($id_centro, $pesq); 
// obtem registros 
    $rs = $centro->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>Centro</p>"; 
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
    echo "<th align='left'>Nome</th>"; 
    echo "<th align='left'>Sigla</th>"; 
    echo "<th align='left'>Telefone</th>"; 
    echo "<th align='left'>Endereco</th>"; 
    echo "<th align='left'>Cidade</th>"; 
    echo "<th align='left'>Estado</th>"; 
    echo "<th align='left'>CEP</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// para cada linha 
    while ($reg = $rs->fetch() ){ 
        $id_centro = $reg["id_centro"]; 
        $nome_centro = $reg["nome_centro"]; 
        $nome_centro_url = urlencode($nome_centro); 
        $sigla_centro = $reg["sigla_centro"]; 
        $sigla_centro_url = urlencode($sigla_centro); 
        $telefone = $reg["telefone"]; 
        $telefone_url = urlencode($telefone); 
        $endereco = $reg["endereco"]; 
        $endereco_url = urlencode($endereco); 
        $cidade = $reg["cidade"]; 
        $cidade_url = urlencode($cidade); 
        $estado = $reg["estado"]; 
        $estado_url = urlencode($estado); 
        $cep = $reg["cep"]; 
        $cep_url = urlencode($cep); 
// evento on click 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_centro=$id_centro"; 
        echo "&nome_centro=$nome_centro_url"; 
        echo "&sigla_centro=$sigla_centro_url"; 
        echo "&telefone=$telefone_url"; 
        echo "&endereco=$endereco_url"; 
        echo "&cidade=$cidade_url"; 
        echo "&estado=$estado_url"; 
        echo "&cep=$cep_url"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$nome_centro</td>"; 
        echo "<td>$sigla_centro</td>"; 
        echo "<td>$telefone</td>"; 
        echo "<td>$endereco</td>"; 
        echo "<td>$cidade</td>"; 
        echo "<td>$estado</td>"; 
        echo "<td>$cep</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraDominio 22-08-2023 09:30:01</p>"; 
Arch::endView(); 
?> 
