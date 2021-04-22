<?php 
  function emisoresyreceptores($db, $id_usuario){

    try {
        
        $sentencia = $db->prepare("SELECT DISTINCT id, id_receptor FROM mensajes WHERE id_emisor LIKE $id_usuario 
        ORDER BY id DESC" );
        $sentencia->execute();
        $array=array();
        while ($usuarios=$sentencia->fetch()) {
            $array[$usuarios["id"]]=$usuarios["id_receptor"];
        
        }
        

        $sentencia = $db->prepare("SELECT DISTINCT id, id_emisor FROM mensajes WHERE id_receptor like $id_usuario order by id DESC" );
        $sentencia->execute();
        while ($usuarios=$sentencia->fetch()) {
        $array[$usuarios["id"]]=$usuarios["id_emisor"];
    
    }

ksort($array);
   
        //$resultado=array_unique($array);
        return array_reverse($array);
    
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con las notificaciones");
        exit;
    }
    
    }


?>