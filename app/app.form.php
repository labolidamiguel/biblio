<?php                   // app.form.php 
// criado por GeraForm em 21-08-2023 13:55:10
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>App</p>"; 

    echo "<p class=labelx>Id: $id_app</p>"; 

    echo "<p class=labelx>Codigo</p>"; 
    echo "<input type='text' name='codigo' "; 
    echo "class='inputx' value='$codigo'/>"; 

    echo "<p class=labelx>Titulo</p>"; 
    echo "<input type='text' name='titulo' "; 
    echo "class='inputx' value='$titulo'/>"; 

    echo "<p class=labelx>Imagem</p>"; 
    echo "<input type='text' name='imagem' "; 
    echo "class='inputx' value='$imagem'/>"; 

    echo "<p class=labelx>Perfil</p>"; 
    echo "<input type='text' name='perfil_app' "; 
    echo "class='inputx' value='$perfil_app'/>"; 

    echo "<p class=labelx>URL</p>"; 
    echo "<input type='text' name='url' "; 
    echo "class='inputx' value='$url'/>"; 

    echo "<p class=labelx>Ordem</p>"; 
    echo "<input type='text' name='ordem' "; 
    echo "class='inputx' value='$ordem'/>"; 

    echo "<br><b>$msg</b><br>"; 
?> 
