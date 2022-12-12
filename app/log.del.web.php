<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
Arch::initController("log");
	
	Arch::FileWrite("../log/log.html",""); // escrevendo EMPTY no Arquivo log.html

Arch::initView(TRUE);  

	echo " LOG eliminado!";
	echo "<br><br><a href='log.read.web.php'>voltar</a>";


Arch::endView();
?>