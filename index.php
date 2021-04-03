<?php
session_start();
include("./funcionesphp/conexionbd.php");
$bd = conectardb();
include("./funcionesphp/funcionesusuarios.php");
include("clases/obras.class.php");
include("funcionesphp/funcionesobras.php");
include("clases/usuarios.class.php");
include("clases/categorias.class.php");
include("funcionesphp/funcionescategorias.php");
$categorias = categorias($bd);
$ses = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 0;
if (isset($_SESSION['usuario'])) {
    $usuario = unusuarioporcodigo($bd, $_SESSION['usuario']);
}
include("Includes/header.php");
?>
<link rel="stylesheet" href="index.css">
</head>

<body>
    <?php
    include("Includes/nav.php");
    $desplazamiento = $_GET['desplazamiento'] ?? 0;
    $orden = $_GET['orden'] ?? "likes";
    $ordnum = 0;
    $num_filas = 20;
    $pagina = $_GET['pag'] ?? 1;

    if (isset($_GET["orden"])) {
        $cat = $_GET['categoria'] ?? 0;
        switch ($orden) {
            case 0:
                $orden = "likes";
                $ordnum = 0;
                break;

            case 1:
                $orden = "lecturas";
                $ordnum = 1;
                break;

            case 2:
                $orden = "terminada";
                $ordnum = 2;
                break;

            case 3:
                $orden = "id";
                $ordnum = 3;
                break;

            default:
                $orden = "likes";
                break;
        }

        if (isset($_GET["buscarpor"])) {
            if ($cat == 0) {
                $obras = obraspalabras($bd, $desplazamiento, $orden, $_GET["buscarpor"], $ses);
                $total = totalobraspalabras($bd, $desplazamiento, $orden, $_GET["buscarpor"], $ses);
            } else {
                $obras = obraspalabrasconcat($bd, $desplazamiento, $orden, $_GET["buscarpor"], $cat, $ses);
                $total = totalobraspalabrasconcat($bd, $desplazamiento, $orden, $_GET["buscarpor"], $cat, $ses);
            }
        } else {
            if ($cat == 0) {
                $obras = obras($bd, $desplazamiento, $orden, $ses);
                $total = totalobras($bd, $ses);
            } else {
                $obras = filtrarobras1($bd, $desplazamiento, $orden, $cat, $ses);
                $total = totalobras1($bd, $desplazamiento, $orden, $cat, $ses);
            }
        }
    } else {
        $obras = obras($bd, $desplazamiento, $orden, $ses);
        $total = totalobras($bd, $ses);
    }
    $usuarios = arrayusuariosporid($bd);
    ?>
    <div class="jumbotron jumbotron-fluid bg-dark">

        <div class="jumbotron-background">
            <img src="pulp.jpg" class="blur ">
        </div>

        <div class="container text-white">

            <h1 class="display-5">Bienvenido a pulp world!</h1>
            <p class="lead">Esta plataforma tiene el proposito de que la gente pueda leer, escribir y públicar relatos de una forma sencilla</p>
            <hr class="my-4">
            <p>El nombre Pulp word hace referencia a las revistas pulp muy famosas durante los años</p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Saber más</a>
            <?php if (!isset($_SESSION['usuario'])) {
            ?>
                <a class="btn btn-primary btn-lg" href="#" role="button">¿No estas registrado? Hazlo!</a>
            <?php } else {
            ?>
                <a class="btn btn-primary btn-lg" href="#" role="button">Crear nueva obra</a>
            <?php } ?>

        </div>
        <!-- /.container -->


    </div>
    <div>
        <h1 class="display-3 text-center mb-5">Historias Pulp</h1>
    </div>

    <div class="container-fluid mb-3">
        <div class="row">
            <div class="col-md-12">
                <form action="./funcionesphp/filtrar.php" method="POST" class="form-horizontal" role="form">
                    <div class="input-group" id="adv-search">

                        <input type="text" class="form-control" id="textobusqueda" name="textobusqueda" placeholder="Busqueda avanzada" <?php if (isset($_GET["buscarpor"])) echo "value={$_GET['buscarpor']}"; ?>>
                        <div class="input-group-btn">
                            <div class="btn-group" role="group">
                                <div class="dropdown dropdown-lg">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span>Opciones</button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">


                                        <div class="form-group">
                                            <label for="filter">Categorias</label>
                                            <select class="form-control" id="categorias" name="categoria">
                                                <option value="0" selected>Todas las categorias</option>
                                                <?php
                                                for ($i = 0; $i < count($categorias); $i++) {
                                                    if (isset($_GET["categoria"]) && $categorias[$i]->getid() == $cat) {
                                                        echo "<option selected value='{$categorias[$i]->getid()}'>{$categorias[$i]->getnombre()}</option>";
                                                    } else {
                                                        echo "<option value='{$categorias[$i]->getid()}'>{$categorias[$i]->getnombre()}</option>";
                                                    }
                                                }

                                                ?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="filter">Ordenar por</label>
                                            <select class="form-control" id="orden" name="orden">
                                                <?php
                                                $arrayord = ["Likes", "Mas leidos", "Terminados", "Recientes"];
                                                for ($i = 0; $i < count($arrayord); $i++) {
                                                    if (isset($_GET["orden"]) && $i == $ordnum) {
                                                        echo "<option selected value=$i>{$arrayord[$i]}</option>";
                                                    } else {
                                                        echo "<option value=$i>{$arrayord[$i]}</option>";
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>

                                        <input type="submit" id="busqueda" name="busqueda" class="btn btn-primary busqueda" value="Buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></input>

                                    </div>
                                </div>
                                <input type="submit" id="busqueda1" name="busqueda1" class="btn btn-primary busqueda" value="Buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></input>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <?php $linea = 20;

    ?>

    <div id="coleccion" class="card-group">
        <div class="container-fluid mb-3">
            <div class="row">
                <?php for ($i = 0; $i < 12; $i++) {


                ?>
                    <?php if ($i < $total - $desplazamiento) {
                        $generos = generos($bd, $obras[$i]->getid());
                    ?>
                        <a class="noDecoration" <?php echo "href=obra.php?obra={$obras[$i]->getid()}";  ?>>

                            <div class="card col-md-3 col-xs-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <img style="width: 80%; height: 20rem; display:block;
margin:auto; " class="card-img-top" src=<?php echo "Imagenes/Obras/" . $obras[$i]->getportada(); ?> alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php
                                        echo $obras[$i]->gettitulo();
                                        ?>
                                    </h5>
                                    <p style="word-break: break-all;" class="card-text text-justify">
                                        <?php echo $obras[$i]->getsinopsis();
                                        ?>
                                    </p>
                                    <a style="color:blue;" data-toggle="modal" data-target=<?php echo "#0" . $obras[$i]->getid(); ?> href="#">Leer mas</a>
                                    <div class="modal fade" id=<?php echo "0" . $obras[$i]->getid(); ?> tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <?php
                                                        echo $obras[$i]->gettitulo();
                                                        ?>
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div style="height: 300px;">
                                                        <img style="width: 70%; height: 20rem;" class="rounded mx-auto d-block mh-100" src=<?php echo "Imagenes/Obras/" . $obras[$i]->getportada(); ?> />
                                                    </div>
                                                    <p class="text-justify mt-3">
                                                        <?php
                                                        echo $obras[$i]->getsinopsis();
                                                        ?>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <a <?php echo "href=obra.php?obra={$obras[$i]->getid()}";  ?> class="btn btn-primary">Empezar lectura</a>
                                                </div>

                                            </div>

                                        </div>
                                    </div>


                                </div>
                                <p class="text-justify ml-4"><strong>Escrito por: </strong><?php
                                                                                            echo " <a href='usuario.php?user={$obras[$i]->getautor()}' >{$usuarios[$obras[$i]->getautor()]->getusuario()}</a>";

                                                                                            ?></p>
                                <div class="card-footer">
                                    <a style="color:white" <?php echo "href=obra.php?obra={$obras[$i]->getid()}";  ?> class="btn btn-primary">Empezar lectura</a>
                                </div>

                            </div>
                        </a>
                    <?php } else {

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
                $prev = $desplazamiento - 12;
                $url = $_SERVER["PHP_SELF"] . "?orden=$orden&desplazamiento=$prev";
                echo "<li class='page-item active'>";
                echo  "<a class='page-link mr-4' href=$url tabindex='-1'>Anterior</a>";
            } else {

                echo "<li class='page-item disabled'>";
                echo  "<a class='page-link mr-4' href='#' tabindex='-1'>Anterior</a>";
            }

            ?>

            </li>
            <?php
            $o = 0;
            for ($i = 0; $i < $total; $i += 12) {
                $o++;
                $url = $_SERVER["PHP_SELF"] . "?orden=$orden&&desplazamiento=$i&pag=$o";
                if ($pagina == $o) {
                    echo "<li class='page-item active'>
                <a class='page-link' href=$url>$o <span class='sr-only'>(current)</span></a>
            </li>";
                } else {
                    echo  "<li class='page-item'><a class='page-link' href=$url>$o</a></li>";
                }
            }

            if ($total > ($desplazamiento + 12)) {
                $prox = $desplazamiento + 12;
                $url = $_SERVER["PHP_SELF"] . "?orden=$orden&desplazamiento=$prox";
                echo "<li class='page-item active'>";
                echo  "<a class='page-link ml-4' href=$url tabindex='-1'>Siguiente</a>";
            } else {
                echo "<li class='page-item disabled'>";
                echo  "<a class='page-link ml-4' href='#' tabindex='-1'>Siguiente</a>";
            }

            ?>
            </li>
        </ul>
    </nav>

    <?php if (isset($_GET['alerta'])) { ?> <script>
            alert("<?php echo $_GET['alerta']; ?>")
        </script> <?php } ?>

    <!-- Modal -->
    <script>
        $('.dropdown-menu').on('click', function(event) {
            event.stopPropagation();
        });

        $(document).on("ready", function() {
            $(".card-text").each(function() {
                max_chars = 280;
                limite_text = $(this).html();
                if (limite_text.length > max_chars) {
                    limite = limite_text.substr(0, max_chars) + " ...";
                    $(this).text(limite);
                }
            });
        });
    </script>
    <?php
    include("Includes/footer.php")
    ?>
</body>

</html>