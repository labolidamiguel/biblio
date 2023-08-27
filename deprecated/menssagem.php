<?php
include "../common/arch.php";
include "../classes/class.app.php";
Arch::initController();
Arch::initView();

	$code = Arch::get("code");

	echo "<br><br><br><br><br><br><center>";

	/* Atencao: Todas as menssagens devem estar pre-registradas 
	   com um codigo aqui HardCoded para evitar abusos por terceiros */

	if ( $code=="M01" ) { echo "Problemas na entrada de valores.";}//Suspeita de SQL-Injection
  //if ( $code=="H505" ) { echo "blablabla.";}

	echo "</center>";

Arch::endView();
?>