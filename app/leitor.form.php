<?php                   // leitor.form.php 
// criado por GeraForm em 23-08-2023 10:03:43
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Leitor</p>"; 

    echo "<p class=labelx>Id: $id_leitor</p>"; 

    echo "<p class=labelx>Nome</p>"; 
    echo "<input type='text' name='nome_leitor' "; 
    echo "class='inputx' value='$nome_leitor'/>"; 

    echo "<p class=labelx>Cel</p>"; 
    echo "<input type='text' name='celular' "; 
    echo "class='inputx' value='$celular'/>"; 

    echo "<p class=labelx>E-Mail</p>"; 
    echo "<input type='text' name='email' "; 
    echo "class='inputx' value='$email'/>"; 

    echo "<p class=labelx>Endereço</p>"; 
    echo "<input type='text' name='endereco' "; 
    echo "class='inputx' value='$endereco'/>"; 

    echo "<p class=labelx>CEP</p>"; 
    echo "<input type='text' name='cep' "; 
    echo "class='inputx' value='$cep'/>"; 

    echo "<p class=labelx>Notas</p>"; 
    echo "<input type='text' name='notas' "; 
    echo "class='inputx' value='$notas'/>"; 

    echo "<br><b>$msg</b><br>"; 
?> 
