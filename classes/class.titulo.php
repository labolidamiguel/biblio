<?php

Class Titulo {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $pesq) {
        $sql = "
            SELECT 
                titulo.id_titulo, titulo.nome_titulo, 
                titulo.sigla, titulo.id_autor, 
                titulo.id_espirito, titulo.id_cde, 
                titulo.nro_volume, titulo.resenha,
                autor.id_autor, autor.nome as autor,
                espirito.nome as espirito,
                cde.cod_cde as cod_cde,
                cde.classe as classe
            FROM 
                titulo
                left join autor     on titulo.id_autor    = autor.id_autor
                left join espirito  on titulo.id_espirito = espirito.id_espirito
                left join cde       on titulo.id_cde      = cde.id_cde 
            WHERE titulo.id_centro = $id_centro ";
        if (strlen($pesq) > 0) {
            $sql = $sql .  
            "AND ( 
            titulo.nome_titulo       like '%".$pesq."%'
            OR  autor.nome      like '%".$pesq."%'
            OR  espirito.nome   like '%".$pesq."%' 
            OR  cde.classe      like '%".$pesq."%')";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $pesq) {
        $sql = "select count(*)
            FROM 
                titulo
                left join autor    on titulo.id_autor    = autor.id_autor
                left join espirito on titulo.id_espirito = espirito.id_espirito 
                left join cde      on titulo.id_cde      = cde.id_cde 
            WHERE titulo.id_centro = $id_centro ";
        if (strlen($pesq) > 0) {
            $sql = $sql . 
            "AND (
            titulo.nome_titulo       like '%".$pesq."%'
            OR  autor.nome      like '%".$pesq."%'
            OR  espirito.nome   like '%".$pesq."%' 
            OR  cde.classe      like '%".$pesq."%')";
        }
        $sql = $sql . ";";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();
        $numberResult = $reg[0];
        return $numberResult;
    }
    
    function selectId($id_centro, $id_titulo){
        $sql = "
        SELECT 
            titulo.id_titulo, titulo.nome_titulo, titulo.sigla, 
            titulo.id_autor, titulo.id_espirito, titulo.id_cde, 
            titulo.nro_volume, titulo.resenha,
            autor.id_autor, autor.nome as autor,
            espirito.nome as espirito,
            cde.cod_cde as cod_cde,
            cde.classe as classe
        FROM 
            titulo
            left join autor     on titulo.id_autor    = autor.id_autor
            left join espirito  on titulo.id_espirito = espirito.id_espirito
            left join cde       on titulo.id_cde      = cde.id_cde 
        WHERE titulo.id_centro = $id_centro AND id_titulo = $id_titulo;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getResenha($id_centro, $id_titulo) {
        $sql = "select resenha from titulo where id_centro = $id_centro and id_titulo = $id_titulo;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }
    
    function existe($id_centro, $id_titulo, $nome_titulo) {
        if (strlen($id_titulo) == 0) {$id_titulo = 0;}
        $sql = "SELECT COUNT(ALL) FROM titulo 
            WHERE id_centro = $id_centro 
            AND nome_titulo = '$nome_titulo' 
            AND id_titulo <> $id_titulo;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function insert($id_centro, $nome_titulo, $sigla, $id_autor, $id_espirito, $id_cde, $nro_volume, $resenha) {
        $sql = "INSERT INTO titulo 
        (id_centro, id_titulo, nome_titulo, sigla, 
        id_autor, id_espirito, id_cde, nro_volume, resenha) 
        VALUES ($id_centro, NULL, '$nome_titulo', '$sigla', 
        $id_autor, $id_espirito, $id_cde, '$nro_volume', '$resenha');";
        return $this->$pdo->query($sql); // PDO
    }

    function update($id_centro, $id_titulo, $nome_titulo, $sigla, $id_autor, $id_espirito, $id_cde, $nro_volume, $resenha) {
        $sql = "UPDATE titulo SET 
            nome_titulo = '$nome_titulo', 
            sigla = '$sigla', 
            id_autor = '$id_autor',
            id_espirito = '$id_espirito', 
            id_cde = '$id_cde',
            nro_volume = '$nro_volume', 
            resenha = '$resenha' 
            WHERE id_centro = $id_centro 
            AND id_titulo = $id_titulo;";
        return $this->$pdo->query($sql); // PDO
    }

    function delete($id_centro, $id_titulo) {
        $sql = "DELETE FROM titulo WHERE id_centro = $id_centro AND id_titulo = $id_titulo;";
        return $this->$pdo->query($sql); // PDO
    }

    function valida() {
        global $action, $id_centro, $id_titulo, $nome_titulo, $sigla, $id_autor, $id_espirito, $id_cde, $nro_volume, $resenha, $autor, $espirito, $cod_cde;
        $msg = "";

        if (strlen($nome_titulo) == 0) {
            $msg = $msg . "<p class=texred>* Título deve ser preenchido</p>";
        }
        if (strlen($sigla) == 0) {
            $msg = $msg . "<p class=texred>* Sigla deve ser preenchida</p>";
        }
        if (strlen($sigla) != 2) {
            $msg = $msg . "<p class=texred>* Sigla deve conter dois caracteres</p>"; 
        }
        if (strlen($sigla) > 1) {
            if (($sigla[0] < "a" || $sigla[0] > "z") 
            ||  ($sigla[1] < "a" || $sigla[1] > "z")) {
                $msg = $msg . "<p class=texred>* Sigla deve conter letras minúsculas</p>"; 
            }
        }
        if (strlen($autor) == 0) {
            $msg = $msg . "<p class=texred>* Autor deve ser selecionado</p>";
        }
        if ($id_espirito == 0) {    // nome pode ser branco
            $msg = $msg . "<p class=texred>* Espírito deve ser selecionado</p>";
        }
        if (strlen($cod_cde) == 0) {
            $msg = $msg . "<p class=texred>* CDE deve ser preenchido</p>";
        }
        if (strlen($nro_volume) == 0) {
            $msg = $msg . "<p class=texred>* Nro.Volume deve ser preenchido</p>";
        }
        if ($this->existe($id_centro, $id_titulo, $nome_titulo) > 0) {
            $msg = $msg . "<p class=texred>* Título já existe</p>"; 
        }
        return $msg;                
    }

    function integridade($id_centro, $id_titulo) {
        $msg = "";
        $sql = "SELECT COUNT(*) FROM exemplar 
        WHERE exemplar.id_centro = $id_centro 
        AND exemplar.id_titulo = $id_titulo;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (($reg[0]) > 0) {
            $msg = "<p class=texred>* Título não pode ser excluído,<br>&nbsp;&nbsp;há Exemplar(es) associado(s)</p>";
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
