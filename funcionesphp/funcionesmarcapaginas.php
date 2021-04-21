<?php 
function vermarcapaginas($bd, $id_usuario, $id_obra)
{
    try {
       
        $sentencia = $bd->prepare("SELECT * FROM marcapaginas WHERE id_usuario LIKE :id_usuario AND
        id_obra LIKE :id_obra");
        $sentencia->execute(array(
            ':id_usuario' => $id_usuario, ':id_obra' => $id_obra)
            
        );
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "marcapaginas");
        
        if ($sentencia->rowCount() == 0) {
            return false;
        }
        $marcapaginas = $sentencia->fetch();
        return $marcapaginas;

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con el marcapaginas");
        exit;
    }
}

function actualizarmarcapaginas($bd, $id_usuario, $id_obra, $id_capitulo)
{
    try {
        $sentencia = $bd->prepare("UPDATE marcapaginas SET id_capitulo = :id_capitulo
          WHERE id_usuario LIKE :id_usuario AND
        id_obra LIKE :id_obra");
        $sentencia->execute(array(
            ':id_usuario' => $id_usuario, ':id_obra' => $id_obra, ':id_capitulo' => $id_capitulo)
            
        );
       

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con el marcapaginas");
        exit;
    }
}

function borrarmarcapaginas($bd, $id_usuario, $id_obra)
{
    try {
       
        $sentencia = $bd->prepare("DELETE FROM marcapaginas WHERE id_usuario LIKE :id_usuario AND
        id_obra LIKE :id_obra");
        $sentencia->execute(array(
            ':id_usuario' => $id_usuario, ':id_obra' => $id_obra)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }


    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con el marcapaginas");
        exit;
    }
}


function crearmarcapaginas($bd, $id_usuario, $id_obra, $id_capitulo)
{
    try {
        $sentencia = $bd->prepare("INSERT INTO marcapaginas (id_usuario, id_obra,id_capitulo)
          VALUES(:id_usuario, :id_obra, :id_capitulo)");
        $sentencia->execute(array(
            ':id_usuario' => $id_usuario, ':id_obra' => $id_obra, ':id_capitulo' => $id_capitulo)
            
        );
       

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con el marcapaginas");
        exit;
    }
}


?>