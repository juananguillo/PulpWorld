<?php 

try {
    $conn = new PDO('mysql:host=localhost;dbname=bda', 'BDA1', 'jefazo');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (\Throwable $th) {
    echo $th->getMessage();
}

try {
    $sentencia = $conn->prepare("SELECT mensaje FROM mensajes WHERE id_emisor like 1 AND id_receptor like 2");
    $sentencia->execute();
    $array= array();
    $i=0;
    while($datos = $sentencia->fetch() ){
     $array[$i]=$datos[0];
     $i++;
           
    }
    echo $array;
}
 
catch (Exception $e) {
    echo $e->getMessage();
}


?>