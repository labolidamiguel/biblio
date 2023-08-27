<?php
header('Content-Type: text/html; charset=iso-8859-1');

    $db = new SQLite3("biblio.db");

    echo "<pre>";
    echo "Duplica tabelas<br><br>";

    $id_centro_novo = $_GET["id_centro"]; // C E N T R O
    echo "ID ".$id_centro_novo."<br>";
                                        //   C D E
    $sql = "INSERT  INTO cde (id_centro, id_cde, cde, classe)
        SELECT $id_centro_novo, NULL, cde, classe FROM cde 
        WHERE id_centro = '1';";
    duplica($sql, "cde");


                                        //   E S T A N T E
    $sql = "INSERT  INTO estante (id_centro, id_estante, estante, cde_inicial, cde_final)
        SELECT $id_centro_novo, NULL, estante, cde_inicial, cde_final FROM estante 
        WHERE id_centro = '1';";
    duplica($sql, "estante");

    function duplica($sql, $tabela) {
        global $db, $id_centro_novo;
        $dsql = "DELETE FROM $tabela 
            WHERE id_centro = $id_centro_novo;";
        $db->exec($dsql);
        echo "SQL ".$sql."<br>";
        $db->exec($sql);
        $sql = "SELECT COUNT(*) FROM $tabela 
            WHERE id_centro = $id_centro_novo;";
        $rs = $db->query($sql);
        $reg = $rs->fetchArray();
        echo "criados ".$reg[0]."<br>";
    }
?>