<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");    // tipo de aplicacao
    $linxpage       = 60;           // linhas por pagina
    $id_centro      = Arch::session("id_centro");
    $id_relatorio   = Arch::requestOrCookie("id_relatorio");
    $action         = Arch::requestOrCookie("action");

    $relatorio = new Relatorio();

    $qtdColunas = $relatorio->numColumns();
    $rs = $relatorio->selectId($id_centro, $id_relatorio);
    $reg        = $rs->fetch();         // PDO
    $nome       = $reg["nome"];
    $tamanhos   = $reg["tamanhos"];
    $consulta   = $reg["consulta"];
    if (strpos($consulta, "IDCENTRO") > 0) {
        $consulta = str_replace("IDCENTRO", $id_centro, $consulta);
    }
echo $nome . " " . $tamanhos . " " . $consulta; // DEBUG
    $tamanho    = explode(" ", $tamanhos);
    $nomeColuna = "nao sei";//getNomeColuna($consulta);
    $qtdTotal = 0;
    $numPagina = 0;

Arch::initView(TRUE, TRUE);             // suprime top header
                                        // botoes controle
    echo "<div id='noprint'>";
    echo "&nbsp;&nbsp;";
    echo "<button onclick='window.print()'><img src='../layout/img/impb.ico' width='22' height='22'></button>";
    echo "&nbsp;&nbsp;";
    echo "<button onclick='window.history.back()'><img src='../layout/img/excl.ico' width='22' height='22'></button>";
    echo "</div>";
    echo "<pre>";
    for ($numPagina = 0; ; $numPagina++) {
        $qtdlin = criaPagina($consulta, $numPagina);
        $qtdTotal = $qtdTotal + $qtdlin;
        if ($qtdlin < $linxpage) break;
    }
    echo "                    ($qtdTotal itens)";
    echo "</pre>";                      // final
?>
<style>
@media print { 
    @page { margin: 0; }
    #noprint { display:none; } 
    body { background: #fff; }
}
</style>
<?php 

    function criaPagina($consulta) {
        global $nome, $tamanho, $qtdColunas, $nomeColuna, $linxpage, $numPagina;
        $margem     = str_repeat(" ", 8);
        $brancos    = str_repeat(" ", 120);
        $tracejado  = str_repeat("-", 120);
        if ($numPagina > 0) {
	        echo "<P style='page-break-before: always'>";
        }
        $inicio = $numPagina * $linxpage; //   C A B E C A L H O
        $sql = 
        "SELECT 
            titulo.id_titulo, 
            titulo.nome_titulo, 
            titulo.sigla, 
            autor.nome, 
            espirito.nome, 
            cde.cod_cde, 
            titulo.nro_volume
        FROM titulo 
        left join autor on titulo.id_autor = autor.id_autor 
        left join espirito on titulo.id_espirito = espirito.id_espirito 
        left join cde on titulo.id_cde = cde.id_cde 
        WHERE titulo.id_centro = $id_centro
        LIMIT $inicio, $linxpage;";

        $rs = $relatorio->exec_query($sql); // PDO
        $pag = $numPagina + 1;
        $hoje = date("d-m-Y");
        echo "<br><br>";
        echo "$margem";
        echo "$nome - $hoje - Página $pag<br>";
        echo "<br>";
        echo "$margem";
        for ($i = 0; $i < $qtdColunas; $i++) { // nome colunas
            $aux = $nomeColuna[$i] . $brancos;
            $col = substr($aux, 0, $tamanho[$i]);
            echo "$col  ";
        }
        echo "<br>";
        echo "$margem";
        for ($i = 0; $i < $qtdColunas; $i++) { // tracejadoO            
            $col = substr($tracejado, 0, $tamanho[$i]);
            echo "$col  ";
        }
        echo "<br>";
        
        $qtlin = 0;                     //   L I N H A S
        while ($reg=$rs->fetch()){ // PDO
            $qtlin++;
            echo "$margem";
            for ($i=0; $i < $qtdColunas; $i++) {
                $aux = $reg[$i] . $brancos;
                $col = substr($aux, 0, $tamanho[$i]);
                echo "$col  ";
            }
            echo "<br>";
        }
        return $qtlin;                  // qtd linhas impressas
    }
    Arch::endView(); 
?>
