<?php 
include("./clases/usuarios.class.php");
include("./funcionesphp/funcionesusuarios.php");
if(isset($_SESSION['usuario'])){
$usbloq=unusuarioporcodigo($bd, $_SESSION['usuario']);
}


?>