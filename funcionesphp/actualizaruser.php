<?php 

if(isset($_POST["usuario"])){
$usuario=$_POST["usuario"];
$img=$_POST["img"];
$username=$_POST["username"];
$email=$_POST["email"];
$nomyape=$_POST["nomyape"];
include("funcionesusuarios.php");
include("../clases/usuarios.class.php");
include("conexionbd.php");
session_start();
$bd = conectardb();
$user=unusuarioporcodigo($bd, $_POST["usuario"]);
$usublock=unusuarioporcodigo($bd, $_SESSION["usuario"]);
if($usublock->getestado()!=0){
if ($_POST['contra']) {
    $pass_enc = password_hash($_POST['contra'], PASSWORD_DEFAULT);
} else {
    $pass_enc = $user->getcontra();
}


actualizaruser($bd, $usuario, $username, $email, $nomyape, $pass_enc);


if($img!=""){
    $nombre_archivo = $_FILES['file']['name'];
    $ruta_temporal_archivo = $_FILES['file']['tmp_name'];
    $ext = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
    $nombretemporal = $_FILES['file']['tmp_name'];
    $fichero = "$usuario.$ext";
    if (move_uploaded_file($nombretemporal, "../Imagenes/Usuarios/$fichero")) {
        cambiarfotouser($bd,$fichero,$usuario);
    }
}
}
else{
    echo "block";
}

}
?>