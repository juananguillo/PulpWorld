<?php 

include("conexionbd.php");
$bd = conectardb();
include("funcionesobras.php");
include("funcionesusuarios.php");
include("../clases/obras.class.php");
include("../clases/capitulos.class.php");
if(isset($_POST["id_obra"])){
$id_obra=$_POST["id_obra"];
$user=$_POST["user"];
$obra=obtenerunaobra($bd,$id_obra);
$seguidores= idseguidor($bd, $obra->getautor());
$o=obtenerunaobra($bd, $id_obra);
switch ($_POST["accion"]) {
    case 'publicar':
        publicar($bd, $id_obra);
      
        for ($i=0; $i < count($seguidores); $i++) { 
            notifiobras($bd, $seguidores[$i]["id_seguidor"], 0, $id_obra, "ha publicado una nueva obra!");
        }

        break;
    
    case 'despublicar':
        
        despublicar($bd, $id_obra);

        
        for ($i=0; $i < count($seguidores); $i++) { 
            quitarnotifi($bd, $seguidores[$i]["id_seguidor"], $id_obra, 0);
        }

        break;

        case 'bloquear':
            bloquear($bd, $id_obra);
            notifiobras($bd, $o->getautor(), -1, $id_obra, "ha sido bloqueada, para mas info contacte con soporte!");
            break;

            case 'desbloquear':
                desbloquear($bd, $id_obra);
                    quitarnotifi($bd, $o->getautor(), $id_obra, -1);
                break;
}

}

elseif(isset($_POST["id_capi"])){
    include("funcionescapitulos.php");
    $id_capi=$_POST["id_capi"];
    $user=$_POST["user"];
    $capitulo=obteneruncapitulo($bd,$id_capi);
    $obra=obtenerunaobra($bd,$capitulo->getid_obra());
    $seguidores= idseguidor($bd, $obra->getautor());
    switch ($_POST["accion"]) {
        case 'publicar':
            publicarcapi($bd, $id_capi);
           if($obra->getpublico()==1){
            for ($i=0; $i < count($seguidores); $i++) { 
            notificapi($bd, $seguidores[$i]["id_seguidor"], 1, $id_capi, "ha publicado un nuevo capitulo");
            }
        }
            break;
        
        case 'despublicar':
            despublicarcapi($bd, $id_capi);
            for ($i=0; $i < count($seguidores); $i++) { 
                quitarnotificapi($bd, $seguidores[$i]["id_seguidor"], $id_capi, 1);
            }
            break;
    
            case 'bloquear':
                echo "block";
                bloquearcapi($bd, $id_capi);
                notificapi($bd, $obra->getautor(), -2, $id_capi, "ha sido bloqueado!, para mas informacion
                contacte con soporte");
                break;
    
                case 'desbloquear':
                    desbloquearcapi($bd, $id_capi);
                   
                        quitarnotifi($bd, $obra->getautor(), $id_capi, -2);
                    
                    break;
    }
}

elseif(isset($_POST["id_user"])){
    
$id_user=$_POST["id_user"];
    if($_POST["accion"]=="bloquear"){
     bloquearuser($bd,$id_user);
    }else{
      desbloquearuser($bd, $id_user);
    
    } 
}