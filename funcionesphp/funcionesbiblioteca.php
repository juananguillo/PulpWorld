<?php 


function crearbiblioteca($db, $usu){
    try {
        $sentencia = $db->prepare("Insert INTO biblioteca(id_usuario)
    VALUES(:usu)");
        $sentencia->execute(array(
            ':usu' => $usu)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();

        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function tubiblioteca($bd, $id)
{
    try {
       
        $sentencia = $bd->prepare("SELECT id FROM biblioteca WHERE id_usuario LIKE :id_usuario");
        $sentencia->execute(array(
            ':id_usuario' => $id)
            
        );
       
       $resultado= $sentencia->fetchColumn();
        return $resultado;

    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}


function guardarobra($db, $id, $id_obra){
    try {
        $sentencia = $db->prepare("Insert INTO obras_guardadas(id_biblioteca, id_obra)
    VALUES(:id, :id_obra)");
        $sentencia->execute(array(
            ':id' => $id, ':id_obra'=>$id_obra)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();

        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


function obrasguardadasporid($bd, $id){
    try {

            $sentencia = $bd->prepare("SELECT id_obra FROM obras_guardadas WHERE id_biblioteca like :id ");
            
    
            $sentencia->execute(array(
                ':id' => $id)
                
            );
           
   
    $resultado= $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    $array=array();
    for ($i=0; $i <count($resultado) ; $i++) { 
        $array[$resultado[$i]["id_obra"]]=$resultado[$i];
    }

    return $array;
  
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Error al cargar el array de clientes ");
    }

}



function unaobraguardadaporid($bd, $id, $id_obra){
    try {

            $sentencia = $bd->prepare("SELECT id_obra FROM obras_guardadas WHERE id_biblioteca like :id AND id_obra like :id_obra ");
            
    
            $sentencia->execute(array(
                ':id' => $id, ':id_obra'=> $id_obra)
                
            );
           
   
    $resultado= $sentencia->fetchColumn();
   return $resultado;
  
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Error al cargar el array de clientes ");
    }

}

function borrarobra_guardada($bd, $id_biblioteca, $id_obra)
{
    try {
       
        $sentencia = $bd->prepare("DELETE FROM obras_guardadas WHERE id_biblioteca LIKE :id_biblioteca AND
        id_obra LIKE :id_obra");
        $sentencia->execute(array(
            ':id_biblioteca' => $id_biblioteca, ':id_obra' => $id_obra)
            
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