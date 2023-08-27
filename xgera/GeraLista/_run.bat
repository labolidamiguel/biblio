set par=C:\Source\biblio\xgera\par
rem java GeraLista %par%\app_lista.par
rem type app.lista.php

    java GeraLista %par%\autor_lista.par
    type autor.lista.php

rem java GeraLista %par%\centro_lista.par
rem type centro.lista.php

 java -jar GeraLista.jar %par%\leitor_lista.par
 type leitor.lista.php

rem    java -jar GeraLista.jar %par%\usuario_lista.par
rem    type usuario.lista.php

pause
