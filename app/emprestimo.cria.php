<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.exemplar.php";
include "../classes/class.emprestimo.php";
include "../classes/class.prateleira.php";
include "../classes/class.auditoria.php";

Arch::initController("emprestimo");
    $id_centro    = Arch::session("id_centro");
    $id_leitor    = Arch::requestOrCookie("id_leitor");
    $nome_leitor  = Arch::requestOrCookie("nome_leitor");
    $id_titulo    = Arch::requestOrCookie("id_titulo");
    $nome_titulo  = Arch::requestOrCookie("nome_titulo");
    $id_exemplar  = Arch::requestOrCookie("id_exemplar");
    $nro_exemplar = Arch::requestOrCookie("nro_exemplar");
    $situacao     = Arch::requestOrCookie("situacao");
    $action       = Arch::requestOrCookie("action");
    $msg          = Arch::requestOrCookie("msg");

//    Arch::deleteCookie("nome_leitor");
    Arch::deleteCookie("celular");
    Arch::deleteCookie("email");
    Arch::deleteCookie("endereco");
    Arch::deleteCookie("cep");
    Arch::deleteCookie("notas");
    Arch::deleteCookie("flag_lido");

    $id_exemplar_previo = $id_exemplar;
    $rs = 0;
    $reg = 0;

    $emprestimo = new Emprestimo();
    $exemplar = new Exemplar();
    $prateleira = new Prateleira();
    $audit = new Auditoria();

    if ($action=="valida") {
        $msg = $emprestimo->valida(
        $id_centro, $nome_leitor, $nome_titulo, $id_exemplar);
        if (strlen($msg) == 0) {
            $rs = $exemplar->selectId(
                $id_centro, $id_exemplar);
            $reg = $rs->fetch();        // PDO
            $action = "decide";         // force
        }
    }

    if ($action=="ok") {
        $err = $emprestimo->insert(
            $id_centro, $id_leitor, $id_exemplar);
        if (strlen($err) > 0) {
            $msg="<p class=texred>Problemas ".$err."</p>";
        }else{
            $msg="<p class=texgreen>* Emprestimo criado</p>";
            $audit->report("Cria $id_centro, $id_leitor, $id_exemplar, $nome_leitor, $nome_titulo, $nro_exemplar");
        }
    }
    if ($action == "ok" 
    ||  $action == "cancel") {
        Arch::deleteAllCookies();
    }
    
Arch::initView(TRUE);
    if (strlen($action) == 0
    ||  $action == "valida") {
        echo "<p class=appTitle2>Empr�stimo</p>";

        echo "<p class=labelx>Leitor</p>";
        echo "<input type='text' name='nome_leitor' class='inputx' value='$nome_leitor' style='width: 260px' readonly/>";
        echo "<a href='leitor.dominio.php?callback=emprestimo.cria.php&search='><img border='0' alt='alt' src='../layout/img/alte.ico' width='26' height='26' style='margin-left:6px; margin-bottom:-6px;'></a><br>";

        echo "<p class=labelx>T&iacute;tulo</p>";
        echo "<input type='text' name='nome_titulo' class='inputx' value='".$nome_titulo."' style='width: 260px' readonly/>";
        echo "<a href='titulo.dominio.php?callback=emprestimo.cria.php&search='><img border='0' alt='alt' src='../layout/img/alte.ico' width='26' height='26' style='margin-left:6px; margin-bottom:-6px;'></a><br>";

        echo "<p class=labelx>Exemplar</p>";
        echo "<input type='text' name='nro_exemplar' class='inputx' value='".$nro_exemplar."' style='width: 260px' readonly/>";
        echo "<a href='exemplar.dominio.php?callback=emprestimo.cria.php&id_titulo=".$id_titulo."&nome_titulo=".$nome_titulo."'><img border='0' alt='alt' src='../layout/img/alte.ico' width='26' height='26' style='margin-left:6px; margin-bottom:-6px;'></a><br>";

        echo $msg;                      // mensagens de erro
        echo "<br>";
        echo "<a href='emprestimo.cria.php?action=valida'><button class=butbase id='empresta'>Empresta</button></a>";
    }

    if ($action == "decide") {
        echo "<p>Verifique se o exemplar est� dispon�vel";
        echo "<br>";
        echo "<table class='tableraw'>";
        echo "<tr><td>CDE</td><td>".$reg["cod_cde"]."</td></tr>";
        echo "<tr><td>Iniciais do Autor</td><td>".$reg["iniciais"]."</td></tr>";
        echo "<tr><td>Sigla do T�tulo</td><td>".$reg["sigla"]."</td></tr>";
        echo "<tr><td>N�mero de volume</td><td>".$reg["nro_volume"]."</td></tr>";
        echo "<tr><td>N�mero de exemplar</td><td>".$reg["nro_exemplar"]."</td></tr>";
        $cod_prateleira = $prateleira->getPrateleira($id_centro, $reg["cod_cde"]);
        echo "<tr><td>Prateleira(s)</td><td>".$cod_prateleira."</td></tr>";
        echo "</table>";
        echo "<p>Verifique se os dados s�o corretos</p>";
        echo "<table class='tableraw'>";
        echo "<tr><td>Leitor</td><td>".$nome_leitor."</td></tr>";
        echo "<tr><td>T�tulo</td><td>".$nome_titulo."</td></tr>";
        echo "<tr><td>Exemplar</td><td>".$nro_exemplar."</td></tr>";
        echo "</table>";

        echo "<a href='emprestimo.cria.php?action=ok'><button class=butbase id='empresta'>Ok</button></a>";

        echo "<a href='emprestimo.cria.php?action=cancel'><button class=butbase id='empresta'>Cancela</button></a>";
    }
    if ($action=="ok") {
        echo "<p class='texgreen'> Opera��o bem sucedida</p>";
    }

    if ($action=="cancel") {
        echo "<p class='texred'> Opera��o cancelada</p>";
    }

    echo "<br><br>";
Arch::endView();
?>
