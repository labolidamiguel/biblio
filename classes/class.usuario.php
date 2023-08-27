<?php

class Usuario {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    // Gera um novo usuario admin para um centro.
    function createAdmin( $idcentro ){
        $nomeUsuario = "admin_".$idcentro;
        $senha = hash('sha1', "123456" );
        $perfis_usuario = "01357";
        $r = $this->insert(
            $idcentro, $nomeUsuario, $perfis_usuario, $senha);
        if ( strpos($r,"ERROR")==0) {
            return "Usuario administrador gerado
            Anote: usuario:$nomeUsuario e senha:123456";
        }else{
            return "Error: geracao do usuario para o centro";
        }
    }

    function delete($id_centro, $id_usuario){
        $sql = "DELETE FROM usuario 
                WHERE id_centro = $id_centro 
                AND id_usuario = $id_usuario;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function select($id_centro, $pesq) {
        $sql = "SELECT * FROM usuario 
                WHERE id_centro = $id_centro ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND nome_usuario 
                LIKE '%$pesq%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    
    function getCount($id_centro, $pesq) {
        $sql = "select count(*) from usuario 
        WHERE id_centro = $id_centro ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND nome_usuario like '%$pesq%' ";
        }
        $sql = $sql.";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function getPerfis($username, $senha, $id_centro) {
        $sql = "SELECT perfis_usuario
                FROM   usuario 
                WHERE  nome_usuario = '$username' 
                AND    senha = '$senha'
                AND    id_centro = '$id_centro';";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (strlen($reg[0]) == 0) {
            $perfis_usuario = -1;       // not found (-1)
            Arch::logg("error perfis_usuario not found :" . $sql );
        }else{
            $perfis_usuario = $reg[0];
            Arch::logg("Login OK  Perfis:" . $perfis_usuario);
        }
        return $perfis_usuario;
    }

    function selectId($id_centro , $id_usuario) {
        $sql = "SELECT
                id_centro,
                id_usuario,
                nome_usuario, 
                perfis_usuario,
                senha, 
                telefone,
                email 
                FROM   usuario 
                WHERE  id_centro = $id_centro 
                AND    id_usuario = $id_usuario;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function existe(
        $id_usuario, $nome_usuario) { // todos os centros
        if (strlen($id_usuario) == 0) {$id_usuario = 0;}
        $sql = "SELECT COUNT(ALL) 
                FROM usuario 
                WHERE nome_usuario = '$nome_usuario' 
                AND id_usuario <> $id_usuario;"; // ele mesmo 
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }


    function insert(
        $id_centro, $id_usuario, $nome_usuario, 
        $perfis_usuario, $senha, 
        $telefone, $email) {
        $sql = "INSERT INTO usuario (
                id_centro, 
                id_usuario, 
                nome_usuario, 
                perfis_usuario, 
                senha, 
                telefone, 
                email) 
                VALUES ($id_centro, NULL, 
                '$nome_usuario', 
                '$perfis_usuario', '$senha', 
                '$telefone', '$email');";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }


    function integridade($id_centro, $id_usuario) {
        return "";
    }

    function update( 
        $id_centro, $id_usuario, 
        $nome_usuario, 
        $perfis_usuario, $senha, $telefone, $email){
        $sql = "UPDATE usuario 
                SET 
                nome_usuario = '$nome_usuario', 
                perfis_usuario = '$perfis_usuario', 
                senha = '$senha', 
                telefone = '$telefone', 
                email = '$email' 
                WHERE id_centro = $id_centro 
                AND id_usuario = $id_usuario;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }
/*
    function update2(       // sem password
        $id_centro, $id_usuario, 
        $nome_usuario, $perfis_usuario, $telefone, $email){
        $sql = "UPDATE usuario 
                SET 
                nome_usuario = '$nome_usuario', 
                perfis_usuario = '$perfis_usuario', 
                telefone = '$telefone', 
                email = '$email' 
                WHERE id_centro = $id_centro 
                AND id_usuario = $id_usuario;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }
*/

    function valida( 
        $id_centro, $id_usuario, 
        $nome_usuario, 
        $perfis_usuario, $senha, $telefone, $email) {
        $msg = "";
        if (strlen($nome_usuario) == 0) {
            $msg = $msg . "<p class=texred>
            * Nome deve ser preenchido</p>";
        }
        if (strlen($perfis_usuario) == 0) {
            $msg = $msg . "<p class=texred>
            * Perfil deve ser preenchido</p>";
        }

        if (strlen($telefone) == 0) {
            $msg = $msg . "<p class=texred>
            * Telefone deve ser preenchido</p>";
        }
        if (strlen($email) == 0) {
            $msg = $msg . "<p class=texred>
            * email deve ser preenchido</p>";
        }
        if (self::existe($id_usuario, $nome) > 0) {
            $msg = $msg . "<p class=texred>
            * Nome já existe</p>"; 
        }
        $msg = $msg . self::validaSenha($senha);

        return $msg;
    }

    function validaSenha($senha) {
        $msg = "";
        if (strlen($senha) == 0) {  // Senha obrigatoria
            $msg = $msg . "<p class=texred>
            * Senha deve ser preenchida</p>";
        }
        if (strlen($senha) < 6) {  // Senha 6 char minimo
            $msg = $msg . "<p class=texred>
            * Senha deve ter no mínimo 6 caracteres</p>";
        }
        return $msg;
    }

    /* ESPECIFICO LOGIN -- O 'NOME' É um UniqueIdentific  */
    function login(
        $nome_usuario, $senha) {
        $sql = "SELECT 
                usuario.id_centro, 
                id_usuario, 
                nome_usuario, perfis_usuario, 
                senha,
                sigla_centro
                FROM   usuario 
                LEFT JOIN centro 
                ON centro.id_centro = usuario.id_centro
                WHERE  nome_usuario = '$nome_usuario'
                AND senha = '$senha';";
        //Arch::logg(" sql login : " . $sql );
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    /* TROCA SENHA DO USUARIO LOGADO - 
    File:'app/preferencia.php' */

    function changePassword($senha_new, $senha_old, 
        $id_centro, $id_usuario, $nome_usuario) {
        $sql = "UPDATE usuario 
                SET    senha = '$senha_new' 
                WHERE  id_centro = '$id_centro' 
                AND    id_usuario = '$id_usuario' 
                AND    nome_usuario = '$nome_usuario'
                AND    senha = '$senha_old';";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo=null;               // PDO
        exibe(__CLASS__ . ": pdo = null"); //DEBUG
        error_reporting (E_ALL);
    }
}
?>
