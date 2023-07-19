<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.usuario.php";
include "../classes/class.centro.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("usuario");
    $action      = Arch::get("action");
    $senha_old   = Arch::post("senha_old");
    $senha_new1  = Arch::post("senha_new1");
    $senha_new2  = Arch::post("senha_new2");
    $message="";
    //123/40bd001563085fc35165329ea1ff5c5ecbdbbeef

    if ($action == "altera") {
echo "altera";
echo "altera";
echo "altera";
echo "altera";
    }
/*
    if ( strlen($senha_old)>0 && strlen($senha_new1)>0  ) {
        $message="Trocando a senha...";

        if ( $senha_new1!=$senha_new2) {
            $message="Senha nova diferente da confirmação da senha nova.";
        }else{
            $message="Trocando a senha...";
            $senha_old  = hash('sha1', $senha_old  );
            $senha_new1 = hash('sha1', $senha_new1 );
            $senha_new2 = hash('sha1', $senha_new2 );
            $nome       = Arch::session("nome");
            $perfis     = Arch::session("perfis");
            $id_centro  = Arch::session("id_centro");
            $id_usuario = Arch::session("id_usuario");

            $usuario = new Usuario();
            $message = $usuario->changePassword($senha_new1,$senha_old,$id_centro,$id_usuario,$nome);
            Arch::logg("MUDA_SENHA:amountAffectedRows=".$message->code);
            if ( $message->code>0 ) {
                $audit = new Auditoria();
                $message = "Senha trocada corretamente!";
                $audit->report("Altera $id_centro, $id_usuario, $nome");
            }else{
                $message = "Erro ao trocar de senha. Provavelmente a senha antiga seja incorreta." . $message->description;
            }
        }
    }
*/
Arch::initView(TRUE);
    $id_centro = Arch::session("id_centro");
    $sigla = Arch::session("siglacentro");
    $centro = new Centro($id_centro);
    $rs = $centro->selectId($id_centro);
    $reg = $rs->fetch();                // PDO
    $nome_centro = $reg["nome"];

    echo "<p class='appTitle2'>Muda Senha</p><br>";

    if (Arch::session("nome") != "demo") { 
        echo "<p class=texred><?php echo $message;?></p>";
        echo "<form action='' method='POST'>";
        echo "<p class=labelx>Senha atual</p>";
        echo "<input type='password' name='senha_old' 
            class='inputx'>";
        echo "<p class=labelx>Nova senha</p>";
        echo "<input type='password' name='senha_new1' 
            class='inputx'>";
        echo "<p class=labelx>Confirma nova senha</p>";
        echo "<input type='password' name='senha_new2' 
            class='inputx'> ";
        echo "<br><br>";
        echo "<input type='submit' name='action'  
            class='butbase' value='altera'>";
        echo "<button type='submit' class='butbase' 
            formaction='usuario.lista.php'>Volta</button>";
        echo "</form>";
     }
Arch::endView(); 
?>
