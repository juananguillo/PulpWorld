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
if(!isset($_SESSION["usuario"])){
    header("Location: index.php");
}
$usuario= unusuarioporcodigo($bd, $_SESSION['usuario']);
$cap=obteneruncapitulo($bd, $_GET["cap"]);
$obra=obtenerunaobra($bd,$_GET["obra"]);


    include("Includes/header.php");

    ?>
    <script type="text/javascript" src="js/editor.js"></script>
    <script src="js/estado.js"></script>
    </head>
<body>
    <?php 
    include("Includes/nav.php");
    ?>
    <body>
    <div class="text-center container mb-5">
   <input type="hidden" id="idcap" class="input-lg" value="<?php echo $cap->getid(); ?>">
   <div class="form-group">
    <input type="text" size="80" maxlength="200" id="titulocap" class="text-center mb-5 mt-5 form-control" value="<?php echo $cap->gettitulo();?>">
    </div>
  <p id="alert"></p>
  <input class="valores" type="hidden" id=<?php echo $_SESSION['usuario']; ?> value=<?php echo $cap->getid(); ?>>
    <ul class="nav nav-tabs">
      <li class="nav-item">
      <input  class="btn btn-primary " type="submit" id="guardar" value="Guardado manual">
	  </li>
	  <li class="nav-item ml-1">
          <?php 
          if($cap->getpublico()==0){
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
	  </li>
    <li class="nav-item">
	  <a class="nav-link"  <?php echo "href=obra.php?obra={$obra->getid()}";?>>Volver a obra</a>
	  </li>
    <ul class="navbar-nav  ml-auto">
    <li class="nav-item">
    <div>Ultimo guardado automatico<p id="gauto"></p></div>
            </li>
    </ul>
   </ul>
   
      <textarea  id="textarea" rows="30" name="textarea">
      <?php echo $cap->getcontenido(); ?>
      </textarea>
  
   
    </div>
    <?php 
include("Includes/footer.php")
?>
</body>

</html>