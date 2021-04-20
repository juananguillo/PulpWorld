<?php 


function nuevaobra($bd, $titulo, $sinopsis, $autor)
{
    try {
       
        $sentencia = $bd->prepare("Insert INTO obras(id,titulo,sinopsis,autor,portada, publico, estado,
         lecturas, likes, terminada)
    VALUES(:id, :titulo, :sinopsis, :autor, :portada, :publico, :estado, :lecturas, :likes, :terminada)");
        $sentencia->execute(array(
            ':id' => null, ':titulo' => $titulo, ':sinopsis' => $sinopsis, ':autor' => $autor,
            ':portada'=>"default.jpg", ':publico'=>0, ':publico'=>0,':estado'=>1, ':lecturas'=>0, ':likes'=>0,
            ':terminada'=>0)
            
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

function cambiarfoto($bd,$img, $id){
    try {
        $sentencia = $bd->prepare("UPDATE obras SET portada= :portada WHERE id LIKE :id ");
        $sentencia->execute(array(
           ':portada' => $img,'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        echo $e->getMessage();
       
    }
}


function obrasguardadasbiblio($bd, $id){
    try {
            $sentencia = $bd->prepare("SELECT DISTINCT o.* FROM obras o, obras_guardadas og
            WHERE og.id_biblioteca like $id AND og.id_obra like o.id");
              $sentencia->execute();
       
        if($sentencia->rowCount()==0)
        {
            return 0;
            
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

function obras($bd,$desc,$orden,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT * FROM obras WHERE estado like 1 AND publico like 1  ORDER BY $orden DESC
              LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT * FROM obras ORDER BY $orden DESC
            LIMIT $desc, 20000000");
        }
       
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

function obrasautor($bd,$tipo,$autor){
    try {
        if($tipo=="autor"){
            $sentencia = $bd->prepare("SELECT * FROM obras WHERE estado like 1 AND autor like $autor ORDER BY id DESC
            ");
        }
        elseif($tipo==1){
            $sentencia = $bd->prepare("SELECT * FROM obras WHERE autor like $autor ORDER BY id DESC");
        }
        else{
            $sentencia = $bd->prepare("SELECT * FROM obras WHERE autor like $autor AND estado like 1 AND publico like 1 ORDER BY id DESC
            ");
        }
       
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


function obraspalabrasconcat($bd,$desc,$orden,$palabra,$cat,$tipo){
    try {
        if($tipo==0){
        $sentencia = $bd->prepare("SELECT DISTINCT o.* FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
        o.estado like 1 AND publico like 1 AND (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
        OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
        AND  (g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.id LIKE $cat) 
        ORDER BY o.$orden DESC
        LIMIT $desc, 20000000");
        }else{
            $sentencia = $bd->prepare("SELECT DISTINCT o.* FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
            (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
            OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
            AND  (g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.id LIKE $cat) 
            ORDER BY o.$orden DESC
            LIMIT $desc, 20000000"); 
        }
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

function totalobraspalabrasconcat($db,$desc, $orden,$palabra,$cat,$tipo){

    try {
        if($tipo==0){
        $sentencia = $db->prepare("SELECT  COUNT(DISTINCT o.id) FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
        o.estado like 1 AND publico like 1 AND (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
        OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
        AND  (g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.id LIKE $cat) 
        ORDER BY o.$orden DESC");
        }
        else{
            $sentencia = $db->prepare("SELECT  COUNT(DISTINCT o.id) FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
            (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
            OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
            AND  (g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.id LIKE $cat) 
            ORDER BY o.$orden DESC");
        }
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    
    } catch (Exception $e) {
        header("Location:error.php?error=Error");
        exit;
    }
    
    }


function obraspalabras($bd,$desc,$orden,$palabra,$tipo){
    try {
        if($tipo==0){
        $sentencia = $bd->prepare("SELECT DISTINCT o.* FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
        o.estado like 1 AND publico like 1 AND (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
        OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
        ORDER BY o.$orden DESC
        LIMIT $desc, 20000000");
        }else{
            $sentencia = $bd->prepare("SELECT DISTINCT o.* FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
        (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
        OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
        ORDER BY o.$orden DESC
        LIMIT $desc, 20000000");
        }
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


function totalobraspalabras($db,$desc, $orden,$palabra,$tipo){

    try {
        if($tipo==0){
        $sentencia = $db->prepare("SELECT  COUNT(DISTINCT o.id) FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
        o.estado like 1 AND publico like 1 AND (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
        OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
        ORDER BY o.$orden DESC");
        }else{
            $sentencia = $db->prepare("SELECT  COUNT(DISTINCT o.id) FROM obras o INNER JOIN usuario u INNER JOIN genero g INNER JOIN categoria c WHERE 
            (titulo LIKE '%$palabra%' OR sinopsis LIKE '%$palabra%'
            OR (o.autor LIKE u.id AND u.usuario like '%$palabra%') OR g.id_obra LIKE o.id AND g.id_categoria LIKE c.id AND c.nombre LIKE '%$palabra%') 
            ORDER BY o.$orden DESC");
        }
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    
    } catch (Exception $e) {
        header("Location:error.php?error=Error");
        exit;
    }
    
    }

function filtrarobras1($bd,$desc,$orden,$cat,$tipo){
    try {
        if($tipo==0){
        $sentencia = $bd->prepare("SELECT o.* from obras o, genero g
        WHERE estado like 1 AND  g.id_categoria like $cat AND g.id_obra LIKE o.id
        ORDER BY $orden DESC
        LIMIT $desc, 200000");
        }else{
            $sentencia = $bd->prepare("SELECT o.* from obras o, genero g
            WHERE  g.id_categoria like $cat AND g.id_obra LIKE o.id
            ORDER BY $orden DESC
            LIMIT $desc, 200000");
        }
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

function totalobras1($db,$desc, $orden, $cat,$tipo){

    try {
        if($tipo==0){
            $sentencia = $db->prepare("SELECT count(*) from obras o, genero g
        WHERE estado like 1 AND  g.id_categoria like $cat AND g.id_obra LIKE o.id
        ORDER BY $orden DESC");
        $sentencia->execute();
        $total=$sentencia->fetchColumn();  
        }
        else{
        $sentencia = $db->prepare("SELECT count(*) from obras o, genero g
        WHERE  g.id_categoria like $cat AND g.id_obra LIKE o.id
        ORDER BY $orden DESC");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
        }
    
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location:error.php?error=Error");
        exit;
    }
    
    }



function totalobras($db,$tipo){

    try {
        if($tipo==0){
            $sentencia = $db->prepare("SELECT COUNT(*) FROM obras WHERE publico LIKE 1 AND estado like 1");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        }else{
        $sentencia = $db->prepare("SELECT COUNT(*) FROM obras");
        $sentencia->execute();
        $total=$sentencia->fetchColumn();
        } 
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
    

    function darmegusta($bd, $id_obra, $id_usuario)
{
    try {
       
        $sentencia = $bd->prepare("Insert INTO megusta(id_obra,id_usuario)
    VALUES(:id_obra,:id_usuario)");
        $sentencia->execute(array(
            ':id_obra' => $id_obra, ':id_usuario' => $id_usuario)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }

    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}


function quitarmegusta($bd, $id_obra, $id_usuario)
{
    try {
       
        $sentencia = $bd->prepare("DELETE FROM megusta WHERE id_obra like :id_obra AND id_usuario LIKE :id_usuario");
        $sentencia->execute(array(
            ':id_obra' => $id_obra, ':id_usuario' => $id_usuario)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }

    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}

function vermegusta($bd, $id_obra, $id_usuario)
{
    try {
       
        $sentencia = $bd->prepare("SELECT COUNT(*) FROM megusta WHERE id_obra LIKE :id_obra AND
        id_usuario LIKE :id_usuario");
        $sentencia->execute(array(
            ':id_obra' => $id_obra, ':id_usuario' => $id_usuario)
            
        );
       
        $sentencia->execute();
        $total=$sentencia->fetchColumn();
        return $total;

    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}

function crearlectura($bd, $ip, $id_obra)
{
    try {
        $sentencia = $bd->prepare("INSERT INTO lectura (ip, id_obra)
          VALUES(:ip, :id_obra)");
        $sentencia->execute(array(
            ':ip' => $ip, ':id_obra'=> $id_obra)
            
        );
       

    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}

function verlectura($bd, $ip, $id_obra)
{
    try {
        $sentencia = $bd->prepare("SELECT count(*) FROM lectura where ip like :ip AND id_obra like :id_obra");
        $sentencia->execute(array(
            ':ip' => $ip, ':id_obra'=> $id_obra)
            
        );
        $total=$sentencia->fetchColumn();
        return $total;

    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}

function publicar($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE obras SET publico= 1 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        echo $e->getMessage();
       
    }
}

function terminar($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE obras SET terminada= 1 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        echo $e->getMessage();
       
    }
}

function desterminar($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE obras SET terminada= 0 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        echo $e->getMessage();
       
    }
}

function eliminarobra($bd,$id){
    try {
        $sentencia = $bd->prepare("DELETE from obras WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        echo $e->getMessage();
       
    }
}

function despublicar($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE obras SET publico= 0 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        echo $e->getMessage();
       
    }
}

function bloquear($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE obras SET estado= 0 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        echo $e->getMessage();
       
    }
}


function desbloquear($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE obras SET estado= 1 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        echo $e->getMessage();
       
    }
}

function notifiobras($bd, $id_usuario, $tipo, $id_novedad, $mensaje)
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
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}

function quitarnotifi($bd, $id_usuario, $id_novedad, $tipo)
{
    try {
       
        $sentencia = $bd->prepare("DELETE FROM notificaciones WHERE id_usuario like :id_usuario
         AND id_novedad LIKE :id_novedad AND tipo like :tipo");
        $sentencia->execute(array(
            ':id_novedad' => $id_novedad, ':id_usuario' => $id_usuario, ':tipo'=> $tipo)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }

    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Errorinsertarcoment");
    }
}

function cambiarobra($bd,$titulo, $sinopsis, $obra){
    try {
        $sentencia = $bd->prepare("UPDATE obras SET titulo= :titulo, sinopsis=:sinopsis WHERE id LIKE :obra ");
        $sentencia->execute(array(
           ':titulo'=> $titulo, ':sinopsis'=>$sinopsis, ':obra'=>$obra
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