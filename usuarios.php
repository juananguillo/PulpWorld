<?php 
ob_start();
session_start();
include("./funcionesphp/conexionbd.php");
$bd = conectardb();
include("./funcionesphp/funcionesusuarios.php");
include("./funcionesphp/block.php");
include("clases/obras.class.php");
include("funcionesphp/funcionesobras.php");
include("clases/usuarios.class.php");
include("clases/categorias.class.php");
include("funcionesphp/funcionescategorias.php");
$categorias=["Autores","Usuarios"];
$usuarios=arrayusuarios($bd); 
$ses=isset($_SESSION['tipo'])?$_SESSION['tipo']: 0;
if(isset($_SESSION['usuario'])){

   $usuario= unusuarioporcodigo($bd, $_SESSION['usuario']);
    isblock($usuario->getestado());
   if($_SESSION['tipo']==1){
   $usuarios=allarrayusuarios($bd);
   }else{
    $usuarios=arrayusuarios($bd); 
   }

}


    include("Includes/header.php");
    ?>
    <link rel="stylesheet" href="css/index.css">
    <script src="js/enviarm.js"></script>
    </head>
<body>
    <?php 
    include("Includes/nav.php");
    $desplazamiento = $_GET['desplazamiento'] ?? 0;
    $orden = $_GET['orden'] ?? "seguidores";
    $ordnum=0;
    $num_filas=20;
    $pagina=$_GET['pag'] ?? 1;
    $buscarpor= $_GET['buscarpor'] ?? "";
    if(isset($_GET["buscarpor"])){
        $buscarpor=urlencode($buscarpor);
    }
    $inputbuscapor=urldecode($buscarpor);
    $cat=$_GET['categoria'] ?? -1;
    if(isset($_GET["orden"])){
       
    switch ($orden) {
        case 0:
            $orden="seguidores";
            $ordnum=0;
            break;
        
        case 1:
            $orden="obras";
            $ordnum=1;
            break;


            case 2:
                $orden="id";
                $ordnum=2;
                break;

        default:
        $orden="seguidores";
        break;
    }

    if(isset($_GET["buscarpor"])){
        if($cat=="Autores"){
            $usuarios=filtrarusuariosporpalabras($bd, $desplazamiento, $orden, $_GET["buscarpor"],$ses);
            $total=totalusuariosporpalabras($bd, $desplazamiento, $orden, $_GET["buscarpor"],$ses);
        }
        elseif ($cat==-1) {
            $usuarios=filtrarusuariosporpalabrastodos($bd, $desplazamiento, $orden, $_GET["buscarpor"],$ses);
            $total=totalusuariosporpalabrastodos($bd, $desplazamiento, $orden, $_GET["buscarpor"],$ses);
        }
        else{
            $usuarios=filtrarusuariosporpalabrasuser($bd, $desplazamiento, $orden, $_GET["buscarpor"],$ses);
            $total=totalusuariosporpalabrasuser($bd, $desplazamiento, $orden, $_GET["buscarpor"],$ses);
            
        }
    }
    else{
    if($cat=="Autores"){
        $usuarios=filtrarusuarios1($bd, $desplazamiento, $orden, $ses);
        $total=totalusuarios1($bd, $desplazamiento, $orden, $ses);
     
    }
    elseif ($cat==-1) {
        $usuarios=filtrarusuarios3($bd, $desplazamiento, $orden, $ses);
        $total=totalusuarios3($bd, $desplazamiento, $orden, $ses);
    }
    else{
        $usuarios=filtrarusuarios2($bd, $desplazamiento, $orden, $ses);
        $total=totalusuarios2($bd, $desplazamiento, $orden, $ses);
       
    }
}

    }else{
   $total=totalusuarios($bd, $ses);
    }
    ?>
   <div class="jumbotron jumbotron-fluid bg-dark">

<div class="jumbotron-background">
    <img src="Imagenes/pulp.jpg" class="blur ">
