<?php 

function comprobarusuario($db, $usu, $contra){
    try {
        //$contra = password_hash($contra, PASSWORD_DEFAULT);
        $sentencia = $db->prepare("SELECT usuario, contra FROM usuario WHERE usuario like :usuario AND estado like :estado");
        $sentencia->execute(array(
            ":usuario" => $usu, ':estado' => 1
        ));
        if($sentencia->rowCount()==0)
        {
            return false;
            
        }
        $contrabd="";
        while ($array=$sentencia->fetch()) {
            $contrabd=$array[1];
        
        }
        if(password_verify($contra, $contrabd)) {
            return true;
        
        }
        else{
        return false;
        }
         
       
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }

    function anyadirusuario($db){
        $sentencia = $db->prepare("Insert INTO clientes(usuario,contra,email)
        VALUES(:usuario, :contra, :email)");
    }


}


function totalusuarios($db,$tipo){

    try {
        if($tipo==0){
            $sentencia = $db->prepare("SELECT COUNT(*) FROM usuario WHERE estado LIKE 1");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        }else{
        $sentencia = $db->prepare("SELECT COUNT(*) FROM usuario");
        $sentencia->execute();
        $total=$sentencia->fetchColumn();
        } 
        return $total;
    
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
    
    }
   


function dardealtausuario($db, $usu, $contra, $email){
    try {
        $pass_enc = password_hash($contra, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) );
        $sentencia = $db->prepare("Insert INTO usuario(id, email, usuario, contra, nomyape, estado, foto, tipo, hash)
    VALUES(:id, :email, :usuario, :contra, :nomyape, :estado, :foto, :tipo, :hash)");
        $sentencia->execute(array(
            ':id' => null, ':usuario' => $usu, ':contra' => $pass_enc, ':nomyape'=>null, ':email' => $email, ':tipo'=>0,  ':estado'=>1, ':foto'=>"default.jpg", ':hash'=>$hash)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();

        }

        $to      = $email; 
$subject = 'Activar cuenta en PulpWorld'; 
$message = '
 
Gracias por registrarte!
Tu cuenta ha sido creada con exito, para activarla haz click en el enlace.
 
------------------------
Usuario: '.$usu.'
Contraseña: '.$contra.'
------------------------
 
Activar cuenta:
http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$hash.'
 
'; 
                     
$headers = 'From:pulpworld@gmail.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email
    
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
}



function obtenerusuario($db, $email){
    try {
    $sentencia = $db->prepare("SELECT usuario FROM usuario WHERE email like :email");
    $sentencia->bindParam(":email", $email, PDO::PARAM_STR);
    $sentencia->execute();
    $usuario=$sentencia->fetchColumn();
    return $usuario; 

} catch (Exception $e) {
        
    header("Location: error.php?error=Ha habido un problema con los usuarios");
    exit;
}
    
}

function obtenerusuario2($db, $email){
    try {
    $sentencia = $db->prepare("SELECT * FROM usuario WHERE email like :email");
    $sentencia->bindParam(":email", $email, PDO::PARAM_STR);
    $sentencia->execute();
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
        $usuario = $sentencia->fetch();
    return $usuario; 

} catch (Exception $e) {
        
    header("Location: error.php?error=Ha habido un problema con los usuarios");
    exit;
}
    
}


function unusuario($bd, $usuario){
    try {
        $sentencia = $bd->prepare("SELECT * FROM usuario WHERE usuario like :usuario");
        $sentencia->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $sentencia->execute();
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
        $usuario = $sentencia->fetch();
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }
       return $usuario;
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }


}

function comprobartipo($db, $usu){
    try {
        $sentencia = $db->prepare("SELECT tipo FROM usuario WHERE id like :id");
        $sentencia->bindParam(":id", $usu, PDO::PARAM_STR);
        $sentencia->execute();
        $tipo=$sentencia->fetchColumn();
        return $tipo; 
    
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
        


}

function unusuarioporcodigo($bd, $id){
    try {
        $sentencia = $bd->prepare("SELECT * FROM usuario WHERE id like :id");
        $sentencia->bindParam(":id", $id, PDO::PARAM_STR);
        $sentencia->execute();
        $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
        $usuario = $sentencia->fetch();
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }
       return $usuario;
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        die;
    }


}


function arrayusuarios($bd){
    try {

            $sentencia = $bd->prepare("SELECT * FROM usuario 
            WHERE estado like 1");
            
    
    $sentencia->execute();
    if($sentencia->rowCount()==0)
    {
        throw new Exception();
        
    }
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
    $array=array();
    while ($usuarios=$sentencia->fetch()) {
    $array[]=$usuarios;

}
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
return $array;
}

function allarrayusuarios($bd){
    try {

            $sentencia = $bd->prepare("SELECT * FROM usuario");
            
    
    $sentencia->execute();
    if($sentencia->rowCount()==0)
    {
        throw new Exception();
        
    }
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
    $array=array();
    while ($usuarios=$sentencia->fetch()) {
    $array[]=$usuarios;

}
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
return $array;
}

function arrayusuariosporid($bd){
    try {

            $sentencia = $bd->prepare("SELECT * FROM usuario");
            
    
    $sentencia->execute();
    if($sentencia->rowCount()==0)
    {
        throw new Exception();
        
    }
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
    $array=array();
    while ($usuarios=$sentencia->fetch()) {
    $array[$usuarios->getid()]=$usuarios;

}
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
return $array;
}




function filtrarusuariosporpalabras($bd,$desc,$orden, $palabra,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE u.estado LIKE 1 AND u.tipo LIKE 0 AND (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id AND o.estado like 1 AND o.publico like 1 )>0 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )>0 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
    $sentencia->execute();
   
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
    $array=array();
    while ($usuarios=$sentencia->fetch()) {
    $array[]=$usuarios;

}
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
return $array;
}

function totalusuariosporpalabras($bd,$desc,$orden, $palabra,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT COUNT(*) FROM usuario u
            WHERE u.estado LIKE 1 AND u.tipo LIKE 0 AND (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id AND o.estado like 1 AND o.publico like 1 )>0 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT COUNT(*) FROM usuario u
            WHERE (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )>0 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
}


function filtrarusuariosporpalabrastodos($bd,$desc,$orden, $palabra,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE u.estado LIKE 1 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
    $sentencia->execute();
   
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
    $array=array();
    while ($usuarios=$sentencia->fetch()) {
    $array[]=$usuarios;

}
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
return $array;
}


function totalusuariosporpalabrastodos($bd,$desc,$orden, $palabra,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT count(*) FROM usuario u
            WHERE u.estado LIKE 1  AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT count(*) FROM usuario u
            WHERE  (u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }

}


function filtrarusuariosporpalabrasuser($bd,$desc,$orden, $palabra,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE u.estado LIKE 1 AND u.tipo LIKE 0 AND (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id AND o.estado like u.id AND o.publico like u.id  )=0 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )=0 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
    $sentencia->execute();
   
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
    $array=array();
    while ($usuarios=$sentencia->fetch()) {
    $array[]=$usuarios;

}
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
return $array;
}


function totalusuariosporpalabrasuser($bd,$desc,$orden, $palabra,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT count(*) FROM usuario u
            WHERE u.estado LIKE 1 AND u.tipo LIKE 0 AND (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id AND o.estado like u.id AND o.publico like u.id)=0 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT count(*) FROM usuario u
            WHERE (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )=0 AND (u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        return $total;
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }

}



function filtrarusuarios3($bd,$desc,$orden,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE u.estado LIKE 1
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
    $sentencia->execute();
   
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
    $array=array();
    while ($usuarios=$sentencia->fetch()) {
    $array[]=$usuarios;

}
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
return $array;
}


function totalusuarios3($bd,$desc,$orden,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT COUNT(*) FROM usuario u
            WHERE u.estado LIKE 1 
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT COUNT(*) FROM usuario u
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
    $sentencia->execute();
   
    $total=$sentencia->fetchColumn(); 
        return $total;


    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }

}



function filtrarusuarios2($bd,$desc,$orden,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE u.estado LIKE 1 AND (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id AND o.estado like 1 AND o.publico like 1 )=0
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE  (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )=0
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
    $sentencia->execute();
   
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
    $array=array();
    while ($usuarios=$sentencia->fetch()) {
    $array[]=$usuarios;

}
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
return $array;
}


function totalusuarios2($bd,$desc,$orden,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT COUNT(*) FROM usuario u
            WHERE u.estado LIKE 1 AND (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id AND o.estado like 1 AND o.publico like 1 )=0
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT COUNT(*) FROM usuario u
            WHERE (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )=0
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
    $sentencia->execute();
   
    $total=$sentencia->fetchColumn(); 
        return $total;


    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }

}

function filtrarusuarios1($bd,$desc,$orden,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE u.estado LIKE 1  AND (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id AND o.estado like 1 AND o.publico like 1 )>0
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )>0
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
    $sentencia->execute();
   
    $sentencia->setFetchMode(PDO::FETCH_CLASS, "usuario");
    $array=array();
    while ($usuarios=$sentencia->fetch()) {
    $array[]=$usuarios;

}
    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
return $array;
}

function totalusuarios1($bd,$desc,$orden,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT COUNT(*) FROM usuario u
            WHERE u.estado LIKE 1 AND (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id AND o.estado like 1 AND o.publico like 1 )>0
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT COUNT(*) FROM usuario u
            WHERE (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )>0
            ORDER BY u.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
    $sentencia->execute();
   
    $total=$sentencia->fetchColumn(); 
        return $total;


    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }

}


