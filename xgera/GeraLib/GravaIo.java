// GravaIo
import java.io.*;
import java.io.FileReader;
import java.io.IOException;

public class GravaIo {
    static BufferedWriter saida = null;

    public static void abreSaida(
        String nomeClasse, String tipo) {
        try {
            String nomePHP = nomeClasse.toLowerCase();
            FileWriter fw = null;
            fw = new FileWriter(nomePHP
            + "." + tipo + ".php");
            saida = new BufferedWriter(fw);
        }
        catch (Exception e) {
            System.out.println("abreSaida: " + e.getMessage());
        }
    }

    public static void fechaSaida() {
        try {
            saida.close();
        }
        catch (Exception e) {
            System.out.println("fechaSaida: " + e.getMessage());
        }
    }

    public static void grava(String linha) {
        try {
            saida.write(linha);
        }
        catch (Exception e) {
            System.out.println("grava: " + e.getMessage());
        }
    }
}
