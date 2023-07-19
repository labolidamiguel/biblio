<?php                            // etiqueta.rel.a4.php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";

Arch::initController("etiqueta");
    $id_centro  = Arch::session("id_centro");
    $inicial    = Arch::get("inicial");
    $final      = Arch::get("final");
    $arr = array(array());         // 10 etiq 7 lin x 3 cols
    $tracejado  = str_repeat("-", 90);
    zeraArr();                          // inicializa matriz

    $exemplar = new Exemplar();
    $rs = $exemplar->getEtiqueta($id_centro, $inicial, $final);

Arch::initView(TRUE, TRUE);             // suprime top header
                              
    echo "<div id='noprint'>";          // botoes controle
    echo "&nbsp;&nbsp;";
    echo "<button onclick='window.print()'><img src='../layout/img/impb.ico' width='22' height='22'></button>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<a href='etiqueta.lista.php'><img src='../layout/img/excl.ico' width='22' height='22'></a>";
    echo "</div>";
    echo "<pre>";

    while($reg = $rs->fetch()){         // PDO
        $ultCol = criaEtiq($reg);
        if ($ultCol == 0) {             // linha completa
            imprimeEtiq();
            zeraArr();
        }
    }
    if ($ultCol != 0) {                 // linha incompleta
        imprimeEtiq();
    } 
    echo "</pre>";                      // final
?>
<style>
@media print { 
    @page { margin: 0; }
    #noprint { display:none; } 
    body { background: #fff; }
} 
p { margin-top: 0;
    margin-bottom: -4px;
    letter-spacing: 1px; 
}   
pre {
    font-family: courier;
    font-size: 20px;
    font-weight: 900;
}
</style>
<?php 

    function criaEtiq($reg) {
        global $arr;
        global $tracejado;
        static $pag = 1;
        static $lin = 0;
        static $col = 0;
//        $fmt2 = "  %-10.10s   %-2.2s   %-10.10s  |";
//        $fmt3 = "  %-10.10s   %-3.3s  %-10.10s  |";
        $fmt2 = "  %-10.10s  %-2.2s  %-10.10s %s";
        $fmt3 = "  %-10.10s  %-3.3s %-10.10s %s";
        $separadorVert;
        if ($lin > 9) {                 // 10 etiq p/folha
            $lin = 0;
            $pag ++;
            echo "<p style='page-break-before: always'>";
        }
        if ($lin == 0 && $col == 0) {   // inicio da pagina
            if ($pag > 1) {             // seguintes paginas
                echo "<p>&nbsp;</p>";
            }
            echo "<p>&nbsp;</p>";
            echo "<p>  pag $pag</p><br>";
            echo "<p>$tracejado</p>";         // separacao
        }
        $separadorVert = ($col == 2) ? " " : "|";
        $arr[0][$col] = sprintf($fmt2, $reg["cent"],
            $reg["cde1"], $reg["cent"], $separadorVert);
        $arr[1][$col] = sprintf($fmt2, $reg["idex"],
            $reg["cde2"], $reg["idex"], $separadorVert);
        $arr[2][$col] = sprintf($fmt2, $reg["nom1"], 
            $reg["cde3"], $reg["nom1"], $separadorVert);
        $arr[3][$col] = sprintf($fmt2, $reg["nom2"], 
            $reg["inic"], $reg["nom2"], $separadorVert);
        $arr[4][$col] = sprintf($fmt2, $reg["tit1"], 
            $reg["sigl"], $reg["tit1"], $separadorVert);
        $arr[5][$col] = sprintf($fmt3, $reg["tit2"], 
            $reg["volu"], $reg["tit2"], $separadorVert);
        $arr[6][$col] = sprintf($fmt2, $reg["tit3"], 
            $reg["exem"], $reg["tit3"], $separadorVert);

        $col ++;
        if ($col > 2) {
            $col = 0;
            $lin ++; 
        }
        return $col;
    }

    function imprimeEtiq() {
        global $arr;
        global $tracejado;
        for ($i=0; $i<7; $i++) {
            echo "<p>"; 
            for ($j=0; $j<3; $j++) {
                echo $arr[$i][$j];
            }
            echo "</p>";
        }
        echo "<p>$tracejado</p>";         // separacao
    }

    function zeraArr() {
        global $arr;
        for ($i=0; $i<7; $i++)        // inicializa matriz
            for ($j=0; $j<3; $j++)
                $arr[$i][$j] = "";
    }

    Arch::endView(); 
?>
