<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
	    <title>Biblio</title>
<!-- versão na linha 20 -->
		<link rel="stylesheet" type="text/css" href="../layout/css.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--meta charset="UTF-8"--> 
		<meta charset="ISO-8859-1"> 
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"> 
		<link href="../layout/img/favicon.png" rel="icon" />
	</head>
	<body>

        <div class="appTitle">
            <a href="main.web.php">
                <img border="0" alt="menu" src="../layout/img/menu.ico" width="24" height="24" style='margin: 0px 10px 0px 10px;'>
            </a>
            
            Biblio&nbsp;<?php echo Arch::versao();?>
&nbsp;&nbsp;&nbsp;<?php echo Arch::session("siglacentro");?>

            <!--   A J U D A   P E L O   C O N T E X T O   -->
            <a href="ajuda.contexto.php?codigo_app=<?php echo Arch::session("codigo_app"); ?>"><img border="0" alt="menu" src="../layout/img/ajud.ico" width="24" height="24" style='margin: 0px 10px 0px 10px; position: absolute; right: 72px;'></a>
            
            <!--   P R E F E R E N C I A S   -->
            <a href="preferencia.php"><img border="0" alt="menu" src="../layout/img/ator.ico" width="24" height="24" style='margin: 0px 10px 0px 10px; position: absolute; right: 36px;'></a>

            <!--   E X I T   -->
            <a href="logoff.web.php"><img border="0" alt="menu" src="../layout/img/exit.ico" width="24" height="24" style='margin: 0px 10px 0px 10px; position: absolute; right: 0px;'></a>
        </div>

		<div class="appMain">
