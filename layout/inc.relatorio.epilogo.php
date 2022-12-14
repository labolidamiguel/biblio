<?php
    $relatorio = new Relatorio();
    $rs = $relatorio->executa_query($sql); // PDO

    echo "<div id='noprint'>";          // botoes controle
    echo "&nbsp;&nbsp;";
    echo "<button onclick='window.print()'><img src='../layout/img/impb.ico' width='22' height='22'></button>";
    echo "&nbsp;&nbsp;";
    echo "<button onclick='window.history.back()'><img src='../layout/img/excl.ico' width='22' height='22'></button>";
    echo "</div>";
    echo "<pre>";                       // inicial

    while ($reg=$rs->fetch()){ // PDO
        if ($qtlin % $linxpage == 0) {  // cabecalho
            if ($qtlin > 0)
                echo "<P style='page-break-before: always'>";
            // cabeçalho
        $numPagina ++;
        $hoje = date("d-m-Y");
        echo "<br><br>";

        echo "$margem";                 // titulo do cabecalho
        echo Arch::session("siglacentro"); // instituicao
        echo "&nbsp;-&nbsp;";
        echo $nomeRelatorio . " - $hoje - Página $numPagina<br><br>";
        echo "$margem";                 // titulos de colunas
        for($i=0; $i < count($tamcol); $i++){
            $aux = $titcol[$i] . $brancos;
            $col = substr($aux, 0, $tamcol[$i]);
            echo "$col  ";
        }
        echo "<br>";
        echo "$margem";
        echo $tracejado;
        echo "<br>";

        }
        $qtlin++;
        echo "$margem";
        for($i=0; $i < count($tamcol); $i++){ // colunas
            $aux = $reg[$i] . $brancos;
            $col = substr($aux, 0, $tamcol[$i]);
            echo "$col  ";
        }
        echo "<br>";
    }

    echo "                    ($qtlin itens)";
    echo "</pre>";                      // final
    echo "<style>";
    echo "@media print { ";
    echo "    @page { margin: 0; }";
    echo "    #noprint { display:none; } ";
    echo "    body { background: #fff; }";
    echo "}";
    echo "</style>";
?>
