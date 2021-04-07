<?php 

include("conexionbd.php");
$bd = conectardb();
if(isset($_POST["id_obra"])){
    include("funcionesobras.php");
$id_obra=$_POST["id_obra"];
$id_usuario=$_POST["id_usuario"];
if($_POST["accion"]=="dar"){
    darmegusta($bd, $id_obra, $id_usuario);
}else{
    quitarmegusta($bd, $id_obra, $id_usuario);

}
}
elseif(isset($_POST["id_seguido"])){
    include("funcionesusuarios.php");
$id_seguido=$_POST["id_seguido"];
$id_seguidor=$_POST["id_seguidor"];
    if($_POST["accion"]=="dar"){
       seguir($bd, $id_seguido, $id_seguidor);
    }else{
        dejardeseguir($bd, $id_seguido, $id_seguidor);
    
    } 
}
?>