<?php
/*  AUDITORIA CONTROLE.
    include("../classes/class.auditoria.php");
    $audit = new Auditoria();
    $audit->report("message");
*/
class Auditoria {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . " new pdo");     // DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq){
        $sql = "SELECT auditoria.id_centro, auditoria.id_usuario, codigo_app, data, hora, mensagem, usuario.nome 
        FROM auditoria 
        LEFT JOIN usuario ON auditoria.id_usuario = usuario.id_usuario 
        WHERE auditoria.id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
            "AND (usuario.nome like '%".$pesq."%' 
            OR  data        like '%".$pesq."%'
            OR  codigo_app  like '%".$pesq."%'
            OR  mensagem    like '%".$pesq."%')";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "SELECT count(*) 
        FROM auditoria 
        LEFT JOIN usuario ON auditoria.id_usuario = usuario.id_usuario 
        WHERE auditoria.id_centro = '$id_centro' ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
            "AND (usuario.nome like '%".$pesq."%' 
            OR  data        like '%".$pesq."%'
            OR  codigo_app  like '%".$pesq."%'
            OR  mensagem    like '%".$pesq."%')";
        }
        $sql = $sql . ";";
//echo "*** $sql ***";    // DEBUG
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }
    
    function report($mensagem) {
        $id_centro =  ARCH::session("id_centro");
        $id_usuario = ARCH::session("id_usuario");
        $codigo_app = ARCH::session("codigo_app");
        $dt = date('Y-m-d');
        $hs = date('H:i:s');
        $sql = "
            INSERT INTO auditoria (id_centro, id_usuario, codigo_app, data, hora, mensagem) 
            VALUES ('$id_centro', '$id_usuario', '$codigo_app', '$dt', '$hs', '$mensagem');
        ";
        return $this->$pdo->query($sql); // PDO
    }

    function valida($id_centro, $data1, $data2) {
        $msg = "";
        if (strlen($data1) == 0) {
            $msg = $msg . "<p class=texred>* data DE deve ser preenchida</p>";
        }
        if (strlen($data2) == 0) {
            $msg = $msg . "<p class=texred>* data ATÉ deve ser preenchida</p>";
        }
        return $msg;
    }

    function delete($id_centro, $data1, $data2){
        $sql = "DELETE FROM auditoria 
        WHERE id_centro = $id_centro 
        AND data BETWEEN '$data1' AND '$data2';";
//echo "class.auditoria $sql";    // DEBUG
        return $this->$pdo->query($sql); // PDO
    }

    function __destruct() {
        error_reporting (E_ALL ^ E_NOTICE);
        $this->$pdo = null;             // PDO
        exibe(__CLASS__ . " pdo = null");  // DEBUG
        error_reporting (E_ALL);

    }
}
?>
