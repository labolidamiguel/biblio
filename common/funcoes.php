<?php

//  Retorna a definição para a conexão com o banco de dados
    function get_connection_string() {  // PDO
        return "sqlite:../database/biblio.db"; // PDO
    }


//  monta texto, botão limpa e botão para pesquisa
    function botaoPesquisa($pesq) {
        echo "<input type='text' value='$pesq' name='pesq'";
        echo "id='pesq' class='inputh'>";
        echo "<a href='?pesq='>";
        echo "<img src='../layout/img/limp.ico' "; 
        echo "width='22' height='22' class='butimg'></a>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<input type='image' ";
        echo "src='../layout/img/pesq.ico' alt='Submit' ";
        echo "width='22' height='22' class='butimg'>";
    }


// monta botao Cria
    function botaoCria($forward, $callback) {
        echo "Cria";
        echo "<a href='$forward?callback=$callback'> ";
        echo "<img border='0' class='butimg'; alt='alt' ";
        echo "src='../layout/img/cria.ico' ";
        echo "style='width: 26px; margin-left:-2px; ";
        echo "margin-bottom:1px;'></a>";
    }

// monta botao (ação)
    function botaoAction() {
    }

// monta botao Volta
    function botaoVolta() {
    }

//  EXIBE                               // DEBUG
    function exibe($mensagem) {         // DEBUG
//        echo "<br>*** " . $mensagem;  // DEBUG
    }
?>
