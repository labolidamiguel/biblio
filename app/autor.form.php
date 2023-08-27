<?php                   // autor.form.php 
// criado por GeraForm em 19-08-2023 11:21:53
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Autor</p>"; 

    echo "<p class=labelx>Id: $id_autor</p>"; 

    echo "<p class=labelx>Nome</p>"; 
    echo "<input type='text' name='nome_autor' "; 
    echo "class='inputx' value='$nome_autor'/>"; 

    echo "<p class=labelx>Inic</p>"; 
    echo "<input type='text' name='iniciais' "; 
    echo "class='inputx' value='$iniciais'/>"; 

    echo "<br><b>$msg</b><br>"; 
?> 
