<?php 
session_start();
include("./funcionesphp/conexionbd.php");
$bd = conectardb();
include("clases/usuarios.class.php");
include("./funcionesphp/funcionesusuarios.php");
include("clases/obras.class.php");
include("clases/capitulos.class.php");
include("funcionesphp/funcionesobras.php");
include("funcionesphp/funcionescapitulos.php");
include("clases/categorias.class.php");
include("funcionesphp/funcionescategorias.php");
include("clases/comentarios.class.php");
include("funcionesphp/funcionescomentarios.php");
if(isset($_GET["cap"])){
    $capitulo=obteneruncapitulo($bd,$_GET["cap"]);
	$obra=obtenerunaobra($bd,$capitulo->getid_obra());
	$usuarios=arrayusuarios($bd);
    if(!isset($_SESSION["usuario"])){
		$capitulos= capitulos($bd, $capitulo->getid_obra());
	}
	if(isset($_SESSION["usuario"])){
		if($_SESSION["usuario"]==$obra->getautor() || $_SESSION["tipo"]==1){
			$capitulos= allcapitulos($bd, $capitulo->getid_obra());
		}
		else{
			$capitulos= capitulos($bd, $capitulo->getid_obra());
		}
	}


	
    $anterior;
    $siguiente;
    for ($i=0; $i < count($capitulos); $i++) { 
        if($capitulos[$i]->getid()==$capitulo->getid()){
            $anterior=$i==0 ? false : $capitulos[$i-1]->getid();
            $siguiente=$i+1>=count($capitulos)? false : $capitulos[$i+1]->getid();
            break;
            
        }
    }
}
else{
	header("Location: index.php");
}
$categorias=categorias($bd);

if(isset($_SESSION['usuario'])){
   $usuario= unusuarioporcodigo($bd, $_SESSION['usuario']);



}
include("Includes/header.php");
    ?>
    <link rel="stylesheet" href="libro.css">
    </head>
<body>
    <?php 
    include("Includes/nav.php");
    $desplazamiento = $_GET['desplazamiento'] ?? 0;
    $pagina=$_GET['pag'] ?? 1;
    ?>
    <body>
   
    <h2 class="text-center mb-5">
    <?php echo $obra->gettitulo(); ?>
    </h2>
    <h3 class="text-center mb-5">
    <?php echo $capitulo->gettitulo(); ?>
    </h3>
    
    <div class="container h-100 mt-5 mb-5 d-flex flex-column">
    <ul class="nav nav-tabs">
      <li class="nav-item">
	  <a class="nav-link active" href="#contenido" data-toggle="tab">Contenido</a>
	  </li>
	  
      <li class="nav-item">
	  <a class="nav-link btn btn-primary ml-1"  <?php echo "href=obra.php?obra={$obra->getid()}";?>>Volver a obra</a>
	  </li>
	 
    </ul>
    
    <div class="row flex-fill h-100" style="min-height:0">
        <div class="col-12 border mh-100 tab-content">
        <div class="tab-pane active in" id="contenido">
       <textarea readonly style="resize: none;" class="form-control" rows="25"><?php echo $capitulo->getcontenido(); ?>
       </textarea> 
        </div>
       
    </div>
    </div>
    
    </div>
    <nav aria-label="...">
        <ul class="pagination justify-content-center mt-5">
        <?php 
        if ($anterior !=false) {
            $url = $_SERVER["PHP_SELF"] . "?cap=$anterior";
            echo "<li class='page-item active'>";
            echo  "<a class='page-link mr-4' href=$url tabindex='-1'>Anterior</a>";
        }
        else{
            
            echo "<li class='page-item disabled'>";
            echo  "<a class='page-link mr-4' href='#' tabindex='-1'>Anterior</a>";
        }
      
         ?>
               
            </li>
            <?php 

              if ($siguiente!=false) {
                
                $url = $_SERVER["PHP_SELF"] . "?cap=$siguiente";
                echo "<li class='page-item active'>";
                echo  "<a class='page-link ml-4' href=$url tabindex='-1'>Siguiente</a>";
              }
              else{
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