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


    function select($id_centro, $pesq) {
        $sql = "SELECT * FROM usuario 
        WHERE id_centro = $id_centro ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND nome like '%$pesq%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    
    function getCount($id_centro, $pesq) {
        $sql = "select count(*) from usuario 
        WHERE id_centro = $id_centro ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND nome like '%$pesq%' ";
        }
        $sql = $sql.";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId( $id_centro , $id_usuario ) {
        $sql = "SELECT id_centro,id_usuario,nome,perfis,senha,telefone,email 
                FROM   usuario 
                WHERE  id_centro = $id_centro 
                AND    id_usuario = $id_usuario " ;
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function existe($id_usuario, $nome) {
        if (strlen($id_usuario) == 0) {$id_usuario = 0;} // safe
        $sql = "SELECT COUNT(ALL) FROM usuario WHERE nome = '$nome' 
        AND id_usuario <> $id_usuario;"; // ele mesmo quando altera
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }
/*
    function existeWhereNome($nome) {
        $sql = "SELECT COUNT(ALL) FROM usuario WHERE nome='$nome'";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }
*/

    // Gera um novo usuario admin para um centro.
    function createAdmin( $idcentro ){
        $nomeUsuario = "admin_".$idcentro;
        $senha = hash('sha1', "123" );
        $perfis = "01357";
        $r = $this->insert($idcentro, $nomeUsuario, $perfis, $senha);
        if ( strpos($r,"ERROR")==0) {
            return "Usuario administrador gerado corretamente para o centro.
            Anote: usuario:$nomeUsuario e senha:123";
        }else{
            return "Error: Problemas na geracao do usuario para o centro.";
        }
    }

    function insert($id_centro, $nome, $perfis, $senha, $telefone, $email) {
        $sql = "INSERT INTO usuario (id_centro, id_usuario, nome, perfis, senha, telefone, email) 
            VALUES ($id_centro, NULL, '$nome', '$perfis', '$senha', '$telefone', '$email');";
        $rs = $this->$pdo->query($sql); // PDO
    }

    function update($id_centro, $id_usuario, $nome, $perfis, $senha, $telefone, $email){
        $sql = "UPDATE usuario SET nome = '$nome', perfis = '$perfis', senha = '$senha', telefone = '$telefone', email = '$email' 
            WHERE id_centro = $id_centro AND id_usuario = $id_usuario;";
        $rs = $this->$pdo->query($sql); // PDO
    }
    function update2(       // sem password
        $id_centro, $id_usuario, $nome, $perfis, $telefone, $email){
        $sql = "UPDATE usuario 
        SET nome = '$nome', perfis = '$perfis', telefone = '$telefone', email = '$email' 
        WHERE id_centro = $id_centro AND id_usuario = $id_usuario;";
        $rs = $this->$pdo->query($sql); // PDO
    }

    function delete($id_centro, $id_usuario){
        $sql = "DELETE FROM usuario WHERE id_centro = $id_centro AND id_usuario = $id_usuario;";
        $rs = $this->$pdo->query($sql); // PDO
    }

    function getPerfis($username, $senha, $id_centro) {
        $sql = "select perfis
                from   usuario 
                where  nome='$username' 
                and    senha='$senha'
                and    id_centro='$id_centro'
                ";
        
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO

        if (strlen($reg[0]) == 0) {
            $perfis=-1;            // not found (-1)
            Arch::logg("Login error - Perfis not found :" . $sql );
        }else{
            $perfis = $reg[0];
            Arch::logg("Login success OK  Perfis:" . $perfis );
        }
        return $perfis;
    }
    
    function valida($id_usuario, $nome, $perfis, $senha, $telefone, $email) {
        $msg = "";
        if (strlen($nome) == 0) {
            $msg = $msg . "<p class=texred>* Nome deve ser preenchido</p>";
        }
        if (strlen($perfis) == 0) {
            $msg = $msg . "<p class=texred>* Perfis deve ser preenchido</p>";
        }

        if (strlen($telefone) == 0) {
            $msg = $msg . "<p class=texred>* Telefone deve ser preenchido</p>";
        }
        if (strlen($email) == 0) {
            $msg = $msg . "<p class=texred>* email deve ser preenchido</p>";
        }

        if (self::existe($id_usuario, $nome) > 0) {
            $msg = $msg . "<p class=texred>* Nome já existe</p>"; 
        }
        $msg = self::validaSenha($senha);
        return $msg;
    }

    function valida2(   // sem password
        $id_usuario, $nome, $perfis, $telefone, $email) {
        $msg = "";
        if (strlen($nome) == 0) {
            $msg = $msg . "<p class=texred>* Nome deve ser preenchido</p>";
        }
        if (strlen($perfis) == 0) {
            $msg = $msg . "<p class=texred>* Perfis deve ser preenchido</p>";
        }

        if (strlen($telefone) == 0) {
            $msg = $msg . "<p class=texred>* Telefone deve ser preenchido</p>";
        }
        if (strlen($email) == 0) {
            $msg = $msg . "<p class=texred>* email deve ser preenchido</p>";
        }

        if (self::existe($id_usuario, $nome) > 0) {
            $msg = $msg . "<p class=texred>* Nome já existe</p>"; 
        }
        return $msg;
    }


    function validaSenha($senha) {
        $msg = "";
        if (strlen($senha) == 0) {  // Senha obrigatoria
            $msg = $msg . "<p class=texred>* Senha deve ser preenchida</p>";
        }
        if (strlen($senha) < 6) {  // Senha 6 char minimo
            $msg = $msg . "<p class=texred>* Senha deve possuir no mínimo 6 caracteres</p>";
        }
        return $msg;
    }


    /* ESPECIFICO LOGIN -- O 'NOME' É um UniqueIdentific  */
    function login( $nome , $senha ) {
        $sql = "SELECT usuario.id_centro, id_usuario, 
                    usuario.nome, perfis, senha,
                    centro.sigla
                FROM   usuario 
                LEFT JOIN centro on centro.id_centro = usuario.id_centro
                WHERE  usuario.nome  = '$nome'
                AND    senha = '$senha'
                ";
        //Arch::logg(" sql login : " . $sql );
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    /* TROCA SENHA DO USUARIO LOGADO - File:'app/preferencia.php' */
    function changePassword( $senha_new , $senha_old , $id_centro , $id_usuario , $nome ) {
        $sql=" 
                    UPDATE usuario 
                    SET    senha='$senha_new' 
                    WHERE  id_centro='$id_centro' 
                    AND    id_usuario='$id_usuario' 
                    AND    nome='$nome'
                    AND    senha='$senha_old'
            ";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo=null;               // PDO
        exibe(__CLASS__ . ": pdo = null"); //DEBUG
        error_reporting (E_ALL);
    }
}
?>
