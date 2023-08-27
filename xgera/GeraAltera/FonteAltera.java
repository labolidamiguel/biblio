// FonteAltera
import java.io.*;
import java.io.FileReader;
import java.io.IOException;

public class FonteAltera {
    static Parse parse = new Parse();
    static GravaIo gravaIo = new GravaIo();
    static String idEntidade;

    public static void grava(String linha) {
        gravaIo.grava(linha);
    }

    public static void cria() {
        gravaIo.abreSaida(parse.nomeEntidade, "altera");
        idEntidade = "id_" + parse.nomeEntidade;

grava("<?php                   // ");
grava(parse.nomeEntidade);
grava(".altera.php\r\n");
grava("// criado por GeraAltera em ");
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
grava("include \"../classes/class.auditoria.php\";\r\n");
grava("\r\n");


grava("Arch::initController(\"");
grava(parse.nomeEntidade);
grava("\"); \r\n");
grava("    $operacao = \"altera\"; \r\n");
        if (parse.nomeColuna[0].equalsIgnoreCase("id_centro")) {
grava("    $id_centro = Arch::session(\"id_centro\"); \r\n");
        }
grava("    $");
grava(idEntidade);
grava(" = Arch::get(\"");
grava(idEntidade);
grava("\"); \r\n");
grava("    $action    = Arch::get(\"action\"); \r\n");
grava("    $flag_lido = Arch::get(\"flag_lido\"); \r\n");
grava("// mantém dados em cookies \r\n");
        for (int i = 0; i < parse.idxColuna; i ++) {
            if (parse.nomeColuna[i].compareTo("id_centro") == 0)
                continue;   // omite duplicidade id
            if (parse.nomeColuna[i].compareTo(idEntidade) == 0)
                continue;   // omite duplicidade id
grava("    $");
grava(parse.nomeColuna[i]);
grava(" = Arch::requestOrCookie(\"");
grava(parse.nomeColuna[i]);
grava("\"); \r\n");
        }
grava("\r\n");
grava("    $msg = \"\"; \r\n");
grava("\r\n");
grava("// instancia classe(s) \r\n");
grava("    $");
grava(parse.nomeEntidade);
grava(" = new ");
grava(parse.nomeClasse);
grava ("(); \r\n");
grava("    $audit = new Auditoria(); \r\n");
grava("\r\n");
grava("// na primeira vez carrega do DB \r\n");
grava("    if (strlen($flag_lido) == 0) { \r\n");
grava("        $rs = $");
grava(parse.nomeEntidade);
grava("->selectId(");
        if (parse.nomeColuna[0].equalsIgnoreCase("id_centro")) {
grava("$id_centro, ");
        }
grava("$");
grava(idEntidade);
grava("); \r\n");
grava("        $reg = $rs->fetch(); \r\n");

grava("// obtém valores das colunas \r\n");
        for (int i = 0; i < parse.idxColuna; i ++) {
grava("        $");
grava(parse.nomeColuna[i]);
grava(" = $reg[\"");
grava(parse.nomeColuna[i]);
grava("\"]; \r\n");
        }
grava("    } \r\n");

grava("// validação \r\n"); 
grava("    if ($action == \"altera\") { \r\n");
grava("        $msg = $");
grava(parse.nomeEntidade);
grava("->valida( \r\n");
grava("// colunas a validar \r\n");
        for (int i = 0; i < parse.idxColuna; i ++) {
grava("            $");
grava(parse.nomeColuna[i]);
grava((i+1 == parse.idxColuna) ? "); \r\n" : ", ");
grava("\r\n");
        }
grava("        if (strlen($msg) == 0) { \r\n");
grava("            $err = $");
grava(parse.nomeEntidade);
grava("->update( \r\n");

grava("// colunas a atualizar \r\n");
        for (int i = 0; i < parse.idxColuna; i ++) {
grava("                $");
grava(parse.nomeColuna[i]);
grava((i+1 == parse.idxColuna) ? "); \r\n" : ", ");
grava("\r\n");
        }
// fim cria colunas insert
grava("            if (strlen($err) > 0) { \r\n");
grava("                $msg = \"<p class=texred> \r\n");
grava("                * Erro $err</p>\"; \r\n");
grava("            }else{ \r\n");
grava("                $msg=\"<p class=texgreen> \r\n");
grava("                * ");
grava(parse.nomeClasse);
grava(" alterado</p>\"; \r\n");
grava("//                $audit->report( \r\n");

grava("//                \"Cria $id_centro, ");
        for (int i = 0; i < parse.idxColuna; i ++) {
            grava("$");
            grava(parse.nomeColuna[i]);
            grava((i+1 == parse.idxColuna) ? "\"); \r\n" : ", ");
        }
grava("                Arch::deleteAllCookies(); \r\n");
grava("            } \r\n");
grava("        } \r\n");
grava("    } \r\n");
grava("\r\n");
// init view


grava("Arch::initView(TRUE); \r\n");
grava("include \"./");
grava(parse.nomeEntidade);
grava(".form.php\"; \r\n");
grava("\r\n");

grava("// botão altera - omite se já foi alterado \r\n");
grava("    if (! strpos($msg, \"alterado\")) { \r\n");
grava("        echo \"<button type='submit' name='action' \"; \r\n");
grava("        echo \"value='altera' class='butbase'> \r\n");
grava("        Altera</button>\"; \r\n");
grava("    } \r\n");
grava("    echo \"<input type='hidden' name='");
grava(idEntidade);
grava("'\"; \r\n");
grava("    echo \"value='$");
grava(idEntidade);
grava("'/>\"; \r\n");
grava("    echo \"<input type='hidden' name='flag_lido'\"; \r\n");
grava("    echo \"value='lido'/>\"; \r\n");

grava("\r\n");
grava("// botão volta \r\n");
grava("    botaoVolta(\"");
grava(parse.nomeEntidade + ".lista.php");
grava("\"); \r\n");
grava("    echo \"</form>\"; \r\n");

// identifica versao
grava("    echo \"<p style='font-size:70%;'>");
grava("GeraAltera " + parse.dataSys + "</p>\"; \r\n");

grava("Arch::endView(); \r\n");
grava("?> \r\n");

        gravaIo.fechaSaida();
    }
}
