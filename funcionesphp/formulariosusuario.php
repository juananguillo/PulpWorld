<?php 
include("conexionbd.php");
$bd = conectardb();
include("funcionesusuarios.php");
include("funcionesbiblioteca.php");
include("../clases/usuarios.class.php");
if(isset($_POST['botonregistro'])){

   
    dardealtausuario($bd, $_POST['usureg'], $_POST['contrareg'], $_POST['emailreg']);
    $id = $bd->lastInsertId();
    crearbiblioteca($bd, $id);
    
    header("Location: ../index.php?alerta=Mira el correo para activar el usuario");
    exit;

}

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
   
}else{
    
}

if(isset($_POST['usulog'])) {
   
    $usuario=$_POST['usulog'];
    $campo=filter_var($_POST['usulog'], FILTER_VALIDATE_EMAIL)? "email":"usuario";
    if($campo=="email") $usuario=obtenerusuario($bd, $_POST['usulog']);
    echo comprobarusuario($bd, $usuario, $_POST['contralog']);
    if(comprobarusuario($bd, $usuario, $_POST['contralog'])){
      
    }
    else {
       echo false;
    }

 }

?>