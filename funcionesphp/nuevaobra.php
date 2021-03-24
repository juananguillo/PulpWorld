<?php 
/*
$titulo=$_POST["titulo"];
$sinopsis=$_POST["sinopsis"];
*/
$nombre_archivo = $_FILES['file']['name'];
$ruta_temporal_archivo = $_FILES['file']['tmp_name'];
$ext = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
$nombretemporal = $_FILES['archivo']['tmp_name'];
$fichero = "$titulo.$ext";
if (move_uploaded_file($nombretemporal, "Imagenes/productos/$fichero")) {
echo "bien";
}

?>