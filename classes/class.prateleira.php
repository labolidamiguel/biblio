<?php
include "../classes/class.cde.php";

class Prateleira {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq){
        $sql = "SELECT * FROM prateleira WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND cod_prateleira LIKE '%".$pesq."%' "; // ???
        }
        $sql = $sql . "ORDER BY cod_prateleira ";
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) FROM prateleira WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND cod_prateleira LIKE '%".$pesq."%' ";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectId($id_centro, $id_prateleira){
        $sql = "SELECT * FROM prateleira WHERE id_centro = $id_centro AND id_prateleira = $id_prateleira;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function existe($id_centro, $id_prateleira, $cod_prateleira) {
//echo "*** id_prateleira " . $id_prateleira . "***";  // DEBUG
        if (strlen($id_prateleira) == 0) {$id_prateleira = 0;}
        $sql = "SELECT COUNT(ALL) FROM prateleira WHERE id_centro = $id_centro AND cod_prateleira = '$cod_prateleira' AND id_prateleira <> $id_prateleira;";
//echo "***" . $sql . "***";  // DEBUG
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function valida($id_centro, $id_prateleira, $cod_prateleira, $cde_inicial, $cde_final) {
//echo "valida $id_prateleira=". $id_prateleira. "***"; // DEBUG
        $msg = "";
        if (strlen($cod_prateleira) == 0) {
            $msg = $msg . "<p class=texred>* Prateleira deve ser preenchido</p>";
        }
        if (strlen($cde_inicial) == 0) {
            $msg = $msg . "<p class=texred>* CDE inicial deve ser preenchido</p>";
        }
        if (strlen($cde_final) == 0) {
            $msg = $msg . "<p class=texred>* CDE final deve ser preenchido</p>";
        }
        if (self::existe($id_centro, $id_prateleira, $prateleira) > 0) {
            $msg = $msg . "<p class=texred>* Prateleira já existe</p>";
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

    function insert($id_centro, $cod_prateleira, $cde_inicial, $cde_final) {
        error_reporting (E_ALL ^ E_NOTICE);
        $sql = "INSERT INTO prateleira (id_centro, id_prateleira, cod_prateleira, cde_inicial, cde_final) VALUES ('$id_centro', NULL, '$cod_prateleira', '$cde_inicial', '$cde_final');";
        return $this->$pdo->query($sql); // PDO
    }

    function update($id_centro, $id_prateleira, $cod_prateleira, $cde_inicial, $cde_final) {
        error_reporting (E_ALL ^ E_NOTICE);
        $sql = "UPDATE prateleira SET cod_prateleira = '$cod_prateleira', cde_inicial = '$cde_inicial', cde_final = '$cde_final'
        WHERE id_centro = $id_centro 
        AND id_prateleira = $id_prateleira;";
        return $this->$pdo->query($sql); // PDO
    }

    function delete($id_centro, $id_prateleira) {
        $sql = "DELETE FROM prateleira WHERE id_centro = $id_centro AND id_prateleira = $id_prateleira;";
        return $this->$pdo->query($sql); // PDO
    }

    function getPrateleira($id_centro, $cod_cde) {
        $resul = "";
        $sql = "SELECT cod_prateleira FROM prateleira WHERE id_centro = $id_centro AND '$cod_cde' BETWEEN cde_inicial AND cde_final;";
        $rs = $this->$pdo->query($sql); // PDO
        while($reg = $rs->fetch() ) {   // PDO
            $estan = $reg["cod_prateleira"];
            $resul = $resul . $estan . " ";
        }
        if (strlen($resul) == 0) {
            $resul = "Não encontrado. Verifique cadastro de Prateleira";
        }
        return $resul;
    }

    function integridade($id_centro, $id_prateleira) {
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
