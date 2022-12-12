<?php

class Cde {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq){
        $sql = "SELECT * FROM cde WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND (cod_cde LIKE '%".$pesq."%' 
            OR classe LIKE '%".$pesq."%')";
        }
        $sql = $sql . " ORDER BY cod_cde ";

        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) FROM cde WHERE id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . "AND (cod_cde LIKE '%".$pesq."%'
            OR classe LIKE '%".$pesq."%')";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function selectClasse($id_centro, $pesq, $cde1){
        if (strlen($pesq) > 0) {
            $sql = "SELECT * FROM cde WHERE id_centro = '$id_centro' 
            AND (cod_cde LIKE '%$pesq%'
            OR classe LIKE '%$pesq%') 
            ORDER BY cod_cde LIMIT $page , $linxpage;";
        } else {
            $sql = "SELECT * FROM cde WHERE id_centro = '$id_centro' 
            AND substr(cod_cde,1,1) = '$cde1'
            ORDER BY cod_cde ";
        }
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCountClasse($id_centro, $pesq, $cde1) {
        if (strlen($pesq) > 0) {
            $sql = "SELECT count(*) FROM cde WHERE id_centro = '$id_centro' 
            AND (cod_cde LIKE '%$pesq%'
            OR classe LIKE '%$pesq%');";
        } else {
            $sql = "SELECT count(*) FROM cde WHERE id_centro = '$id_centro'
            AND substr(cod_cde,1,1) = '$cde1';";
        }
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }
    
    function selectId($id_centro, $id_cde){
        $sql = "SELECT * FROM cde WHERE id_centro = $id_centro AND id_cde = $id_cde;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    
    function selectClasificacao($id_centro) {
        $rs = 0;
        $sql = "SELECT id_centro, id_cde, cod_cde, classe, substr(cod_cde,1,1) as cde1 FROM cde WHERE id_centro = '$id_centro' AND (cod_cde LIKE '%0.00.00');";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function selectAll($id_centro, $pesq) {
        $rs = 0;
        $sql = "SELECT * FROM cde WHERE id_centro = '$id_centro' AND (cod_cde LIKE '%".$pesq."%' OR classe LIKE '%".$pesq."%');";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    
    function valida($id_centro, $id_cde, $cod_cde, $classe) {
        $msg = "";
        if (strlen($cod_cde) == 0) {
            $msg = $msg . "<p class=texred>* CDE deve ser preenchido</p>";
        }
        if (strlen($classe) == 0) {
            $msg = $msg . "<p class=texred>* Classe deve ser preenchida</p>";
        }
        if ( strlen($cod_cde)>7 
        &&  is_numeric($cod_cde[0]) 
        &&  is_numeric($cod_cde[1])
        &&  $cod_cde[2] == "."
        &&  is_numeric($cod_cde[3])
        &&  is_numeric($cod_cde[4])
        &&  $cod_cde[5] == "."
        &&  is_numeric($cod_cde[6])
        &&  is_numeric($cod_cde[7])) {      // correct
        }else{
            $msg = $msg . "<p class=texred>* CDE inválido. Deve ser formado como nn.nn.nn</p>"; 
        }
        if (self::existe($id_centro, $id_cde, $cod_cde) > 0) {
            $msg = $msg . "<p class=texred>* CDE já existe</p>"; 
        }                
        return $msg;
    }

    function existe($id_centro, $id_cde, $cod_cde) {
        if (strlen($id_cde) == 0) {$id_cde = 0;}
        $sql = "SELECT COUNT(ALL) FROM cde WHERE id_centro = $id_centro AND cod_cde = '$cod_cde' AND id_cde <> $id_cde;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function insert($id_centro, $cod_cde, $classe) {
        $sql = "INSERT INTO cde (id_centro, id_cde, cod_cde, classe) VALUES ('$id_centro', NULL, '$cod_cde', '$classe');";
        return $this->$pdo->query($sql); // PDO
    }

    function update($id_centro, $id_cde, $cod_cde, $classe) {
        $sql = "UPDATE cde SET cod_cde = '$cod_cde', classe = '$classe' WHERE id_centro = $id_centro AND id_cde = $id_cde;";
        return $this->$pdo->query($sql); // PDO
    }
    
    function delete($id_centro, $id_cde) {
        $sql = "DELETE FROM cde WHERE id_centro = $id_centro AND id_cde = $id_cde;";
        return $this->$pdo->query($sql); // PDO
    }
    
    function duplica($id_centro_novo) {
        $sql = "INSERT INTO cde (id_centro, id_cde, cod_cde, classe)
        SELECT $id_centro_novo, NULL, cod_cde, classe
        FROM cde
        WHERE id_centro = '1';";
        return $this->$pdo->query($sql); // PDO
    }   
    
    function integridade($id_centro, $id_cde) {
        $msg = "";
        $sql = "SELECT COUNT(*) FROM titulo 
        WHERE titulo.id_centro = $id_centro 
        AND titulo.id_cde = $id_cde;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (($reg[0]) > 0) {
            $msg = "<p class=texred>* CDE não pode ser excluído,<br>&nbsp;&nbsp;há Título(s) associado(s)</p>";
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
