<?php

class Tradutor {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");//DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conex�o dB"); // PDO
    }

    function select($id_centro, $pesq) {
        $sql = "SELECT * FROM tradutor WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND nome LIKE '%".$pesq."%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) FROM tradutor WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND nome LIKE '%".$pesq."%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_centro, $id_tradutor){
        $sql = "SELECT * FROM tradutor WHERE id_centro = $id_centro AND id_tradutor = $id_tradutor;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function valida($id_centro, $id_tradutor, $nome) {
        $msg = ""; 
        if (strlen($nome) == 0) {
            $msg = $msg . "<p class=texred>* Nome deve ser preenchido</p>";
        }
        if (self::existe($id_centro, $id_tradutor, $nome) > 0) {
            $msg = $msg . "<p class=texred>* Nome j� existe</p>"; 
        }
        return $msg;
    }

    function existe($id_centro, $id_tradutor, $nome) {
        if (strlen($id_tradutor) == 0) {$id_tradutor = 0;}
        $sql = "SELECT COUNT(ALL) FROM tradutor WHERE id_centro = $id_centro AND nome = '$nome' AND id_tradutor <> $id_tradutor;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function insert($id_centro, $nome) {
        $sql = "INSERT INTO tradutor (id_centro, id_tradutor, nome) VALUES ($id_centro, NULL, '$nome')";
        return $this->$pdo->query($sql); // PDO
    }

    function update($id_centro, $id_tradutor, $nome){
        $sql = "UPDATE tradutor SET nome = '$nome' WHERE id_centro = $id_centro AND id_tradutor = $id_tradutor;";
        return $this->$pdo->query($sql); // PDO
    }

    function delete($id_centro, $id_tradutor){
        $sql = "DELETE FROM tradutor WHERE id_centro = $id_centro AND id_tradutor = $id_tradutor;";
        return $this->$pdo->query($sql); // PDO
    }

    function integridade($id_centro, $id_tradutor) {
        $msg = "";
        $sql = "SELECT COUNT(*) FROM exemplar 
        WHERE exemplar.id_centro = $id_centro 
        AND exemplar.id_tradutor = $id_tradutor;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (($reg[0]) > 0) {
            $msg = "<p class=texred>* Tradutor n�o pode ser exclu�do,<br>&nbsp;&nbsp;h� Exemplar(es) associado(s)</p>";
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