</div>

<div class="container text-white">

    <h1 class="display-5">¡Bienvenido a Pulp World!</h1>
    <p class="lead">Pulp World es una plataforma online de lectura y escritura que nace con el proposito de que la gente pueda leer, escribir y públicar relatos de una forma sencilla</p>
    <hr class="my-4">
    <?php if (!isset($_SESSION['usuario'])) {
    ?>
    <p>Si no estas registrado podras leer todas las obras que quieras,
    pero para poder comentar, escribir obras, seguir usuarios y dar me gustas tendrás que registrarte
    </p>
        <a class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#registro" href="#" role="button">¿No estas registrado? Hazlo!</a>
    <?php } else {
    ?>
     <p>No seas timido, lee lo que quieras, da me gusta, comenta, sigue a los usuarios que quieras que te avise si publican una nueva obra y en general disfruta de esta plataforma
    </p>
        <a class="btn btn-primary btn-lg" href="new.php" role="button">Crear nueva obra</a>
    <?php } ?>

</div>
<!-- /.container -->


</div>
  <!-- /.container -->
  
 
</div>
    <div id="content">
    <h1 class="display-3 text-center mb-5">Usuarios Pulp</h1>
    </div>
 
    <div class="container-fluid mb-3">
	<div class="row">
		<div class="col-md-12">
        <form  action="./funcionesphp/filtrar.php" method="POST" class="form-horizontal" role="form">
            <div class="input-group" id="adv-search">
            
                <input type="text" class="form-control" id="textobusqueda" name="textobusqueda" placeholder="Busqueda avanzada" <?php if(isset($_GET["buscarpor"])) echo "value={$_GET['buscarpor']}"; ?>>
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span>Opciones</button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                              

                                <div class="form-group">
                                    <label for="filter">Categorias</label>
                                    <select class="form-control" id="categorias" name="categoria">
                                        <option value="-1" selected>Todas las categorias</option>
                                       <?php 
                                       for ($i=0; $i <count($categorias) ; $i++) { 
                                           if(isset($_GET["categoria"]) && $categorias[$i]==$_GET["categoria"]){
                                            echo "<option selected value='{$categorias[$i]}'>{$categorias[$i]}</option>";
                                           }else{
                                           echo "<option value='{$categorias[$i]}'>{$categorias[$i]}</option>";
                                           }
                                        }
                                       
                                       ?>
                                    </select>
                                  </div>


                                  <div class="form-group">
                                    <label for="filter">Ordenar por</label>
                                    <select class="form-control" id="orden" name="orden">
                                    <?php 
                                    $arrayord=["Mas seguidores","Mas obras", "Recientes"];
                                    for ($i=0; $i <count($arrayord) ; $i++) { 
                                        if(isset($_GET["orden"]) && $i==$ordnum){
                                            echo "<option selected value=$i>{$arrayord[$i]}</option>";
                                           }else{
                                            echo "<option value=$i>{$arrayord[$i]}</option>";
                                           }

                                    }
                                    ?>
                                        
                                    </select>
                                  </div>
                                  
                                  <input type="submit" id="busqueda" name="busquedausu" class="btn btn-primary busqueda" value="Buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></input>
                               
                            </div>
                        </div>
                        <input type="submit" id="busqueda1" name="busquedausu1" class="btn btn-primary busqueda" value="Buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></input>
                        
                    </div>
                </div>
            </div>
            </form>
          </div>
        </div>
	
</div>
<?php $linea=20; 
    
