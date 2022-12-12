<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.centro.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("centro");
    $action     = Arch::get("action");
    $flag_lido  = Arch::requestOrCookie("flag_lido");
    $id_centro  = Arch::requestOrCookie("id_centro");
    $nome       = Arch::requestOrCookie("nome");
    $sigla      = Arch::requestOrCookie("sigla");
    $telefone   = Arch::requestOrCookie("telefone");
    $endereco   = Arch::requestOrCookie("endereco");
    $cidade     = Arch::requestOrCookie("cidade");
    $estado     = Arch::requestOrCookie("estado");
    $cep        = Arch::requestOrCookie("cep");

    $msg = "";
    $Centro = new Centro();
    
    if (strlen($flag_lido) == 0) {           // 1a vez Select from dB
        setcookie("flag_lido", "ja lido");
        $rs  = $Centro->selectId($id_centro); 
//        $reg = $rs->fetchArray();
        $reg = $rs->fetch();            // PDO
        $nome       = $reg["nome"];
        $sigla      = $reg["sigla"];
        $telefone   = $reg["telefone"];
        $endereco   = $reg["endereco"];
        $cidade     = $reg["cidade"];
        $estado     = $reg["estado"];
        $cep        = $reg["cep"];
    }

    if ($action == 'grava') {
        $msg = $Centro->valida($id_centro, $nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep);
        if (strlen($msg) == 0) {
            $audit = new Auditoria();
            $message = $Centro->update($id_centro, $nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Centro alterado</p>";
                $audit->report("Altera $id_centro, $nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep");
            }
        Arch::deleteAllCookies();
        }
    }
    
Arch::initView(TRUE);
include "./centro.form.php";

        if (! strpos($msg, "alterado")) {  // omite botao altera
            echo "<button type='submit' class='butbase' name='action' value='grava'>Altera</button>";
        }
        ?>
        <input type='hidden' name='id_centro' value='<?php echo $id_centro?>'/>
        <button type='submit' class='butbase' formaction='centro.lista.php'>Volta</button>
    </form>
<?php 
Arch::endView(); 
?>