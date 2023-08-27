<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";

Arch::initController("@");

Arch::deleteAllCookies(); // DELETE COOKIES DO BROWSER MENOS A DE CONTROLE DO INDICE DE SESSAO!

    $app = new App();   

// desabilita o aplicativo quando 
// usuario não possui perfis 9
// e na tabela app
// coluna codigo = stop 
// e coluna titulo = s
    $perfis_usuario = $_SESSION["perfis_usuario"];
    if (strpos($perfis_usuario, "9") === false) { // se não e root
        $rs = $app->select_codigo("stop"); 
        $reg = $rs->fetch(); 
        $titulo = $reg["titulo"]; 
        if (strcmp(strtoupper($titulo), "S") == 0) {
            header("Location: ../stop.html");
        }
    }

Arch::initView(TRUE);
?>
    <style>
        .btn {
            border: none;
            color: white;
            padding: 10px 12px;
            margin: 5px 5px;
            width: 150px; !important;
            font-size: 18px;
            text-align: left;
            cursor: pointer;
        }
        .ima {
            width:22px; height:22px;
        }
        .btn:hover {
          background-color: RoyalBlue;
        }
    </style>

<?php
    // MENU - APRESENTA BOTOES SEGUNDO PERFIL DO USUARIO

    if ( isset($_SESSION["perfis_usuario"])) {
        $userPerfis = $_SESSION["perfis_usuario"]; // declarada e recolhidaDB no login.web
    }

    Arch::deleteCookie("pesq");         // inicializa string
//    $app = new App();
    $rs = $app->select_all();       //ordem
    while( $reg = $rs->fetch()){        // PDO
        $id_app = $reg["id_app"];
        $codigo = $reg["codigo"];
        $titulo = $reg["titulo"];
        $imagem = $reg["imagem"] ;
        $perfil_app = $reg["perfil_app"];
        $url    = $reg["url"]   ;
        
        if (strlen($titulo) > 2) { // Se "tituloApp" vazio nao pinta botao
            $found = strpos($userPerfis, $perfil_app);
            // Arch::logx("main.web:menu:found=".$found);
            // O strpos nao devolve sempre int. 
            // caso NotFound deveria devolver -1 ou boolean false 
            // safe colors 0 3 6 9 C F
            switch($perfil_app) {
                case 0: $corfundo = "#90C"; break; // violeta
                case 1: $corfundo = "#08F"; break; // azul
                case 3: $corfundo = "#0A9"; break; // verde
                case 5: $corfundo = "#BB0"; break; // amarelo
                case 7: $corfundo = "#C60"; break; // laranja
                case 9: $corfundo = "#700"; break; // vermelho
                default: $corfundo = "#A00"; break;
            } 

            if (strlen($found) > 0) {
                echo "<a href=$url>";
                echo "<button class='btn' style='background-color:$corfundo'>";
                echo "<img src='../layout/img/$imagem' class='ima'>";
                echo "&nbsp";
                echo $titulo;
                echo "</button></a>";
            }
        }
    }

Arch::endView();
?>