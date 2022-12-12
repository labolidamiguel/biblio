<?php
include "../common/arch.php";
Arch::initController("@");    //Codigo de um character nao procuta na DB.table.app

	//echo "voce tem certeza? Sim Nao";

	$_SESSION["nome"]="";
	$_SESSION["id_centro"]="";
	$_SESSION["id_usuario"]="";
	$_SESSION["perfis"]="";
	
	$bool = session_unset(); // PHP Native function
	if ( !$bool ) {
		Arch::logg("<b>ERROR!!!</b> logoff.web.php - session_unset() return false.");
	}

	Arch::logg("LOGOFF by user.");


Arch::initView(TRUE);
?>

	<br><br><br><br><br><br>

	<center>
		A sua sess&atilde;o foi terminada corretamente. <br><br>
		Muito obrigado pela utiliza&ccedil;&atilde;o do sistema.<br><br>

		<br> <a href='../index.html'>Voltar ao in&iacute;cio</a>
	</center>

<?php
Arch::endView();
?>