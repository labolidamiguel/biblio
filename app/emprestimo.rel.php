<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);
    $nomeRelatorio = "Empréstimos"; // nome
    $tamcol=array('26','26','3','3','10','10'); // tam.col
    $titcol=array('Leitor','Título','Vol','Ex','Emprestado','Devolvido');
        $sql = 
        "SELECT 
            leitor.nome, 
            titulo.nome_titulo,
            titulo.nro_volume,
            exemplar.nro_exemplar,
            emprestado, 
            devolvido 
        FROM emprestimo 
        left join leitor on emprestimo.id_leitor = leitor.id_leitor
        left join exemplar on emprestimo.id_exemplar = exemplar.id_exemplar
        left join titulo on exemplar.id_titulo = titulo.id_titulo 
        WHERE emprestimo.id_centro = $id_centro
        ORDER BY devolvido, emprestado;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
