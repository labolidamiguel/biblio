<?php
    echo "<form method='get'>";
    echo "<p class=appTitle2>Leitor</p>";

    echo "<p class=labelx>Nome</p>";
    echo "<input type='text' name='nome' value='" . $nome . "' class='inputx'/>";

    echo "<p class=labelx>Telefone celular</p>";
    echo "<input type='text' name='celular' value='" . $celular . "' class='inputx'/>";

    echo "<p class=labelx>e-mail</p>";
    echo "<input type='text' name='email' value='" . $email . "' class='inputx'/>";

    echo "<p class=labelx>Endere&ccedil;o</p>";
    echo "<input type='text' name='endereco' value='" . $endereco . "' class='inputx'/>";
        
    echo "<p class=labelx>CEP</p>";
    echo "<input type='text' name='cep' value='" . $cep . "' class='inputx'/>";

    echo "<p class=labelx>Notas</p>";
    echo "<input type='text' name='notas' value='" . $notas . " 'class='inputx'/>";

    echo "<br><b>" . $msg . "</b><br>"; // mensagens
?>
