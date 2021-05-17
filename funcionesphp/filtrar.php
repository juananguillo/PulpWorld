<?php 

if(isset($_POST["busqueda"]) || isset($_POST["busqueda1"])){
    include("conexionbd.php");
    include("../clases/obras.class.php");
    include("funcionesobras.php");
    $bd = conectardb();
    $orden=$_POST["orden"];
    $categoria=$_POST["categoria"];
    if($_POST["textobusqueda"]==""){
        if($_POST["block"]){
            header("Location: ../index.php?orden=$orden&categoria=$categoria&block=true#content");   
        }
        else{
            header("Location: ../index.php?orden=$orden&categoria=$categoria#content");   
        }
   
    }
    else{
        $palabras=trim($_POST["textobusqueda"]);
        if($_POST["block"]){
            header("Location: ../index.php?buscarpor=$palabras&orden=$orden&categoria=$categoria&block=true#content"); 
        }
        else{
            header("Location: ../index.php?buscarpor=$palabras&orden=$orden&categoria=$categoria#content");   
        }
      
    }

}

if(isset($_POST["busquedausu"]) || isset($_POST["busquedausu1"])){
    $orden=$_POST["orden"];
    $categoria=$_POST["categoria"];
    if($_POST["textobusqueda"]==""){
    header("Location: ../usuarios.php?orden=$orden&categoria=$categoria#content");   
    }
    else{
        $palabras=trim($_POST["textobusqueda"]);
        header("Location: ../usuarios.php?buscarpor=$palabras&orden=$orden&categoria=$categoria#content");   
    }

}


?>