<?php

class Exemplar {

	private $pdo;                       // PDO

    function __construct() {
        error_reporting (E_ALL ^ E_NOTICE);
        Arch::logg("construct: " . __CLASS__ );
        exibe(__CLASS__ . ": new pdo");    //DEBUG
        $this->$pdo = new PDO(get_connection_string()) // PDO
        or die(__CLASS__ . " Erro conexão dB"); // PDO
    }

    function select($id_centro, $id_titulo) {
        $sql = "
        SELECT 
            exemplar.id_exemplar,
            exemplar.id_titulo,
            exemplar.id_tradutor,
            exemplar.id_editora,
            exemplar.nro_edicao,
            exemplar.ano_publicacao,
            exemplar.data_entrada,
            exemplar.nro_exemplar,
            titulo.nome_titulo,
            editora.nome as editora,
            tradutor.nome as tradutor 
        FROM exemplar 
        LEFT JOIN titulo ON titulo.id_titulo = exemplar.id_titulo
        LEFT JOIN editora ON editora.id_editora = exemplar.id_editora
        LEFT JOIN tradutor ON tradutor.id_tradutor = exemplar.id_tradutor 
        WHERE exemplar.id_centro = $id_centro 
        AND exemplar.id_titulo = $id_titulo 
        ORDER BY exemplar.nro_exemplar;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCount($id_centro, $id_titulo) {
        $sql = "
        SELECT COUNT(*) from exemplar
        WHERE exemplar.id_centro = $id_centro 
        AND exemplar.id_titulo = $id_titulo;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

        # Devolve os EXEMPLARES de um Titulo por Editora e situacao
    function getExemplaresGroup($id_centro, $id_titulo) {
        $sql = "SELECT COUNT(*) as quant, 
            editora.nome as editora, 
            tradutor.nome as tradutor,
            titulo.nome_titulo as nome_titulo,
            espirito.nome as espirito,
            exemplar.id_exemplar,
            exemplar.nro_exemplar, 
        (select '(emprestado)' where
            (SELECT exists(SELECT 1 
            where emprestimo.id_exemplar = exemplar.id_exemplar 
            and emprestimo.devolvido = '') ) ) as situacao
        FROM exemplar
        LEFT JOIN editora ON editora.id_editora = exemplar.id_editora 
        LEFT JOIN tradutor ON tradutor.id_tradutor = exemplar.id_tradutor 
        LEFT JOIN titulo on titulo.id_titulo = exemplar.id_titulo  
        LEFT JOIN espirito on espirito.id_espirito = titulo.id_espirito 
        LEFT JOIN emprestimo ON emprestimo.id_exemplar = exemplar.id_exemplar 
        WHERE exemplar.id_centro = $id_centro 
        AND exemplar.id_titulo = $id_titulo 
        GROUP BY editora.id_editora, exemplar.id_tradutor, situacao;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;       
    }
    
    function getEtiqueta($id_centro, $id_exemplar) {
//            substr(autor.nome,1,10) as nom1,
//            substr(autor.nome,11,10) as nom2,
//            substr(titulo.nome_titulo,1,10) as tit1,
//            substr(titulo.nome_titulo,11,10) as tit2,
//            substr(titulo.nome_titulo,21,10) as tit3,

        $sql = "
        SELECT
            centro.sigla as cent,
            exemplar.id_exemplar as idex,
            substr(cde.cod_cde,1,2) as cde1,
            substr(cde.cod_cde,4,2) as cde2,
            substr(cde.cod_cde,7,2) as cde3,
            substr(autor.nome,1,9) as nom1,
            substr(autor.nome,10,9) as nom2,
            autor.iniciais as inic,

            substr(titulo.nome_titulo,1,9) as tit1,
            substr(titulo.nome_titulo,10,9) as tit2,
            substr(titulo.nome_titulo,19,9) as tit3,

            titulo.sigla as sigl,
            titulo.nro_volume as volu,
            exemplar.nro_exemplar as exem
        FROM exemplar 
        LEFT JOIN centro on centro.id_centro = exemplar.id_centro
        LEFT JOIN titulo on titulo.id_titulo = exemplar.id_titulo 
        LEFT JOIN cde on cde.id_cde = titulo.id_cde 
        LEFT JOIN autor on autor.id_autor = titulo.id_autor 
        WHERE exemplar.id_centro = $id_centro
        AND exemplar.id_exemplar == $id_exemplar;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getEtiquetas($id_centro, $inicial, $final) {
//            substr(autor.nome,1,10) as nom1,
//            substr(autor.nome,11,10) as nom2,
//            substr(titulo.nome_titulo,1,10) as tit1,
//            substr(titulo.nome_titulo,11,10) as tit2,
//            substr(titulo.nome_titulo,21,10) as tit3,

        $sql = "
        SELECT
            centro.sigla as cent,
            exemplar.id_exemplar as idex,
            substr(cde.cod_cde,1,2) as cde1,
            substr(cde.cod_cde,4,2) as cde2,
            substr(cde.cod_cde,7,2) as cde3,
            substr(autor.nome,1,9) as nom1,
            substr(autor.nome,10,9) as nom2,
            autor.iniciais as inic,

            substr(titulo.nome_titulo,1,9) as tit1,
            substr(titulo.nome_titulo,10,9) as tit2,
            substr(titulo.nome_titulo,19,9) as tit3,

            titulo.sigla as sigl,
            titulo.nro_volume as volu,
            exemplar.nro_exemplar as exem
        FROM exemplar 
        LEFT JOIN centro on centro.id_centro = exemplar.id_centro
        LEFT JOIN titulo on titulo.id_titulo = exemplar.id_titulo 
        LEFT JOIN cde on cde.id_cde = titulo.id_cde 
        LEFT JOIN autor on autor.id_autor = titulo.id_autor 
        WHERE exemplar.id_centro = $id_centro
        AND exemplar.id_exemplar >= $inicial 
        AND exemplar.id_exemplar <= $final;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function parseEtiquetas($selecao) { // linha selecao
        $arrIds = array();
        $tok = strtok($selecao," ,");   // parsing
        while ($tok !== false) {        // parsing
            $pos = strpos($tok, "-");
            if ($pos !== false) {
                $lim = explode("-", $tok);
                for ($i = $lim[0]; $i <= $lim[1]; $i ++) {
                    $arrIds[] = $i;
                }
            }
            else {
                $arrIds[] = $tok;
            }
            $tok = strtok(" ,");
        }
        return $arrIds;
    }

    function selectId($id_centro, $id_exemplar) {
        $sql = "
        SELECT  
            exemplar.id_exemplar,
            exemplar.id_titulo,
            exemplar.id_tradutor,
            exemplar.id_editora,
            exemplar.nro_edicao,
            exemplar.ano_publicacao,
            exemplar.data_entrada,
            exemplar.nro_exemplar,
            editora.nome as editora,
            tradutor.nome as tradutor,
            titulo.nome_titulo as nome_titulo,
            titulo.sigla as sigla,
            espirito.nome as espirito,
            titulo.nro_volume as nro_volume,
            cde.cod_cde as cod_cde,
            autor.iniciais as iniciais
        FROM exemplar
        LEFT JOIN editora on editora.id_editora = exemplar.id_editora
        LEFT JOIN tradutor on tradutor.id_tradutor = exemplar.id_tradutor
        LEFT JOIN titulo on titulo.id_titulo = exemplar.id_titulo 
        LEFT JOIN espirito on espirito.id_espirito = titulo.id_espirito 
        LEFT JOIN cde on cde.id_cde = titulo.id_cde 
        LEFT JOIN autor on autor.id_autor = titulo.id_autor 
        WHERE exemplar.id_centro = $id_centro 
        AND exemplar.id_exemplar = $id_exemplar;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getDataIntervalo($id_centro) {
        $sql = "SELECT data_entrada, min(id_exemplar) AS inicial, max(id_exemplar) AS final FROM exemplar  WHERE id_centro = $id_centro 
        GROUP BY data_entrada ORDER BY data_entrada DESC";

        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function getCountDataIntervalo($id_centro) {
        $sql = "SELECT count( DISTINCT data_entrada) FROM exemplar  WHERE id_centro = $id_centro";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        $numberResult = $reg[0];
        return $numberResult;
    }

    function getIntervaloMinMax($id_centro) {
        $sql = "SELECT MIN(id_exemplar) as min, MAX(id_exemplar) as max FROM exemplar WHERE id_centro = $id_centro;";
        $rs = $this->$pdo->query($sql); // PDO
        return $rs;
    }

    function insert($id_centro, $id_titulo, $id_tradutor, $id_editora, $nro_edicao, $ano_publicacao, $data_entrada, $nro_exemplar) {
        $sql = "INSERT INTO exemplar (id_centro, id_exemplar, id_titulo, id_tradutor, id_editora, nro_edicao, ano_publicacao, data_entrada, nro_exemplar) 
        VALUES ($id_centro, NULL, $id_titulo, $id_tradutor, $id_editora, '$nro_edicao', '$ano_publicacao', '$data_entrada', '$nro_exemplar');";
        return $this->$pdo->query($sql); // PDO
    }

    function update($id_centro, $id_exemplar, $id_tradutor, $id_editora, $nro_edicao, $ano_publicacao, $data_entrada, $nro_exemplar) {
        $sql = "UPDATE exemplar SET 
        id_tradutor = $id_tradutor, 
        id_editora = $id_editora, 
        nro_edicao = '$nro_edicao', 
        ano_publicacao = '$ano_publicacao', 
        data_entrada = '$data_entrada', 
        nro_exemplar = '$nro_exemplar'
        WHERE id_centro = $id_centro 
        AND id_exemplar = $id_exemplar;";
        return $this->$pdo->query($sql); // PDO
    }

    function delete($id_centro, $id_exemplar) {
        $sql = "DELETE FROM exemplar WHERE id_centro = $id_centro AND id_exemplar = $id_exemplar;";
        return $this->$pdo->query($sql); // PDO
    }

    function valida($id_centro, $id_titulo, $id_exemplar, $id_tradutor, $tradutor, $editora, $data_entrada, $nro_exemplar) {
        $msg = "";

        if (strlen($tradutor) == 0
        &&  strlen($id_tradutor) == 0) {
            $msg = $msg . "<p class=texred>* Tradutor deve ser selecionado</p>";
        }
        if (strlen($editora) == 0) {
            $msg = $msg . "<p class=texred>* Editora deve ser selecionada</p>";
        }
        if (strlen($data_entrada) == 0) {
            $msg = $msg . "<p class=texred>* Data de Entrada deve ser preenchida</p>";
        }
        if (strlen($nro_exemplar) == 0) {
            $msg = $msg . "<p class=texred>* Nro. de Exemplar deve ser preenchido</p>";
        }
        $qtdexemp = self::existe($id_centro, $id_titulo, $id_exemplar, $nro_exemplar);
        if ($qtdexemp > 0) {
            $msg = $msg . "<p class=texred>* Número de Exemplar já existe </p>"; 
        }
        return $msg;
    }

    function existe($id_centro, $id_titulo, $id_exemplar, $nro_exemplar) {
        $sql = "SELECT COUNT(ALL) FROM exemplar 
        WHERE id_centro = $id_centro 
        AND id_titulo = $id_titulo 
        AND nro_exemplar = '$nro_exemplar' 
        AND id_exemplar <> '$id_exemplar';";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function integridade($id_centro, $id_exemplar) {
        $msg = "";
        $sql = "SELECT COUNT(*) FROM emprestimo 
        WHERE emprestimo.id_centro = $id_centro 
        AND emprestimo.id_exemplar = $id_exemplar;";
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        if (($reg[0]) > 0) {
            $msg = "<p class=texred>* Exemplar não pode ser excluído,<br>&nbsp;&nbsp;há Empréstimo(s) associado(s)</p>";
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
