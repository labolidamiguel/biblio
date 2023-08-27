<?php

class Emprestimo {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function emprestado($id_centro, $id_exemplar) {
//      retorna 1 emprestado; 0 disponivel
        $sql = "SELECT COUNT(*)
                FROM emprestimo
                WHERE emprestimo.id_centro = $id_centro
                AND emprestimo.id_exemplar = $id_exemplar 
                AND emprestimo.devolvido = '' ";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $count = $reg[0];
        return $count;
    }

    function select($id_centro, $pesq) {
        $sql = "SELECT
                emprestimo.id_emprestimo,
                emprestimo.id_leitor,
                nome_leitor,
                emprestimo.id_exemplar,
                exemplar.id_titulo,
                exemplar.nro_exemplar,
                titulo.nome_titulo,
                emprestimo.emprestado,
                emprestimo.devolvido
                FROM emprestimo
                LEFT JOIN leitor 
                ON leitor.id_leitor = emprestimo.id_leitor
                LEFT JOIN exemplar 
                ON exemplar.id_exemplar = emprestimo.id_exemplar
                LEFT JOIN titulo 
                ON titulo.id_titulo = exemplar.id_titulo
                WHERE emprestimo.id_centro = $id_centro ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND nome_leitor like '%".$pesq."%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function selectOrdDate($id_centro, $pesq){
        $sql = "SELECT
            emprestimo.id_emprestimo,
            emprestimo.id_leitor,
            nome_leitor,
            emprestimo.id_exemplar,
            exemplar.id_titulo,
            exemplar.nro_exemplar,
            titulo.nome_titulo,
            emprestimo.emprestado,
            emprestimo.devolvido
            FROM emprestimo
            LEFT JOIN leitor 
            ON leitor.id_leitor = emprestimo.id_leitor
            LEFT JOIN exemplar 
            ON exemplar.id_exemplar = emprestimo.id_exemplar
            LEFT JOIN titulo 
            ON titulo.id_titulo = exemplar.id_titulo
            WHERE emprestimo.id_centro = $id_centro
            AND emprestimo.devolvido = '' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
            "AND (nome_leitor like '%$pesq%' 
            OR nome_titulo like '%$pesq%') ";
        }
        $sql = $sql . "ORDER BY emprestado DESC ";
        $sql = $sql . ";";
//echo $sql;      // DEBUG
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT COUNT(*)
                FROM emprestimo
                LEFT JOIN leitor 
                ON leitor.id_leitor = emprestimo.id_leitor
                LEFT JOIN exemplar 
                ON exemplar.id_exemplar = emprestimo.id_exemplar
                LEFT JOIN titulo 
                ON titulo.id_titulo = exemplar.id_titulo
                WHERE emprestimo.id_centro = $id_centro
                AND emprestimo.devolvido = '' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
                "AND (nome_leitor like '%$pesq%' 
                OR nome_titulo like '%$pesq%') ";
        }
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function getEmprestimo($id_centro, $id_emprestimo) {
        $sql = "SELECT
            emprestimo.id_emprestimo,
            emprestimo.id_leitor,
            nome_leitor,
            emprestimo.id_exemplar,
            exemplar.id_titulo,
            exemplar.nro_exemplar,
            titulo.nome_titulo,
            titulo.nro_volume,
            emprestimo.emprestado,
            emprestimo.devolvido,
            cde.cod_cde,
            cde.clas_cde
            FROM emprestimo
            LEFT JOIN leitor 
            ON leitor.id_leitor = emprestimo.id_leitor
            LEFT JOIN exemplar 
            ON exemplar.id_exemplar = emprestimo.id_exemplar
            LEFT JOIN titulo 
            ON titulo.id_titulo = exemplar.id_titulo
            LEFT JOIN cde 
            ON cde.id_cde = titulo.id_cde
            WHERE emprestimo.id_centro = $id_centro
            AND emprestimo.id_emprestimo = $id_emprestimo";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function insert($id_centro, $id_leitor, $id_exemplar) {
        $hoje = date("Y-m-d");
        $sql = "INSERT INTO emprestimo (
                id_centro, id_emprestimo, id_leitor, 
                id_exemplar, emprestado, devolvido) 
                VALUES ($id_centro, NULL, $id_leitor, 
                $id_exemplar, '$hoje', '');";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function update($id_centro, $id_emprestimo) {
        $hoje = date("Y-m-d");
        $sql = "UPDATE emprestimo SET 
                devolvido = '$hoje'
                WHERE id_centro = $id_centro 
                AND id_emprestimo = $id_emprestimo;";
        $this->$pdo->query($sql);       // PDO
        $err = $this->$pdo->errorInfo();// get error
        if ($err[0] == 0) return "";    // OK
        return implode(",", $err);      // erro
    }

    function valida($id_centro, $leitor, $nome_titulo, $id_exemplar) {
        $msg = "";
        if (strlen($leitor) == 0) {
            $msg = $msg . "<p class=texred>* Leitor não selecionado</p>";
        }
        if (strlen($nome_titulo) == 0) {
            $msg = $msg . "<p class=texred>* Título não selecionado</p>";
        }
        if (strlen($id_exemplar) == 0) {
            $msg = $msg . "<p class=texred>* Exemplar não selecionado</p>";
        }
        if (strlen($msg) > 0)           // erros anteriores
            return $msg;
        $qtd = self::emprestado($id_centro, $id_exemplar);
        if ($qtd > 0) {
            $msg = $msg . "<p class=texred>* Exemplar j&aacute; emprestado</p>";
        }
        return $msg;
    }

    function delete() {
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo=null;               // PDO
        exibe(__CLASS__ . ": pdo = null"); //DEBUG
        error_reporting (E_ALL);
    }
}
?>
