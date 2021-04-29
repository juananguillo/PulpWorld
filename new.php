<?php 
session_start();

include("./funcionesphp/conexionbd.php");
$bd = conectardb();
include("clases/usuarios.class.php");
include("./funcionesphp/funcionesusuarios.php");
include("clases/categorias.class.php");
include("funcionesphp/funcionescategorias.php");
include("funcionesphp/funcionesobras.php");
include("clases/obras.class.php");
if(!isset($_SESSION["usuario"])){
    header("Location: index.php");
}
$usuario= unusuarioporcodigo($bd, $_SESSION['usuario']);
$categorias=categorias($bd);
include("Includes/header.php");
    ?>
    <link rel="stylesheet" href="css/libro.css">
    <script src="js/nuevaobra.js"></script>
	
    </head>
<body>
<?php 
    include("Includes/nav.php");




    ?>
  
    <div class="container h-100 mt-5 mb-5 d-flex flex-column">
        
	<h1 class="text-center">Crear nueva obra</h1>
	<ul class="nav nav-tabs ml-auto">
      <li class="nav-item">
        
	  <a class="btn btn-primary" href="#obra" id="guardar" data-toggle="tab">Guardar</a>
	  </li>
    </ul>
    
    <div class="row flex-fill h-100" style="min-height:0">
    
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 border mh-100" style="overflow-y: scroll; ">
    <img id="port" style="width: 80%; height: 20rem; display:block;
margin:auto; " src="Imagenes/Obras/default.jpg" class="img-thumbnail"  alt="" />
<br>
<form enctype="multipart/form-data" action="#" id="imgform" method="POST">
<div id="div_file">
<p id="textoboton">Subir Imagen</p>
<input name="subidaimg" id="subidaimg" type="file" accept=".png, .jpg, .jpeg" />

</div>
</form>
    </div>
<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 border mh-100 tab-content" style="overflow-y: scroll; word-wrap: break-word;">
<form  action="#" id="dataform" method="POST">
<br>
<p id="err"></p>
<input type="hidden" id="autor" value=<?php echo $_SESSION['usuario']; ?>>
<label for="titulo">Titulo:</label><br>

  <input class="form-control" type="text" id="titobra" name="titulo"><br>



  
  <label for="filter">Selecciona el genero (Minimo 1 Maximo 4)</label>
                                        <select class="selectpicker" id="categorias">
                                        <option value="0" selected>Selecciona el genero</option>
                                       <?php 
                                       for ($i=0; $i <count($categorias) ; $i++) { 
                                          
                                           echo "<option value='{$categorias[$i]->getid()}'>{$categorias[$i]->getnombre()}</option>";
                                           
                                        }
                                       
                                       ?>
                                    </select><br>
                                    <p id="err2"></p>
 <div id="selecat">

 </div><br>
  <label for="sinopsis">Sinopsis: (Maximo 250 palabras)</label><br>
  <textarea style="resize: none;" class="form-control" id="sinopsisobra"  rows="22" maxlength="1684"></textarea>
</form>
 
	</div>

    </div>

    </div>
  
    </div>
    <?php 
include("Includes/footer.php")
?>
</body>


</html>


   

