<?php 

$titulo=$_POST["titulo"];
$sinopsis=$_POST["sinopsis"];
$img=$_POST["titulo"];
$autor=$_POST["autor"];
$cat=$_POST["cat"];

include("conexionbd.php");
$bd = conectardb();
include("funcionesobras.php");
include("funcionescategorias.php");
$array=explode(",", $cat);


$id=nuevaobra($bd, $titulo, $sinopsis, $autor);

if($img!=""){
$nombre_archivo = $_FILES['file']['name'];
$ruta_temporal_archivo = $_FILES['file']['tmp_name'];
$ext = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
$nombretemporal = $_FILES['file']['tmp_name'];
$fichero = "$id.$ext";
if (move_uploaded_file($nombretemporal, "../Imagenes/Obras/$fichero")) {
    cambiarfoto($bd,$fichero,$id);
}
}
for ($i=0; $i <count($array) ; $i++) { 
    addgenero($bd,$id,$array[$i]);
}

echo $id;

?>