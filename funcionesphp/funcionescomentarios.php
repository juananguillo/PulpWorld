<?php 

function obtenercoments($db, $id){
    try {
    $sentencia = $db->prepare("SELECT * FROM comentarios WHERE id_obra like :id_obra AND res is null ORDER BY id DESC");
    $sentencia->bindParam(":id_obra", $id, PDO::PARAM_STR);
    $sentencia->execute();
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "comentarios");
   
    $array=array();
    while ($comentarios=$sentencia->fetch()) {
    $array[]=$comentarios;

}

return $array;
} catch (Exception $e) {
    header("Location: error.php?error=Ha habido un problema con los comentarios");
        exit;
}
    
}


function obtenerespuestas($db, $id){
    try {
    $sentencia = $db->prepare("SELECT * FROM comentarios WHERE res is not null AND res like :res");
    $sentencia->bindParam(":res", $id, PDO::PARAM_STR);
    $sentencia->execute();
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "comentarios");
    
    $array=array();
    while ($comentarios=$sentencia->fetch()) {
    $array[]=$comentarios;

}

return $array;
} catch (Exception $e) {
    header("Location: error.php?error=Ha habido un problema con los comentarios");
        exit;
}
    
}


function totalcoments($db, $obra){

    try {
        $sentencia = $db->prepare("SELECT COUNT(*) FROM comentarios WHERE id_obra like $obra");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los comentarios");
        exit;
    }
    
    }




    
function insertarcomentario($db, $id_usuario, $mensaje, $id_obra, $res){
    try {
       
        $sentencia = $db->prepare("Insert INTO comentarios(id,mensaje,id_usuario,id_obra,res)
    VALUES(:id, :mensaje, :id_usuario, :id_obra, :res)");
        $sentencia->execute(array(
            ':id' => null, ':mensaje' => $mensaje, ':id_usuario' => $id_usuario, ':id_obra' => $id_obra, ':res'=>$res)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }
        
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los comentarios");
        exit;
    }
}


?>