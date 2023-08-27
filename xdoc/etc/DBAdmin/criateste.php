<?php
header('Content-Type: text/html; charset=iso-8859-1');
    $id_centro = $_GET["id_centro"];    //    C E N T R O
    $tabela = "";                       // nome tabela
    $nomeId = "";                       // nome coluna id
    $nomeDado = "";                     // nome coluna dado
    $valorDado = "";                    // valor coluna dado
    $arrtab = array();                  // array nome tabelas
    $arrid = array();                   // array ultimo id inserido
    $etc = new etc();
    $db = new SQLite3("biblio.db");
    $filename = "parametros.txt";
    array_push($arrtab, "id_centro");   // 1o elemento 
    array_push($arrid, $id_centro);

    echo "<pre>";
    echo "criaSQLite - centro $id_centro<br><br>";
    if (strlen($id_centro) == 0) {
        echo "*** id_centro não informado ***<br>";
        exit();
    }
    if ($id_centro == 1) {
        echo "*** id_centro invalido ***<br>";
        exit();
    }

    $sql = "DELETE FROM autor WHERE id_centro = $id_centro;";
    $db->exec($sql);
    $sql = "DELETE FROM editora WHERE id_centro = $id_centro;";
    $db->exec($sql);
    $sql = "DELETE FROM emprestimo WHERE id_centro = $id_centro;";
    $db->exec($sql);
    $sql = "DELETE FROM espirito WHERE id_centro = $id_centro;";
    $db->exec($sql);
    $sql = "DELETE FROM exemplar WHERE id_centro = $id_centro;";
    $db->exec($sql);
    $sql = "DELETE FROM leitor WHERE id_centro = $id_centro;";
    $db->exec($sql);
    $sql = "DELETE FROM titulo WHERE id_centro = $id_centro;";
    $db->exec($sql);
    $sql = "DELETE FROM tradutor WHERE id_centro = $id_centro;";
    $db->exec($sql);

    if (is_file($filename)) {
        $fp = fopen ($filename, "r");
        while(! feof($fp)) {
            $parm = fgets($fp);
            $parm = rtrim($parm);
            if (strlen($parm) == 0) continue;
            if ($parm[0] == '#') continue;  // comment
            $etc->parse($parm);
            $etc->criaInsert($parm);
// echo "$parm|$tabela|$nomeId|$nomeDado|$valorDado|<br>";//   D E B U G
        }
        fclose($fp);
    }else{
        return "erro " . $filename;
    }
    print_r(array_values($arrtab));     //   D E B U G
    print_r(array_values($arrid));      //   D E B U G

class etc {
    public function parse($param) {
        global $tabela, $nomeId, $nomeDado, $valorDado;
        $tok = explode("(", $param);    // nome tabela
        $tabela = $tok[0];
        $tok = explode(",", $param);    // nome coluna id
        $nomeId = $tok[1];
        $tok = explode(",", $param);    // nome coluna dado
        $nomeDado = $tok[2];
        $i = strpos($nomeDado, ")");
        if ($i > 0) { $nomeDado = substr($nomeDado, 0, $i); }
        $tok = strstr($param, "VALUES"); // valor coluna dado
        $aux = explode(",", $tok);      
        $valorDado = $aux[2];
        $i = strpos($valorDado, ")");
        if ($i > 0) { $valorDado = substr($valorDado, 0, $i); }
    }

    public function criaInsert($param) {
        global $db, $tabela, $id_centro, $nomeId, $nomeDado, $valorDado;
        $sql = "SELECT $nomeId FROM $tabela WHERE id_centro = $id_centro AND $nomeDado = $valorDado;";
        $rs = $db->query($sql);
        $reg = $rs->fetchArray();
        if ($reg == null) {             // não existe registro: cria
            $param = self::preparaInsert($param);
            $sql = "INSERT INTO ".$param; // prepare insert
            $rs = $db->exec($sql);      // insert
echo $sql."<br>";
            if($rs == FALSE) { echo "<br>$db->lastErrorMsg(); $sql"; }
            $sql = "SELECT MAX($nomeId) FROM $tabela;";
            $rs = $db->query($sql);
            $reg = $rs->fetchArray();
            $id = $reg[0];
        }
        else{
            $id = $reg[0];              // existe, guarda id
        }
        self::guardaId($tabela, $id);
    }

    public function guardaId($tabela, $id) {
        global $arrtab, $arrid;
        for ($i=0; $i<count($arrtab); $i++) {
            if (! strcmp($arrtab[$i], $tabela)) {
                $arrid[$i] = $id;
                return;
            }
        }
        array_push($arrtab, $tabela);
        array_push($arrid, $id);
    }

    public function preparaInsert($param) {
        global $arrtab, $arrid, $tabela;
        $contador = 0;
        while (strpos($param, "#") > 0) {
            $contador ++;
            if ($contador > 100) {
                echo "sem resolver param:$param<br>";
                return $param;
            }
            for ($i=0; $i<count($arrtab); $i++) {
                $key = "#".$arrtab[$i];
                $param = str_replace($key, $arrid[$i], $param);
            }
        }
        return $param;
    }
}
?>