<?php
header('Content-Type: text/html; charset=iso-8859-1');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
	    <title>Restore Database Biblio</title>
		<meta charset="ISO-8859-1"> 
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"> 
	</head>
	<body>
	<?php
		echo "restoring sql .... ";

		// FILE READ
		$filename = "restore.sql";
		$fp   = fopen ( $filename, "r");
		$sqls = fread( $fp , filesize($filename) );
		fclose($fp);

		// Split into array of SQLs
		$arrSql = explode( ";" , $sqls ); 

		// DATABASE
		$SQLite = new SQLite3("../DATABASE/biblio.db");

		for ($i = 0; $i < count($arrSql); $i++) { // Loop SQLss
			$sql = $arrSql[$i] ;
			echo "<br> SQL::" . $sql;

			$bool = $SQLite->exec($sql);          // EXECUTE SQL s s

			if (! $bool ) {
				echo "ERROR SQL " . $sql;
			}

		}
	?>
	</body>
</html>