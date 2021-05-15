<?php 

function isblock($state){
    if($state==0){
        header("Location: ./funcionesphp/sesion.php?logout=yes&index=yes");
        die();
    }
}

?>