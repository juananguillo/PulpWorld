<?php 
    include("Includes/header.php");
    ?>
    <script type="text/javascript" src="editor.js"></script>
    </head>
<body>
    <?php 
    include("Includes/nav.php");
    ?>
    <body>
    <div class="text-center container">
   
    <input type="text" class="display-4 text-center mb-5 mt-5" placeholder="Titulo del Capitulo">
    <div class="text-left">
    <div class="text-right">Ultimo guardado automatico</div>
    <input  class="btn btn-secondary " type="submit" id="guardar" value="Guardado manual">
    <input  class="btn btn-secondary " type="submit" id="publicar" value="Publicar capitulo">
    </div>
      <textarea  id="textarea" rows="20" name="textarea">
      <?php echo "Hola"; ?>
      </textarea>
  
   
    </div>
    <?php 
include("Includes/footer.php")
?>
</body>

</html>