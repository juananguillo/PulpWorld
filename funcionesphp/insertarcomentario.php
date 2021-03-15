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
$usuarios=arrayusuariostodos($bd);

 for($i=0; $i<count($comentarios); $i++) {
    $respuestas=obtenerespuestas($bd, $comentarios[$i]->getid());
   echo "
    <div class='comment clearfix'>
            <div class='comment-details'>
                <span class='comment-name'>";
                echo $usuarios[$comentarios[$i]->getid_usuario()]->getusuario(); echo "</span>
                <span class='comment-date'>"; echo $comentarios[$i]->getid_usuario(); echo "</span>
                <p>"; echo $comentarios[$i]->getmensaje(); echo "</p>
                <a class='reply-btn resp2'  href='#' data-toggle='modal' data-target='#coment' data-value={$usuarios[$comentarios[$i]->getid_usuario()]->getusuario()} data-id={$comentarios[$i]->getid()} >Responder</a>
            </div>
    </div>
            
            
            <div>";
               
                for($e=0; $e<count($respuestas); $e++) {
               echo "<div class='comment reply clearfix'>
                    
                    <div class='comment-details'>
                        <span class='comment-name'>"; echo $usuarios[$respuestas[$e]->getid_usuario()]->getusuario(); echo "</span>
                        <span class='comment-date'></span>
                        <p>"; echo $respuestas[$e]->getmensaje(); echo "</p>
                        <a class='reply-btn resp2' data-toggle='modal' data-target='#coment' href='#'  data-value={$usuarios[$comentarios[$i]->getid_usuario()]->getusuario()} data-id={$comentarios[$i]->getid()}>Responder</a>
                    </div>
                </div>";
                 }
                 echo "
            </div>";
             } 
                }
                else{
                    header("Location :./index.php");
                }
?>