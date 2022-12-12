<?php
?>
    <p class=appTitle2>Título</p>

    <form name="myform" method='get'>
        <p class=labelx>Título</p>
        <input type='text' name='nome_titulo' class='inputx' value='<?php echo $nome_titulo?>'/>

        <p class=labelx>Sigla</p>
        <input type='text' name='sigla' class='inputx' value='<?php echo $sigla?>'/>

        <p class=labelx>Autor</p>
        <input type='text' name='autor' class='inputx' value='<?php echo $autor?>' readonly/>
        <input type='submit' name='action' value='a' class='buthidelist' style='background-image: url(../layout/img/alte2.ico); background-repeat:no-repeat; background-size:26px 26px;'>

        <p class=labelx>Espírito</p>
        <input type='text' name='espirito' class='inputx' value='<?php echo $espirito?>' readonly/>
        <input type='submit' name='action' value='e' class='buthidelist' style='background-image: url(../layout/img/alte2.ico); background-repeat:no-repeat; background-size:26px 26px;'>

        <p class=labelx>CDE</p>
        <input type='text' name='cod_cde' class='inputx' value='<?php echo $cod_cde?>' readonly/>
        <input type='submit' name='action' value='c' class='buthidelist' style='background-image: url(../layout/img/alte2.ico); background-repeat:no-repeat; background-size:26px 26px;'>

        <p class=labelx>Nro.Volume</p>
        <input type='text' name='nro_volume' class='inputx' value='<?php echo $nro_volume?>'/>

        <p class=labelx>Resenha</p>
        <textarea name='resenha' class='inputx_quebra_Cols' cols='40' rows='6'><?php echo $resenha?></textarea>

        <input type='hidden' name='id_autor' value='<?php echo $id_autor?>'/>
        <input type='hidden' name='id_espirito' value='<?php echo $id_espirito?>'/>
        <input type='hidden' name='id_cde' value='<?php echo $id_cde?>'/>

        <br>
        
        <b><?php echo $msg ?></b> <br>  <!-- MESSAGE -->

        <?php 
?>