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
       $totalm= countmensajes($bd, $id1,  $id2);
       echo "<input id='receptor' type='hidden' value='{$id2}'>
       <input id='totalm' type='hidden' value='{$totalm}'>";
       foreach ($array as $key => $value) {
          if($value->getid_emisor()==$id1){
            echo "<div class='mt-1  border rounded border-primary mdiv1'><p class='text text-justify'><strong>".$value->getcontenido()."</strong></p></div><br>";
        }
        else{
          echo "<div class='mt-1  border rounded border-success mdiv2'><p class='text text-justify'><strong>".$value->getcontenido()."</strong></p></div><br>";
        }
       }

        break;
       
    case 'insertar':
        crearmensaje($bd, $id1, $id2, $_POST["contenido"]);

        break;

    case 'comprobar':
      echo countmensajes($bd, $id1, $id2);

        break;
}
}

?>