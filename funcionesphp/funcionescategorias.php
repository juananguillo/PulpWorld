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



function generos($bd, $id_obra){
    try {
        $sentencia = $bd->prepare("SELECT DISTINCT c.* FROM categoria c, genero g WHERE g.id_obra like $id_obra AND g.id_categoria LIKE c.id");
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


function addgenero($bd, $id_obra, $id_categoria)
{
    try {
        $sentencia = $bd->prepare("Insert INTO genero(id_obra,id_categoria)
    VALUES(:id_obra, :id_categoria)");
        $sentencia->execute(array(
            ':id_obra' => $id_obra, ':id_categoria' => $id_categoria)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }
        
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}

?>