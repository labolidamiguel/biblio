<?php

class Leitor {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . " new pdo");//DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq){
        $sql = "SELECT * FROM leitor 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_leitor like '%$pesq%' ";
        }
        $sql = $sql . "ORDER BY nome_leitor;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT COUNT(*) FROM leitor 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_leitor like '%$pesq%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_centro, $id_leitor){
        $sql = "SELECT * FROM leitor 
                WHERE id_centro = $id_centro 
                AND id_leitor = $id_leitor;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function valida(
        $id_centro, $id_leitor, $nome, $celular, 
        $email, $endereco, $cep, $notas) {
        $msg = "";
        if (strlen($nome) == 0) {
            $msg = $msg . "<p class=texred>
            * Nome deve ser preenchido</p>";
        }
        if (strlen($celular) == 0) {
            $msg = $msg . "<p class=texred>
            * Telefone celular deve ser preenchido</p>";
        }
        if (self::existe($id_centro, $id_leitor, $nome) > 0) {
            $msg = $msg . "<p class=texred>
            * Nome j&aacute; existe</p>";
        }
        return $msg;
    }

    function existe($id_centro, $id_leitor, $nome) {
        if (strlen($id_leitor) == 0) {$id_leitor = 0;}
        $sql = "SELECT COUNT(ALL) FROM leitor 
                WHERE id_centro = $id_centro 
                AND nome_leitor = '$nome_leitor' 
                AND id_leitor <> $id_leitor;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function insert($id_centro, $id_leitor, $nome_leitor, 
        $celular, $email, $endereco, $cep, $notas) {
        $sql = "INSERT INTO leitor (
                id_centro, id_leitor, nome_leitor, celular, 
                email, endereco, cep, notas) 
                VALUES ('$id_centro', NULL, '$nome_leitor', 
                '$celular', '$email', '$endereco', 
                '$cep', '$notas');";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function update($id_centro, $id_leitor, $nome_leitor, 
        $celular, $email, $endereco, $cep, $notas) {
        $sql = "UPDATE leitor SET 
                nome_leitor = '$nome_leitor', 
                celular = '$celular', 
                email = '$email', 
                endereco = '$endereco', 
                cep = '$cep', 
                notas = '$notas' 
                WHERE id_centro = $id_centro 
                AND id_leitor = $id_leitor;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function delete($id_centro, $id_leitor){
        $sql = "DELETE FROM leitor 
            WHERE id_centro = $id_centro 
            AND id_leitor = $id_leitor;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function integridade($id_centro, $id_leitor) {
        $msg = "";
        $sql = "SELECT COUNT(*) FROM emprestimo
                WHERE emprestimo.id_centro = $id_centro
                AND emprestimo.id_leitor = $id_leitor;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (($reg[0]) > 0) {
            $msg = "<p class=texred>
            * Leitor não pode ser excluído,<br>
            &nbsp;&nbsp;há Empréstimo(s) pendente(s)</p>";
        }
        return $msg;
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo=null;               // PDO
        exibe(__CLASS__ . " pdo = null");//DEBUG
        error_reporting (E_ALL);
    }
}
?>
