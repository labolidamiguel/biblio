// FonteForm
import java.io.*;
import java.io.FileReader;
import java.io.IOException;

public class FonteForm {
    static Parse parse = new Parse();
    static GravaIo gravaIo = new GravaIo();

    public static void grava(String linha) {
        GravaIo.grava(linha);
    }
    public static void cria() {
        gravaIo.abreSaida(
            parse.nomeEntidade, "form");

grava("<?php                   // ");
grava(parse.nomeEntidade);
grava(".form.php \r\n");
grava("// criado por GeraForm em ");
grava(parse.dataSys + "\r\n");


grava("    echo \"<form method='get'>\"; \r\n");
grava("    echo \"<p class=appTitle2>");
grava(parse.nomeClasse);
grava("</p>\"; \r\n");
grava("\r\n");

// cria campos
    for (int i = 0; i < parse.idxColuna; i ++) {
        if (parse.nomeColuna[i].equalsIgnoreCase("id_centro")) {
            continue;           // omite coluna id_centro
        }
        switch(parse.tipoColuna[i].toUpperCase()) {
        case "A":       // textarea
            criaTextarea(i);
            break;
        case "D":       // data dd/mm/aaaa
            criaData(i);
            break;
        case "F":       // foreign key (dominino)
            criaDominio(i);
            break;
        case "P":       // password
            criaPassword(i);
            break;
        case "R":       // texto readonly
            criaReadonly(i);
            break;
        case "S":       // selecao - combo
            criaSelect(i);
            break;
        case "X":       // texto
            criaTexto(i);
            break;

        }
    }
// fim cria campos
grava("    echo \"<br><b>$msg</b><br>\"; \r\n"); // mensagens
grava("?> \r\n");

        gravaIo.fechaSaida();
    }

    public static void criaTextarea(int i) {
    }

    public static void criaDominio(int i) {
grava("// dominio " + parse.dominio[i] 
    + " " + parse.nomeColuna[i] + "\r\n");
grava("    echo \"<p class=labelx>");
grava(parse.nomeColuna[i]);
grava("</p>\"; \r\n");
grava("    echo \"<input type='text' name=\"; \r\n");
grava("    echo \"'");
grava(parse.nomeColuna[i] + "' \"; \r\n");
grava("    echo \"class='inputx' value='$");
grava(parse.nomeColuna[i] + "'\"; \r\n");
grava("    echo \"readonly/>\"; \r\n");
grava("    echo \"<a href='cde.dominio.php\"; \r\n");
grava("    echo \"?callback=");
grava(parse.nomeEntidade);
grava(".$operacao.php\"; \r\n");

grava("    echo \"&target=");
grava(parse.nomeColuna[i] + "\"; \r\n");

grava("    echo \"&source=");
grava(parse.dominioColuna[i] + "'>\"; \r\n");

grava("    echo \"<img border='0' class='butimg'; alt='alt' \"; \r\n");
grava("    echo \"src='../layout/img/alte2.ico' \"; \r\n");
grava("    echo \"style='width: 26px; margin-left:-2px; \"; \r\n");
grava("    echo \"margin-bottom:1px;'>\"; \r\n");
grava("    echo \"</a>\"; \r\n");
    }

    public static void criaData(int i) {
    }

    public static void criaPassword(int i) { // P password
grava("    if (strnatcasecmp($operacao, \"cria\") == 0) { \r\n");
grava("// input tipo password \r\n");
grava("        echo \"<p class=labelx>");
grava(parse.tituloColuna[i]);
grava("</p>\"; \r\n");

grava("        echo \"<input type='password' name='");
grava(parse.nomeColuna[i] + "' \"; \r\n");
grava("        echo \"class='inputx' value='$");
grava(parse.nomeColuna[i] + "'/>\"; \r\n");
grava("    } \r\n");

grava("    if (strnatcasecmp($operacao, \"altera\") == 0) { \r\n");
grava("        echo \"<input type='hidden' name='");
grava(parse.nomeColuna[i] + "' \"; \r\n");
grava("        echo \"class='inputx' value='$");
grava(parse.nomeColuna[i] + "'/>\"; \r\n");
grava("    } \r\n");

grava("\r\n");
    }

    public static void criaReadonly(int i) {
grava("    echo \"<p class=labelx>");
grava(parse.tituloColuna[i]);
grava(": $");
grava(parse.nomeColuna[i]);
grava("</p>\"; \r\n");
grava("\r\n");
    }

    public static void criaSelect(int i) {
grava("// cria lista seleção e a posiciona \r\n");
grava("    echo \"<p class=labelx>");
grava(parse.tituloColuna[i]);
grava("</p>\"; \r\n");
grava("// select para " + parse.nomeColuna[i] + "\r\n");
grava("    echo \"<select name='"); // select
grava(parse.nomeColuna[i]);
grava("' class='inputx'>\"; \r\n");
grava("// options para " + parse.nomeColuna[i] + "\r\n");
        String[] val = parse.dominio[i].split("[:_]");
        for (int j = 0; j < val.length; j+=2) {
grava("    echo \"<option value='");
grava(val[j]);
grava("'\"; \r\n");
grava("    if (strcasecmp($");
grava(parse.nomeColuna[i]);
grava(", '" + val[j] + "') == 0) \r\n");
grava("        echo \" selected\"; \r\n");
grava("    echo \">");
grava(val[j] + " " + val[j+1] + "</option>\"; \r\n");
        }
grava("    echo \"</select>\"; \r\n");
grava("\r\n");
    }

    public static void criaTexto(int i) {
grava("    echo \"<p class=labelx>");
grava(parse.tituloColuna[i]);
grava("</p>\"; \r\n");
grava("    echo \"<input type='text' name='");
grava(parse.nomeColuna[i] + "' \"; \r\n");
grava("    echo \"class='inputx' value='$");
grava(parse.nomeColuna[i] + "'/>\"; \r\n");
grava("\r\n");
    }
}
