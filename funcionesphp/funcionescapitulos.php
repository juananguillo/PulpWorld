<?php 

function allcapitulos($bd, $id_obra){
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
      header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
       
    }

}

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
        header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
       
       
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
    header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
    exit;
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
        header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
    }
}

function editcap($bd,$titulo,$contenido,$id){
    try {
        $sentencia = $bd->prepare("UPDATE capitulos SET titulo= :titulo, contenido=:contenido WHERE id LIKE :id ");
        $sentencia->execute(array(
           ':titulo' => $titulo,':contenido' => $contenido,'id'=> $id
        ));

    } catch (Exception $e) {
        header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
       
    }
}


function publicarcapi($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE capitulos SET publico= 1 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
      header("Location: error.php?error=Error al cargar la biblioteca");
        exit;
       
    }
}

function despublicarcapi($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE capitulos SET publico= 0 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
       
    }
}

function bloquearcapi($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE capitulos SET estado= 0 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
       
    }
}


function desbloquearcapi($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE capitulos SET estado= 1 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
       
    }
}


function notificapi($bd, $id_usuario, $tipo, $id_novedad, $mensaje)
{
    try {
       
        $sentencia = $bd->prepare("Insert INTO notificaciones(id,id_usuario,tipo,id_novedad, mensaje)
    VALUES(:id, :id_usuario, :tipo, :id_novedad, :mensaje)");
        $sentencia->execute(array(
            ':id' => null, ':id_usuario' => $id_usuario , ':tipo' => $tipo,
             ':id_novedad'=>$id_novedad,':mensaje'=>$mensaje)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }

        
    } catch (Exception $e) {
        header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
    }
}

function quitarnotificapi($bd, $id_usuario, $id_novedad, $tipo)
{
    try {
       
        $sentencia = $bd->prepare("DELETE FROM notificaciones WHERE id_usuario like :id_usuario
         AND id_novedad LIKE :id_novedad AND tipo like :tipo");
        $sentencia->execute(array(
            ':id_novedad' => $id_novedad, ':id_usuario' => $id_usuario, ':tipo'=> $tipo)
            
        );
       

    } catch (Exception $e) {
        header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
    }
}


function eliminarcapi($bd,$id){
    try {
        $sentencia = $bd->prepare("DELETE from capitulos WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        header("Location: error.php?error=Ha ocurrido un problema con los capitulos");
        exit;
       
    }
}

?>