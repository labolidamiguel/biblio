<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.usuario.php";

Arch::initController("usuario");
    $id_centro  = Arch::session("id_centro");
    $pesq       = Arch::requestOrCookie("pesq");
    Arch::deleteCookie("id_usuario");
    Arch::deleteCookie("nome");
    Arch::deleteCookie("perfis");
    Arch::deleteCookie("senha");

    $usuario = new Usuario();

    $count = $usuario->getCount($id_centro, $pesq);
    $rs = $usuario->select($id_centro, $pesq);

Arch::initView(TRUE);
    $space5 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $space10 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
?>
    <p class=appTitle2>Usu&aacute;rio</p>
    <form>
    <div>
        <input type="text" value="<?php echo $pesq ?>" name="pesq" id="pesq" class="inputh">
        <a href="?pesq="><img src="../layout/img/limp.ico" width="22" height="22" class="butimg"></a> <!-- reset -->
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="image" src="../layout/img/pesq.ico" alt="Submit" width="22" height="22" class="butimg">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cria
        <a href='usuario.cria.php?callback=usuario.lista.php'><img border='0' class='butimg'; alt='alt' src='../layout/img/cria.ico' style='width: 26px; margin-left:-2px; margin-bottom:1px;'></a>
    </div>
    </form>

<?php
    echo "<div class='tableFixHead'>";  // header fixo
    echo "<table>";
    echo "<thead>";
    echo "<tr class=\"blue\">";
    echo "<th align='left'>Nome</th>";
    echo "<th align='left'>Perfis</th>";
    echo "<th align='left' colspan=2></td>";
    echo "</tr>";
    echo "</thead>";
    while($reg = $rs->fetch()){         // PDO
        $id_usuario = $reg["id_usuario"];
        $nome      = $reg["nome"];
        $perfis    = $reg["perfis"];
        echo "<td>" . $nome . "</td>";
        echo "<td>" . $perfis . "</td>";
        echo "<td><a href='usuario.altera.php?id_usuario=$id_usuario'><img border='0' alt='alt' src='../layout/img/alte.ico' width='20' height='20'></a><br></td>";
        echo "<td><a href='usuario.exclui.php?id_usuario=$id_usuario&nome=$nome&perfis=$perfis'><img border='0' alt='excl' src='../layout/img/excl.ico' width='20' height='20'></a><br></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";//NOPAG
    echo "$space10 ($count itens)";//NOPAG

Arch::endView();
?>
