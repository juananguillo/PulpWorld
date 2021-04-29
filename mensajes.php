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
    $usuarios= arrayusuariosporid($bd);
  $id_chats= emisoresyreceptores($bd, $_SESSION['usuario']);
}
else{
  header("Location: index.php");
}


    ?>
   <link rel="stylesheet" href="css/mensajes.css">
   <script src="js/mensajes.js"></script>
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
           <div class="input-group mb-3">
         <input type="text" class="form-control " id="textobusqueda" name="textobusqueda" placeholder="Busqueda avanzada">
         <button disabled id="busqueda" name="busqueda" class="btn btn-primary busqueda"><i class="fas fa-search"></i></button>
</div>
<input type="hidden" id="usuid" value="<?php echo $_SESSION["usuario"]; ?>">
<div id="chats">
       <?php 
       
        foreach ($id_chats as $key => $value) {
          $chat_user=$usuarios[$value];
          if($chat_user->getestado()==0){
            continue;
          }
          $t= sinleermen($bd, $_SESSION["usuario"], $chat_user->getid());
          ?>
            <div  id="<?php echo  $chat_user->getid(); ?> " style="cursor: pointer; overflow:hidden;" class="border mt-2 mb-3 chatid">
            <img align="left" class="foto rounded-circle mt-1 mr-2" src="<?php echo "Imagenes/Usuarios/".$chat_user->getfoto(); ?>">
              <a href=<?php echo 'usuario.php?user='.$value ?>><?php echo  $chat_user->getusuario(); ?> </a>
               <span class="noti"><?php if($t>0){?> <span class="badge badge-primary"><?php echo $t ?></span> <?php } ?></span>
                <p><?php echo  $chat_user->getemail(); ?></p>
             
            </div>

          <?php  
         
        }
        
        ?>
</div>





         </div>
         <div class="col-md-3 col-xs-12 col-sm-12 col-md-8 col-lg-8 contenido">
           <div id="mencaja" class="col-md-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 cajam">
          <?php 
          if(isset($_GET["chat"])){
            $totalm= countmensajes($bd, $_SESSION["usuario"],  $_GET["chat"]);
            $array= mensajes($bd, $_SESSION["usuario"], $_GET["chat"]);
            echo "<input id='receptor' type='hidden' value='{$_GET["chat"]}'>
            <input id='totalm' type='hidden' value='{$totalm}'>";
            foreach ($array as $key => $value) {
               if($value->getid_emisor()==$_SESSION["usuario"]){
                echo "<div class='mt-1  border rounded border-primary mdiv1'><p class='text text-justify'><strong>".$value->getcontenido()."</strong></p></div><br>";
              }
              else{
                echo "<div class='mt-1  border rounded border-success mdiv2'><p class='text text-justify'><strong>".$value->getcontenido()."</strong></p></div><br>";
              }
            }
          }
          
          ?>
           </div>
           <div class="col-md-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 msn">
  <textarea maxlength="800" disabled id="mn" class="form-control" rows="2" cols="60"></textarea>
  <div class="text-right mt-1"><button disabled id="enviar" class="btn btn-primary">Enviar</button></div>
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