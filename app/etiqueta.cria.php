<?php                               // etiqueta.cria.php
include "../common/arch.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";
include "../common/funcoes.php";

Arch::initController("etiqueta");
    $id_centro      = Arch::session("id_centro");
    $action         = Arch::get("action");
    $etiq           = Arch::get("etiq");
    $ids            = Arch::get("ids");
    $msg = "";

    if ($action == "cria")
        $msg = valida($ids);
    if (($action == "cria")
    and (strlen($msg) == 0)) {
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

        $target = "$targ?callback=etiqueta.cria.php&selecao=$ids";
    	header("Location: $target"); 
    }

Arch::initView(TRUE);
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
    echo "<textarea id='ids' name='ids' rows='4' cols='40'>";
    echo $ids;
    echo "</textarea>";

    echo "<br>";
    echo $msg;
    echo "<br>";

    echo "<br><br>";
    echo "<button type='submit' name='action' value='cria'";
    echo "class='butbase'>Cria</button>";
    echo "<button type='submit' class='butbase' ";
    echo "formaction='main.web.php'>Volta</button>";
    echo "</form>";

    echo "</div>";//NOPAG

    function valida($ids) {
        $arrIds = array();
        $exemplar = new Exemplar();
        if (strlen($ids) == 0) {
            return "<p class=texred> * id vazio</p>";
        }
        $arrIds = $exemplar->parseEtiquetas($ids);
        for ($d = 0; $d < count($arrIds); $d ++) { // is_num
            if (! is_numeric($arrIds[$d])) {
                return "<p class=texred> * id inválido:  '$arrIds[$d]'</p>";
            }
        }
        return "";
    }
Arch::endView();
?>
