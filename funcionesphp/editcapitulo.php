<?php 
include("conexionbd.php");
include("funcionescapitulos.php");
$bd = conectardb();
$titulo=$_POST["titulo"];
$contenido=$_POST["contenido"];
$id=$_POST["id"];
editcap($bd, $titulo, $contenido, $id);




?>