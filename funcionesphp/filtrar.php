<?php 

if(isset($_POST["busqueda"]) || isset($_POST["busqueda1"])){
    include("conexionbd.php");
    include("../clases/obras.class.php");
    include("funcionesobras.php");
    $bd = conectardb();
    $orden=$_POST["orden"];
    $categoria=$_POST["categoria"];
    if($_POST["textobusqueda"]==""){
    header("Location: ../index.php?orden=$orden&categoria=$categoria");   
    }
    else{
        $palabras=$_POST["textobusqueda"];
        header("Location: ../index.php?buscarpor=$palabras&orden=$orden&categoria=$categoria");   
    }

}

?>