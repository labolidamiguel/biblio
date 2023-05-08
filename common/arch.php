<?php
/**************************************************************
ARCH - ARCHTECTURE
***************************************************************/

session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Arch {

    static function versao() {          // versao do sistema
        return "1.03";
    }

    /***********************************************************
    initWebApp : Inicializa a WebPageApplication
    PARAM      : Titulo da pagina - onde via query.sql obtemos o application_perfil
    VALIDATIONS:
        user_session ok
        user_perfil match application_perfil
    ************************************************************/
    static function initController( $codigo="" ) {

        $_SESSION["codigo_app"] = $codigo; // miguel 20200626

        // LOG SEGURANCA
        self::logg("<hr>");

        $uri = ""; 
        if (isset($_SERVER["REQUEST_URI"]))
            {$uri =$_SERVER["REQUEST_URI"];}
        self::logg("<h2>" . $uri . "</h2>");

        self::logg("DATETIME:" . date('d-m-Y H:i:s') );

        $cookie = ""; 
        if (isset($_SERVER["HTTP_COOKIE"]))
            {$cookie =$_SERVER["HTTP_COOKIE"];}
        self::logg(" [COOKIEs]:" . $cookie);


        $arrkey = array_keys($_SESSION);
        if ( sizeof($arrkey)>4 ){ self::logg("Atencao:Existem mais de 4 variaveis de sessao!","1"); }
        for ( $i=0 ; $i<sizeof($arrkey) ; $i++ ) {
            $key = $arrkey[$i];
            if (isset($_SESSION[$key]) && ! is_array($_SESSION[$key]) ) {
                self::logg("  [SESSION] ". $key . ": " . $_SESSION[$key]);
            }
        }
        $arrkey = array_keys($_COOKIE);
        for ( $i=0 ; $i<sizeof($arrkey) ; $i++ ) {
            $key = $arrkey[$i];
            if (isset($_COOKIE[$key]) && ! is_array($_COOKIE[$key]) ) {
                self::logg("  [COOKIE] ". $key . ": " . $_COOKIE[$key]);
            }
        }
        $buff="";// temp buffer Server variables
        $arrkey = array_keys($_SERVER);
        for ( $i=0 ; $i<sizeof($arrkey) ; $i++ ) {
            $key = $arrkey[$i];
            if (isset($_SERVER[$key])  &&  !is_array($_SERVER[$key]) ) {
                $buff=$buff." ".$key.":".$_SERVER[$key];
            }
        }
        self::logg("  ServerVars:".$buff,"2");

        $arrkey = array_keys($_GET);
        for ( $i=0 ; $i<sizeof($arrkey) ; $i++ ) {
            $key = $arrkey[$i];
            if (isset($_GET[$key])  &&  !is_array($_GET[$key])  ) {
                self::logg("  [GET] ". $key . ": " . $_GET[$key]);
            }
        }
        $arrkey = array_keys($_POST);
        for ( $i=0 ; $i<sizeof($arrkey) ; $i++ ) {
            $key = $arrkey[$i];
            if (isset($_POST[$key])  &&  !is_array($_POST[$key]) ) {
                self::logg("  [POST] ". $key . ": " . $_POST[$key]);
            }
        }
        $arrkey = array_keys($_REQUEST);
        for ( $i=0 ; $i<sizeof($arrkey) ; $i++ ) {
            $key = $arrkey[$i];
            if (isset($_REQUEST[$key]) && ! is_array($_REQUEST[$key]) ) {
                self::logg("  [REQUEST]:". $key . ": " . $_REQUEST[$key]);
                self::SqlInjection($_REQUEST[$key]);
            }
        }

        if ( strlen($codigo)>0 ) {                          // SECURE VALIDATION FOR WEB-APP UNDER LOGON

            if ( isset($_SESSION["nome"])==0 ) {            // VALIDA IF LOGADO
                header("Location: login.web.php");
            }

            // BACALHAU NOJENTO PRA BURLAR A SEGURANCA DO CODIGO DA APLICACAO strlen($codigo)>1
            if ( strlen($codigo)>1 ) {
                $perfil_app="";
                $result="";

                $app = new App();                                // VALIDANDO O PERFIL : USUARIO X WEB-APP
                $rs = $app->select_codigo($codigo);              // SQL SELECT APP_PERFIL FROM APP WHERE TITULO
                while($reg = $rs->fetch()){ // PDO
// Somente deveria existir 1 um registro
                    $perfil_app = $reg["perfil"];                // Perfil da APPlicacao
                }

                if ( isset($_SESSION['perfis']) && isset($perfil_app)) {
                    $result = strpos( $_SESSION["perfis"] , $perfil_app ) ;
                }

                if ( strlen($result)<=0) {
                    echo "<h2>Perfil não autorizado</h2> Desculpe, você não têm acesso a esta funcionalidade.";
                    self::logg("Profile denied! Actual is " . $_SESSION["perfis"] . " required is " . $param );
                    exit();
                }
            }
        }

    }


    /*********************************************************
    Initializa o layout html da applicacao
    PARAMETER admin default=false
        admin=false // usado para a web        publica [OPEN]
        admin=true  // usado para a web-admin  privada [SECURED]
    *********************************************************/
    static function initView( $admin=FALSE , $hide=FALSE) {

        self::logg("[ARCH.initView]");

        // HEAD para NAO Cachear. Isto deve ser usado em desenvolvimento.
        header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
        header("Pragma: no-cache"); //HTTP 1.0
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        //HEAD para cachear. Isto deve de ser ativado em Producao
        //header("Cache-Control: max-age=86400"); //(60sec * 60min * 24hours * 1days) 86400
        header('Content-Type: text/html; charset=iso-8859-1'); // LATIN charset

        # Incluir HTML.content.head+body
        if ($hide==false) {
            if ($admin) {
                include "../layout/inc.layout.head.admin.php";
            }else{
                include "../layout/inc.layout.head.login.php";
            }
        }
    }


    /*********************************************************
    LAYOUT - Finaliza o layout HTML
    *********************************************************/
    static function endView(){
        include "../layout/inc.layout.foot.php";    // HTML
    }


    /***********************************************************
    DATABASE - DUMP/DEBUG de ResultSet de SQL 
    bom para depuracao simples e rapida
    ***********************************************************/
    static function debugRS($rs){
        echo "<br> Debug ResultSet (lib.util.php). Parameter=";
        var_dump($rs);
        while ($reg = $rs->fetch()){    // PDO
            echo "<br>" . $reg[0] . $reg[1] ;
        }
    }

    /******************************************************
    REQUEST, GET, POST, SERVER, ENV
    *******************************************************/
    static function get($param) {
        if ( isset($_GET[$param])) {
            return $_GET[$param];
        }else{
            return "";
        }
    }

    static function post($param) {
        if ( isset($_POST[$param])) {
            return $_POST[$param];
        }else{
            return "";
        }
    }

    static function request($param) {
        if ( isset($_REQUEST[$param])) {
            return $_REQUEST[$param];
        }else{
            return "";
        }
    }

    static function cookie($param) {
        if ( isset($_COOKIE[$param])) {
            return $_COOKIE[$param];
        }else{
            return "";
        }
    }

    static function requestOrCookie ( $key ) {
        if ( isset($_GET[$key])) {
            setcookie ( $key , $_GET[$key]  );
            return $_GET[$key];
        }else{
            if (isset($_COOKIE[$key])) {
                return $_COOKIE[$key];
            }else{
                //setcookie ( $key , ""  );
                return "";
            }
        }
    }

    static function session($param) {
        if ( isset($_SESSION[$param])) {
            return $_SESSION[$param];
        }else{
            return "";
        }
    }


    static function deleteCookie( $param ) {
        setcookie($param, "" ,time() - 3600);
    }

    static function deleteAllCookies() {
        $PHP_SESSION_COOKIE="PHPSESSID";
        $arrkey = array_keys($_COOKIE);
        for ( $i=0 ; $i<sizeof($arrkey) ; $i++ ) {
            $key = $arrkey[$i]; // each key
            if ( isset($_COOKIE[$key]) && $key!=$PHP_SESSION_COOKIE ) { // Nao destroi indexSession!!!
                setcookie($key, "" ,time() - 3600);
            }
        }
    }

    /* SQL INJECTION VALIDATION SUSPICIOUS HACKER VULNERABILITY ATTACK */
    static function SqlInjection($param) {
        $b = FALSE ;                        // No problem (Boolean)
        $param="A".$param;                  // CONCATENA UN CHAR PARA QUE O STRPOS FUNCIONE
        $param=strtoupper($param);          // UPPERCASE
        if ( strpos( $param , "'"     )>0)  { $b=TRUE; }
        //if ( strpos( $param , "%"     )>0)  { $b=TRUE; }
        //if ( strpos( $param , "OR"    )>0)  { $b=TRUE; }
        //if ( strpos( $param , "DELETE")>0)  { $b=TRUE; }
        //if ( strpos( $param , "INSERT")>0)  { $b=TRUE; }
        //if ( strpos( $param , "UPDATE")>0)  { $b=TRUE; }
        //if ( strpos( $param , "SELECT")>0)  { $b=TRUE; }
        //if ( strpos( $param , "--"    )>0)  { $b=TRUE; }
        //if ( strpos( $param , "/*"    )>0)  { $b=TRUE; }

        if ($b) {
            self::logg("<b>Suspicious of SQL Injection!</b> REQUEST=" . $param );
            //// str_replace("'", "", $param); Melhor nao replace but bloquear!
            self::deleteAllCookies(); // Alguma cookie pode estar infectada. Limpar!
            header("Location: menssagem.php?code=M01");
        }


    }


    /******************************************************
    LOG no arquivo do SERVER
    *******************************************************/
    static function logg($msg , $code=0){
        if ($code==1) { $msg="<font color='AA0000'><b>".$msg."</b></font>"; }  // RED Warning or Error
        if ($code==2) { $msg="<font color='888888'><i>".$msg."</i></font>"; }  // SoftGray
        self::FileAppend("../log/log.html","\n<br>" . $msg );
    }



    /******************************************************
    ARQUIVO - LER
    *******************************************************/
    static function FileRead($filename) {
        if ( is_file($filename) ){
            $fp = fopen ( $filename, "r");
            $txt = fread( $fp , filesize($filename) );
            fclose($fp);
            return $txt;
        }else{
            return "ERROR. FILE NOT FOUND " . $filename;
        }
    }

    /******************************************************
    ARQUIVO - ESCREVE - If file no exit then cria
    ******************************************************/
    static function FileWrite($filename, $body) {
            $fp = fopen ( $filename, "w+");        #grava nuevo o remplaza
            fwrite( $fp , $body );
            fclose($fp);
    }

    /*****************************************************
    ARQUIVO - ESCREVE COM APPEND
    ******************************************************/
    static function FileAppend($filename, $body) {
        if ( is_file($filename) ){
            $fp = fopen ( $filename, "a");
            fwrite( $fp , $body );
            fclose($fp);
        }
    }
}
?>
