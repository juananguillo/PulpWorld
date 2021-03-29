<?php 

function capitulos($bd, $id_obra){
    try {
        $sentencia = $bd->prepare("SELECT * FROM capitulos WHERE id_obra like $id_obra");
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

function nuevocapitulo($bd, $id_obra)
{
    try {
       
        $sentencia = $bd->prepare("Insert INTO capitulos(id,titulo,contenido,publico, estado,id_obra)
    VALUES(:id, :titulo, :contenido, :publico, :estado, :id_obra)");
        $sentencia->execute(array(
            ':id' => null, ':titulo' => "Sin titulo", ':contenido' => "", ':publico'=>0,':estado'=>1,
            ':id_obra'=>$id_obra)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }

        $id = $bd->lastInsertId();
        return $id;
        
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}

function editcap($bd,$titulo,$contenido,$id){
    try {
        $sentencia = $bd->prepare("UPDATE capitulos SET titulo= :titulo, contenido=:contenido WHERE id LIKE :id ");
        $sentencia->execute(array(
           ':titulo' => $titulo,':contenido' => $contenido,'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        echo $e->getMessage();
       
    }
}





?>