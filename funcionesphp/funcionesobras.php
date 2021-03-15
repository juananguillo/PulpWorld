<?php 

function obras($bd,$desc,$orden){
    try {
        $sentencia = $bd->prepare("SELECT * FROM obras WHERE estado like 1 AND publico like 1  ORDER BY $orden DESC
        LIMIT $desc, 20000000");
        $sentencia->execute();
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "obras");
        $array=array();
            while ($obras=$sentencia->fetch()) {
            $array[]=$obras;
        
        }

        return $array;
    } catch (Exception $e) {
        echo $e->getMessage();
       
    }

}

function obraspalabrasconcat($bd,$desc,$orden,$palabra,$cat){
    try {
        $sentencia = $bd->prepare("SELECT DISTINCT o.* FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
        o.estado like 1 AND publico like 1 AND (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
        OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
        AND  (g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.id LIKE $cat) 
        ORDER BY o.$orden DESC
        LIMIT $desc, 20000000");
        $sentencia->execute();
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "obras");
        $array=array();
            while ($obras=$sentencia->fetch()) {
            $array[]=$obras;
        
        }

        return $array;
    } catch (Exception $e) {
        echo $e->getMessage();
       
    }

}

function totalobraspalabrasconcat($db,$desc, $orden,$palabra,$cat){

    try {
        $sentencia = $db->prepare("SELECT  COUNT(DISTINCT o.id) FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
        o.estado like 1 AND publico like 1 AND (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
        OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
        AND  (g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.id LIKE $cat) 
        ORDER BY o.$orden DESC");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    
    } catch (Exception $e) {
        header("Location:error.php?error=Error");
        exit;
    }
    
    }


function obraspalabras($bd,$desc,$orden,$palabra){
    try {
        $sentencia = $bd->prepare("SELECT DISTINCT o.* FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
        o.estado like 1 AND publico like 1 AND (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
        OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
        ORDER BY o.$orden DESC
        LIMIT $desc, 20000000");
        $sentencia->execute();
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "obras");
        $array=array();
            while ($obras=$sentencia->fetch()) {
            $array[]=$obras;
        
        }

        return $array;
    } catch (Exception $e) {
        echo $e->getMessage();
       
    }

}


function totalobraspalabras($db,$desc, $orden,$palabra){

    try {
        $sentencia = $db->prepare("SELECT  COUNT(DISTINCT o.id) FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
        o.estado like 1 AND publico like 1 AND (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
        OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
        ORDER BY o.$orden DESC");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    
    } catch (Exception $e) {
        header("Location:error.php?error=Error");
        exit;
    }
    
    }

function filtrarobras1($bd,$desc,$orden,$cat){
    try {
        $sentencia = $bd->prepare("SELECT o.* from obras o, genero g
        WHERE estado like 1 AND  g.id_categoria like $cat AND g.id_obra LIKE o.id
        ORDER BY $orden DESC
        LIMIT $desc, 200000");
        $sentencia->execute();
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "obras");
        $array=array();
            while ($obras=$sentencia->fetch()) {
            $array[]=$obras;
        
        }

        return $array;
    } catch (Exception $e) {
        echo $e->getMessage();
       
    }

}

function totalobras1($db,$desc, $orden, $cat){

    try {
        $sentencia = $db->prepare("SELECT count(*) from obras o, genero g
        WHERE estado like 1 AND  g.id_categoria like $cat AND g.id_obra LIKE o.id
        ORDER BY $orden DESC");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location:error.php?error=Error");
        exit;
    }
    
    }



function totalobras($db){

    try {
        $sentencia = $db->prepare("SELECT COUNT(*) FROM obras WHERE publico LIKE 1 AND estado like 1");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location:error.php?error=Error");
        exit;
    }
    
    }


    function obtenerunaobra($db, $id){
        try {
        $sentencia = $db->prepare("SELECT * FROM obras WHERE id like :id");
        $sentencia->bindParam(":id", $id, PDO::PARAM_STR);
        $sentencia->execute();
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "obras");
        $obra = $sentencia->fetch();
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }
       return $obra;
    } catch (Exception $e) {
        echo $e->getMessage();
       // header("Location: error.php?error=Error al devolver el cliente, no existe en la base de datos");
    }
        
    }
    


?>