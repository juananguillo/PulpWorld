<?php 

function categorias($bd){
    try {
        $sentencia = $bd->prepare("SELECT * FROM categoria WHERE sub IS NULL");
        $sentencia->execute();
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "categorias");
        $array=array();
            while ($categorias=$sentencia->fetch()) {
            $array[]=$categorias;
        
        }

        return $array;
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Error al devolver la categoria, no existe en la base de datos");
    }

}

?>