<?php 
include("conexionbd.php");
$conn = conectardb();
 try {
     if(isset($_POST['usuario'])){
    $usu=$_POST['usuario'];
    $sentencia = $conn->prepare("SELECT COUNT(*) FROM usuario WHERE usuario like :usuario");
    $sentencia->execute(array(
        ":usuario" => $usu
    ));
    $total=$sentencia->fetchColumn(); 
    if($total==0){ 
        echo true;
    }
    else{
echo false;
        }
    
    }
    
    else{
       
            $email=$_POST['email'];
            $sentencia = $conn->prepare("SELECT COUNT(*) FROM usuario WHERE email like :email");
            $sentencia->execute(array(
                ":email" => $email
            ));
            $total=$sentencia->fetchColumn(); 
            if($total==0){ 
                echo true;
            }
            else{
        echo false;
                }
            
            }
    
} catch (Exception $e) {
    header("Location:formulario.php?error=Error");
    exit;
}



?>