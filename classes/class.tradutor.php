<?php

class Tradutor {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");//DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq) {
        $sql = "SELECT * FROM tradutor 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_tradutor LIKE '%$pesq%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) FROM tradutor 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_tradutor LIKE '%$pesq%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_centro, $id_tradutor){
        $sql = "SELECT * FROM tradutor 
                WHERE id_centro = $id_centro 
                AND id_tradutor = $id_tradutor;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function valida(
        $id_centro, $id_tradutor, $nome_tradutor) {
        $msg = ""; 
        if (strlen($nome_tradutor) == 0) {
            $msg = $msg . "<p class=texred>
            * Nome deve ser preenchido</p>";
        }
        if (self::existe(
            $id_centro, $id_tradutor, $nome_tradutor) > 0) {
            $msg = $msg . "<p class=texred>
            * Nome já existe</p>"; 
        }
        return $msg;
    }

    function existe(
        $id_centro, $id_tradutor, $nome_tradutor) {
        if (strlen($id_tradutor) == 0) {$id_tradutor = 0;}
        $sql = "SELECT COUNT(ALL) FROM tradutor 
                WHERE id_centro = $id_centro 
                AND nome_tradutor = '$nome_tradutor' 
                AND id_tradutor <> $id_tradutor;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function insert(
        $id_centro, $id_tradutor, $nome_tradutor) {
        $sql = "INSERT INTO tradutor (
                id_centro, id_tradutor, nome_tradutor) 
                VALUES ($id_centro, NULL, '$nome_tradutor');";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function update(
        $id_centro, $id_tradutor, $nome_tradutor){
        $sql = "UPDATE tradutor SET 
                nome_tradutor = '$nome_tradutor' 
                WHERE id_centro = $id_centro 
                AND id_tradutor = $id_tradutor;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function delete($id_centro, $id_tradutor){
        $sql = "DELETE FROM tradutor 
                WHERE id_centro = $id_centro 
                AND id_tradutor = $id_tradutor;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function integridade($id_centro, $id_tradutor) {
        $msg = "";
        $sql = "SELECT COUNT(*) FROM exemplar 
                WHERE exemplar.id_centro = $id_centro 
                AND exemplar.id_tradutor = $id_tradutor;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (($reg[0]) > 0) {
            $msg = "<p class=texred>
            * Tradutor não pode ser excluído,
            <br>&nbsp;&nbsp;há Exemplar(es) associado(s)</p>";
        }
        return $msg;
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo=null;               // PDO
        error_reporting (E_ALL);
        exibe(__CLASS__ . ": pdo = null");//DEBUG
    }
}
?>
