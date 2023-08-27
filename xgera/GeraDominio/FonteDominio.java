// FonteDominio
import java.io.*;
import java.io.FileReader;
import java.io.IOException;

public class FonteDominio {
    static Parse parse = new Parse();
    static GravaIo gravaIo = new GravaIo();
    static String idEntidade;
    public static void grava(String linha) {
        GravaIo.grava(linha);
    }

    public static void cria() {
        gravaIo.abreSaida(parse.nomeClasse, "dominio");
        idEntidade = "id_" + parse.nomeEntidade;

grava("<?php                   // ");
grava(parse.nomeEntidade);
grava(".dominio.php \r\n");

grava("// criado por GeraDominio em " + parse.dataSys + "\r\n");
grava("include \"../common/arch.php\"; \r\n");
grava("include \"../common/funcoes.php\"; \r\n");
grava("include \"../classes/class.app.php\"; \r\n");
// evita duplicação de include
        if (! parse.nomeEntidade.equalsIgnoreCase("app")) { 
grava("include \"../classes/class.");
grava(parse.nomeEntidade);
grava(".php\";\r\n");
        }
grava("\r\n");
grava("Arch::initController(\"lista\"); \r\n");
grava("    $id_centro  = Arch::session(\"id_centro\"); \r\n");
grava("    $pesq       = Arch::get(\"pesq\"); \r\n");
grava("    $callback   = Arch::get(\"callback\"); \r\n");
grava("// instancia classe(s) \r\n");
grava("    $" + parse.nomeEntidade + " = new " 
    + parse.nomeClasse + "(); \r\n");
grava("    $count = $" + parse.nomeEntidade 
    + "->getCount($id_centro, $pesq); \r\n");
grava("// obtem registros \r\n");
grava("    $rs = $" + parse.nomeEntidade 
    + "->select($id_centro, $pesq); \r\n");
grava("\r\n");


grava("Arch::initView(TRUE); \r\n");
grava("    $space5     = str_repeat(\"&nbsp\", 5); \r\n");
grava("    $space10    = str_repeat(\"&nbsp\", 10); \r\n");

grava("    echo \"<p class=appTitle2>");
grava(parse.nomeClasse + "</p>\"; \r\n");
grava("    echo \"<form>\"; \r\n");
grava("    echo \"<div>\"; \r\n");
grava("// texto, botão apaga e botão pesquisa \r\n");
grava("    botaoPesquisa($pesq); \r\n");
grava("    echo \"</div>\"; \r\n");
grava("    echo \"</form>\"; \r\n");

grava("// monta lista na tabela html \r\n");
grava("    echo \"<div class='tableFixHead'>\"; \r\n");
grava("    echo \"<table>\"; \r\n");
grava("    echo \"<thead>\"; \r\n");
grava("    echo \"<tr class='blue'>\"; \r\n");
grava("// titulos colunas \r\n");
        for (int i = 0; i < parse.idxColuna; i++) {
            if (parse.nomeColuna[i]
                .equalsIgnoreCase("id_centro"))
                continue;   // omite duplicidade id_centro
grava("    echo \"<th align='left'>"
            + parse.tituloColuna[i] 
            + "</th>\"; \r\n");
        }
grava("    echo \"</tr>\"; \r\n");
grava("    echo \"</thead>\"; \r\n");

grava("// para cada linha \r\n");
grava("    while ($reg = $rs->fetch() ){ \r\n");
grava("        $" + idEntidade 
        + " = $reg[\"" + idEntidade 
        + "\"]; \r\n");

        for (int i = 0; i < parse.idxColuna; i++) {
            if (parse.nomeColuna[i]
                .equalsIgnoreCase("id_centro"))
                continue;   // omite duplicidade id_centro
            if (parse.nomeColuna[i]
                .equalsIgnoreCase(idEntidade))
                continue;   // omite duplicidade id

grava("        $" + parse.nomeColuna[i] 
        + " = $reg[\"" 
        + parse.nomeColuna[i] + "\"]; \r\n");

grava("        $" + parse.nomeColuna[i] + "_url "); // urlencode
grava("= urlencode($" + parse.nomeColuna[i] + "); \r\n"); // urlencode
        }
grava("// evento on click \r\n");
grava("        echo \"<tr onclick\"; \r\n");
grava("        echo \"=window.location.href\"; \r\n");
grava("        echo \"='$callback\"; \r\n");
grava("        echo \"?id_" 
            + parse.nomeEntidade + "=$id_" 
            + parse.nomeEntidade + "\"; \r\n");

        for (int i = 0; i < parse.idxColuna; i++) {
            if (parse.nomeColuna[i]
                .equalsIgnoreCase(idEntidade))
                continue;   // omite duplicidade id_entidade
            if (parse.nomeColuna[i]
                .equalsIgnoreCase("id_centro"))
                continue;   // omite duplicidade id_centro
grava("        echo \"&" 
            + parse.nomeColuna[i] + "=$" 
            + parse.nomeColuna[i] + "_url\"; \r\n");
        }
grava("        echo \"&flag_lido=lido'></a>\"; \r\n");
grava("// colunas a exibir \r\n");
        for (int i = 0; i < parse.idxColuna; i++) {
            if (parse.nomeColuna[i]
                .equalsIgnoreCase("id_centro"))
                continue;   // omite duplicidade id_centro
grava("        echo \"<td>$" 
                + parse.nomeColuna[i] + "</td>\"; \r\n");
        }
grava("        echo \"</tr>\"; \r\n");
grava("    } \r\n");
grava("    echo \"</table>\"; \r\n");
grava("    echo \"</div>\"; \r\n");
grava("    echo \"$space10 ($count itens)\"; \r\n");

// identifica versao
grava("    echo \"<p style='font-size:70%;'>");
grava("GeraDominio " + parse.dataSys + "</p>\"; \r\n");

grava("Arch::endView(); \r\n");
grava("?> \r\n");

        gravaIo.fechaSaida();
    }
}
