<nav class="navbar navbar-expand-md navbar-light bg-light">

    <a class="navbar-brand" href="index.php">

        Pulp Word
    </a>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#firstnavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="firstnavbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Obras</a></li>
            <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuarios</a></li>
            <?php if(isset($_SESSION['usuario'])){?>
                <li class="nav-item"><a class="nav-link" href="./notificaciones.php">Notificaciones <?php $sinver=sinver($bd, $_SESSION["usuario"]);  if($sinver!=0) { ?><span class="badge badge-primary"><?php echo sinver($bd, $_SESSION["usuario"]) ?></span> <?php } ?></a></li>
            <li class="nav-item"><a class="nav-link" href="#">Mensajes<span class="badge badge-primary">4</span></a></li>
                <?php } 
                if(isset($_SESSION["usuario"])){
                ?>
                <li class="nav-item"><a class="nav-link" href="new.php">Escribir obra</a></li>
                <?php } ?>
        </ul>
        <?php if(isset($_SESSION['usuario'])){
            ?>


<div class="pull-right mr-4">
                <ul class="nav pull-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-user"></i> Hola! <?php echo $usuario->getusuario(); ?><b class="caret"></b>  <span class="badge badge-primary">4</span></a>
                        <ul class="dropdown-menu">
                            <li><a href=<?php echo "usuario.php?user={$_SESSION['usuario']}";?> ><i class="icon-cog"></i> Perfil</a></li>
                            <li><a href="/help/support"><i class="icon-envelope"></i> Contact Support</a></li>
                            <li class="divider"></li>
                            <li><a href="./funcionesphp/sesion.php?logout=yes"><i class="icon-off"></i> Cerrar Sesion</a></li>
                        </ul>
                    </li>
                </ul>
              </div>
            
            <?php }else{ ?>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#sesion" href="#">Iniciar Sesion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#registro" href="#">Registrarse</a>
            </li>
        </ul>
        <?php } ?>

        <div class="modal fade" id="sesion" tabindex="-1" role="dialog" aria-labelledby="sesionLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sesionLabel">Iniciar Sesion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                         <form id="iniciosesion" action="./funcionesphp/sesion.php" method="POST">
                         <p id="error"></p>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Usuario o email</label>
                                <input type="text" class="form-control" id="usulog" name="usulog">
                            </div>

                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contralog" name="contralog">
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" id="botonsesion" name="botonsesion" value="Enviar"></input>
                        </form>
                    </div>
                </div>
            </div>
        </div>






        <div class="modal fade" id="registro" tabindex="-1" role="dialog" aria-labelledby="registroLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registroLabel">Registrarse</h5>
                       
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <p id="errores"></p>
                        <form id="registroform" action="./funcionesphp/formulariosusuario.php" method="POST">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Usuario</label>
                                <input type="text" class="form-control" name="usureg" id="usureg">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Email</label>
                                <input type="text" class="form-control" name="emailreg" id="emailreg">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Contraseña</label>
                                <input type="password" class="form-control" name="contrareg" id="contrareg">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Repetir Contraseña</label>
                                <input type="password" class="form-control" name="contrareg2" id="contrareg2">
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" name="botonregistro" id="botonregistro" value="Enviar">
                        </form>
                    </div>
                </div>
            </div>
        </div>





    </div>

</nav>