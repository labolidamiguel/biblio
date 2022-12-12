<?php
?>
    <p class=appTitle2>Exemplar</p>
    <p class=apptitle4>&nbsp;&nbsp;<?php echo $nome_titulo?></p>
    <form method='get'>
        <p class=labelx>Tradutor</p>
        <input type='text' name='tradutor' value='<?php echo $tradutor?>' class='inputx' readonly/>
        <input type='submit' name='action' value='t' class='buthidelist' style='background-image: url(../layout/img/alte2.ico); background-repeat:no-repeat; background-size:26px 26px;'>

        <p class=labelx>Editora</p>
        <input type='text' name='editora' value='<?php echo $editora?>' class='inputx' readonly/>
        <input type='submit' name='action' value='e' class='buthidelist' style='background-image: url(../layout/img/alte2.ico); background-repeat:no-repeat; background-size:26px 26px;'>

        <p class=labelx>Nro. de Edição</p>
        <input type='text' name='nro_edicao' value='<?php echo $nro_edicao?>' class='inputx'/>

        <p class=labelx>Ano de Publicação</p>
        <input type='text' name='ano_publicacao' value='<?php echo $ano_publicacao?>' class='inputx'/>

        <p class=labelx>Data de Entrada</p>
        <input type='date' name='data_entrada' value='<?php echo $data_entrada?>' class='inputx'/>

        <p class=labelx>Nro. de Exemplar</p>
        <input type='text' name='nro_exemplar' value='<?php echo $nro_exemplar?>' class='inputx'/>

        <input type='hidden' name='id_tradutor' value='<?php echo $id_tradutor?>'/>
        <input type='hidden' name='id_editora' value='<?php echo $id_editora?>'/>
        <br>
        
        <b><?php echo $msg ?></b> <br>  <!-- mensagem -->
    <?php 
?>