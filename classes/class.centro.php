<?php

class Centro {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($pesq){
        $sql = "SELECT * FROM centro ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "WHERE nome LIKE '%".$pesq."%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function select_all(){
        $sql = "SELECT * FROM centro ";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($pesq) {
        $sql = "SELECT count(*) FROM centro ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "WHERE nome LIKE '%".$pesq."%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_centro) {
        $sql = "SELECT * FROM centro WHERE id_centro = $id_centro;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    
    function valida($id_centro, $nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep) {
        $msg = "";
        if (strlen($nome) == 0) {
            $msg = $msg . "<p class=texred>* Nome deve ser preenchido</p>";
        }

        if (strlen($sigla) == 0) {
            $msg = $msg . "<p class=texred>* Sigla deve ser preenchida</p>";
        }
        if (strlen($sigla) > 8) {
            $msg = $msg . "<p class=texred>* Sigla não pode ter mais de 8 caracetres</p>";
        }
        
        if (strlen($telefone) == 0) {
            $msg = $msg . "<p class=texred>* Telefone deve ser preenchido</p>";
        }
        if (strlen($endereco) == 0) {
            $msg = $msg . "<p class=texred>* Endereco deve ser preenchida</p>";
        }
        if (strlen($cidade) == 0) {
            $msg = $msg . "<p class=texred>* Cidade deve ser preenchida</p>";
        }
        if (strlen($estado) == 0) {
            $msg = $msg . "<p class=texred>* Estado deve ser preenchido</p>";
        }
        if (strlen($cep) == 0) {
            $msg = $msg . "<p class=texred>* CEP deve ser preenchido</p>";
        }

        if (self::existe($id_centro, $nome) > 0) {
            $msg = $msg . "<p class=texred>* Nome já existe</p>"; 
        }                
        return $msg;
    }

    function existe($id_centro, $nome) {
        if (strlen($id_centro) == 0) {$id_centro = 0;}
        $sql = "SELECT COUNT(ALL) FROM Centro WHERE nome = '$nome' AND id_centro <> $id_centro;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function insert($nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep) {
        $sql = "INSERT INTO centro (id_centro, nome, sigla, telefone, endereco, cidade, estado, cep) VALUES (NULL, '$nome', '$sigla', '$telefone', '$endereco', '$cidade', '$estado', '$cep');";
        return $this->$pdo->query($sql); // PDO
    }

    function getId() {
        $sql = "SELECT MAX(id_centro) FROM centro;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $id = $reg[0];
        return $id;
    }

    function update($id_centro, $nome, $sigla, $telefone, $endereco, $cidade, $estado, $cep) {
        $sql = "UPDATE centro SET nome = '$nome', sigla = '$sigla',
        telefone = '$telefone', endereco = '$endereco', cidade = '$cidade', estado = '$estado', cep = '$cep'
        WHERE id_centro = $id_centro;";
        return $this->$pdo->query($sql); // PDO
    }
    
    function delete($id_centro) {
        $sql = "DELETE FROM centro WHERE id_centro = $id_centro;";
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
