<?php                   // usuario.dominio.php 
// criado por GeraDominio em 23-08-2023 08:56:42
include "../common/arch.php"; 
include "../common/funcoes.php"; 
include "../classes/class.app.php"; 
include "../classes/class.usuario.php";

Arch::initController("lista"); 
    $id_centro  = Arch::session("id_centro"); 
    $pesq       = Arch::get("pesq"); 
    $callback   = Arch::get("callback"); 
// instancia classe(s) 
    $usuario = new Usuario(); 
    $count = $usuario->getCount($id_centro, $pesq); 
// obtem registros 
    $rs = $usuario->select($id_centro, $pesq); 

Arch::initView(TRUE); 
    $space5     = str_repeat("&nbsp", 5); 
    $space10    = str_repeat("&nbsp", 10); 
    echo "<p class=appTitle2>Usuario</p>"; 
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
    echo "<th align='left'>Id usuario</th>"; 
    echo "<th align='left'>Nome</th>"; 
    echo "<th align='left'>Perfis</th>"; 
    echo "<th align='left'>Senha</th>"; 
    echo "<th align='left'>Telefone</th>"; 
    echo "<th align='left'>Email</th>"; 
    echo "</tr>"; 
    echo "</thead>"; 
// para cada linha 
    while ($reg = $rs->fetch() ){ 
        $id_usuario = $reg["id_usuario"]; 
        $nome_usuario = $reg["nome_usuario"]; 
        $nome_usuario_url = urlencode($nome_usuario); 
        $perfis_usuario = $reg["perfis_usuario"]; 
        $perfis_usuario_url = urlencode($perfis_usuario); 
        $senha = $reg["senha"]; 
        $senha_url = urlencode($senha); 
        $telefone = $reg["telefone"]; 
        $telefone_url = urlencode($telefone); 
        $email = $reg["email"]; 
        $email_url = urlencode($email); 
// evento on click 
        echo "<tr onclick"; 
        echo "=window.location.href"; 
        echo "='$callback"; 
        echo "?id_usuario=$id_usuario"; 
        echo "&nome_usuario=$nome_usuario_url"; 
        echo "&perfis_usuario=$perfis_usuario_url"; 
        echo "&senha=$senha_url"; 
        echo "&telefone=$telefone_url"; 
        echo "&email=$email_url"; 
        echo "&flag_lido=lido'></a>"; 
// colunas a exibir 
        echo "<td>$id_usuario</td>"; 
        echo "<td>$nome_usuario</td>"; 
        echo "<td>$perfis_usuario</td>"; 
        echo "<td>$senha</td>"; 
        echo "<td>$telefone</td>"; 
        echo "<td>$email</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
    echo "</div>"; 
    echo "$space10 ($count itens)"; 
    echo "<p style='font-size:70%;'>GeraDominio 23-08-2023 08:56:42</p>"; 
Arch::endView(); 
?> 
