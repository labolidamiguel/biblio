<?php
    $linxpage   = 60;           // linhas por pagina
    $id_centro  = Arch::requestOrCookie("id_centro");
    $qtlin      = 0;
    $numPagina  = 0;
    $margem     = str_repeat(" ", 8);
    $brancos    = str_repeat(" ", 96);
    $tracejado  = str_repeat("-", 96);
?>
