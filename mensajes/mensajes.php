<?php 

try {
    $conn = new PDO('mysql:host=localhost;dbname=bda', 'BDA1', 'jefazo');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (\Throwable $th) {
    echo $th->getMessage();
}

 try {
    $mensaje=explode("\n", $_POST['mensaje']);
    for ($i=0; $i <count($mensaje) ; $i++) { 
        $sentencia = $conn->prepare("Insert INTO mensajes(id_mensaje,id_emisor,id_receptor,mensaje)
VALUES(:id_mensaje,:id_emisor, :id_receptor, :mensaje)");
    $sentencia->execute(array(
        ':id_mensaje' => null, ':id_emisor' => 1, ':id_receptor' => 2, ':mensaje' => $mensaje[$i])
        
    ); 
    }
   
   
    if ($sentencia->rowCount() == 0) {
        throw new Exception();
    }
    
    
} catch (Exception $e) {
  echo $e->getMessage();
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