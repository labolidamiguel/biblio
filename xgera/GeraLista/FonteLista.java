// FonteLista
import java.io.*;
import java.io.FileReader;
import java.io.IOException;

public class FonteLista {
    static Parse parse = new Parse();
    static GravaIo gravaIo = new GravaIo();
    static String idEntidade;

    public static void grava(String linha) {
        gravaIo.grava(linha);
    }

    public static void cria() {
        gravaIo.abreSaida(parse.nomeEntidade, "lista");
        idEntidade = "id_" + parse.nomeEntidade;

grava("<?php                   // ");
grava(parse.nomeEntidade);
grava(".lista.php\r\n");
grava("// criado por GeraLista em ");
grava(parse.dataSys);
grava("\r\n");
grava("include \"../common/arch.php\";\r\n");
grava("include \"../common/funcoes.php\"; \r\n");
grava("include \"../classes/class.app.php\"; \r\n"); // sempre
        if (! parse.nomeEntidade.equalsIgnoreCase("app")) { //avoid dupl
grava("include \"../classes/class.");
grava(parse.nomeEntidade);
grava(".php\";\r\n");
        }

grava("\r\n");



grava("Arch::initController(\"");
grava(parse.nomeEntidade);
grava("\"); \r\n");
grava("    $id_centro = Arch::session(\"id_centro\"); \r\n");
grava("    $pesq      = Arch::get(\"pesq\"); \r\n");
grava("\r\n");
grava("// instancia classe(s) \r\n");
grava("    $");
grava(parse.nomeEntidade);
grava(" = new ");
grava(parse.nomeClasse);
grava("(); \r\n");

grava("    $count = $");
grava(parse.nomeEntidade);
grava("->getCount(");
        if (parse.nomeColuna[0].equalsIgnoreCase("id_centro")
        && ! parse.nomeEntidade.equalsIgnoreCase("centro")) {
grava("$id_centro");
grava(", ");
        }
grava("$pesq); \r\n");
grava("    $rs = $");
grava(parse.nomeEntidade);
grava("->select(");
        if (parse.nomeColuna[0].equalsIgnoreCase("id_centro")
        && ! parse.nomeEntidade.equalsIgnoreCase("centro")) {
grava("$id_centro");
grava(", ");
        }
grava("$pesq); \r\n");
grava("    Arch::deleteAllCookies(); \r\n");
grava("\r\n");


grava("Arch::initView(TRUE); \r\n");
grava("    $space5 = str_repeat(\"&nbsp;\", 5); \r\n");
grava("    $space10 = str_repeat(\"&nbsp;\", 10); \r\n");
grava("\r\n");
grava("    echo \"<p class=appTitle2>");
grava(parse.nomeClasse);
grava("</p>\"; \r\n");
grava("    echo \"<form>\"; \r\n");
grava("    echo \"<div>\"; \r\n");
grava("    botaoPesquisa($pesq); \r\n");
grava("    echo $space10; \r\n");
grava("    botaoCria(\"");
grava(parse.nomeEntidade);
grava(".cria.php\", \"");
grava(parse.nomeEntidade);
grava(".lista.php\"); \r\n");
grava("    echo \"</div>\"; \r\n");
grava("    echo \"</form>\"; \r\n");

grava("    echo \"<div class='tableFixHead'>\"; \r\n");
grava("    echo \"<table>\"; \r\n");
grava("    echo \"<thead>\"; \r\n");
grava("    echo \"<tr class='blue'>\"; \r\n");
        for (int i = 0; i < parse.idxColuna; i ++) { // table
            if (parse.nomeColuna[i]
                .equalsIgnoreCase("id_centro")) {
                continue;           // omite coluna id_centro
            }
grava("    echo \"<th align='left'>");
grava(parse.tituloColuna[i]);
grava("</th>\"; \r\n");
        }
grava("    echo \"<th>&nbsp;</th><th>&nbsp;</th>\"; \r\n");
grava("    echo \"</tr>\"; \r\n");
grava("    echo \"</thead>\"; \r\n");
grava("// fetch colunas da tabela \r\n");
grava("    while($reg = $rs->fetch()) { \r\n");
        for (int i = 0; i < parse.idxColuna; i ++) { // fetch col
grava("        $");
grava(parse.nomeColuna[i]);
grava(" = $reg[\"");
grava(parse.nomeColuna[i]);
grava("\"]; \r\n");
        }
// omite a linha de usuario root - perfis_usuario = 13579
        if (parse.nomeEntidade.equalsIgnoreCase("usuario")) {
grava("        if ($perfis_usuario == \"13579\") \r\n");
grava("            continue; // ignora user root \r\n");
        }
grava("// colunas tabela html \r\n");
        for (int i = 0; i < parse.idxColuna; i ++) {
            if (parse.nomeColuna[i]
                .equalsIgnoreCase("id_centro")) {
                continue;           // omite coluna id_centro
            }
grava("        echo \"<td>$");
grava(parse.nomeColuna[i]);
grava("</td>\"; \r\n");
        }

grava("// botao altera \r\n");
grava("        echo \"<td><a href='");
grava(parse.nomeEntidade);
grava(".altera.php?\"; \r\n");
grava("        echo \"id_"); // id
grava(parse.nomeEntidade);
grava("=$id_");
grava(parse.nomeEntidade);
grava("\"; \r\n");
grava("        echo \"&callback=");
grava(parse.nomeEntidade);
grava(".lista.php'>\"; \r\n");
grava("        echo \"<img border='0' alt='alt'\"; \r\n");
grava("        echo \"src='../layout/img/alte.ico'\"; \r\n");
grava("        echo \"width='20' height='20'></a><br></td>\"; \r\n");

grava("// botao exclui \r\n");
grava("        echo \"<td><a href='");
grava(parse.nomeEntidade);
grava(".exclui.php?\"; \r\n");
grava("        echo \"id_"); // id
grava(parse.nomeEntidade);
grava("=$id_");
grava(parse.nomeEntidade);
grava("\"; \r\n");
grava("        echo \"&callback=");
grava(parse.nomeEntidade);
grava(".lista.php'>\"; \r\n");
grava("        echo \"<img border='0' alt='alt'\"; \r\n");
grava("        echo \"src='../layout/img/excl.ico'\"; \r\n");
grava("        echo \"width='20' height='20'></a><br></td>\"; \r\n");
grava("        echo \"</tr>\"; \r\n");
grava("    } \r\n");
grava("    echo \"</table>\"; \r\n");
grava("    echo \"</div>\"; \r\n");
grava("    echo \"$space10 ($count itens)\"; \r\n");

// identifica versao
grava("    echo \"<p style='font-size:70%;'>");
grava("GeraLista " + parse.dataSys + "</p>\"; \r\n");

grava("Arch::endView(); \r\n");
grava("?> \r\n");

        gravaIo.fechaSaida();
    }
}
