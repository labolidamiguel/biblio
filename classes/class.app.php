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

    function selectId($id_app){
        $sql = "select * from app where id_app = $id_app;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function existe($id_app, $codigo) {
        if (strlen($id_app) == 0) {$id_app = 0;}
        $sql = "SELECT COUNT(ALL) FROM app WHERE codigo = '$codigo' AND id_app <> $id_app;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function valida($id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem) {
        $msg = "";
        if (strlen($codigo) == 0) {
            $msg = $msg . "<p class=texred>* Código deve ser preenchido</p>";
        }
        if (strlen($titulo) == 0) {
            $msg = $msg . "<p class=texred>* Título deve ser preenchido</p>";
        }
        if (strlen($imagem) == 0) {
            $msg = $msg . "<p class=texred>* Imagem deve ser preenchida</p>";
        }
        if (strlen($perfil) == 0) {
            $msg = $msg . "<p class=texred>* Perfil deve ser preenchido</p>";
        }else
        if (strlen($perfil) != 1) {
            $msg = $msg . "<p class=texred>* Perfil deve ter 1 caracter numérico</p>";
        }else
        if ($perfil < "0" || $perfil > "9") {
            $msg = $msg . "<p class=texred>* Perfil deve ser de 0 a 9</p>";
        }
        if (strlen($url) == 0) {
            $msg = $msg . "<p class=texred>* URL deve ser preenchido</p>";
        }
        if (strlen($ordem) == 0) {
            $msg = $msg . "<p class=texred>* Ordem deve ser preenchido</p>";
        }
        if (self::existe($id_app, $codigo) > 0) {
            $msg = $msg . "<p class=texred>* Código já existe</p>"; 
        }
        return $msg;                
    }

    function insert($codigo, $titulo, $imagem, $perfil, $url, $ordem) {
        $sql = "INSERT INTO app VALUES (NULL, '$codigo', '$titulo', '$imagem', '$perfil', '$url', '$ordem');";
        return $this->$pdo->query($sql); // PDO
    }

    function update($id_app, $codigo, $titulo, $imagem, $perfil, $url, $ordem){
        $sql = "UPDATE app SET codigo = '$codigo', titulo = '$titulo', imagem = '$imagem', perfil = '$perfil', url = '$url', ordem = '$ordem' WHERE id_app = $id_app;";
        return $this->$pdo->query($sql); // PDO
    }
    
    function delete($id_app){
        $sql = "DELETE FROM app WHERE id_app = $id_app;";
        return $this->$pdo->query($sql); // PDO
    }

    function select_group_perfil() {
        $sql = "SELECT * FROM app GROUP BY perfil;";
        return $this->$pdo->query($sql); // PDO
    }
    
    function select_all() {
        $sql = "select * from app order by ordem";
        return $this->$pdo->query($sql); // PDO
    }

    function select_id($id_app) {
        $sql = "select * from app where id_app = $id_app order by ordem";
        return $this->$pdo->query($sql); // PDO
    }

    function select_codigo($codigo) {
        $sql = "select * from app where codigo = '$codigo' order by ordem";
        return $this->$pdo->query($sql); // PDO
    }

    function select_titulo($titulo) {
        $sql = "select * from app where titulo = '$titulo' order by ordem";
        return $this->$pdo->query($sql); // PDO
    }

    function select_perfil($perfil) {
        $sql = "select * from app where perfil = '$perfil' order by ordem";
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
