<?php 
function sinver($db, $id_usuario){

    try {
        
        $sentencia = $db->prepare("SELECT COUNT(*) FROM notificaciones WHERE id_usuario LIKE $id_usuario AND vista like 0");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        
        return $total;
    
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location:error.php?error=Error");
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
            echo $e->getMessage();
            //header("Location:error.php?error=Error");
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
            echo $e->getMessage();
            //header("Location:error.php?error=Error");
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
                    if($sentencia->rowCount()==0)
                    {
                        throw new Exception();
                        
                    }
            
                } catch (Exception $e) {
                    echo $e->getMessage();
                   
                }
            }
            
        }
