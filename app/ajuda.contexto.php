<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
Arch::initController("ajuda");
    $codigo_app = Arch::get("codigo_app");

Arch::initView(TRUE);

//echo "codigo_app=$codigo_app<br>";     //   D E B U G
    switch($codigo_app) {
    case "@": include "../layout/help/ajuda.geral.php"; // menu
        break;
    case "ajuda": include "../layout/help/ajuda.geral.php";
        break;
    case "lista": echo "não implementado";
        break;
    case "emprestimo": include "../layout/help/ajuda.emprestimo.php";
        break;
    case "devolucao": include "../layout/help/ajuda.devolucao.php";
        break;
    case "titulo": include "../layout/help/ajuda.titulo.php"; // livro
        break;
    case "buscacde": include "../layout/help/ajuda.buscacde.php";
        break;
    case "autor": include "../layout/help/ajuda.autor.php";
        break;
    case "cde": include "../layout/help/ajuda.cde.php";
        break;
    case "editora": include "../layout/help/ajuda.editora.php";
        break;
    case "espirito": include "../layout/help/ajuda.espirito.php";
        break;
    case "estante": include "../layout/help/ajuda.estante.php";
        break;
    case "leitor": include "../layout/help/ajuda.leitor.php";
        break;
    case "tradutor": include "../layout/help/ajuda.tradutor.php";
        break;
    case "imprime": include "../layout/help/ajuda.imprime.php";
        break;
    case "etiqueta": include "../layout/help/ajuda.etiqueta.php";
        break;
    case "relatorio": include "../layout/help/ajuda.relatorio.php";
        break;
    case "estante": include "../layout/help/ajuda.geral.php";
        break;
    case "usuario": include "../layout/help/ajuda.usuario.php";
        break;
    case "publicado": include "../layout/help/ajuda.publicado.php";
        break;
    case "app": include "../layout/help/ajuda.app.php";
        break;
    case "centro": include "../layout/help/ajuda.centro.php";
        break;
    case "log": echo "não implementado";
        break;
    case "auditoria": include "../layout/help/ajuda.auditoria.php";
        break;
    }

Arch::endView();
?>