<?php                   // usuario.form.php 
// criado por GeraForm em 23-08-2023 08:56:42
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Usuario</p>"; 

    echo "<p class=labelx>Id usuario: $id_usuario</p>"; 

    echo "<p class=labelx>Nome</p>"; 
    echo "<input type='text' name='nome_usuario' "; 
    echo "class='inputx' value='$nome_usuario'/>"; 

// cria lista seleção e a posiciona 
    echo "<p class=labelx>Perfis</p>"; 
// select para perfis_usuario
    echo "<select name='perfis_usuario' class='inputx'>"; 
// options para perfis_usuario
    echo "<option value='1'"; 
    if (strcasecmp($perfis_usuario, '1') == 0) 
        echo " selected"; 
    echo ">1 Básico</option>"; 
    echo "<option value='13'"; 
    if (strcasecmp($perfis_usuario, '13') == 0) 
        echo " selected"; 
    echo ">13 Auxiliar</option>"; 
    echo "<option value='135'"; 
    if (strcasecmp($perfis_usuario, '135') == 0) 
        echo " selected"; 
    echo ">135 Bibliotecário</option>"; 
    echo "<option value='1357'"; 
    if (strcasecmp($perfis_usuario, '1357') == 0) 
        echo " selected"; 
    echo ">1357 Administrador</option>"; 
    echo "</select>"; 

    if (strnatcasecmp($operacao, "cria") == 0) { 
// input tipo password 
        echo "<p class=labelx>Senha</p>"; 
        echo "<input type='password' name='senha' "; 
        echo "class='inputx' value='$senha'/>"; 
    } 
    if (strnatcasecmp($operacao, "altera") == 0) { 
        echo "<input type='hidden' name='senha' "; 
        echo "class='inputx' value='$senha'/>"; 
    } 

    echo "<p class=labelx>Telefone</p>"; 
    echo "<input type='text' name='telefone' "; 
    echo "class='inputx' value='$telefone'/>"; 

    echo "<p class=labelx>Email</p>"; 
    echo "<input type='text' name='email' "; 
    echo "class='inputx' value='$email'/>"; 

    echo "<br><b>$msg</b><br>"; 
?> 
