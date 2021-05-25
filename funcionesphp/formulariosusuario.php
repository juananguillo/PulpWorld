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
    
    header("Location: ../index.php?alerta=El usuario ha sido creado con exito, para disfrutar de la aplicación tienes que iniciar sesion!");
    exit;

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