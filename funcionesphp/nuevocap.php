<?php 

include("conexionbd.php");
$bd = conectardb();
include('../clases/capitulos.class.php');
include('funcionescapitulos.php');
include('funcionesusuarios.php');
usublock($bd, $_GET["autor"]);
$cap=nuevocapitulo($bd, $_GET["obra"]);
header("Location: ../edicion.php?cap=$cap&obra={$_GET["obra"]}");

?>