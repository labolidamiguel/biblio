<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.usuario.php";
include "../classes/class.auditoria.php";

Arch::initController();
    $nome_usuario   = Arch::post("nome_usuario");
    $senha          = Arch::post("senha");
    $id_usuario     = "";
    $perfis_usuario = "";
    $msg            = "";

    if (strlen($nome_usuario) > 1 
    || strlen($senha) > 1) { // POST
        $usuario = new Usuario();       // class
        $senha = hash('sha1', $senha ); // CRYPTOGRAPHY-ALG.
        
        $rs = $usuario->login($nome_usuario, $senha);                
        $count=0;

        while($reg = $rs->fetch()){     // PDO
            $id_usuario     = $reg["id_usuario"];
            $perfis_usuario = $reg["perfis_usuario"];    
            $id_centro      = $reg["id_centro"]; 
            $siglacentro    = $reg["sigla"]; 
            $count++;
        }
        if ($count == 0) {
            $msg="Usuario ou senha incorreto!";
        }
        if ($count == 1){           // security validation
            $_SESSION["nome_usuario"]   = $nome_usuario;
            $_SESSION["perfis_usuario"] = $perfis_usuario;
            $_SESSION["id_centro"]  = $id_centro;
            $_SESSION["siglacentro"]= $siglacentro;
            $_SESSION["id_usuario"] = $id_usuario;
            Arch::logg(
            "[login] debug login=ok ".$nome_usuario );
            Arch::logg(
            "[login] debug login=ok ".$perfis_usuario );
            Arch::logg(
            "[login] debug login=ok ".$id_centro );
            Arch::logg(
            "[login] debug login=ok ".$id_usuario );
            $audit = new Auditoria();
            $audit->report("Login");

            header("Location: main.web.php"); // Redirect 
        }
        if ($count > 1) {   // Mais de um registro
            $msg="Erro: Duplicidade de usuario";
        }
    }

Arch::initView();
    echo "<div style='justify-content:center; ";
    echo "display:flex;'>";

    echo "<div style='text-align:left; width:300px; ";
    echo "background-color:#EEE; padding:0px 18px 0px 24px; ";
    echo "border: 1px solid #ccc;'>";

    echo "<form action='login.web.php' method='POST'>";
    echo "<p style='font-size:24px; font-weight: ";
    echo "bold;'>Login</p>";

    echo "Usuario:<br>";
    echo "<input type='text' name='nome_usuario' ";
    echo "class='inputx' value='' ><br><br>";

    echo "Senha:<br>";
    echo "<input type='password' name='senha' ";
    echo "class='inputx'  value=''><br>";

    echo "<b>$msg<b><br>";
    echo "<input type='submit' name='ok' ";
    echo "class='butbase' value='OK' >";

    echo "</form>";
    echo "</div>";
    echo "</div>";

    arch::endView();
?>
