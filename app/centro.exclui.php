<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.centro.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("centro");

    $id_centro  = Arch::get("id_centro");
    $nome       = Arch::get("nome");
    $sigla      = Arch::get("sigla");
    $telefone   = Arch::get("telefone");
    $endereco   = Arch::get("endereco");
    $cidade     = Arch::get("cidade");
    $estado     = Arch::get("estado");
    $cep        = Arch::get("cep");
    
    $action     = Arch::get("action");
    $msg = "";

    if ($action == 'confirma') {
        $Centro = new Centro();
        $audit = new Auditoria();
        $message=$Centro->delete($id_centro);
        if ( $message->code<0 ) {
            $msg="<p class=texred>* Erro na exclusão</p>" . $message->description;
        }else{
            $msg="<p class=texgreen>* Centro excluido</p>";
            $audit->report("Exclui centro $id_centro, $nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep");
        }
    }
Arch::initView(TRUE);
?>
    <p class=appTitle2>Centro Espírita</p>
    <table class='tableraw'>
        <tr><td>Nome</td><td><?php echo $nome; ?></td></tr>
        <tr><td>Sigla</td><td><?php echo $sigla; ?></td></tr>
    </table>
    <b><?php echo $msg; ?></b> <br><br>
    <?php if ($action == ""){ ?>
        <p class='texgreen'>* Confirma a exclusão?</p> <br>
        <a href='?action=confirma&id_centro=<?php echo $id_centro?>&nome=<?php echo $nome?>&sigla=<?php echo $sigla?>'><button class=butbase>Confirma</button></a>
    <?php } ?>
    <a href='centro.lista.php'><button class="butbase">Volta</button></a>

<?php Arch::endView(); 
?>