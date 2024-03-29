<?php

class Editora {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conex�o dB"); // PDO
    }

    function select($id_centro, $pesq) {
        $sql = "SELECT * FROM editora 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND nome_editora LIKE '%".$pesq."%' ";
        }
        $sql = $sql . "ORDER BY nome_editora ";
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) FROM editora 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_editora LIKE '%".$pesq."%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_centro, $id_editora){
        $sql = "SELECT * FROM editora 
                WHERE id_centro = $id_centro 
                AND id_editora = $id_editora;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function valida($id_centro, $id_editora, $nome_editora) {
        $msg = "";
        if (strlen($nome_editora) == 0) {
            $msg = $msg . "<p class=texred>
            * Nome deve ser preenchido</p>";
        }
        if (self::existe(
            $id_centro, $id_editora, $nome_editora) > 0) {
            $msg = $msg . "<p class=texred>
            * Nome j&aacute; existe</p>"; 
        }   
        return $msg;             
    }

    function existe($id_centro, $id_editora, $nome_editora) {
        if (strlen($id_editora) == 0) {$id_editora = 0;}
        $sql = "SELECT COUNT(ALL) FROM editora 
                WHERE id_centro = $id_centro 
                AND nome_editora = '$nome_editora' 
                AND id_editora <> $id_editora;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function insert($id_centro, $id_editora, $nome_editora) {
        $sql = "INSERT INTO editora (
                id_centro, id_editora, nome_editora) 
                VALUES ($id_centro, NULL, '$nome_editora')";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function update($id_centro, $id_editora, $nome_editora){
        $sql = "UPDATE editora SET 
                nome_editora = '$nome_editora' 
                WHERE id_centro = $id_centro 
                AND id_editora = $id_editora;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function delete($id_centro, $id_editora){
        $sql = "DELETE FROM editora 
                WHERE id_centro = $id_centro 
                AND id_editora = $id_editora;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function integridade($id_centro, $id_editora) {
        $msg = "";
        $sql = "SELECT COUNT(*) FROM exemplar 
                WHERE exemplar.id_centro = $id_centro 
                AND exemplar.id_editora = $id_editora;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (($reg[0]) > 0) {
            $msg = "<p class=texred>
            * Editora n�o pode ser exclu�da,
            <br>&nbsp;&nbsp;h� Exemplar(es) associado(s)</p>";
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
