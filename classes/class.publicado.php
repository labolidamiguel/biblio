<?php

class Publicado {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq){
        $sql = "
        SELECT 
            id_publicado, 
            publicado.cod_cde, 
            nome_titulo
        FROM publicado ";
        if (strlen($pesq) > 0) {
            $sql = $sql . " WHERE (publicado.cod_cde LIKE '%$pesq%' 
            OR nome_titulo LIKE '%$pesq%') ";
        }
        $sql = $sql . "ORDER BY publicado.cod_cde;";

        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) 
        FROM publicado ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "WHERE (publicado.cod_cde LIKE '%$pesq%'
            OR nome_titulo LIKE '%$pesq%');";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_publicado){
        $sql = "SELECT * FROM publicado WHERE id_publicado = $id_publicado;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    
    function valida($id_publicado, $cod_cde, $nome_titulo) {
        $msg = "";
        if (strlen($cod_cde) == 0) {
            $msg = $msg . "<p class=texred>* CDE deve ser preenchido</p>";
        }
        if (strlen($nome_titulo) == 0) {
            $msg = $msg . "<p class=texred>* T&iacute;tulo deve ser preenchido</p>";
        }
        if (strlen($cod_cde) > 7
        &&  is_numeric($cod_cde[0]) 
        &&  is_numeric($cod_cde[1])
        &&  $cod_cde[2] == "."
        &&  is_numeric($cod_cde[3])
        &&  is_numeric($cod_cde[4])
        &&  $cod_cde[5] == "."
        &&  is_numeric($cod_cde[6])
        &&  is_numeric($cod_cde[7])) {      // correct
        }else{
            $msg = $msg . "<p class=texred>* CDE inválido. Deve ser formado como nn.nn.nn</p>"; 
        }
        if (self::existe($id_publicado, $titulo) > 0) {
            $msg = $msg . "<p class=texred>* Título já existe</p>"; 
        } 
        return $msg;               
    }

    function existe($id_publicado, $nome_titulo) {
        $sql = "SELECT COUNT(ALL) FROM publicado WHERE nome_titulo = '$nome_titulo' AND id_publicado <> '$id_publicado';";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function insert($cod_cde, $nome_titulo) {
        $sql = "INSERT INTO publicado (id_publicado, cod_cde, nome_titulo) VALUES (NULL, '$cod_cde', '$nome_titulo');";
        return $this->$pdo->query($sql); // PDO
    }

    function update($id_publicado, $cod_cde, $nome_titulo){
        $sql = "UPDATE publicado SET cod_cde = '$cod_cde', nome_titulo = '$nome_titulo' WHERE id_publicado = $id_publicado;";
        return $this->$pdo->query($sql); // PDO
    }
    
    function delete($id_publicado){
        $sql = "DELETE FROM publicado WHERE id_publicado = $id_publicado;";
        return $this->$pdo->query($sql); // PDO
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo=null;               // PDO
        exibe(__CLASS__ . ": pdo = null"); //DEBUG
        error_reporting (E_ALL);
    }
}
?>
