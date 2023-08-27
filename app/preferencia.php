<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.usuario.php";
include "../classes/class.centro.php";
include "../classes/class.auditoria.php";

Arch::initController("@");

    $senha_old   = Arch::post("senha_old");
    $senha_new1  = Arch::post("senha_new1");
    $senha_new2  = Arch::post("senha_new2");
    $msg = "";
    //123/40bd001563085fc35165329ea1ff5c5ecbdbbeef
    if (strlen($senha_old) > 0 
    &&  strlen($senha_new1) > 0  ) {
        $msg = "Trocando a senha...";

        if ( $senha_new1!=$senha_new2) {
            $msg = 
            "Nova senha diferente de Confirma nova senha";
        }else{
            $msg        = "Trocando a senha...";
            $senha_old  = hash('sha1', $senha_old  );
            $senha_new1 = hash('sha1', $senha_new1 );
            $senha_new2 = hash('sha1', $senha_new2 );
            $nome       = Arch::session("nome");
            $perfis_usuario = Arch::session("perfis_usuario");
            $id_centro  = Arch::session("id_centro");
            $id_usuario = Arch::session("id_usuario");

            $usuario = new Usuario();
            $msg = $usuario->changePassword(
                $senha_new1, $senha_old, 
                $id_centro, $id_usuario, $nome);
            Arch::logg("TROCA_SENHA:amountAffectedRows=".$msg);
            if (strlen($msg) == 0) {
                $audit = new Auditoria();
                $msg = "Senha trocada corretamente";
                $audit->report("Altera $id_centro,
                    $id_usuario, $nome");
            }else{
                $msg = "Erro ao trocar de senha. 
                    Provavel senha antiga incorreta.";
            }
        }
    }
Arch::initView(TRUE);
    $id_centro      = Arch::session("id_centro");
    $sigla_centro   = Arch::session("sigla_centro");
    $nome_usuario   = Arch::session("nome_usuario");
    $perfis_usuario = Arch::session("perfis_usuario");

    $centro = new Centro($id_centro);
    $rs = $centro->selectId($id_centro);
    $reg = $rs->fetch();                // PDO
    $nome_centro = $reg["nome_centro"];
    $sigla_centro = $reg["sigla_centro"];

    echo "<p class='appTitle2'>Preferências</p>";
    echo "<table class='tableraw'>";

    echo "<tr><td>Centro</td><td>$nome_centro</td></tr>";
    echo "<tr><td>Sigla </td><td>$sigla_centro</td></tr>";

    echo "<tr><td>Usuário</td><td>$nome_usuario</td>";
    echo "<tr><td>Perfis </td><td>$perfis_usuario</td>";
    echo "<table>";
    echo "<br>";

    if (Arch::session("nome_usuario") != "demo") { 
        echo "<p class='appTitle3'>Troca de senha</p>";
        echo "<p class=texgreen>$msg</p>";
        echo "<form action='' method='POST'>";

        echo "<p class=labelx>Senha atual</p>";
        echo "<input type='password' name='senha_old' ";
        echo "class='inputx'>";

        echo "<p class=labelx>Nova senha</p>";
        echo "<input type='password' name='senha_new1' ";
        echo "class='inputx'>";

        echo "<p class=labelx>Confirma nova senha</p>";
        echo "<input type='password' name='senha_new2' ";
        echo "class='inputx'>";
        echo "<br><br>";

        echo "<input type='submit' name='submit' ";
        echo "value='Trocar de senha' class='butlist'>";
        echo "</form>";
    }

Arch::endView(); 
?>
