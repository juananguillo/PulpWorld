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
if(isset($_SESSION["usuario"])){
    $usuario= unusuarioporcodigo($bd, $_SESSION['usuario']);
}
else{
  header("Location: index.php");
}


    ?>
   <link rel="stylesheet" href="css/mensajes.css">
    </head>
<body>
    <?php 
    include("Includes/nav.php");
    ?>
    <body>
    <h1 class="text-center mt-3">
			Mensajes

		</h1>
    <div id="cont" class="container mb-5 mt-5">
    <div class="row  border">
         <div class="col-md-3 col-xs-12 col-sm-12 col-md-4 col-lg-4  border classcol">

         </div>
         <div class="col-md-3 col-xs-12 col-sm-12 col-md-8 col-lg-8 contenido">
           <div class="col-md-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 cajam">
         
           </div>
           <div class="col-md-12 col-xs-12 col-sm-12 col-md-12 col-lg-12  msn  ">
  <textarea class="form-control" rows="2" cols="60"></textarea>
  <div class="text-right mt-1"><button class="btn btn-primary">Enviar</button></div>
</div>
           </div>

         </div>
    </div>
    </div>
    <?php 
include("Includes/footer.php")
?>
</body>

</html>