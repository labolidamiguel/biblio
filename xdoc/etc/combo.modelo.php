    echo "<select name='perfis' class='inputx'>"; 
    echo "<option value='1'";
    if (strcasecmp($perfis, '1') == 0)
        echo " selected";
    echo ">1 Básio</option>";

    echo "<option value='135'";
    if (strcasecmp($perfis, '135') == 0)
        echo " selected";
    echo ">135 Bibliotecário</option>";

    echo "</select>"; 