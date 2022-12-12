<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");    // tipo de aplicacao
    $linxpage       = 60;           // linhas por pagina
    $id_centro      = Arch::requestOrCookie("id_centro");
    $action         = Arch::requestOrCookie("action");
    $qtdTotal = 0;
    $numPagina = 0;

Arch::initView(TRUE, TRUE);             // suprime top header
    echo "<div id='noprint'>";          // botoes controle
    echo "&nbsp;&nbsp;";
    echo "<button onclick='window.print()'><img src='../layout/img/impb.ico' width='22' height='22'></button>";
    echo "&nbsp;&nbsp;";
    echo "<button onclick='window.history.back()'><img src='../layout/img/excl.ico' width='22' height='22'></button>";
    echo "</div>";
    echo "<pre>";                       // inicial
    for ($numPagina = 0; ; $numPagina++) {
        $qtdlin = criaPagina($numPagina, $linxpage, $id_centro);
        $qtdTotal = $qtdTotal + $qtdlin;
        if ($qtdlin < $linxpage) break;
    }
    echo "                    ($qtdTotal itens)";
    echo "</pre>";                      // final
    echo "<style>";
    echo "@media print { ";
    echo "    @page { margin: 0; }";
    echo "    #noprint { display:none; } ";
    echo "    body { background: #fff; }";
    echo "}";
    echo "</style>";

    function criaPagina($numPagina, $linxpage, $id_centro) {
        $relatorio = new Relatorio();
        $margem     = str_repeat(" ", 8);
        $brancos    = str_repeat(" ", 96);
        $tracejado  = str_repeat("-", 96);
        if ($numPagina > 0) {
	        echo "<P style='page-break-before: always'>";
        }
        $inicio = $numPagina * $linxpage; //   C A B E C A L H O
        $sql = 
        "SELECT 
            cde.cod_cde, 
            titulo.nome_titulo, 
            autor.nome, 
            espirito.nome, 
            titulo.nro_volume,
            exemplar.nro_exemplar
        FROM exemplar 
        left join titulo on exemplar.id_titulo = titulo.id_titulo 
        left join cde on titulo.id_cde = cde.id_cde 
        left join autor on titulo.id_autor = autor.id_autor 
        left join espirito on titulo.id_espirito = espirito.id_espirito 
        WHERE exemplar.id_centro = $id_centro
ORDER BY cde.cod_cde, titulo.nome_titulo, exemplar.nro_exemplar
        LIMIT $inicio, $linxpage;";

        $rs = $relatorio->executa_query($sql); // PDO
        $pag = $numPagina + 1;
        $hoje = date("d-m-Y");
        echo "<br><br>";
        echo "$margem";
        echo "Título - $hoje - Página $pag<br>";
        echo "<br>";
        echo "$margem";
//                     1         2         3
//            1234567890123456789012345678901234567890
        echo "CDE       ";
        echo "Título                              ";
        echo "Autor                 ";
        echo "Espírito            ";
        echo "Vol ";
        echo "Exemp";

        echo "<br>";
        echo "$margem";
        echo $tracejado;
        echo "<br>";
        
        $qtlin = 0;                     //   L I N H A S
        while ($reg=$rs->fetch()){ // PDO
            $qtlin++;
            echo "$margem";

            $aux = $reg[0] . $brancos; // CDE
            $col = substr($aux, 0, 8);
            echo "$col  ";

            $aux = $reg[1] . $brancos; // nome titulo
            $col = substr($aux, 0, 34);
            echo "$col  ";

            $aux = $reg[2] . $brancos; // autor
            $col = substr($aux, 0, 20);
            echo "$col  ";

            $aux = $reg[3] . $brancos; // espirito
            $col = substr($aux, 0, 20);
            echo "$col  ";

            $aux = $reg[4] . $brancos; // vol
            $col = substr($aux, 0, 2);
            echo "$col ";

            $aux = $reg[5] . $brancos; // exemplar
            $col = substr($aux, 0, 3);
            echo "$col ";

            echo "<br>";
        }
        return $qtlin;                  // qtd linhas impressas
    }
    Arch::endView(); 
?>
