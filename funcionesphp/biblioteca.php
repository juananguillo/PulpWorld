<?php 
if(isset($_POST["id_bi"])){
include("conexionbd.php");
$bd = conectardb();
include("funcionesbiblioteca.php");
$id_biblioteca=$_POST["id_bi"];
$id_obra=$_POST["id_o"];
guardarobra($bd, $id_biblioteca, $id_obra);

}

?>