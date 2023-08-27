<?php                   // publicado.form.php 
// criado por GeraForm em 14-08-2023 16:55:05
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Publicado</p>"; 

    echo "<p class=labelx>Id: $id_publicado</p>"; 

    echo "<p class=labelx>Cod CDE</p>"; 
    echo "<input type='text' name='cod_cde' "; 
    echo "class='inputx' value='$cod_cde'/>"; 

    echo "<p class=labelx>Nome Titulo</p>"; 
    echo "<input type='text' name='nome_titulo' "; 
    echo "class='inputx' value='$nome_titulo'/>"; 

    echo "<br><b>$msg</b><br>"; 
?> 
