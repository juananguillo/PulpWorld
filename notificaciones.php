<?php 
session_start();

include("./funcionesphp/conexionbd.php");
$bd = conectardb();
include("clases/usuarios.class.php");
include("./funcionesphp/funcionesusuarios.php");
include("./funcionesphp/funcionesobras.php");
include("clases/obras.class.php");
include('clases/capitulos.class.php');
include('./funcionesphp/funcionescapitulos.php');
include("Includes/header.php");
if(!isset($_SESSION["usuario"])){
    header("Location: index.php");
}
$desplazamiento = $_GET['desplazamiento'] ?? 0;
$usuario= unusuarioporcodigo($bd, $_SESSION['usuario']);
$usuarios=arrayusuariosporid($bd);
$notificaciones=notificaciones($bd,$_SESSION['usuario'], $desplazamiento);
$total=totalnoti($bd, $_SESSION['usuario']);



   

    ?>

    </head>
<body>
    <?php 
    include("Includes/nav.php");
    ?>
    <body>
      <h1 class="text-center">Notificaciones</h1>
    <div id="not" class="container mb-5 text-center">
      <?php 
      for ($i=0; $i < count($notificaciones) ; $i++) { 
        ?>

        <div class="row">
          <?php 
          $u="<a href='usuario.php?user={$notificaciones[$i]["id_usuario"]}'>{$usuarios[$notificaciones[$i]["id_usuario"]]->getusuario()}</a>";
          switch ($notificaciones[$i]["tipo"]) {
            case 0:
              $ver=$notificaciones[$i]["id_novedad"];
              $a="<a href='obra.php?obra={$ver}'>Ver mas</a>";
              echo "El usuario ".$u." ".$notificaciones[$i]["mensaje"]." ".$a;
              break;
            
            case 1:
              $ver=$notificaciones[$i]["id_novedad"];

             $c= obteneruncapitulo($bd, $notificaciones[$i]["id_novedad"]);
             $o= obtenerunaobra($bd, $c->getid_obra());
              $a="<a href='capitulo.php?cap={$ver}'>Ver mas</a>";
              $a2="<a href='obra.php?obra={$o->getid()}'>{$o->gettitulo()}</a>";
            
              echo "El usuario ".$u." ".$notificaciones[$i]["mensaje"]." en ".$a2." ".$a;
              break;

              case -1:
                $o=obtenerunaobra($bd, $notificaciones[$i]["id_novedad"]);
                echo "Lo sentimos la obra <strong>".$o->gettitulo()."</strong> ".$notificaciones[$i]["mensaje"];
              break;

              case -2:
                $c= obteneruncapitulo($bd, $notificaciones[$i]["id_novedad"]);
                $o= obtenerunaobra($bd, $c->getid_obra());
                $a2="<a href='obra.php?obra={$o->getid()}'>{$o->gettitulo()}</a>";
                echo "Lo sentimos en la obra ".$a2." el capitulo <strong>".$c->gettitulo()." </strong>".$notificaciones[$i]["mensaje"];
          }
          
          ?>
        </div>

        <?php
      }
      ?>
   <div>

   </div>
   
    </div>
    <?php 
include("Includes/footer.php")
?>
</body>

</html>