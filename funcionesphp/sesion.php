<?php 

session_start();
if($_POST['botonsesion']){
include("conexionbd.php");
$bd = conectardb();
include("funcionesusuarios.php");
include("../clases/usuarios.class.php");
$us;
$campo=filter_var($_POST['usulog'], FILTER_VALIDATE_EMAIL)? "email":"usuario";
if($campo=="email"){ $us=obtenerusuario2($bd, $_POST['usulog']);}
else{
    $us = unusuario($bd, $_POST['usulog']);
}
$_SESSION['usuario']=$us->getid();
switch (comprobartipo($bd, $_SESSION['usuario'])) {
    case 0:
        $_SESSION['tipo']=0;
        break;
    
    case 1:
        $_SESSION['tipo']=1;
        break;
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
}
if(isset($_GET['logout'])){
    session_destroy();
    if($_GET['index']){
        header("Location: ../index.php");
    }else{
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
  
}

?>