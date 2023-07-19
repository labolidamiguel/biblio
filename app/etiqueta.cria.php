<?php                               // etiqueta.cria.php
include "../common/arch.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";
include "../common/funcoes.php";
$arrIds = array();

Arch::initController("etiqueta");
    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
    $etiq           = Arch::get("etiq");
    $ids            = Arch::get("ids");
    $msg = "";

    $exemplar = new Exemplar();

    if ($action == "cria") {
        $msg = $ids;                    // mantem ids
//echo $etiq . "<br>";     // DEBUG 998-1040
        switch ($etiq) {
        case "A424":
            $targ = "etiqueta.rel.a424.php";
            break;
        case "A430":
            $targ = "etiqueta.rel.a430.php";
            break;
        case "ades":
            $targ = "etiqueta.rel.ades.php";
            break;
        }
//echo $targ . "<br>";     // DEBUG 

        $arrIds = $exemplar->parseEtiquetas($ids);
//$msg = "<p class=texred>deu ruim</p>";  // DEBUG

            $target = "$targ?callback=etiqueta.cria.php&selecao=$ids";
            $action = "ok";
    	    header("Location: $target"); 
    }

Arch::initView(TRUE);
    $GLOBALS['$arrIds'];
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<form>";
    echo "<p class=appTitle2>Etiquetas</p>";

    echo "<p>Informar o tipo de etiqueta<br>";

    echo "<input type='radio' id='A424' name='etiq' value='A424' checked>";
    echo "<label for='A424'>A4 24 etiquetas</label><br>";

    echo "<input type='radio' id='A430' name='etiq' value='A430'>";
    echo "<label for='A430'>A4 30 etiquetas</label><br>";

    echo "<input type='radio' id='ades' name='etiq' value='ades'>";
    echo "<label for='ades'>carta 30 etiquetas adesivas<br>&nbsp;&nbsp;&nbsp;(Ref Pimaco 6080, 6180 ou 6280)</label>";

    echo "<p>Informar os id dos exemplares.<br>";
    echo "Exemplo: 1 2 5-17 22<br>";
    echo "ou: 1, 2, 5-17, 22</p>";
    echo "<textarea id='ids' name='ids' rows='4' cols='50'>";
    echo $ids;
    echo "</textarea>";

    echo "<br>";
    echo $msg;
    echo "<br>";

    for ($d = 0; $d < count($arrIds); $d ++) { // DEBUG
        echo $arrIds[$d] . " ";             // DEBUG
    }
    echo "<br><br>";
    echo "<button type='submit' name='action' value='cria'";
    echo "class='butbase'>Cria</button>";
    echo "<button type='submit' class='butbase' ";
    echo "formaction='main.web.php'>Volta</button>";
    echo "</form>";

    echo "</div>";//NOPAG

    function valida() {
        $msg = "";
        $msg = $msg . "<p class=texred> * inválido</p>";
        return $msg;
    }
Arch::endView();
?>
