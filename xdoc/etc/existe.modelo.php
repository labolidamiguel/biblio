<?php
    function existe($id_centro, $id_espirito, $nome) {
        if (strlen($id_espirito) == 0) {$id_espirito = 0;}
        $sql = "SELECT COUNT(ALL) 
                FROM espirito 
                WHERE id_centro = $id_centro 
                AND nome = '$nome' 
                AND id_espirito <> $id_espirito;";// ele mesmo
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function existe($id_usuario, $nome) {
        if (strlen($id_usuario) == 0) {$id_usuario = 0;}
        $sql = "SELECT COUNT(ALL) 
                FROM usuario 
                WHERE nome = '$nome' 
                AND id_usuario <> $id_usuario;";// ele mesmo 
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }

    function existe($id_app, $codigo) {
        if (strlen($id_app) == 0) {$id_app = 0;}
        $sql = "SELECT COUNT(ALL) 
                FROM app 
                WHERE codigo = '$codigo' 
                AND id_app <> $id_app;";// ele mesmo
        $rs = $this->$pdo->query($sql); // PDO
        $reg = $rs->fetch();            // PDO
        return $reg[0];
    }
?>
