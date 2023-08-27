<?php
/*
http://127.0.0.1:88/miguel/biblio/DATABASE/chat.php
http://labolida.com/miguel/biblio/DATABASE/chat.php
*/
//----------------------------------------------------------------------------
	session_start();

	if ( strlen($_SESSION["logged"])==0 ) {         // SECURITY VALIDATION
		echo "Usuario nao logado no biblio!";
		exit();
	}
//----------------------------------------------------------------------------
?>
<html>
<head>
    <title>CHAT_BIBLIO</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
</head>
<body style="margin:4px;padding:4px;font-family:verdana;font-size:18px;color:#8396bb;">

    <form>
        <input type="text"   name="message" value=""     size="50">
        <input type="submit" name=""        value=" send / refresh ">
    </form>

	<?php 
	//----------------------------------------------------------------------------
		// WRITE NEW MESSAGE FROM FORM INTO FILE
		$msg = $_REQUEST["message"];
		if ( strlen($msg)>2) {
			$content = fileRead();
			$content = "\n" . date("Y-m-d H:i:s") . " - - ". $msg . $content;
			fileWrite($content);
		}

		// SHOW MESSAGES FROM FILE
		echo "<pre>" . fileRead() . "</pre>";
	//----------------------------------------------------------------------------
	?>

</body>
</html>

	<?php
	//----------------------------------------------------------------------------
	function fileWrite( $content ) {
	    $fp=fopen("./chat.txt","w");   // w,a
	    fwrite($fp, $content);
	    fclose($fp);
	}
	//----------------------------------------------------------------------------
	function fileRead(){
		$fp = fopen("./chat.txt","r");
		$content = fread($fp , filesize("./chat.txt") );
		fclose($fp);
	  return $content;
	}
	//----------------------------------------------------------------------------
	?>