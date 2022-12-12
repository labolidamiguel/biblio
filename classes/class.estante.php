<?php
include "../classes/class.cde.php";

class Estante {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq){
        $sql = "SELECT * FROM estante WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND cod_estante LIKE '%".$pesq."%' "; // ???
        }
        $sql = $sql . "ORDER BY cod_estante ";
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) FROM estante WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND cod_estante LIKE '%".$pesq."%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_centro, $id_estante){
        $sql = "SELECT * FROM estante WHERE id_centro = $id_centro AND id_estante = $id_estante;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function existe($id_centro, $id_estante, $cod_estante) {
//echo "*** id_estante " . $id_estante . "***";  // DEBUG
        if (strlen($id_estante) == 0) {$id_estante = 0;}
        $sql = "SELECT COUNT(ALL) FROM estante WHERE id_centro = $id_centro AND cod_estante = '$cod_estante' AND id_estante <> $id_estante;";
//echo "***" . $sql . "***";  // DEBUG
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function valida($id_centro, $id_estante, $cod_estante, $cde_inicial, $cde_final) {
//echo "valida $id_estante=". $id_estante. "***"; // DEBUG
        $msg = "";
        if (strlen($cod_estante) == 0) {
            $msg = $msg . "<p class=texred>* Estante deve ser preenchido</p>";
        }
        if (strlen($cde_inicial) == 0) {
            $msg = $msg . "<p class=texred>* CDE inicial deve ser preenchido</p>";
        }
        if (strlen($cde_final) == 0) {
            $msg = $msg . "<p class=texred>* CDE final deve ser preenchido</p>";
        }
        if (self::existe($id_centro, $id_estante, $estante) > 0) {
            $msg = $msg . "<p class=texred>* Estante já existe</p>";
        }
        $cde = new Cde();
        if (! $cde->existe($id_centro, 0, $cde_inicial)) {
            $msg = $msg . "<p class=texred>* CDE inicial não existe</p>";
        }
        if (! $cde->existe($id_centro, 0, $cde_final)) {
            $msg = $msg . "<p class=texred>* CDE final não existe</p>";
        }
        if (strcmp($cde_inicial, $cde_final) > 0) {
            $msg = $msg . "<p class=texred>* CDE inicial não pode ser maior que CDE final</p>";
        }
        return $msg;
    }

    function insert($id_centro, $cod_estante, $cde_inicial, $cde_final) {
        error_reporting (E_ALL ^ E_NOTICE);
        $sql = "INSERT INTO estante (id_centro, id_estante, cod_estante, cde_inicial, cde_final) VALUES ('$id_centro', NULL, '$cod_estante', '$cde_inicial', '$cde_final');";
        return $this->$pdo->query($sql); // PDO
    }

    function update($id_centro, $id_estante, $cod_estante, $cde_inicial, $cde_final) {
        error_reporting (E_ALL ^ E_NOTICE);
        $sql = "UPDATE estante SET cod_estante = '$cod_estante', cde_inicial = '$cde_inicial', cde_final = '$cde_final'
        WHERE id_centro = $id_centro AND id_estante = $id_estante;";
        return $this->$pdo->query($sql); // PDO
    }

    function delete($id_centro, $id_estante) {
        $sql = "DELETE FROM estante WHERE id_centro = $id_centro AND id_estante = $id_estante;";
        return $this->$pdo->query($sql); // PDO
    }

    function getEstante($id_centro, $cod_cde) {
        $resul = "";
        $sql = "SELECT cod_estante FROM estante WHERE id_centro = $id_centro AND '$cod_cde' BETWEEN cde_inicial AND cde_final;";
        $rs = $this->$pdo->query($sql); // PDO
        while($reg = $rs->fetch() ) {   // PDO
            $estan = $reg["cod_estante"];
            $resul = $resul . $estan . " ";
        }
        if (strlen($resul) == 0) {
            $resul = "Não encontrado. Verifique cadastro de Estantes";
        }
        return $resul;
    }

    function integridade($id_centro, $id_estante) {
        return "";
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo=null;               // PDO
        exibe(__CLASS__ . ": pdo = null"); //DEBUG
        error_reporting (E_ALL);
    }
}
?>
