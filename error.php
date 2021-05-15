<?php 
session_start();

include("./funcionesphp/conexionbd.php");
$bd = conectardb();
include("clases/usuarios.class.php");
include("./funcionesphp/block.php");
include("./funcionesphp/funcionesusuarios.php");
include("./funcionesphp/funcionesobras.php");
include("clases/obras.class.php");
include('clases/capitulos.class.php');
include('./funcionesphp/funcionescapitulos.php');
include("Includes/header.php");
if(isset($_SESSION["usuario"])){
    $usuario= unusuarioporcodigo($bd, $_SESSION['usuario']);
    isblock($usuario->getestado());
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
    <div id="err" class="container mb-5 mt-5">
    <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-3 d-block mb-5"><?php echo $_GET["error"]; ?></span>
                <div class="mb-4 lead">Lo sentimos ha ocurrido un error, intentalo más tarde. Tambien puede contactar con nosotros mediante el formulario de la web o enviando un mensaje al siguiente email si el error persiste
                <a href="mailto:pulplworldinfo@gmail.com">pulplworldinfo@gmail.com</a> 
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