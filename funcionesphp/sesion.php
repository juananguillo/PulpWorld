<?php 

session_start();
if($_POST['botonsesion']){
include("conexionbd.php");
$bd = conectardb();
include("funcionesusuarios.php");
include("../clases/usuarios.class.php");
$us = unusuario($bd, $_POST['usulog']);
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
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>