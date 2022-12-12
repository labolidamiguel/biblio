<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.centro.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("centro");

    $id_centro  = Arch::session("id_centro");
    $action     = Arch::get("action");
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
        
    if ($action == 'grava') {
        $msg = $Centro->valida($id_centro, $nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep);

        if ( strlen($msg)==0) {
            $audit = new Auditoria();
            $message = $Centro->insert($nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep);
            if ($message->code<0) {
                $msg="<p class=texred>Problemas ".$message->description."</p>";
            }else{
                $msg="<p class=texgreen>* Centro criado</p>";
                $audit->report("Cria $nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep");
            }
        }
    }
    
Arch::initView(TRUE);
include "./centro.form.php";
        
        if (! strpos($msg, "criado")) {  // omite botao cria
            echo "<button type='submit' name='action' value='grava' class='butbase'>Cria</button>";
        }
        ?>
        <input type='hidden' name='id_centro' value='<?php echo $id_centro?>'/>

        <button type='submit' class='butbase' formaction='centro.lista.php'>Volta</button>
    </form>

<?php Arch::endView(); 
?>