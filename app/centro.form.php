<?php                   // centro.form.php 
// criado por GeraForm em 22-08-2023 09:30:01
    echo "<form method='get'>"; 
    echo "<p class=appTitle2>Centro</p>"; 

    echo "<p class=labelx>Nome</p>"; 
    echo "<input type='text' name='nome_centro' "; 
    echo "class='inputx' value='$nome_centro'/>"; 

    echo "<p class=labelx>Sigla</p>"; 
    echo "<input type='text' name='sigla_centro' "; 
    echo "class='inputx' value='$sigla_centro'/>"; 

    echo "<p class=labelx>Telefone</p>"; 
    echo "<input type='text' name='telefone' "; 
    echo "class='inputx' value='$telefone'/>"; 

    echo "<p class=labelx>Endereco</p>"; 
    echo "<input type='text' name='endereco' "; 
    echo "class='inputx' value='$endereco'/>"; 

    echo "<p class=labelx>Cidade</p>"; 
    echo "<input type='text' name='cidade' "; 
    echo "class='inputx' value='$cidade'/>"; 

    echo "<p class=labelx>Estado</p>"; 
    echo "<input type='text' name='estado' "; 
    echo "class='inputx' value='$estado'/>"; 

    echo "<p class=labelx>CEP</p>"; 
    echo "<input type='text' name='cep' "; 
    echo "class='inputx' value='$cep'/>"; 

    echo "<br><b>$msg</b><br>"; 
?> 
