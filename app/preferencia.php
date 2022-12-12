<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.usuario.php";
include "../classes/class.centro.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController("@");

    $senha_old   = Arch::post("senha_old");
    $senha_new1  = Arch::post("senha_new1");
    $senha_new2  = Arch::post("senha_new2");
    $message="";
    //123/40bd001563085fc35165329ea1ff5c5ecbdbbeef
    if ( strlen($senha_old)>0 && strlen($senha_new1)>0  ) {
        $message="Trocando a senha...";

        if ( $senha_new1!=$senha_new2) {
            $message="A senha nova deve coincidir com a redigitacao da senha nova.";
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
            Arch::logg("TROCA_SENHA:amountAffectedRows=".$message->code);
            if ( $message->code>0 ) {
                $audit = new Auditoria();
                $message = "Senha trocada corretamente!";
                $audit->report("Altera $id_centro, $id_usuario, $nome");
            }else{
                $message = "Erro ao trocar de senha. Provavelmente a senha antiga seja incorreta." . $message->description;
            }
        }
    }
Arch::initView(TRUE);
    $id_centro = Arch::session("id_centro");
    $sigla = Arch::session("siglacentro");
    $centro = new Centro($id_centro);
    $rs = $centro->selectId($id_centro);
    $reg = $rs->fetch();                // PDO
    $nome_centro = $reg["nome"];
?>
    <p class="appTitle2">Preferências</p>

    <table class='tableraw'>
    <tr><td>Centro</td><td><?php echo $nome_centro;?></td></tr>
    <tr><td>Sigla </td><td><?php echo $sigla;?></td></tr>
    <tr><td>Usuário</td><td><?php echo Arch::session("nome");?></td>
    <tr><td>Perfis </td><td><?php echo Arch::session("perfis");?></td>
    <table>
    <br>

    <?php if ( strpos(ARCH::session("perfis"),"9")>0 ) {  /* IF ROOT */  ?>
    <p class="appTitle3">Troca de centro</p> <br>
    <form action="preferencia.chsess.php" method="POST">
        <select name='centro'>
            <?php 
                $rs = $centro->select_all();
//                while($reg = $rs->fetchArray()){ 
                while($reg = $rs->fetch()){ // PDO
                    $id=$reg["id_centro"];$name=$reg["nome"];$sg=$reg["sigla"];
                    echo "<option value='$id'>$id $sg $name</option>";
                }
            ?>
        </select>
        <br><br>
        <input type="submit" name="submit" value="Troca temporária" class="butlist">
    </form>
    <?php } ?>
    <br><br>

    <?php if (Arch::session("nome") != "demo") { ?>
    <p class="appTitle3">Troca de senha</p>
    <p class=texred><?php echo $message;?></p>
    <form action="" method="POST">
    <p class=labelx>Senha atual</p>
    <input type="password" name="senha_old" class='inputx'>
    <p class=labelx>Nova senha</p>
    <input type="password" name="senha_new1" class='inputx'>
    <p class=labelx>Confirma nova senha</p>
    <input type="password" name="senha_new2" class='inputx'> 
    <br><br>
    <input type="submit" name="submit" value="Trocar de senha" class="butlist">
    </form>
    <?php } ?>

    <?php Arch::endView(); 
?>
