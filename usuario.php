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
include("funcionesphp/funcionesbiblioteca.php");


if(isset($_GET["user"])){
	$readonly="disabled";
    $thisusuario=unusuarioporcodigo($bd, $_GET["user"]);
    if($thisusuario->getestado()==0 && !isset($_SESSION["usuario"])) header("Location: index.php");
	if(!isset($_SESSION["usuario"])){
		$obras= obrasautor($bd,"n",$_GET["user"]);
	}
	else{
		if($thisusuario->getestado()==0 && $_SESSION["tipo"]==0) header("Location: index.php");
		$readonly=$_SESSION['usuario']!=$_GET["user"] ? "disabled" :"";
		$readonly=$_SESSION['tipo']==0 ? "disabled" :"";
		$usuario=unusuarioporcodigo($bd, $_SESSION["usuario"]);
		$seguidor=verseguidor($bd, $thisusuario->getid(), $_SESSION["usuario"]);
		$textomegusta=$seguidor==0 ? "Seguir" : "Dejar de seguir";
		$buttoncolor=$seguidor==0 ? "btn-success": "btn-danger";
		$seguidor=$seguidor==0 ? "dar" : "quitar";
		if($_SESSION["tipo"]==1){
			$obras= obrasautor($bd,1,$_GET["user"]);
		}
		elseif($_SESSION["usuario"]==$_GET["user"]){
			$obras= obrasautor($bd,"autor",$_GET["user"]);
			
		}
		else{
			$obras= obrasautor($bd,"n",$_GET["user"]);
		}
	}
	
	$biblioteca= tubiblioteca($bd,  $thisusuario->getid());
	$obras_biblioteca=obrasguardadasbiblio($bd, $biblioteca);
	
}
else{
	header("Location: index.php");
}


    include("Includes/header.php");
    ?>
    <link rel="stylesheet" href="libro.css">
	<script src="js/usuario.js"></script>
	<script src="js/darquitar.js"></script>
	<script src="js/estado.js"></script>
    </head>
	<body>
    <?php 
    include("Includes/nav.php");




    ?>
   

	
    <div class="container mt-5 mb-5 d-flex flex-column">
	<input id="usuid" type="hidden" value="<?php echo $thisusuario->getid(); ?>">
	<div class="row flex-fill">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<img id="port" style="display:block;
margin:auto; "  <?php echo "src=Imagenes/Usuarios/{$thisusuario->getfoto()}"; ?>  class="img-thumbnail rounded-circle"  alt="" />
	<br>
	<?php if(isset($_SESSION["usuario"]) && ($_SESSION["usuario"]==$_GET["user"] || $_SESSION["tipo"]==1)) { ?>
	<form enctype="multipart/form-data" action="#" id="imgform" method="POST">
<div id="div_file">
<p id="textoboton">Cambiar Imagen</p>
<input name="subidaimg" id="subidaimg" type="file" accept=".png, .jpg, .jpeg" />

</div>
</form>
<br>
<?php } ?>
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
	<button class="btn mr-1 <?php echo $buttoncolor ?>" id=<?php echo $seguidor; ?>  ><i class="fas fa-users"> <?php echo $textomegusta; ?> </i></button>
	<a class="btn btn-primary "   data-toggle="modal" data-target=<?php echo "#0".$thisusuario->getid(); ?>  href="#">Escribir mensaje</a>
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
	  <a class="nav-link redi" id="navpers" href="#personal" data-toggle="tab">Datos Personales</a>
	  </li>
	  <li class="nav-item">
	  <a class="nav-link redi" id="navbi" href="#biblio"  data-toggle="tab">Biblioteca</a>
	  </li>
	  <?php if(isset($_SESSION['usuario']) && ($_SESSION['usuario']==$_GET["user"] || $_SESSION["tipo"]==1)){ ?>
		<ul id="submenu" class="navbar-nav  ml-auto">
            <li class="nav-item">
			<button id="guardar" class="btn btn-primary">Guardar</button>
			<?php
			
				if($_SESSION["tipo"]==1 && $thisusuario->getestado()==1){
					?>
					<button id="bloquearuser" class="btn btn-primary">Bloquear</button>
					<?php
				}
				elseif($_SESSION["tipo"]==1 && $thisusuario->getestado()==0){
					?>
					<button id="desbloquearuser" class="btn btn-primary">Desbloquear</button>
					<?php
				}

			?>
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
                             
                                  
                            
                          
                        </li>
                       <?php }
					
					} ?>
                    </ul>
      </div>

	  <div class="tab-pane fade usucontent border" id="personal">
	  <br>
	  <form id="formusuario">
	  <label for="Usuario">Usuario</label><br>
	  <input class="form-control" type="hidden" id="usuariohidden" name="usuariohidden" <?php echo $readonly ?> value="<?php echo $thisusuario->getusuario(); ?>"><br><br>
  <input class="form-control" type="text" id="usuario" name="usuario" <?php echo $readonly ?> value="<?php echo $thisusuario->getusuario(); ?>"><br><br>
  <label for="email">Email</label><br>
  <input class="form-control" type="hidden" id="emailhidden" name="emailhidden" <?php echo $readonly ?> value="<?php echo $thisusuario->getemail(); ?>"><br><br> 
  <input class="form-control" type="text" id="email" name="email" <?php echo $readonly ?> value="<?php echo $thisusuario->getemail(); ?>"><br><br> 
  <label for="nomyape">Nombre y apellido</label><br>
  <input class="form-control" type="text" id="nomyape" name="nomyape" <?php echo $readonly ?> value="<?php echo $thisusuario->getnomyape(); ?>"><br><br>
  <label for="contra">Contraseña</label><br>
<?php if(isset($_SESSION["usuario"]) && ($_SESSION["usuario"]==$thisusuario->getid()) || $_SESSION["tipo"]==1){ ?>
  <input class="form-control" type="password" id="contra" name="contra" value="<?php echo $thisusuario->getcontra(); ?>"><br><br>
 <?php } ?> 
  <input type="hidden" class="btn btn-primary" name="cambiousu" id="cambiousu" value="Enviar">  
</form>
</div>



	





















		<div class=" tab-pane fade usucontent border" id="biblio">
		<ul class="list-group mt-3">
		<h3 class="text-center">Biblioteca Personal</h3>
		<?php 
	
		for($i=0; $i<count($obras_biblioteca); $i++) {
			?>
                    
                        <li class="list-group-item">
						<input type="hidden" id="biblioteca" value="<?php echo $biblioteca ?>">
						<a <?php echo "href=obra.php?obra={$obras_biblioteca[$i]->getid()}"  ?>>
						<?php echo $obras_biblioteca[$i]->gettitulo(); ?>
						</a>
						
                        </li>
                       <?php }
					
					 ?>
                    </ul>
		
				
        </div>
        </div>
       
			</div>
			
</div>
    <?php 
include("Includes/footer.php")
?>
</body>


</html>