<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
    $nomeRelatorio = "Exemplar ordenado por CDE"; // nome relatorio
    $linxpage       = 60;           // linhas por pagina
    $id_centro      = Arch::requestOrCookie("id_centro");
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
        $qtdlin = criaPagina($nomeRelatorio, $numPagina, $linxpage, $id_centro);
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

    function criaPagina($nomeRelatorio, $numPagina, $linxpage, $id_centro) {
        $relatorio = new Relatorio();
        $margem     = str_repeat(" ", 8);
        $brancos    = str_repeat(" ", 96);
        $tracejado  = str_repeat("-", 96);
        if ($numPagina > 0) {
	        echo "<P style='page-break-before: always'>";
        }
        $inicio = $numPagina * $linxpage; // paginacao
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

        $tamcol=array('8','30','16','10','3','3'); // tam.colunas
        $titcol=array('CDE','Título','Autor','Espírito','Vol','Ex');
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

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
        $rs = $relatorio->executa_query($sql); // PDO
        $pag = $numPagina + 1;
        $hoje = date("d-m-Y");
        echo "<br><br>";
        echo "$margem";                 // titulo do cabecalho
        echo $nomeRelatorio . " - $hoje - Página $pag<br><br>";
        echo "$margem";                 // titulos
        for($i=0; $i<sizeof($titcol); $i++){
            $aux = $titcol[$i] . $brancos;
            $col = substr($aux, 0, $tamcol[$i]);
            echo "$col  ";
        }
        echo "Estante";
        echo "<br>";
        echo "$margem";
        echo $tracejado;
        echo "<br>";
        $qtlin = 0;                     // linhas
        while ($reg = $rs->fetch()){ // PDO
            $qtlin++;
            echo "$margem";
            for($i=0; $i<sizeof($tamcol); $i++){ // colunas
                $aux = $reg[$i] . $brancos;
                $col = substr($aux, 0, $tamcol[$i]);
                echo "$col  ";
            }
            $sqlcde = 
            "SELECT cod_estante
            FROM estante
            WHERE '$reg[0]' BETWEEN cde_inicial AND cde_final
            AND estante.id_centro = $id_centro;";
            $rscde = $relatorio->executa_query($sqlcde); // PDO
            while ($regcde = $rscde->fetch()){ // PDO
                echo $regcde[0] . " ";
            }
            echo "<br>";
        }
        return $qtlin;                  // qtd linhas impressas
    }
    Arch::endView(); 
?>
