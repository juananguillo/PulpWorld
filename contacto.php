<?php
ob_start();
session_start();
include("./funcionesphp/conexionbd.php");
$bd = conectardb();
include("clases/usuarios.class.php");
include("./funcionesphp/block.php");
include("funcionesphp/funcionesmarcapaginas.php");
include("./funcionesphp/funcionesusuarios.php");
include("clases/obras.class.php");
include("clases/marcapaginas.class.php");
include("clases/capitulos.class.php");
include("funcionesphp/funcionesobras.php");
include("funcionesphp/funcionescapitulos.php");
include("clases/categorias.class.php");
include("funcionesphp/funcionescategorias.php");
include("clases/comentarios.class.php");
include("funcionesphp/funcionescomentarios.php");
include("funcionesphp/funcionesbiblioteca.php");

if (isset($_SESSION['usuario'])) {
  $usuario = unusuarioporcodigo($bd, $_SESSION['usuario']);
  isblock($usuario->getestado());
}

$motivos = ["Dudas Generales", "Problemas con la web", "Denunciar obra o capitulo", "Denunciar Usuario", "Bloqueo de Usuario", "Bloqueo de Obra", "Bloqueo de Capitulo"];

if (isset($_POST['enviarmensaje'])) {
  $field_name = $_POST['nombre'];
  $field_email = $_POST['email'];
  $field_email = $_POST['email'];
  $field_motivo = $_POST['motivos'];
  $field_message = $_POST['mensaje'];
  $email = $_POST['email'];
  $mail_to = 'pulpworldinfo@gmail.com';
  $subject = 'Mensaje del visitante ' . $field_name;
  $body_message = 'From: ' . $field_name . "\n";
  $body_message .= 'E-mail: ' . $field_email . "\n";
  $body_message .= 'Mensaje: ' . $field_message  . "\n";
  $body_message .= 'Motivo:' . $motivos[$field_motivo];
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";
  $mail_status = mail($mail_to, $subject, $body_message, $headers);
  if ($mail_status) {
    header("Location: contacto.php?alerta=El mensaje se ha enviado con exito");

    die;
  } else {
    header("Location: contacto.php?alerta=El mensaje no se ha enviado, pruebe mas tarde");
    die;
  }
}
include("./Includes/header.php");
?>
<script src="js/contacto.js"></script>
</head>

<body>
  <?php
  include("Includes/nav.php");
  ?>
  <div class="text-center mb-5 mt-5">
    <h1 class="text-center">Contacta con nosotros</h1>
  </div>

  <div id="contact">
    <form id="formcontact" action="contacto.php" method="POST">
      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
      </div>
      <div class="form-group row">
        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2">Motivo</div>
        <div class="col-sm-10">
          <div class="form-check">
            <label for="filter">Selecciona un motivo</label>
            <select class="selectpicker" id="motivos" name="motivos">
              <option value="" selected>Selecciona una opcion</option>
              <?php
              for ($i = 0; $i < count($motivos); $i++) {

                echo "<option value='$i'>{$motivos[$i]}</option>";
              }

              ?>


            </select><br>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label for="mensaje" class="col-sm-2 col-form-label">Mensaje</label>
        <div class="col-sm-10">
          <textarea id="mensaje" style="resize: none;" class="form-control" rows="10" cols="40" name="mensaje"></textarea>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-10 text-center">
          <input class="btn btn-primary" name="enviarmensaje" id="mod" type="submit" value="Enviar">
          <input class="btn btn-secondary" type="reset" id="bot" value="Limpiar">
        </div>
      </div>
    </form>
  </div>
  <?php if (isset($_GET['alerta'])) { ?> <script>
      alert("<?php echo $_GET['alerta']; ?>")
    </script> <?php } ?>
  <?php
  include("Includes/footer.php")
  ?>
</body>

</html>