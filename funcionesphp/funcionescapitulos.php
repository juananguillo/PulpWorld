<?php 

function capitulos($bd, $id_obra){
    try {
        $sentencia = $bd->prepare("SELECT * FROM capitulos WHERE estado like 1 AND publico like 1
       AND id_obra like $id_obra");
        $sentencia->execute();
       
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "capitulos");
        $array=array();
            while ($capitulos=$sentencia->fetch()) {
            $array[]=$capitulos;
        
        }

        return $array;
    } catch (Exception $e) {
        echo $e->getMessage();
       
    }

}

?>