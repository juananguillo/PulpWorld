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

function obteneruncapitulo($db, $id){
    try {
    $sentencia = $db->prepare("SELECT * FROM capitulos WHERE id like :id");
    $sentencia->bindParam(":id", $id, PDO::PARAM_STR);
    $sentencia->execute();
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "capitulos");
    $capitulo = $sentencia->fetch();
    if($sentencia->rowCount()==0)
    {
        throw new Exception();
        
    }
   return $capitulo;
} catch (Exception $e) {
    echo $e->getMessage();
   // header("Location: error.php?error=Error al devolver el cliente, no existe en la base de datos");
}
    
}



?>