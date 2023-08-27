<?php

class Espirito {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq) {
        $sql = "SELECT * FROM espirito 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_espirito LIKE '%$pesq%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) 
                FROM espirito 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_espirito LIKE '%$pesq%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_centro, $id_espirito){
        $sql = "SELECT * FROM espirito 
                WHERE id_centro = $id_centro 
                AND id_espirito = $id_espirito;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function valida($id_centro, $id_espirito, $nome) {
        $msg = "";
        if (strlen($nome) == 0) {
            $msg = $msg . "<p class=texred>
            * Nome deve ser preenchido</p>";
        }
        if (self::existe($id_centro, $id_espirito, $nome) > 0) {
            $msg = $msg . "<p class=texred>
            * Nome j&aacute; existe</p>"; 
        }  
        return $msg;              
    }

    function existe(
        $id_centro, $id_espirito, $nome_espirito) {
        if (strlen($id_espirito) == 0) {$id_espirito = 0;}
        $sql = "SELECT COUNT(ALL) 
                FROM espirito 
                WHERE id_centro = $id_centro 
                AND nome_espirito = '$nome_espirito' 
                AND id_espirito <> $id_espirito;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function insert(
        $id_centro, $id_espirito, $nome_espirito) {
        $sql = "INSERT INTO espirito (
                id_centro, id_espirito, nome_espirito) 
                VALUES ($id_centro, NULL, '$nome_espirito')";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function update($id_centro, $id_espirito, $nome_espirito){
        $sql = "UPDATE espirito SET 
                nome_espirito = '$nome_espirito' 
                WHERE id_centro = $id_centro 
                AND id_espirito = $id_espirito;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function delete($id_centro, $id_espirito){
        $sql = "DELETE FROM espirito 
                WHERE id_centro = $id_centro 
                AND id_espirito = $id_espirito;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function integridade($id_centro, $id_espirito) {
        $msg = "";
        $sql = "SELECT COUNT(*) FROM titulo 
                WHERE titulo.id_centro = $id_centro 
                AND titulo.id_espirito = $id_espirito;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (($reg[0]) > 0) {
            $msg = "<p class=texred>
            * Espírito não pode ser excluído,<br>
            &nbsp;&nbsp;há Título(s) associado(s)</p>";
        }
        return $msg;
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo=null;               // PDO
        exibe(__CLASS__ . ": pdo = null"); //DEBUG
        error_reporting (E_ALL);
    }
}
?>