function seguir($bd, $id_seguido, $id_seguidor)
{
    try {
       
        $sentencia = $bd->prepare("Insert INTO seguidor(id_seguido,id_seguidor)
    VALUES(:id_seguido,:id_seguidor)");
        $sentencia->execute(array(
            ':id_seguido' => $id_seguido, ':id_seguidor' => $id_seguidor)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
}


function dejardeseguir($bd, $id_seguido, $id_seguidor)
{
    try {
       
        $sentencia = $bd->prepare("DELETE FROM seguidor WHERE id_seguido like :id_seguido AND id_seguidor LIKE :id_seguidor");
        $sentencia->execute(array(
            ':id_seguido' => $id_seguido, ':id_seguidor' => $id_seguidor)
            
        );
       
        if ($sentencia->rowCount() == 0) {
            throw new Exception();
        }

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
}

function verseguidor($bd, $id_seguido, $id_seguidor)
{
    try {
       
        $sentencia = $bd->prepare("SELECT COUNT(*) FROM seguidor WHERE id_seguido LIKE :id_seguido AND
        id_seguidor LIKE :id_seguidor");
        $sentencia->execute(array(
            ':id_seguido' => $id_seguido, ':id_seguidor' => $id_seguidor)
            
        );
       
        $sentencia->execute();
        $total=$sentencia->fetchColumn();
        return $total;

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
}

function idseguidor($bd, $id_seguido)
{
    try {
       
        $sentencia = $bd->prepare("SELECT id_seguidor FROM seguidor WHERE id_seguido LIKE :id_seguido");
        $sentencia->execute(array(
            ':id_seguido' => $id_seguido)
            
        );
       
       $resultado= $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
    }
}

function bloquearuser($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE usuario SET estado= 0 WHERE id LIKE :id ");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
       
    }
}


function desbloquearuser($bd,$id){
    try {
        $sentencia = $bd->prepare("UPDATE usuario SET estado= 1 WHERE id LIKE :id ");
        $sentencia->execute(array(
           ':id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
       
    }
}


function actualizaruser($bd,$id, $username, $email, $nomyape, $contra){
    try {
        $sentencia = $bd->prepare("UPDATE usuario SET usuario= :username, email=:email,
        nomyape=:nomyape, contra=:contra
         WHERE id LIKE :id ");
        $sentencia->execute(array(
           ':id'=> $id, ':username'=>$username, ':email'=>$email, ':nomyape'=>$nomyape, ':contra'=>$contra
        ));
        

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
       
    }
}

function cambiarfotouser($bd,$img, $id){
    try {
        $sentencia = $bd->prepare("UPDATE usuario SET foto= :foto WHERE id LIKE :id ");
        $sentencia->execute(array(
           ':foto' => $img,':id'=> $id
        ));
        

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
       
    }
}


function eliminarusuario($bd,$id){
    try {
        $sentencia = $bd->prepare("DELETE from usuario WHERE id LIKE :id");
        $sentencia->execute(array(
           'id'=> $id
        ));
        if($sentencia->rowCount()==0)
        {
            throw new Exception();
            
        }

    } catch (Exception $e) {
        header("Location: error.php?error=Ha habido un problema con los usuarios");
        exit;
       
    }
}
?>