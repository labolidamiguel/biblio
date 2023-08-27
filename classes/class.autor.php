<?php

class Autor {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo"); //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq){
        $sql = "SELECT * FROM autor 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_autor LIKE '%$pesq%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) FROM autor 
                WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_autor LIKE '%$pesq%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_centro, $id_autor){
        $sql = "SELECT * FROM autor 
                WHERE id_centro = $id_centro 
                AND id_autor = $id_autor;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    
    function existe($id_centro, $id_autor, $nome_autor) {
        $sql = "SELECT COUNT(ALL) 
                FROM autor 
                WHERE id_centro = $id_centro 
                AND nome_autor = '$nome_autor'";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if ((strlen($id_autor) > 0) // se altera deve
        and ($reg[0] == 1))         // existir apenas 1 item
            return 0;
        return $reg[0];
    }

    function valida($id_centro, $id_autor, $nome_autor, $iniciais) {
        $msg = "";
        if (strlen($nome_autor) == 0) {
            $msg = $msg . "<p class=texred>
            * Nome deve ser preenchido</p>";
        }
        if (self::existe(
            $id_centro, $id_autor, $nome_autor) > 0) {
            $msg = $msg . "<p class=texred>
            * Nome já existe</p>"; 
        }
        if (strlen($iniciais) == 0) {
            $msg = $msg . "<p class=texred>
            * Iniciais deve ser preenchidas</p>";
        }
        if (strlen($iniciais) != 2) {
            $msg = $msg . "<p class=texred>
            * Iniciais devem conter dois caracteres</p>"; 
        }
        if (strlen($iniciais) > 0) {
            if (($iniciais[0] < "A" || $iniciais[0] > "Z") 
            ||  ($iniciais[1] < "A" || $iniciais[1] > "Z")) {
                $msg = $msg . "<p class=texred>
                * Iniciais devem ser letras maiúsculas</p>"; 
            }
        }
        return $msg;
    }

    function insert($id_centro, $id_autor, $nome_autor, $iniciais) {
        $sql = "INSERT INTO autor (
                id_centro, id_autor, nome_autor, iniciais) 
                VALUES (
                '$id_centro', NULL, 
                '$nome_autor', '$iniciais');";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function update($id_centro, $id_autor, $nome_autor, $iniciais){
        $sql = "UPDATE autor SET 
                nome_autor = '$nome_autor', 
                iniciais = '$iniciais' 
                WHERE id_centro = $id_centro 
                AND id_autor = $id_autor;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }
    
    function delete($id_centro, $id_autor){
        $sql = "DELETE FROM autor 
                WHERE id_centro = $id_centro 
                AND id_autor = $id_autor;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }
    
    function integridade($id_centro, $id_autor) {
        $msg = "";
        $sql = "SELECT COUNT(*) FROM titulo 
                WHERE titulo.id_centro = $id_centro 
                AND titulo.id_autor = $id_autor;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (($reg[0]) > 0) {
            $msg = "<p class=texred>* Autor não pode ser excluído,<br>&nbsp;&nbsp;há Título(s) associado(s)</p>";
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
