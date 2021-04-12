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
if(isset($_GET["user"])){
	$readonly="disabled";
    $thisusuario=unusuarioporcodigo($bd, $_GET["user"]);
    if($thisusuario->getestado()==0) header("Location: index.php");
	if(!isset($_SESSION["usuario"])){
		$obras= obrasautor($bd,"n",$_GET["user"]);
	}
	else{
		$usuario=unusuarioporcodigo($bd, $_SESSION["usuario"]);
		$seguidor=verseguidor($bd, $thisusuario->getid(), $_SESSION["usuario"]);
		$textomegusta=$seguidor==0 ? "Seguir" : "Dejar de seguir";
		$seguidor=$seguidor==0 ? "dar" : "quitar";
		if($_SESSION["usuario"]==$_GET["user"] || $_SESSION["tipo"]==1){
			$readonly="readonly";
			$obras= obrasautor($bd,"autor",$_GET["user"]);
			
		}
		else{
			$obras= obrasautor($bd,"n",$_GET["user"]);
		}
	}
	

	
}
else{
	header("Location: index.php");
}


    include("Includes/header.php");
    ?>
    <link rel="stylesheet" href="libro.css">
	<script src="js/obra.js"></script>
	<script src="js/darquitar.js"></script>
    </head>
	<body>
    <?php 
    include("Includes/nav.php");




    ?>
   

	
    <div class="container mt-5 mb-5 d-flex flex-column">
	
	<div class="row flex-fill">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<img style="display:block;
margin:auto; "  <?php echo "src=Imagenes/Usuarios/{$thisusuario->getfoto()}"; ?>  class="img-thumbnail rounded-circle"  alt="" />
	<br>
	<h1 class="text-center">
	<?php echo $thisusuario->getusuario(); ?>
	
	</h1>
	<div class="text-center">
	<strong>Seguidores</strong> <i class="fas fa-users text-danger"> <?php echo $thisusuario->getseguidores(); ?></i>
	<strong>Obras publicas</strong> <i class="fas fa-book-open text-primary"> <?php echo $thisusuario->getobras(); ?></i><br>
</div>
	<div class="text-center">
	<?php if(isset($_SESSION["usuario"]) && $_SESSION["usuario"]!=$thisusuario->getid()){ ?>
	<input class="valores" type="hidden" id=<?php echo $_SESSION['usuario']; ?> value=<?php echo $thisusuario->getid(); ?>>
	<button class="btn btn-danger mr-1" id=<?php echo $seguidor; ?>  ><i class="fas fa-users"> <?php echo $textomegusta; ?> </i></button>
	<a class="btn btn-primary "   data-toggle="modal" data-target=<?php echo "#0".$thisusuario->getid(); ?>  href="#">Esribir mensaje</a>
	<?php } ?>
	</div><div class="modal fade" id=<?php echo "0" . $thisusuario->getid(); ?> tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="comentLabel">Enviar mensaje a:  <?php echo $thisusuario->getusuario();  ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                            <div class="form-group">

							<div class="form-group shadow-textarea">
  <span id="commentarionew"></span>
  <textarea id="mn" class="form-control z-depth-1" rows="4" ></textarea>
</div>

                                
                            </div>

                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="enviarcoment" class="btn btn-primary" id="botonsesion" disabled>Enviar</button>
                    </div>
                </div>
            </div>
        </div>
</div>

	
	 
    
	

	
   

        <div class="col-xs-10 col-sm-10 col-md-9 col-lg-9 mt-3 tab-content" id="obracont">
		
		
		<ul class="nav nav-tabs">
      <li class="nav-item">
	  <a class="nav-link active redi" id="navcapi" href="#obra" data-toggle="tab">Obras</a>
	  </li>
	  <li class="nav-item">
	  <a class="nav-link redi" id="navdet" href="#sinopsis" data-toggle="tab">Detalles</a>
	  </li>
	  <li class="nav-item">
	  <a class="nav-link redi" id="navcom" href="#comentarios"  data-toggle="tab">Comentarios</a>
	  </li>
	  <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']==$_GET["user"]){ ?>
		<ul class="navbar-nav  ml-auto">
            <li class="nav-item">
			<a class="btn btn-primary"  <?php echo "href=user.php?user={$_GET["user"]}";?>>Guardar</a>
            </li>
			</ul>
       
	  <?php } ?>
	  </ul>
		<div class="tab-pane active in usucontent border" id="obra"><br>
		<h3 class="text-center">Listado de Obras</h3>
		<?php if(isset($_SESSION["usuario"]) && ($_SESSION["usuario"]==$_GET["user"])){
			?>
		<a  href="new.php">Escribir una obra</a>
		<?php } ?>
		
		<ul class="list-group mt-3">
		<input type="hidden" value=<?php echo 10; ?>>
		<?php 
		if($obras!=""){
		for($i=0; $i<count($obras); $i++) {
			if(count($obras)<=$i) break;
			?>
                    
                        <li class="list-group-item">
                            
						<a <?php echo "href=obra.php?obra={$obras[$i]->getid()}"  ?>>
						<?php echo $obras[$i]->gettitulo(); ?>
						</a>
                             
                                  
                            
                           <div class="pull-right action-buttons">
						   <a style="float: right;" <?php echo "href=obra.php?obras={$obras[$i]->getid()}"  ?> class="">Ver</a>
						   <?php if(isset($_SESSION["usuario"]) && ($_SESSION["usuario"]==$_GET["user"] || $_SESSION["tipo"]==1)) {?>
                                <a href="edicion.php?cap=<?php echo $obras[$i]->getid();?>&obra=<?php echo $obras[$i]->getid();?>"><span class="glyphicon glyphicon-pencil"></span>Editar</a>
                                <a href="http://www.jquery2dotnet.com" class="trash"><span class="glyphicon glyphicon-trash"></span>Borrar</a>
                               <?php } ?>
                            </div>
                        </li>
                       <?php }
					
					} ?>
                    </ul>
      </div>

	  <div class="tab-pane fade usucontent border" id="sinopsis">
	  <br>
	  <label for="titulo">Titulo:</label><br>
 
      </div>



	





















		<div class=" tab-pane fade usucontent border">
			<!-- comment form -->
		
				
        </div>
        </div>
       
			</div>
			
</div>
    <?php 
include("Includes/footer.php")
?>
</body>


</html>