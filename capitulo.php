<?php 
ob_start();
session_start();
include("./funcionesphp/conexionbd.php");
$bd = conectardb();
include("clases/usuarios.class.php");
include("./funcionesphp/funcionesusuarios.php");
include("clases/marcapaginas.class.php");
include("./funcionesphp/block.php");
include("funcionesphp/funcionesmarcapaginas.php");
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
	$usuarios=arrayusuariosporid($bd);
    if($capitulo->getestado()==0 && $_SESSION["tipo"]==0){}
    if(!isset($_SESSION["usuario"])){
        if($capitulo->getestado()==0 || $capitulo->getpublico()==0 || $obra->getestado()==0){
            header("Location: index.php");
            die();
        }
		$capitulos= capitulos($bd, $capitulo->getid_obra());
	}
	if(isset($_SESSION["usuario"])){
        if(($capitulo->getestado()==0 || $obra->getestado()==0) && $_SESSION["tipo"]==0){
            header("Location: index.php");
            die();
        }
        $usuario= unusuarioporcodigo($bd, $_SESSION['usuario']);
        isblock($usuario->getestado());
		if($_SESSION["usuario"]==$obra->getautor() || $_SESSION["tipo"]==1){
			$capitulos= allcapitulos($bd, $capitulo->getid_obra());
		}
		else{
			$capitulos= capitulos($bd, $capitulo->getid_obra());
		}
	}
	if(isset($_SESSION["usuario"])){
    $marcapaginas=vermarcapaginas($bd,$_SESSION["usuario"], $obra->getid());
    if($obra->getautor()!=$_SESSION["usuario"] &&  $_SESSION["tipo"]==0 && ($capitulo->getpublico()==0 || $obra->getpublico()==0)){
        header("Location: index.php");
        die();
    }
        if($marcapaginas){
            if($marcapaginas->getid_capitulo()==$capitulos[count($capitulos)-1]->getid()){
                borrarmarcapaginas($bd,$_SESSION["usuario"], $obra->getid());
                if(verlectura($bd, $_SERVER['REMOTE_ADDR'], $obra->getid())==0){
                    crearlectura($bd, $_SERVER['REMOTE_ADDR'], $obra->getid());
                     }
            }
            else{
            actualizarmarcapaginas($bd,$_SESSION["usuario"], $obra->getid(), $capitulo->getid());
            }
        }else{
            crearmarcapaginas($bd,$_SESSION["usuario"], $obra->getid(), $capitulo->getid());
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
    die();
}
$categorias=categorias($bd);




if($capitulos[count($capitulos)-1]->getid()==$capitulo->getid()){
    if(verlectura($bd, $_SERVER['REMOTE_ADDR'], $obra->getid())==0){
   crearlectura($bd, $_SERVER['REMOTE_ADDR'], $obra->getid());
    }
}
include("Includes/header.php");
    ?>
    <link rel="stylesheet" href="css/libro.css">
    <script src="js/estado.js"></script>
    <script src="js/zoom.js"></script>
    </head>
<body>
    <?php 
    include("Includes/nav.php");
    $desplazamiento = $_GET['desplazamiento'] ?? 0;
    $pagina=$_GET['pag'] ?? 1;
    ?>
    <body>
   
    <h2 class="text-center mb-5 mt-3">
    <?php echo $obra->gettitulo(); ?>
    </h2>
    <p id="alert"></p>
    <h3 class="text-center mb-5">
    <?php echo $capitulo->gettitulo(); ?>
    </h3>
    <div class="text-center">
    <button id="zoomin" class="btn btn-primary"><i class="fas fa-search-plus"></i></button>
    <button id="zoomout"  class="btn btn-primary"><i class="fas fa-search-minus"></i></button>
    </div>
    <div class="container h-100 mt-3 mb-5 d-flex flex-column">
    <ul class="nav nav-tabs">
      <li class="nav-item">
	  <a class="nav-link active" href="#contenido" data-toggle="tab">Contenido</a>
	  </li>
	  
      <li class="nav-item">
	  <a class="nav-link ml-1"  <?php echo "href=obra.php?obra={$obra->getid()}";?>>Volver a obra</a>
	  </li>
      <input type="hidden" id="obracapi" value="<?php echo $capitulo->getid_obra(); ?>">
      <?php if(isset($_SESSION['usuario']) && ($_SESSION['usuario']==$obra->getautor() | $_SESSION["tipo"]==1)){ ?>
         <input class="valores" type="hidden" id=<?php echo $_SESSION['usuario']; ?> value=<?php echo $capitulo->getid(); ?>>
		
        <ul id="submenu" class="navbar-nav  ml-auto">
            <li class="nav-item">

			<?php
			
				if($_SESSION["tipo"]==1 && $capitulo->getestado()==1){
					?>
					<button id="bloquearcapi" class="btn btn-primary">Bloquear</button>
					<?php
				}
				elseif($_SESSION["tipo"]==1 && $capitulo->getestado()==0){
					?>
					<button id="desbloquearcapi" class="btn btn-primary">Desbloquear</button>
					<?php
				}
				if($capitulo->getpublico()==0){
					?>
					<button id="publicarcapi" class="btn btn-primary">Publicar</button>
					<?php
				}
				else{
					?>
					<button id="despublicarcapi" class="btn btn-primary">Despublicar</button>
					<?php
				}
                
			?>
            <?php if($obra->getautor()==$_SESSION["usuario"]){ ?>
            <button id="eliminar" class="btn btn-dark">Eliminar</button>
            <?php } ?>
            </li>
			</ul>
       
	  <?php } ?>
	  </ul>
    
    <div class="row flex-fill h-100" style="min-height:0">
        <div class="col-12 tab-content">
        <div class="tab-pane active in" id="contenido">
       <div  class="form-control" id="capcontent"><?php echo $capitulo->getcontenido(); ?>
</div> 
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