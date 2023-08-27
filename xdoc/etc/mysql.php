<?php
/*

Documentacion mierda
	https://www.php.net/manual/en/ref.pdo-mysql.php

Documentacion regular
	https://www.w3schools.com/php/php_mysql_connect.asp

Documentacion completa
	https://phpdelusions.net/pdo


	PDO will work on 12 different database systems, whereas MySQLi will only work with MySQL databases.
	URL_CONNECTION = mysql:host=localhost;dbname=test;port=3306;charset=utf8mb4


		SQUIRREAL - jdbc:mysql://127.0.0.1:3306/labolida_biblio?user=***&password=***

		http://127.0.0.1:88/miguel/biblio/DATABASE/mysql.php
*/

	/*  TEST IF PDO IS INSTALLED
	if ($db->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') {
	    $stmt = $db->prepare('select * from foo',array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
	} else {
	    die("my application only works with mysql; I should use \$stmt->fetchAll() instead");
	}*/


	// PRODUCTION NEVIRONMENT
	$HOST     = "63?????????";          // Pendente de achar o IP do MySQL Server de PRO
	$PORT     = "3306";
	$DATABASE = "labolida_biblio";
	$USER     = "labolida_biblio";
	$PASSWORD = "Arable123Biblio";

	// DEVELOPER ENVIRONMENT
	$HOST     = "127.0.0.1";
	$PORT     = "3306";
	$DATABASE = "labolida_biblio";
	$USER     = "root";
	$PASSWORD = "arable";

	$URL_CONNECTION = "mysql:host=".$HOST.";dbname=".$DATABASE."";

	$sql = "select * from usuario";
	echo "<br>sql:".$sql;
	
	$pdo = new PDO($URL_CONNECTION, $USER, $PASSWORD );
	echo "<br>pdo-ok";

	// pdo->exec(update,insert,delete) doesnot return ResultSet
	$rs = $pdo->query($sql); 
	echo "<br>query-ok";

	while ($row = $rs->fetch()) {
	    echo "<br>" . $row['nome'] . "\n";
	}

	$pdo->close(); 


	/* UAU!!
 			$sql = "UPDATE users SET name = ? WHERE id = ?";
			$pdo->prepare($sql)->execute([$name, $id]);
	*/

?>