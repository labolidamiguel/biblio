<?php
include "../common/arch.php";
include "../classes/class.usuario.php";
include "../classes/class.centro.php";

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

            $Usuario = new Usuario();
            $amountAffectedRows = $Usuario->changePassword($senha_new1,$senha_old,$id_centro,$id_usuario,$nome);

            Arch::logg("TROCA_SENHA:amountAffectedRows=".$amountAffectedRows);
            if ( $amountAffectedRows>0 ) {
                $message = "Senha trocada corretamente!";
            }else{
                $message = "Erro ao trocar de senha. Provavelmente a senha antiga seja incorreta.";
            }
        }
    }
Arch::initView(TRUE);
?>
    <p class="appTitle2">Propiedades do usuário</p>
    <br><br>

    <p class="appTitle3">Configuração do usuário</p>
    <table>
    <tr><td> Nome:       </td> <td> <b> <?php echo Arch::session("nome");       ?> </b> </td>
    <tr><td> perfis:     </td> <td> <b> <?php echo Arch::session("perfis");     ?> </b> </td>
    <tr><td> id_centro:  </td> <td> <b> <?php echo Arch::session("id_centro");  ?> </b> </td>
    <tr><td> id_usuario: </td> <td> <b> <?php echo Arch::session("id_usuario"); ?> </b> </td>
    <table>
    <br><br>

    <?php if ( strpos(ARCH::session("perfis"),"9")>0 ) {  /* IF ROOT */  ?>
    <p class="appTitle3">Troca de centro</p> <br>
    <form action="logged.settings.chsess.php" method="POST">
        <select name='centro'>
            <?php 
                $centro=new Centro();
                $rs = $centro->select_all();
                while($reg = $rs->fetch()){ // PDO
                    $id=$reg["id_centro"];$name=$reg["nome"];$sg=$reg["sigla"];
                    echo "<option value='$id'>$id $sg $name</option>";
                }
            ?>
        </select>
        <input type="submit" name="submit" value="Troca temporária de centro">
    </form>
    <?php } ?>
    <br><br><br>

    <?php if (Arch::session("nome") != "demo") { ?>
    <p class="appTitle3">Troca de senha</p>
    <i><font color="#990000"><?php echo $message; ?></font></i>
    <form action="" method="POST">
        <br> Digite a senha antiga:   <br> <input type="password" name="senha_old">  <br>
        <br> Digite a senha nova      <br> <input type="password" name="senha_new1"> <br>
        <br> Redigite a senha nova    <br> <input type="password" name="senha_new2"> <br>
        <br> <input type="submit" name="submit" value="Trocar de senha">
    </form>
    <?php } ?>

    <?php Arch::endView(); 
?>
