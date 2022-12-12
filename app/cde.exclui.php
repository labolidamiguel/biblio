<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.cde.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("cde");
    $id_centro  = Arch::session("id_centro");
    $id_cde     = Arch::get("id_cde");
    $cod_cde    = Arch::requestOrCookie("cod_cde");
    $classe     = Arch::requestOrCookie("classe");
    $action     = Arch::get("action");
    $msg = "";
    
    $cde = new Cde();

    $msg = $cde->integridade($id_centro, $id_cde);
    if (strlen($msg) == 0) {
        $audit = new Auditoria();
        if ($action == 'Confirma') {
            $message = $cde->delete($id_centro, $id_cde);
            if ($message->code < 0) {
                $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
            }else{
                $msg="<p class=texgreen>* Cde excluido</p>";
                $audit->report("Exclui $id_centro, $cod_cde, $classe");
            }
        }
    }

Arch::initView(TRUE);
?>
    <p class=appTitle2>Classificação Decimal Espírita</p>
    <table class='tableraw'>
        <tr><td>CDE</td><td><?php echo $cod_cde; ?></td></tr>
        <tr><td>Classe</td><td><?php echo $classe; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if (strlen($msg) == 0) { ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=Confirma&id_cde=<?php echo $id_cde;?>&classe=<?php echo $classe;?>'><button class="butbase">Confirma</button></a>
    <?php } ?>
    <a href='cde.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>