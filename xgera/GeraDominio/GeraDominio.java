// Gteste
import java.io.*;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;

public class GeraDominio {
    static Parse parse = new Parse();

    public static void main(String[] args) {
        if (args.length != 1) {
            parse.ajuda("GeraDominio");
            try {System.in.read(); }
            catch (Exception e) {}
            System.exit(0);
        }
        parse.parse(args[0]);
        FonteDominio fonteDominio = new FonteDominio();
        fonteDominio.cria();
    }
}
