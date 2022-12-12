<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.usuario.php";
include "../classes/class.auditoria.php";
include "../classes/class.message.php";

Arch::initController();
    $nome       = Arch::post("nome");
    $senha      = Arch::post("senha");
    $id_usuario = "";
    $perfis     = "";
    $message    = "";

    if (strlen($nome)>1 || strlen($senha)>1) {                       // POST
        $usuario = new Usuario();                                    // class
        $senha = hash('sha1', $senha );                              // SHA1-CRYPTOGRAPHY-ALGORITHM
        
        $rs = $usuario->login( $nome, $senha );                
        $count=0;

        while($reg = $rs->fetch()){     // PDO
            $id_usuario = $reg["id_usuario"];
            $perfis     = $reg["perfis"];    
            $id_centro  = $reg["id_centro"]; 
            $siglacentro= $reg["sigla"]; 
            $count++;
        }
        if ($count==0) {
            $message="Usuario ou senha incorreto!";
        }
        if ( $count==1){                // security validation
            $_SESSION["nome"]       = $nome;
            $_SESSION["perfis"]     = $perfis;
            $_SESSION["id_centro"]  = $id_centro;
            $_SESSION["siglacentro"]= $siglacentro;
            $_SESSION["id_usuario"] = $id_usuario;
            Arch::logg("[login.web.php] debug login=ok session.nome=".$nome );
            Arch::logg("[login.web.php] debug login=ok session.perfis=".$perfis );
            Arch::logg("[login.web.php] debug login=ok session.id_centro=".$id_centro );
            Arch::logg("[login.web.php] debug login=ok session.id_usuario=".$id_usuario );
            $audit = new Auditoria();
            $audit->report("Login");
            header("Location: main.web.php"); // OK Redirect to the app
        }
        if ($count>1) {   // Mais de um registro.
            $message="Problemas de autenticacao. Contate o administrador. Causa: Duplicidade de usuario.";
        }

    }

Arch::initView();
    
?>
    <div style="justify-content:center; display:flex;">  
        <!-- padding top right bottom left -->
        <div style="text-align:left; width:300px; background-color:#EEE; padding:0px 18px 0px 24px; border: 1px solid #ccc; box-shadow: 0px 0px 5px 5px #eee;">
        <form action="login.web.php" method="POST">
            <p style='font-size:24px; font-weight: bold;'>Login</p>

            Usuario: <br>
            <input type="text" name="nome" value="" class="inputx"> 
            <br><br>

            Senha: <br>
            <input type="password" name="senha" value="" class="inputx"> 
            <br>

            <center>
            <b><?php echo $message ?><b> <br>
            <input type="submit" name="ok" value="OK" class="butbase">
            </center>
        </form>
        </div>
    </div>

<?php
    arch::endView(); 
?>