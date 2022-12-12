<?php
include "../common/arch.php";
include "../common/funcoes.php";
include "../classes/class.app.php";
Arch::initController("log");

	$content = Arch::FileRead("../log/log.html");
	/////echo "<textarea cols=140 rows=34 style='width:90%'>" . $content . "</textarea>";

Arch::initView(TRUE);  
?>

	<br><br>
	<a href='log.del.web.php' class="butbase">Limpar logs</a>
	<?php echo $content; ?>

<?php Arch::endView(); ?>