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
if(isset($_GET["obra"])){
	$obra=obtenerunaobra($bd,$_GET["obra"]);
	$comentarios=obtenercoments($bd, $_GET["obra"]);
	$usuarios=arrayusuariostodos($bd);
	$capitulos= capitulos($bd, $_GET["obra"]);
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
	<script src="js/comentarios.js"></script>
    </head>
<body>
    <?php 
    include("Includes/nav.php");




    ?>
    <body>

	
    <div class="container h-100 mt-5 mb-5 d-flex flex-column">
	<h1 class="text-center"><?php echo $obra->gettitulo(); ?></h1>
	<ul class="nav nav-tabs">
      <li class="nav-item">
	  <a class="nav-link active" href="#obra" data-toggle="tab">Obra</a>
	  </li>
	  <li class="nav-item">
	  <a class="nav-link" href="#sinopsis" data-toggle="tab">Sinopsis</a>
	  </li>
	  <li class="nav-item">
	  <a class="nav-link" href="#comentarios" data-toggle="tab">Comentarios</a>
	  </li>
    </ul>
	


    <div class="row flex-fill h-100" style="min-height:0">
	<div class="col-4 border mh-100" style="overflow-y: scroll;">
	 <img style="width: 18rem; height: 20rem;  display: block;
  margin-left: auto;
  margin-right: auto;
  " class="card-img-top" src=<?php echo "Imagenes/Obras/".$obra->getportada(); ?> alt="Card image cap">
	<?php 
	if(isset($_SESSION['usuario'])){
		?>
		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">Añadir a lista</button>
		<?php 
	}
	?>
	</div>

        <div class="col-8 border mh-100 tab-content" style="overflow-y: scroll;">

		<div class="tab-pane active in" id="obra">
		<h3 class="text-center">Listado de Capitulos</h3>
		<ul class="list-group">
		<?php for($i=0; $i<count($capitulos); $i++) {?>
                    
                        <li class="list-group-item">
                            
						<a <?php echo "href=capitulo.php?cap={$capitulos[$i]->getid()}"  ?>>
						<?php echo $capitulos[$i]->gettitulo(); ?>
						</a>
                             
                                  
                            
                           <div class="pull-right action-buttons">
						   <a style="float: right;" <?php echo "href=capitulo.php?cap={$capitulos[$i]->getid()}"  ?> class="">Leer</a>
						   <?php if(isset($_SESSION["usuario"]) && ($_SESSION["usuario"]==$obra->getid() || $_SESSION["tipo"]==1)) {?>
                                <a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-pencil"></span>Editar</a>
                                <a href="http://www.jquery2dotnet.com" class="trash"><span class="glyphicon glyphicon-trash"></span>Borrar</a>
                               <?php } ?>
                            </div>
                        </li>
                       <?php } ?>
                    </ul>
      </div>

	  <div class="tab-pane fade" id="sinopsis">
	  <p class="justify">
	<?php echo $obra->getsinopsis();
	 ?>
	</p>
      </div>



	





















		<div class="col-md-12 col-md-offset-3 comments-section tab-pane fade" id="comentarios">
			<!-- comment form -->
		
				
			

			<!-- Display total number of comments on this post  -->
			<p class="d-none" id="obranum"><?php echo $_GET["obra"]; ?></p>
			<p class="d-none" id="sesionnum"><?php echo $_SESSION["usuario"]; ?></p>
			<h2><span id="comments_count"><?php echo totalcoments($bd, $_GET["obra"]); ?></span> Comentarios
			<?php if(isset($_SESSION["usuario"])) {?>
			<button class="btn btn-primary btn-sm pull-right ml-4"  data-toggle="modal" data-target="#coment" id="submit_comment">Añadir comentario</button>
			<?php }
			 ?>
			 </h2>
			<div class="modal fade" id="coment" tabindex="-1" role="dialog" aria-labelledby="sesionLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="comentLabel">Añadir comentario</h5>
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
			
			<hr>
			<!-- comments wrapper -->
			
			<div id="comments-wrapper">
			<?php for($i=0; $i<count($comentarios); $i++) {
				$respuestas=obtenerespuestas($bd, $comentarios[$i]->getid());
				?>
				<div class="comment clearfix">
						<div class="comment-details">
							<span class="comment-name"><?php echo $usuarios[$comentarios[$i]->getid_usuario()]->getusuario(); ?></span>
							<span class="comment-date"><?php echo $comentarios[$i]->getid_usuario(); ?></span>
							<p><?php echo $comentarios[$i]->getmensaje(); ?></p>
							<a class="reply-btn resp2"  href="#" data-toggle="modal" data-target="#coment" <?php echo " data-value={$usuarios[$comentarios[$i]->getid_usuario()]->getusuario()} data-id={$comentarios[$i]->getid()}" ?>>Responder</a>
						</div>
				</div>
						
						
						<div>
							<!-- reply -->
							<?php for($e=0; $e<count($respuestas); $e++) {?>
							<div class="comment reply clearfix">
								
								<div class="comment-details">
									<span class="comment-name"><?php echo $usuarios[$respuestas[$e]->getid_usuario()]->getusuario(); ?></span>
									<span class="comment-date"></span>
									<p><?php echo $respuestas[$e]->getmensaje(); ?></p>
									<a class="reply-btn resp2" data-toggle="modal" data-target="#coment" href="#"  <?php echo " data-value={$usuarios[$comentarios[$i]->getid_usuario()]->getusuario()} data-id={$comentarios[$i]->getid()}" ?>>Responder</a>
								</div>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
			</div>
			<!-- // comments wrapper -->
			
		</div>

            
        </div>
		</div>
    
    <?php 
include("Includes/footer.php")
?>
</body>


</html>