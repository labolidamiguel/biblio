<?php                              // prateleira.form.php
    echo "<p class=appTitle2>Prateleira</p>";
    echo "<form method='get'>";
    echo "<p class=labelx>Prateleira</p>";
    echo "<input type='text' name='cod_prateleira' value='$cod_prateleira' class='inputx'/>";

    echo "<p class=labelx>CDE inicial</p>";
    echo "<input type='text' name='cde_inicial' class='inputx' value='$cde_inicial' readonly/>";
    echo "<input type='submit' name='action' value='i' class='buthidelist' style='background-image: url(../layout/img/alte2.ico); background-repeat:no-repeat; background-size:26px 26px;'>";

    echo "<p class=labelx>CDE final</p>";
    echo "<input type='text' name='cde_final' class='inputx' value='$cde_final' readonly/>";
    echo "<input type='submit' name='action' value='f' class='buthidelist' style='background-image: url(../layout/img/alte2.ico); background-repeat:no-repeat; background-size:26px 26px;'>";

    echo "<b>$msg</b><br>";             // mensagens
?>
