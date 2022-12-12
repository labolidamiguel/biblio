<?php
include "../common/arch.php";
include "../classes/class.usuario.php";
include "../classes/class.centro.php";
Arch::initController("@");
    $centro = Arch::post("centro");
    $perfis = ARCH::session("perfis");
	$message="";
	//echo strpos($perfis,"9");
	if ( strpos($perfis,"9")>0 ) {       // isRoot?
	    if ( strlen($centro)>0   ) {
	    	$_SESSION["id_centro"]=$centro;
	    	$message="Voce agora esta operando no centro:".$centro;
	    }
	}else{
		ARCH::logg("PROBLEMAS DE SEGURANCA",1);
		ARCH::logg("O usuario Nao Root entrou nesta pagina!",1);
	}
Arch::initView(TRUE);
?>
	<h2> Usuario logado </h2>
	<b> <?php echo $message; ?> </b> <br><br>
	<a class="butbase" href='logged.settings.php'> Voltar</a>
<?php Arch::endView(); ?>