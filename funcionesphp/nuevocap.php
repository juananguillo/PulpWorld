<?php 

include("conexionbd.php");
$bd = conectardb();
include('../clases/capitulos.class.php');
include('funcionescapitulos.php');

$cap=nuevocapitulo($bd, $_GET["obra"]);
header("Location: ../edicion.php?cap=$cap&obra={$_GET["obra"]}");

?>