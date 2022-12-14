<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
include "../classes/class.relatorio.php";

Arch::initController("imprime");
include "../layout/inc.relatorio.prologo.php";

Arch::initView(TRUE, TRUE);
    $nomeRelatorio = "Auditoria"; // TITULO rel.
    $tamcol=array('20','10','10','10','50'); // tam. coluna
    $titcol=array('Usuário','Aplicação','Data','Hora','Mensagem');

    $sql = 
    "SELECT 
        usuario.nome, 
        app.titulo,
        data,
        hora,
        mensagem
    FROM auditoria
    left join usuario on auditoria.id_usuario = usuario.id_usuario
    left join app on auditoria.codigo_app = app.codigo
    WHERE auditoria.id_centro = $id_centro;";

include "../layout/inc.relatorio.epilogo.php";

    Arch::endView(); 
?>
