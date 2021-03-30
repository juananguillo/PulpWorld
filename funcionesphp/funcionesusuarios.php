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
        echo $e->getMessage();
        //header("Location: error.php?error=Error");
    }

    function anyadirusuario($db){
        $sentencia = $db->prepare("Insert INTO clientes(usuario,contra,email)
        VALUES(:usuario, :contra, :email)");
    }


}


function totalusuarios($db,$tipo){

    try {
        if($tipo==0){
            $sentencia = $db->prepare("SELECT COUNT(*) FROM usuario WHERE estado LIKE 1 AND tipo like 0");
        $sentencia->execute();
        $total=$sentencia->fetchColumn(); 
        }else{
        $sentencia = $db->prepare("SELECT COUNT(*) FROM usuario");
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
/*
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
        */
    } catch (Exception $e) {
        echo $e->getMessage();
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
        
    header("Location: error.php?error=Error");
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
        
    header("Location: error.php?error=Error");
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
        echo $e->getMessage();
        //header("Location: error.php?error=Error al devolver el cliente, no existe en la base de datos");
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
        echo $e->getMessage();
        ///header("Location: error.php?error=Error");
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
        echo $e->getMessage();
        //header("Location: error.php?error=Error al devolver el cliente, no existe en la base de datos");
    }


}


function arrayusuarios($bd){
    try {

            $sentencia = $bd->prepare("SELECT * FROM usuario 
            WHERE tipo LIKE 0 AND estado like 1");
            
    
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
        echo $e->getMessage();
        //header("Location: error.php?error=Error al cargar el array de clientes ");
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
        echo $e->getMessage();
        //header("Location: error.php?error=Error al cargar el array de clientes ");
    }
return $array;
}

function arrayusuariosporid($bd){
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
    $array[$usuarios->getid()]=$usuarios;

}
    } catch (Exception $e) {
        echo $e->getMessage();
        //header("Location: error.php?error=Error al cargar el array de clientes ");
    }
return $array;
}




function filtrarusuariosporpalabras($bd,$desc,$orden, $palabra,$tipo){
    try {
        if($tipo==0){
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE u.estado LIKE 1 u.tipo LIKE 0 (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )>0 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY o.$orden DESC
        LIMIT $desc, 20000000");
        }
        else{
            $sentencia = $bd->prepare("SELECT u.* FROM usuario u
            WHERE (SELECT COUNT(*) FROM obras o WHERE o.autor LIKE u.id )>0 AND (
            u.id like '%$palabra%' OR u.email LIKE '%$palabra%' OR u.nomyape LIKE '%$palabra%')
            ORDER BY o.$orden DESC
        LIMIT $desc, 20000000");
        }   
    
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
        echo $e->getMessage();
        //header("Location: error.php?error=Error al cargar el array de clientes ");
    }
return $array;
}


?>