<?php 

if(isset($_POST['id_usuario'])){
    include('conexionbd.php');
    $bd = conectardb();
    include('../clases/usuarios.class.php');
include('funcionesusuarios.php');
include('../clases/obras.class.php');
include('funcionesobras.php');
include('../clases/comentarios.class.php');
include('funcionescomentarios.php');
    $id_usuario=$_POST['id_usuario'];
    $id_obra=$_POST['id_obra'];
    $mensaje=$_POST['mensaje'];
    $res=$_POST['res'] ?? null;
   /* if($_POST['una']==0){
        insertarcomentario($bd, $id_usuario, $mensaje, $id_obra, $res);
      
    }*/
    //echo $_POST['una'];
    insertarcomentario($bd, $id_usuario, $mensaje, $id_obra, $res);
$obra=obtenerunaobra($bd,$id_obra);
$comentarios=obtenercoments($bd, $id_obra);
$usuarios=arrayusuariosporid($bd);

 for($i=0; $i<count($comentarios); $i++) {
    $respuestas=obtenerespuestas($bd, $comentarios[$i]->getid());
   echo "
   <li class='font-weight-bold'>{$usuarios[$comentarios[$i]->getid_usuario()]->getusuario()}</li>
				<li>{$comentarios[$i]->getmensaje()}</li>
				<li><a class='reply-btn resp2'  href='#' data-toggle='modal' data-target='#coment'  data-value={$usuarios[$comentarios[$i]->getid_usuario()]->getusuario()} data-id={$comentarios[$i]->getid()}>Responder</a></li>
							<ul style='list-style:none;'>";
							for($e=0; $e<count($respuestas); $e++) {
								echo "	
							<li class='font-weight-bold'>{$usuarios[$respuestas[$e]->getid_usuario()]->getusuario()}</li>
							<li>{$respuestas[$e]->getmensaje()}</li>
							<li><a class='reply-btn resp2' data-toggle='modal' data-target='#coment' href='#' data-value={$usuarios[$comentarios[$i]->getid_usuario()]->getusuario()} data-id={$comentarios[$i]->getid()}>Responder</a></li>
							";
             }
             echo "</ul>"; 
                }
            }
                else{
                    header('Location :./index.php');
                }
