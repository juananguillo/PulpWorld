<?php 
function sinver($db, $id_usuario){

    try {
        
        $sentencia = $db->prepare("SELECT COUNT(*) FROM notificaciones WHERE id_usuario LIKE $id_usuario AND vista like 0");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        
        return $total;
    
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con las notificaciones");
        exit;
    }
    
    }

    function totalnoti($db, $id_usuario){

        try {
            
            $sentencia = $db->prepare("SELECT COUNT(*) FROM notificaciones WHERE id_usuario LIKE $id_usuario");
            $sentencia->execute();
            $total=$sentencia->fetchColumn(); 
            
            return $total;
        
        } catch (Exception $e) {
            header("Location: error.php?error=Ha habido un problema con las notificaciones");
                    exit;
        }
        
        }
    

    function notificaciones($db, $id_usuario, $desc){

        try {
            
            $sentencia = $db->prepare("SELECT * FROM notificaciones WHERE id_usuario LIKE $id_usuario 
            ORDER BY id  desc LIMIT $desc, 12");
            $sentencia->execute();
            $resultado= $sentencia->fetchAll(\PDO::FETCH_ASSOC);

            leernoti($db,$resultado);


            return $resultado;
        
        } catch (Exception $e) {
            header("Location: error.php?error=Ha habido un problema con las notificaciones");
            exit;
        }
        
        }

        function leernoti($bd, $notificaciones){
            foreach ($notificaciones as $key => $value) {
                try {
                    $sentencia = $bd->prepare("UPDATE notificaciones SET vista= 1 WHERE id LIKE :id ");
                    $sentencia->execute(array(
                       'id'=> $value["id"]
                    ));
                   
            
                } catch (Exception $e) {
                    header("Location: error.php?error=Ha habido un problema con las notificaciones");
                    exit;
                   
                }
            }
            
        }