?>

    <div id="coleccion" class="card-group">
    <div class="container-fluid mb-3">
    <div class="row"> 
        <?php for ($i = 0; $i < 12; $i++) {
            
        ?>
        <?php if($i< $total- $desplazamiento){ ?>
        <a class="noDecoration" <?php echo "href=usuario.php?user={$usuarios[$i]->getid()}";  ?> >
        
            <div class="card col-md-3 col-xs-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <img style="width: 50%; height: 10rem; display:block;
margin:auto; " class="card-img-top rounded-circle" src=<?php echo "Imagenes/Usuarios/".$usuarios[$i]->getfoto(); ?> alt="Card image cap">
                <div  class="card-body">
                    <h5 class="card-title text-center">
                    <?php 
                    echo $usuarios[$i]->getusuario();
                    ?>
                    </h5>
                    <div class="text-center">
	<strong>Seguidores</strong> <i class="fas fa-users text-danger"> <?php echo $usuarios[$i]->getseguidores(); ?></i>
	<strong>Obras</strong> <i class="fas fa-book-open text-primary"> <?php echo $usuarios[$i]->getobras(); ?></i><br>
</div>
 <?php
if(isset($_SESSION["tipo"])){
					if($_SESSION["tipo"]==1){
		?>	<div id="usustate" class="text-center mt-2 mb-2 text-danger"> <?php  
		if($usuarios[$i]->getestado()==0){
		?>
	
		<strong>Usuario Bloqueado</strong>
        <?php } ?>
</div>
<?php } }  ?>
                </div>
              
                <div class="card-footer text-center">
                    <a style="color:white"  <?php echo "href=usuario.php?user={$usuarios[$i]->getid()}";  ?>  class="btn btn-primary">Ver Perfil</a>
                </div>

            </div>
            </a>
        <?php }
        else{
            ?>
            <div class="card ml-4" style="border: none;">
            </div>
      <?php    }
    } ?>


    </div>
    </div>
    </div>
   

    <nav aria-label="...">
        <ul class="pagination justify-content-center mt-5">
        <?php 
        if ($desplazamiento > 0) {
            $pagant=$pagina-1;
            $prev = $desplazamiento - 12;
            $url = $_SERVER["PHP_SELF"] . "?categoria=$cat&orden=$ordnum&desplazamiento=$prev&buscarpor=$buscarpor&pag=$pagant#content";
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
             $o=  $pagina>4 ? $pagina :0;
             $o=$o>0?$o-1:$o;

             if($o>0){
                 while ($o % 4) {
                     $o--;
                 }
                 
             }
             for ($i = 0; $i < 48; $i += 12) {
                 if($i>=$total){
                     break;
                 }
                 $o++;
                $url = $_SERVER["PHP_SELF"] . "?categoria=$cat&orden=$ordnum&desplazamiento=$i&pag=$o&buscarpor=$buscarpor#content";
                if($pagina==$o){
                 echo "<li class='page-item active'>
                <a class='page-link' href=$url>$o <span class='sr-only'>(current)</span></a>
            </li>";
                }else{
                    echo  "<li class='page-item'><a class='page-link' href=$url>$o</a></li>";
                }
              }

              if ($total > ($desplazamiento + 12)) {
                $pagsec=$pagina+1;
                $prox = $desplazamiento + 12;
                $url = $_SERVER["PHP_SELF"] . "?categoria=$cat&orden=$ordnum&desplazamiento=$prox&buscarpor=$buscarpor&pag=$pagsec#content";
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
    
    <?php  if(isset($_GET['alerta'])) { ?> <script>alert("<?php echo $_GET['alerta']; ?>")</script> <?php } ?> 
    <script>
    $('.dropdown-menu').on('click', function(event) {
  event.stopPropagation();
});
if($("#categorias option:selected").val()=="Usuarios"){
   $("#orden option:eq(1)").attr('disabled','disabled');
}
$("#categorias").on("change", function () {  

if($("#categorias option:selected").val()=="Usuarios"){
    $("#orden option:eq(1)").attr('disabled','disabled');
}
else{
    $("#orden option:eq(1)").removeAttr('disabled');
}
});
        
       
    </script>
   
<?php 
include("Includes/footer.php")
?>
</body>

</html>