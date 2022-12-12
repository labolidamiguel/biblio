<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.titulo.php";

Arch::initController("lista");  // antes titulo
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::request("pesq") ;
    $callback   = Arch::requestOrCookie("callback") ;

    $titulo = new Titulo();

    $count = $titulo->getCount($id_centro, $pesq);
    $rs = $titulo->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
    <p class=appTitle2>T&iacute;tulo</p>

    <form>
    <div>
        <input type="hidden" value="<?php echo $callback ?>" name="callback" id="callback" class="callback">
        <input type="text" value="<?php echo $pesq ?>" name="pesq" id="pesq" class="inputh">
        <a href="?pesq="><img src="../layout/img/limp.ico" width="22" height="22" class="butimg"></a> <!-- reset -->
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="image" src="../layout/img/pesq.ico" alt="pesq" width="22" height="22" class="butimg">
    </div>
    </form>

<?php
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Título</th>";
    echo "</tr>";
    echo "</thead>";
    while($reg = $rs->fetch()) {        // PDO
        $tit = $reg["nome_titulo"];
        $nome_titulo = str_replace(" ","%20",$reg["nome_titulo"]);
        if ($callback == "emprestimo.cria.php") { // apaga exemplar
            echo "<tr onclick=window.location.href='$callback?id_titulo=".$reg["id_titulo"]."&nome_titulo=$nome_titulo&id_exemplar=&nro_exemplar=&msg='></a>";
        }else{
            echo "<tr onclick=window.location.href='".$callback."?id_titulo=".$reg["id_titulo"]."&nome_titulo=".$nome_titulo."'></a>";
        }
        echo "<td>" . $tit . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
