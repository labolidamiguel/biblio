<?php
    include "../common/arch.php";
    include "../common/funcoes.php";
    include "../classes/class.app.php";
    include "../classes/class.cde.php";
    include "../classes/class.publicado.php";
    include "../classes/class.titulo.php";

Arch::initController("buscacde");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::get("pesq");
    $callback   = Arch::requestOrCookie("callback");
    $iaba       = Arch::requestOrCookie("iaba");
    $cde1       = Arch::requestOrCookie("cde1");
    $id_cde     = Arch::requestOrCookie("id_cde");

    $aba = array();                     // estilo das abas

    $cde = new Cde();
    $publicado = new Publicado();
    $titulo = new Titulo();

    if (strlen($iaba) == 0) $iaba = 0;
    if ($iaba == 0) {
        $cde1 = "";
        Arch::deleteCookie("cde1");
        $pesq = "";
        Arch::deleteCookie("pesq");
    }

Arch::initView(TRUE);
    $space5 = str_repeat("&nbsp;", 5); 
    $space10 = str_repeat("&nbsp;", 10); 
?>
<style>
#abas {     /* tabs */
    font-size: 0;
}
.aba_off {
    background-color: #DDD; /* #CEF; */
    border-style: solid;
    border-color: #000 #000 #000 #000;
    border-radius: 8px 8px 0px 0px;
    border-width: 1px;
    font-size: 14;
}
.aba_on {
    background-color: #FFF;
    border-style: solid;
    border-color: #000 #000 #FFF #000;
    border-radius: 8px 8px 0px 0px;
    border-width: 1px;
    font-size: 14;
}

</style>
<?php
    echo "<form>";
    echo "<p class=appTitle2>Busca CDE</p>";
    if ($iaba > 1) {                    // exibe pesquisa
        echo "<input type='hidden' name='callback' value='$callback'  id='callback' class='callback'>";
        echo "<input type='text' name='pesq' value='$pesq' id='pesq' class='inputh'>&nbsp;";
        echo "<a href='?pesq='><img src='../layout/img/limp.ico' width='22' height='22' class='butimg'></a> 
        &nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<input type='image' src='../layout/img/pesq.ico' alt='Submit' width='22' height='22' class='butimg'>";
    } else                              // oculta pesquisa
        echo "<input type='image' src='../layout/img/bran.ico' height='29' class='butimg'>";
    echo "</form>";

    $aba[0] = $aba[1] = $aba[2] = $aba[3] = "aba_off";
    $aba[$iaba] = "aba_on";
    echo "<div id='abas'>
    <a href='?iaba=0'><button class='$aba[0]'>Classif.CDE</button></a>
    <a href='?iaba=1'><button class='$aba[1]'>Classes</button></a>
    <a href='?iaba=2&page=0'><button class='$aba[2]'>Public.FEB</button></a>
    <a href='?iaba=3&page=0'><button class='$aba[3]'>Cadastrado</button></a>";
    echo "</div>";

    switch ($iaba) {                    // dependendo da aba selecionada
    case 0:                             // classificacao CDE
        $rscde = $cde->selectClasificacao($id_centro);
        echo "<table class='table striped'>";
        while ($reg = $rscde->fetch()){ // PDO
            $id_cde = $reg["id_cde"];
            $cod_cde = $reg["cod_cde"];
            $cde1 = $reg["cde1"];
            $classif = $reg["clas_cde"];
            echo "<tr onclick=window.location.href='?id_cde=$id_cde&cde1=$cde1&iaba=1'></a>";
            echo "<td>$cod_cde</td>";
            echo "<td>$classif</td>";
            echo "</tr>";
        }
        echo "</table>";
        break;
    case 1:                             // classes
        $count = $cde->getCountClasse($id_centro, $pesq, $cde1);
        if (strlen($page) == 0) {$page = 0; } // prevent select error
        if ($page >= $count) {$page = 0; }  // adjust after pesq        
        $rscla = $cde->selectClasse($id_centro, $pesq, $cde1, $page, $linxpage);
        if ($count == 0) {
            echo "<br><p class=texred>* selecione Classif.CDE</p>";
            break;
        }
        echo "<div style='height:55%; overflow-y: scroll;'>"; //NOPAG
        echo "<table class='table striped'>";
        while ($reg = $rscla->fetch()){ // PDO
            $id_cde = $reg["id_cde"];
            $cod_cde = $reg["cod_cde"];
            $classe = $reg["clas_cde"];
            echo "<tr onclick=window.location.href='$callback?id_cde=$id_cde&cod_cde=$cod_cde&step=&action='></a>";
            echo "<td>$cod_cde</td>";
            echo "<td>$classe</td>";
            echo "</tr>";
        }
        echo "</table></div>";
        echo "</div>";//NOPAG
        echo "$space10 ($count itens)";//NOPAG
        break;
    case 2:                             // publicado pela FEB
        $count = $publicado->getCount($id_centro, $pesq);
        $rsfeb = $publicado->select($id_centro, $pesq);
        echo "<div style='height:55%; overflow-y: scroll;'>"; //NOPAG
        echo "<table class='table striped'>";
        while ($reg = $rsfeb->fetch()){ // PDO
            $id_publicado = $reg["id_publicado"];
            $id_cde         = $reg["id_cde"];
            $cod_cde        = $reg["cod_cde"];
            $nome_titulo    = $reg["nome_titulo"];
            echo "<tr onclick=window.location.href='$callback?id_cde=$id_cde&cod_cde=$cod_cde&step=&action='></a>";
            echo "<td>$cod_cde</td>";
            echo "<td>$nome_titulo</td>";
            echo "</tr>";
        }
        echo "</table></div>";
        echo "</div>";//NOPAG
        echo "$space10 ($count itens)";//NOPAG
        break;
    case 3:                             // cadastrados
        $count = $titulo->getCount($id_centro, $pesq);
        $rstit = $titulo->select($id_centro, $pesq, $page, $linxpage);
        echo "<div style='height:55%; overflow-y: scroll;'>"; //NOPAG
        echo "<table class='table striped'>";
        while ($reg = $rstit->fetch()){ // PDO
            $id_cde = $reg["id_cde"];
            $cod_cde = $reg["cod_cde"];
            $nome_titulo = $reg["nome_titulo"];
            echo "<tr onclick=window.location.href='$callback?id_cde=$id_cde&cod_cde=$cod_cde'></a>";
            echo "<td>" . $reg["cod_cde"] . "</td>";
            echo "<td>" . $reg["nome_titulo"] . "</td>";
            echo "</tr>";
        }
        echo "</table></div>";
        echo "</div>";//NOPAG
        echo "$space10 ($count itens)";//NOPAG
        break;
    default: break;
    }
Arch::endView();
?>
