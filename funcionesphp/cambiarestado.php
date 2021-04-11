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

switch ($_POST["accion"]) {
    case 'publicar':
        publicar($bd, $id_obra);
       $seguidores= idseguidor($bd, $obra->getautor());
        for ($i=0; $i < count($seguidores); $i++) { 
            notifiobras($bd, $seguidores[$i]["id_seguidor"], 0, $id_obra, "Ha publicado una nueva obra!");
        }

        break;
    
    case 'despublicar':
        despublicar($bd, $id_obra);
        break;

        case 'bloquear':
            bloquear($bd, $id_obra);
            break;

            case 'desbloquear':
                desbloquear($bd, $id_obra);
                break;
}

}

elseif(isset($_POST["id_capi"])){
    include("funcionescapitulos.php");
    $id_capi=$_POST["id_capi"];
    $user=$_POST["user"];
    $capitulo=obteneruncapitulo($bd,$id_capi);
    $obra=obtenerunaobra($bd,$capitulo->getid_obra());
    switch ($_POST["accion"]) {
        case 'publicar':
            publicarcapi($bd, $id_capi);
            $seguidores= idseguidor($bd, $obra->getautor());
            for ($i=0; $i < count($seguidores); $i++) { 
            notificapi($bd, $seguidores[$i]["id_seguidor"], 1, $id_capi, "Ha publicado un nuevo capitulo!");
            }
            break;
        
        case 'despublicar':
            despublicarcapi($bd, $id_capi);
            break;
    
            case 'bloquear':
                echo "block";
                bloquearcapi($bd, $id_capi);
                break;
    
                case 'desbloquear':
                    desbloquearcapi($bd, $id_capi);
                    break;
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
