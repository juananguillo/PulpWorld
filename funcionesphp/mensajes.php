<?php 

if(isset($_POST["accion"])){
include("conexionbd.php");
$bd = conectardb();
$id1=$_POST["id1"];
$id2=$_POST["id2"];
$accion=$_POST["accion"];
include('funcionesmensajes.php');
include("../clases/mensajes.class.php");

switch ($accion) {
    case 'listar':
       $array= mensajes($bd, $id1, $id2);
       echo "<input id='receptor' type='hidden' value='{$id2}'>";
       foreach ($array as $key => $value) {
          if($value->getid_emisor()==$id1){
              echo "<div class='text-right mt-1  border rounded border-primary'><strong class='ml-3 mr-3 text'>".$value->getcontenido()."</strong></div><br>";
          }
          else{
            echo "<div class='text-left mt-1  border rounded border-success'><strong class='ml-3 mr-3 text'>".$value->getcontenido()."</strong></div><br>";
          }
       }

        break;
       
    case 'insertar':
        crearmensaje($bd, $id1, $id2, $_POST["contenido"]);

        break;
}
}

?>