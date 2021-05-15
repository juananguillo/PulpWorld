<?php 

include("conexionbd.php");
$bd = conectardb();
session_start();
include("funcionesobras.php");
include("funcionesusuarios.php");
include("funcionescapitulos.php");
include("../clases/obras.class.php");
include("../clases/usuarios.class.php");
include("../clases/capitulos.class.php");
$user=$_POST["user"];
$usublock=unusuarioporcodigo($bd, $_SESSION["usuario"]);
if($usublock->getestado()!=0){
if(isset($_POST["id_obra"])){
$id_obra=$_POST["id_obra"];
$obra=obtenerunaobra($bd,$id_obra);
$seguidores= idseguidor($bd, $obra->getautor());
$o=obtenerunaobra($bd, $id_obra);
switch ($_POST["accion"]) {
    case 'eliminar':{
        $capis=allcapitulos($bd, $id_obra);
        for ($i=0; $i < count($seguidores); $i++) { 
            quitarnotifi($bd, $seguidores[$i]["id_seguidor"], $id_obra, 0);
            for ($e=0; $e < count($capis); $e++) { 
                quitarnotificapi($bd, $seguidores[$i]["id_seguidor"], $capis[$e]->getid(), 1);
            }
        }
        eliminarobra($bd,$id_obra);
        break;
    }

    case 'publicar':
        publicar($bd, $id_obra);
    
      
        for ($i=0; $i < count($seguidores); $i++) { 
            notifiobras($bd, $seguidores[$i]["id_seguidor"], 0, $id_obra, "ha publicado una nueva obra, no te la pierdas!");
        }

        break;
    
    case 'despublicar':
        
        despublicar($bd, $id_obra);
        if($o->getestado()==1){
            menosuna($bd, $o->getautor());
        }
        $capis=allcapitulos($bd, $id_obra);
        for ($i=0; $i < count($seguidores); $i++) { 
            quitarnotifi($bd, $seguidores[$i]["id_seguidor"], $id_obra, 0);
            for ($e=0; $e < count($capis); $e++) { 
                quitarnotificapi($bd, $seguidores[$i]["id_seguidor"], $capis[$e]->getid(), 1);
            }
        }

        break;

        case 'terminar':
            terminar($bd, $id_obra);
         
        
    
            break;
        
        case 'desterminar':
            
            desterminar($bd, $id_obra);
    
            break;


        case 'bloquear':
            bloquear($bd, $id_obra);
            
            notifiobras($bd, $o->getautor(), -1, $id_obra, "ha sido bloqueada, para mas informacion
            mande en la pestaña de contacto un mensaje con el motivo de la incidencia");

        if($o->getestado()==1 && $o->getpublico()==1){
            menosuna($bd, $o->getautor());
        }
        $capis=allcapitulos($bd, $id_obra);
        for ($i=0; $i < count($seguidores); $i++) { 
            quitarnotifi($bd, $seguidores[$i]["id_seguidor"], $id_obra, 0);
            for ($e=0; $e < count($capis); $e++) { 
                quitarnotificapi($bd, $seguidores[$i]["id_seguidor"], $capis[$e]->getid(), 1);
            }
           
        }


            break;

            case 'desbloquear':
                desbloquear($bd, $id_obra);
                    quitarnotifi($bd, $o->getautor(), $id_obra, -1);
                break;
}

}

elseif(isset($_POST["id_capi"])){
    $id_capi=$_POST["id_capi"];
    $user=$_POST["user"];
    $capitulo=obteneruncapitulo($bd,$id_capi);
    $obra=obtenerunaobra($bd,$capitulo->getid_obra());
    $seguidores= idseguidor($bd, $obra->getautor());
    switch ($_POST["accion"]) {

        case 'eliminar':
            for ($i=0; $i < count($seguidores); $i++) { 
                quitarnotificapi($bd, $seguidores[$i]["id_seguidor"], $id_capi, 1);
            }
            eliminarcapi($bd, $id_capi);
            break;

        case 'publicar':
            publicarcapi($bd, $id_capi);
           if($obra->getpublico()==1){
            for ($i=0; $i < count($seguidores); $i++) { 
            notificapi($bd, $seguidores[$i]["id_seguidor"], 1, $id_capi, "ha publicado un nuevo capitulo, no te lo pierdas!");
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
                bloquearcapi($bd, $id_capi);
                notificapi($bd, $obra->getautor(), -2, $id_capi, "ha sido bloqueado, para mas informacion
                mande en la pestaña de contacto un mensaje con el motivo de la incidencia");

                for ($i=0; $i < count($seguidores); $i++) { 
                    quitarnotificapi($bd, $seguidores[$i]["id_seguidor"], $id_capi, 1);
                }

                break;
    
                case 'desbloquear':
                    desbloquearcapi($bd, $id_capi);
                   
                        quitarnotifi($bd, $obra->getautor(), $id_capi, -2);
                    
                    break;
    }
}

elseif(isset($_POST["id_user"])){
    
$id_user=$_POST["id_user"];

switch ($_POST["accion"]) {
    case 'bloquear':
        bloquearuser($bd,$id_user);
        $obras= obrasautor($bd,1,$id_user);
        foreach ($obras as $key => $value) {
            bloquear($bd, $value->getid());
        }
        break;
    
    case 'desbloquear':
        desbloquearuser($bd, $id_user);
        break;

    case 'eliminar':
        eliminarusuario($bd, $id_user);
        break;
}
   
}

}

else{
    echo "block";
}
