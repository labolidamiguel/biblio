<?php
// tradutor.dominio
// 20230320 retirada função cria
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.tradutor.php";

Arch::initController("lista");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::request("pesq");
    $callback   = Arch::requestOrCookie("callback");

    $tradutor = new Tradutor();
    $count = $tradutor->getCount($id_centro, $pesq);
    $rs = $tradutor->select($id_centro, $pesq);
    
Arch::initView(TRUE);

?>
    <p class=appTitle2>Tradutor</p>
    <form>
        <input type="hidden" value="<?php echo $callback ?>" name="callback" id="callback" class="callback">
        <input type="text" value="<?php echo $pesq ?>" name="pesq" id="pesq" class="inputh">
        <a href="?pesq="><img src="../layout/img/limp.ico" width="22" height="22" class="butimg"></a> <!-- reset -->
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="image" src="../layout/img/pesq.ico" alt="Submit" width="22" height="22" class="butimg">
<!--
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cria
        <a href='tradutor.crud.write.web.php?callback=tradutor.lista.web.php&action=cria&step=inicio'><img class='butimg'; alt='alt' src='../layout/img/cria.ico' style='width: 26px; margin-left:-2px; margin-bottom:1px;'></a>
-->
    </form>

<?php
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "</tr>";
    echo "</thead>";

    while( $reg = $rs->fetch()){        // PDO
        $nome = urlencode($reg["nome"]);
        echo "<tr onclick=window.location.href='".$callback."?id_tradutor=".$reg["id_tradutor"]."&tradutor=".$nome."'></a>";
        echo "<td>" . $reg["nome"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
