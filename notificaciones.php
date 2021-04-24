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
$pagina = $_GET['pag'] ?? 1;



   

    ?>
   <link rel="stylesheet" href="css/notificaciones.css">
    </head>
<body>
    <?php 
    include("Includes/nav.php");
    ?>
    <body>
      <h1 class="text-center mt-5 mb-5">Notificaciones</h1>
    <div id="not" class="container mb-5 border">
      <?php 
      for ($i=0; $i < count($notificaciones) ; $i++) { 
        ?>
        <div id="textnot" class="mt-3 mb-3 border border-primary ml-3 mr-3">

       
          <?php 
          switch ($notificaciones[$i]["tipo"]) {
            case 0:
              $o= obtenerunaobra($bd, $notificaciones[$i]["id_novedad"]);
              $thisusuario=unusuarioporcodigo($bd, $o->getautor());
              $u="<a href='usuario.php?user={$o->getautor()}'>{$thisusuario->getusuario()}</a>";
              $ver=$notificaciones[$i]["id_novedad"];
              $a="<a href='obra.php?obra={$ver}'>Ver mas</a>";
              echo "El usuario ".$u." ".$notificaciones[$i]["mensaje"]." ".$a;
              break;
            
            case 1:
              $ver=$notificaciones[$i]["id_novedad"];
             $c= obteneruncapitulo($bd, $notificaciones[$i]["id_novedad"]);
             $o= obtenerunaobra($bd, $c->getid_obra());
             $thisusuario=unusuarioporcodigo($bd, $o->getautor());
             $u="<a href='usuario.php?user={$o->getautor()}'>{$thisusuario->getusuario()}</a>";
              $a="<a href='capitulo.php?cap={$ver}'>Ver mas</a>";
              $a2="<a href='obra.php?obra={$o->getid()}'>{$o->gettitulo()}</a>";
              $u="<a href='usuario.php?user={$o->getautor()}'>{$thisusuario->getusuario()}</a>";
              echo "El usuario ".$u." en la obra ".$a2." ".$notificaciones[$i]["mensaje"]." ".$a;
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
   <br>

        <?php
      }
      ?>
   <div>

   </div>
   
    </div>
    
    <nav aria-label="...">
        <ul class="pagination justify-content-center mt-5">
            <?php
            if ($desplazamiento > 0) {
                $prev = $desplazamiento - 12;
                $url = $_SERVER["PHP_SELF"] . "?&desplazamiento=$prev";
                echo "<li class='page-item active'>";
                echo  "<a class='page-link mr-4' href=$url tabindex='-1'>Anterior</a>";
            } else {

                echo "<li class='page-item disabled'>";
                echo  "<a class='page-link mr-4' href='#' tabindex='-1'>Anterior</a>";
            }

            ?>

            </li>
            <?php
            $o = 0;
            for ($i = 0; $i < $total; $i += 12) {
                $o++;
                $url = $_SERVER["PHP_SELF"] . "?&desplazamiento=$i&pag=$o";
                if ($pagina == $o) {
                    echo "<li class='page-item active'>
                <a class='page-link' href=$url>$o <span class='sr-only'>(current)</span></a>
            </li>";
                } else {
                    echo  "<li class='page-item'><a class='page-link' href=$url>$o</a></li>";
                }
            }

            if ($total > ($desplazamiento + 12)) {
                $prox = $desplazamiento + 12;
                $url = $_SERVER["PHP_SELF"] . "?desplazamiento=$prox";
                echo "<li class='page-item active'>";
                echo  "<a class='page-link ml-4' href=$url tabindex='-1'>Siguiente</a>";
            } else {
                echo "<li class='page-item disabled'>";
                echo  "<a class='page-link ml-4' href='#' tabindex='-1'>Siguiente</a>";
            }

            ?>
            </li>
        </ul>
    </nav>
    <?php 
include("Includes/footer.php")
?>
</body>

</html>