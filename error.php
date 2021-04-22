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

if(!isset($_GET["error"])){
    header("Location: index.php");
}
    ?>
   <link rel="stylesheet" href="css/notificaciones.css">
    </head>
<body>
    <?php 
    include("Includes/nav.php");
    ?>
    <body>
    <div id="err" class="container mb-5">
    <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-2 d-block mb-5"><?php echo $_GET["error"]; ?></span>
                <div class="mb-4 lead">Lo sentimos ha ocurrido un error, intentalo más tarde o contacte con el siguiente email si el error persiste
                pulplworldinfo@gmail.com
                </div>
                <a href="index.php" class="btn btn-link">Volver a Inicio</a>
            </div>
    </div>
    </div>
    <?php 
include("Includes/footer.php")
?>
</body>

</html>