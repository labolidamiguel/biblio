<?php

class App {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo"); //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($pesq) {
        $sql = "SELECT * FROM app ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "WHERE codigo like '%".$pesq."%' ";
        }
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    
    function getCount($pesq) {
        $sql = "select count(*) from app ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "WHERE codigo like '%".$pesq."%' ";
        }
        $sql = $sql.";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_app) {
        $sql = "SELECT * from app 
                WHERE id_app = $id_app;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function integridade($id_app) {
        return "";
    }

    function existe($id_app, $codigo) {
        if (strlen($id_app) == 0) {$id_app = 0;}
        $sql = "SELECT COUNT(ALL) 
                FROM app 
                WHERE codigo = '$codigo' 
                AND id_app <> $id_app;";// ele mesmo
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function valida(
        $id_app, $codigo, 
        $titulo, $imagem, $perfil_app, $url, $ordem) {
        $msg = "";
        if (strlen($codigo) == 0) {
            $msg = $msg . "<p class=texred>
            * Código deve ser preenchido</p>";
        }
        if (strlen($titulo) == 0) {
            $msg = $msg . "<p class=texred>
            * Título deve ser preenchido</p>";
        }
        if (strlen($imagem) == 0) {
            $msg = $msg . "<p class=texred>
            * Imagem deve ser preenchida</p>";
        }
        if (strlen($perfil_app) == 0) {
            $msg = $msg . "<p class=texred>
            * Perfil deve ser preenchido</p>";
        }else
        if (strlen($perfil_app) != 1) {
            $msg = $msg . "<p class=texred>
            * Perfil deve ter 1 caracter numérico 
            ($perfil)</p>";
        }else
        if ($perfil_app < "0" || $perfil_app > "9") {
            $msg = $msg . "<p class=texred>
            * Perfil deve ser de 0 a 9</p>";
        }
        if (strlen($url) == 0) {
            $msg = $msg . "<p class=texred>
            * URL deve ser preenchido</p>";
        }
        if (strlen($ordem) == 0) {
            $msg = $msg . "<p class=texred>
            * Ordem deve ser preenchido</p>";
        }
        // duplicidade de codigo
        if (self::existe($id_app, $codigo) > 0) {
            $msg = $msg . "<p class=texred>
            * Código já existe</p>"; 
        }
        return $msg;                
    }

    function insert(
        $id_app, $codigo, 
        $titulo, $imagem, $perfil_app, $url, $ordem) {
        $sql = "INSERT INTO app VALUES (
                NULL, '$codigo', '$titulo', '$imagem',
                '$perfil_app', '$url', '$ordem');";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function update(
        $id_app, $codigo, $titulo, $imagem, 
        $perfil_app, $url, $ordem){
        $sql = "UPDATE app SET 
            codigo = '$codigo', 
            titulo = '$titulo', 
            imagem = '$imagem', 
            perfil_app = '$perfil_app', 
            url = '$url', 
            ordem = '$ordem' 
            WHERE id_app = $id_app;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }
    
    function delete($id_app){
        $sql = "DELETE FROM app WHERE id_app = $id_app;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function select_group_perfil_app() {
        $sql = "SELECT * FROM app 
                GROUP BY perfil_app;";
        return $this->$pdo->query($sql); // PDO
    }

    function select_all() {
        $sql = "SELECT * FROM app 
                ORDER BY ordem;";
        return $this->$pdo->query($sql); // PDO
    }

    function select_id($id_app) {
        $sql = "SELECT * FROM app 
                WHERE id_app = $id_app 
                ORDER BY ordem;";
        return $this->$pdo->query($sql); // PDO
    }

    function select_codigo($codigo) {
        $sql = "select * from app 
                WHERE codigo = '$codigo' 
                ORDER BY ordem;";
        return $this->$pdo->query($sql); // PDO
    }

    function select_titulo($titulo) {
        $sql = "SELECT * FROM app 
                WHERE titulo = '$titulo' 
                ORDER BY ordem;";
        return $this->$pdo->query($sql); // PDO
    }

    function select_titulos_por_perfil_app($perfil_app) {
        $sql = "SELECT titulo FROM app 
                WHERE perfil_app = '$perfil_app';";
        return $this->$pdo->query($sql); // PDO
    }

    function select_perfil_app($perfil_app) {
        $sql = "select * from app 
                where perfil_app = '$perfil_app' 
                ORDER BY ordem;";
        return $this->$pdo->query($sql); // PDO
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo=null; 
        exibe(__CLASS__ . ": pdo = null"); //DEBUG
        error_reporting (E_ALL);
    }    
}
?>
