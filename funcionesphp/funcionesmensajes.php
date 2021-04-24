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
        $resultado=array_reverse($array);
        $resultado=array_unique($resultado);
        $resultado=array_reverse($resultado);
        return array_reverse($resultado);
    
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los mensajes");
        exit;
    }
    
    }

    function mensajes($bd, $id1, $id2){
        try {
                $sentencia = $bd->prepare("SELECT * FROM mensajes WHERE (id_receptor like $id1 OR id_emisor like $id1) 
                AND (id_receptor like $id2 OR id_emisor like $id2)");
                  $sentencia->execute();
           
            if($sentencia->rowCount()==0)
            {
                throw new Exception();
                
                
            }
            $sentencia->setFetchMode(PDO::FETCH_CLASS, "mensajes");
            $array=array();
                while ($mensajes=$sentencia->fetch()) {
                $array[]=$mensajes;
            
            }

           $array= leermen($bd, $array, $id1);
    
            return $array;
        } catch (Exception $e) {
            header("Location: error.php?error=Ha habido un problema con los mensajes");
            exit;
           
        }
    
    }


    function crearmensaje($bd, $id1, $id2, $contenido){
        try {
            $sentencia = $bd->prepare("Insert INTO mensajes(id,id_emisor,id_receptor,contenido, leido)
            VALUES(:id,:id_emisor, :id_receptor, :contenido, :leido)");
                $sentencia->execute(array(
                    ':id' => null, ':id_emisor' => $id1, ':id_receptor' => $id2, ':contenido' => trim($contenido), ':leido'=>0)
                    
                );
           
            if($sentencia->rowCount()==0)
            {
                throw new Exception();
                
                
            }
            
        } catch (Exception $e) {
            header("Location: error.php?error=Ha habido un problema con los mensajes");
            exit;
           
        }
    
    }




    function sinleertotal($db, $id_usuario){

        try {
            
            $sentencia = $db->prepare("SELECT COUNT(*) FROM mensajes WHERE id_receptor like $id_usuario AND leido like 0");
            $sentencia->execute();
            $total=$sentencia->fetchColumn(); 
            
            return $total;
        
        } catch (Exception $e) {
            header("Location: error.php?error=Ha habido un problema con los mensajes");
            exit;
        }
        
        }

        function sinleermen($db, $id_usuario, $id_otro){

            try {
                
                $sentencia = $db->prepare("SELECT COUNT(*) FROM mensajes WHERE id_receptor like $id_usuario AND id_emisor like $id_otro AND leido like 0");
                $sentencia->execute();
                $total=$sentencia->fetchColumn(); 
                
                return $total;
            
            } catch (Exception $e) {
                header("Location: error.php?error=Ha habido un problema con los mensajes");
                exit;
            }
            
            }

            function leermen($bd, $mensajes, $id_receptor){
                foreach ($mensajes as $key => $value) {
                    try {
                        if($value->getleido()==0 && $value->getid_receptor()==$id_receptor){
                        $sentencia = $bd->prepare("UPDATE mensajes SET leido= 1 WHERE id LIKE :id ");
                        $sentencia->execute(array(
                           'id'=> $value->getid()
                        ));
                        $value->setleido(1);
                    }
                    } catch (Exception $e) {
                        header("Location: error.php?error=Ha habido un problema con las notificaciones");
                        exit;
                       
                    }
                }
                return $mensajes;
                
            }   

?>