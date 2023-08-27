// FonteExclui
import java.io.*;
import java.io.FileReader;
import java.io.IOException;

public class FonteExclui {
    static Parse parse = new Parse();
    static GravaIo gravaIo = new GravaIo();
    static String idEntidade;
    public static void grava(String linha) {
        GravaIo.grava(linha);
    }

    public static void cria() {
        gravaIo.abreSaida(parse.nomeEntidade, "exclui");
        idEntidade = "id_" + parse.nomeEntidade;

grava("<?php                   // ");
grava(parse.nomeEntidade);
grava(".exclui.php\r\n");
grava("// criado por GeraExclui em ");
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

grava("// include \"../classes/class.auditoria.php\"; \r\n");
grava("\r\n");


grava("Arch::initController(\"");
grava(parse.nomeEntidade);
grava("\"); \r\n");
grava("    $id_centro = Arch::session(\"id_centro\"); \r\n");
grava("    $");
grava(idEntidade);
grava(" = Arch::get(\"");
grava(idEntidade);
grava("\"); \r\n");
grava("    $action = Arch::get(\"action\"); \r\n");
grava("\r\n");
grava("// instancia classe(s) \r\n");
grava("    $");
grava(parse.nomeEntidade);
grava(" = new ");
grava(parse.nomeClasse);
grava("(); \r\n");
grava("//    $auditoria = new Auditoria(); \r\n");
grava("// obtém dados das colunas \r\n");
grava("    $rs = $");
grava(parse.nomeEntidade);
grava("->selectId(");
        if (parse.nomeColuna[0].equalsIgnoreCase("id_centro")) {
grava("$id_centro, ");
        }
grava("$" + idEntidade + "); \r\n");

grava("    $reg = $rs->fetch(); \r\n");
        for (int i = 0; i < parse.idxColuna; i ++) {
            if (parse.nomeColuna[i].equalsIgnoreCase("id_centro"))
                continue;   // omite id_centro
            if (parse.nomeColuna[i].equalsIgnoreCase(idEntidade))
                continue;   // omite idEntidade
grava("    $");
grava(parse.nomeColuna[i]);
grava(" = $reg[\"");
grava(parse.nomeColuna[i]);
grava("\"]; \r\n"); 
        }
grava("// valida integridade referencial \r\n");
grava("    $msg = $");
grava(parse.nomeEntidade);
grava("->integridade(");
        if (parse.nomeColuna[0].equalsIgnoreCase("id_centro")) {
grava("$id_centro, ");
        }
grava("$");
grava(idEntidade);
grava("); \r\n");
grava("    if (strlen($msg) == 0) { \r\n");
grava("        if ($action == 'Confirma') { \r\n");
grava("// exclui instância \r\n");
grava("            $err = $");
grava(parse.nomeEntidade);
grava("->delete(");
        if (parse.nomeColuna[0].equalsIgnoreCase("id_centro")) {
grava("$id_centro, ");
        }
grava("$" + idEntidade + "); \r\n");
grava("            if (strlen($err) > 0) { \r\n");
grava("                $msg=\"<p class=texred> \r\n");
grava("                * Erro $err</p>\"; \r\n");
grava("            }else{ \r\n");
grava("                $msg=\"<p class=texgreen>* ");
grava(parse.nomeClasse);
grava(" excluido</p>\"; \r\n");
grava("//                $auditoria->report(\"Exclui ");
grava(parse.nomeEntidade);
grava(" $id_centro, $id_");
grava(parse.nomeEntidade);
grava("\"); \r\n");
grava("// desabilitada temporariamente\r\n");
grava("            } \r\n");
grava("        } \r\n");
grava("    } \r\n");
grava("\r\n");


grava("Arch::initView(TRUE); \r\n");
grava("    echo \"<form method='get'>\"; \r\n");
grava("    echo \"<p class=appTitle2>");
grava(parse.nomeClasse);
grava("</p>\"; \r\n");
grava("    echo \"<table class='tableraw'>\"; \r\n");
grava("// colunas a exibir \r\n");
        for (int i = 0; i < parse.idxColuna; i ++) {
           if (parse.tipoColuna[i].equalsIgnoreCase("p"))
               continue;    // omite coluna password 
grava("    echo \"<tr><td>");
grava(parse.tituloColuna[i]);
grava("</td><td>$");
grava(parse.nomeColuna[i]);
grava("</td></tr>\"; \r\n");
        }   // for
grava("    echo \"</table>\"; \r\n");
grava("    echo \"<b>$msg</b> <br><br>\"; \r\n");
grava("// se não hover erro solicita confirmação \r\n");
grava("    if (strlen($msg) == 0) { \r\n");
grava("        echo \"<p class='texgreen'>\"; \r\n");
grava("        echo \"* Confirma a exclusão?</p> <br>\"; \r\n");
grava("        echo \"<input type='hidden' name='action' \"; \r\n");
grava("        echo \"value='Confirma'/>\";  \r\n");
grava("        echo \"<input type='hidden' name='");
grava(idEntidade);
grava("' \"; \r\n");
grava("        echo \"value='$");
grava(idEntidade);
grava("'/>\"; \r\n");
grava("// botão de confirmação \r\n");
grava("        echo \"<button type='submit' \"; \r\n");
grava("        echo \"class='butbase' \"; \r\n");
grava("        echo \"formaction='\"; \r\n");
grava("        echo \"'>Confirma</button>\"; \r\n");
grava("    } \r\n");

grava("// botão Volta \r\n");
grava("    botaoVolta(\"");
grava(parse.nomeEntidade + ".lista.php");
grava("\"); \r\n");
grava("    echo \"</form>\"; \r\n");

// identifica versao
grava("    echo \"<p style='font-size:70%;'>");
grava("GeraExclui " + parse.dataSys + "</p>\"; \r\n");

grava("Arch::endView(); \r\n");
grava("?> \r\n");

        gravaIo.fechaSaida();
    }
}
