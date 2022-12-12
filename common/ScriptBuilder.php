<?php
/*
    PENDENTE: incluir:
        1 ScriptBuilder buildList(): incluir icones e URL para altera e exclui
        2 json: incluir URL dos altera e exclui
        3 ScriptBuilder: criar buildSelection()
        4 ScriptBuilder buildList: incluir tr onclick=
        5 json: incluir URL do tr onclick= 
*/
class ScriptBuilder {
    
    protected $conf = '';

    function __construct( $jsonConfig ) {
        Arch::logg("[ScriptBuilder.contructor]JSON=".$jsonConfig);
        $this->conf = json_decode( $jsonConfig ) ;
        if ( ! isset($this->conf) ) { 
            Arch::logg("[ScriptBuilder.contructor] ERROR Objeto nuLLo !!! Provavel erro no json!");
            echo "ATENCAO!  O ScriptBuilder.constructor tentou montar um objeto a partir de um json defeituoso.";
            echo "<pre>" . $jsonConfig . "</pre>" ; 
            exit();
        }

        Arch::logg("[ScriptBuilder.contructor]OBJ.listTrUrl=".$this->conf->listTrUrl);
        Arch::logg("[ScriptBuilder.contructor]count_BJ.fields=".count($this->conf->fields));
    }


    // SPECIAL LIST
    function buildListSelection($rs){
        // Pendente: modify configObject
        $this->conf->listTrUrl='';
        return $this->buildList($rs);
    }



    function buildList($rs){
        $buff='';
        $buff=$buff . "<table class='table striped' style='width:98%'>";
        $buff=$buff . "<tr class='blue'>";
        for ($x=0; $x<count($this->conf->fields); $x++) {
            $title = $this->conf->fields[$x]->title ;
            $flag  = $this->conf->fields[$x]->flag ;
            if ( strpos($flag,"L") ) {
                $buff=$buff . "<th align='left'>$title</th>";
            }
        }
        $listAlteraUrl = $this->conf->listAlteraUrl;
        $listExcluiUrl = $this->conf->listExcluiUrl;
        if (strlen($listAlteraUrl)>1) {
        $buff=$buff . "<th align='left'>Altera</th>";
        $buff=$buff . "<th align='left'>Exclui</th>";
        }
        $buff=$buff . "</tr>";
        

//        while($reg = $rs->fetchArray()){
        while($reg = $rs->fetch()){     // PDO
            // CREATE A JAVASCRIPT ONCLICK FOR 'TR'
            $listTrUrl = $this->conf->listTrUrl;
            $tr_onclick = "";
            if ($listTrUrl!='') {
//              $idFieldName="FK";//$this->conf->PK;
                $idFieldName=$this->conf->PK;
                $idFieldValue=$reg[$this->conf->PK];
                $tr_onclick = "onclick=\"window.location.href='".$listTrUrl."?$idFieldName=$idFieldValue'\"";
            }
            $buff=$buff . "<tr $tr_onclick>";
            for ($x=0; $x<count($this->conf->fields); $x++) {
                $name  = $this->conf->fields[$x]->name ;
                $flag  = $this->conf->fields[$x]->flag ;
                if ( strpos($flag,"L") ) {
                    $buff=$buff . "<td>" . $reg[$name] . "</td>";
                }
            }
            $listAlteraUrl = $this->conf->listAlteraUrl;
            $listExcluiUrl = $this->conf->listExcluiUrl;
            $pk  = $this->conf->PK ;
            if (strlen($listAlteraUrl)>1) {
            $altera = "<a href='$listAlteraUrl?$pk=" .$reg[$pk]. "'><img alt='alt'  src='../layout/img/alte.ico' width='20' height='20' border='0'></a>";
            $exclui = "<a href='$listExcluiUrl?$pk=" .$reg[$pk]. "'><img alt='excl' src='../layout/img/excl.ico' width='20' height='20' border='0'></a>";
            $buff=$buff . "<td>$altera</td>";
            $buff=$buff . "<td>$exclui</td>";
            }
            $buff=$buff . "</tr>";
        }
        $buff=$buff . "</table>";
        return $buff;
    }



    function buildForm(){
        $buff='';
        $buff=$buff . "<form action='' method=GET>";
        $c = count($this->conf->fields);
        for ($x=0; $x<$c; $x++) {
            $title = $this->conf->fields[$x]->title ;
            $name = $this->conf->fields[$x]->name ;
            $flag  = $this->conf->fields[$x]->flag ;
            $pk = $this->conf->PK;
            $fk = $this->conf->FK;
            $formUrlFK = $this->conf->formUrlFK;
            if ( strpos($flag,"F")){
                $buff=$buff .  "<br><br> <b> $title </b> <br> ";

                
                //if ($name==$pk){ $buff=$buff .  "PK";}
                if ($name==$fk){ 
                    $rfk=""; if (isset($_REQUEST["FK"])){$rfk=$_REQUEST["FK"];}
                    $buff=$buff .  "<input type='text' name='$name' value='$rfk'>"; 
                    $buff=$buff .  "<a href='$formUrlFK'>seleccionar</a>";
                }else{
                    $buff=$buff .  "<input type='text' name='$name' value=''>"; 
                }
            }
        }
        $buff=$buff .  "<input type='hidden' name='action' value='save'>";
        $buff=$buff .  "<br><input type='submit' value='vai' onclick='confirm(\"certeza?\"  ); '>";
        $buff=$buff .  "</form>";
        return $buff;
    }

}
?>