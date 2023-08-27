<?php // http://127.0.0.1:88/miguel/biblio/DATABASE/sqlmanager.php
header('Content-Type: text/html; charset=iso-8859-1');

GLOBAL $action; $action = "";

if ( isset($_REQUEST["sql"])      ) { $sql     = $_REQUEST["sql"]; } else { $sql="";}
if ( isset($_REQUEST["btParam1"]) ) { $action ="1"; /*$paramSelect = $_REQUEST["SELECT"];strlen($paramExec)*/ }
if ( isset($_REQUEST["btParam2"]) ) { $action ="2"; /*$paramExec   = $_REQUEST["EXEC"];*/ }
?>
<html>
	<head><title>SQL Man</title></head>
	<body>
		<h3> PHP SQLite3 Manager </h3>
		<form method="GET" action="">
			<textarea name="sql" rows="10" cols="160"><?php echo $sql?></textarea> <br>
			<input type="submit" name="btParam1" value="SELECT + resultSet">
			<input type="submit" name="btParam2" value="EXECUTE update delete drop etc">
		</form>
			<hr>
			<br> create table user ( id varchar , name varchar);
			<br> insert into  user ( id , name ) values('001','leonardo');
			<br> select * from autor SYSUSER autor SYSUSER bibliotecario cde config editora emprestimo espirito exemplar leitor publicado relatorio titulo tradutor 
			<hr>


	<?php
	$db = new SQLite3("biblio.db");

	if ($action=="1") {
		echo "<br> Executing sql :<br><pre>" . $sql . "</pre><br><br>";
		$sqlite3result = $db->query( $sql );
		if($sqlite3result==FALSE){
			echo "<br>::Error sqlError ".$db->lastErrorMsg();
			echo "<br>::Error sql ".$sql;
		}
		echo "<table border=0 style='background-color:#EEE;'>";
		echo "<tr'>";
		for( $i=0; $i<$sqlite3result->numColumns(); $i++) { 
			echo "<td style='background-color:#EEE;'>" . $sqlite3result->columnName($i) . "</td>";
		}
		echo "<tr>";
		while( $row = $sqlite3result->fetchArray() ){
			echo "<tr'>";
			for( $i=0; $i<$sqlite3result->numColumns(); $i++) { 
				echo "<td style='background-color:#FFF;'>" . $row[$i] . "</td>";
			}
			echo "<tr>";
		}
		echo "</table>";
	}

	if ($action=="2") {  // exec update delete create drop etc
		echo "running sql " . $sql . "<br>";
		$db->exec($sql);
	}


	?>


	</body>
</html>