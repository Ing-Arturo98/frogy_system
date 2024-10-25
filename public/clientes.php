<?php
//una vez logueado, correctamente, cada pagina debera contar con el apartado de session_start() de esta manera los datos del usuario podran ser usuados con las variables de $_SESSION[''];
session_start();
include("../php/conexion.php");
$con = conectar();
$id_usuario = $_SESSION['id_usuario'];
/*caso contrario, si un susuario quiere ingresar a la pagina sin loguearse escribiendo la url la condicion if no lo dejara
de esta manera la condicion dice si el susuario es diferente a la sesion iniciada entonces te regreso al login, 
para eso se utiliza el !issets de esta manera el usuario tiene que iniciar sesion para poder ingresar y ver que hay dentro 
de el punto e venta*/
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.php");
} else {
    $usuario = mysqli_query($con, "SELECT * FROM `usuarios` WHERE `id_usuario` LIKE '$id_usuario'");
    $user = mysqli_fetch_array($usuario);
    $nombre = $user['nombre'];
    $name_user = $user['nombre_usuario'];
    $rol = $user['rol'];
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Frogy_System</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
        <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    </head>

    <body class="skin-blue">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="../public/inicio.php" class="logo"><img src="../img/text/frogy_logoBLANCO.png" height="30px"></a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- Cuenta de usuario-->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="../img/icon/LOGO_frogy.png" class="user-image" alt="User Image" />
                                    <span class="hidden-xs"><?php echo $nombre ?></span>
                                </a>
                                <ul class="dropdown-menu">

                                    <!-- aqui va el modal con la foto del usuario -->
                                    <li class="user-header">
                                        <img src="../img/icon/LOGO_frogy.png" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo $name_user ?>
                                            <small>@Miembro desde 2023</small>
                                        </p>
                                    </li>

                                    <!-- aquí se pueden incluir la configuracion del user y el sing out-->
                                    <li class="user-footer">
                                        <?php
                                        if ($rol == 'admin') {
                                        ?>
                                            <div class="pull-left">
                                                <a href="../public/configuracion.php" class="btn btn-default btn-flat">Add user</a>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="pull-right">
                                            <a href="../php/logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <?php include("../admin/menu.php") ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Clientes
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="../public/inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Clientes</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- editado de clientes -->
                    <div class="row">
                        <div class="col-xs-12">
                            <?php
                            if (isset($_POST['editar'])) {
                                $id = $_POST['id'];
                                $query = mysqli_query($con, "SELECT * FROM `clientes` WHERE `idCliente` LIKE '$id'");
                                $row = mysqli_fetch_array($query);
                            ?>
                                <div class="box">
                                    <div class="box-header">
                                        <form action="../php/actualizar.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="nombre" value="<?php echo $row['nombre_completo'] ?>" placeholder="Nombres completo del cliente" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group nombre-->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-tag"></i>
                                                    </div>
                                                    <input type="date" class="form-control" name="fecha" value="<?php echo $row['fechaNac'] ?>" placeholder="fecha de nacimiento" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group fechade nacimiento-->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar-o"></i>
                                                    </div>
                                                    <input type="number" class="form-control" name="postal" value="<?php echo $row['codPos'] ?>" placeholder="codigo postal" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group codigo postal-->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="telefono" value="<?php echo $row['telefono'] ?>" placeholder="telefono de contacto" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group telefono-->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-envelope-o"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="correo" value="<?php echo $row['correo'] ?>" placeholder="correo de conacto" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group correo-->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-building-o"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="ciudad" value="<?php echo $row['ciudad'] ?>" placeholder="Ciudad de recidencia actual" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group ciudad-->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-home"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="colonia" value="<?php echo $row['colonia'] ?>" placeholder="Colonia" required />
                                                </div><!-- /.input group-->
                                            </div><!-- /.form group colonia-->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-thumb-tack"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="calle" value="<?php echo $row['calle'] ?>" placeholder="calle" required />
                                                </div><!-- /.input group-->
                                            </div><!-- /.form group calle-->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-tag"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="numcasa" value="<?php echo $row['num_casa'] ?>" placeholder="numero de casa" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group numcasa-->
                                            <div class="row">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-2">
                                                    <div style="align-items: center;">
                                                        <button type="submit" name="actualizar_cliente" class="btn btn-success">Actualizar <i class="fa fa-save"></i></button>
                                                    </div>
                                                </div>
                                        </form>
                                        <div class="col-lg-3">
                                            <a href="clientes.php" class="btn btn-default">Cancelar</a>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                </div>
                        </div>
                    </div>
                <?php
                            }
                ?>
            </div>
        </div>
        <!-- fin formulario edicion -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-10">
                                    <h3 class="box-title">Tabal de clientes</h3>
                                </div>
                                <div class="col-xs-1">
                                    <div style="margin: 0px 0px 0px 40px;">
                                        <button class="btn btn-success" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div><!-- /.box-header -->

                    <div class="collapse" id="collapseExample">
                        <div class="well">
                            <form action="" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" name="nombre" value="" placeholder="Nombres completo del cliente" required />
                                    </div><!-- /.input group -->
                                </div><!-- /.form group nombre-->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar-o"></i>
                                        </div>
                                        <input type="date" class="form-control" name="fecha" value="" placeholder="fecha de nacimiento" required />
                                    </div><!-- /.input group -->
                                </div><!-- /.form group fechade nacimiento-->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-tag"></i>
                                        </div>
                                        <input type="number" class="form-control" name="postal" value="" placeholder="codigo postal" required />
                                    </div><!-- /.input group -->
                                </div><!-- /.form group codigo postal-->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" class="form-control" name="telefono" value="" placeholder="telefono de contacto" required />
                                    </div><!-- /.input group -->
                                </div><!-- /.form group telefono-->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope-o"></i>
                                        </div>
                                        <input type="text" class="form-control" name="correo" value="" placeholder="correo de contacto" required />
                                    </div><!-- /.input group -->
                                </div><!-- /.form group correo-->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-building-o"></i>
                                        </div>
                                        <input type="text" class="form-control" name="ciudad" value="" placeholder="Ciudad de recidencia actual" required />
                                    </div><!-- /.input group -->
                                </div><!-- /.form group ciudad-->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <input type="text" class="form-control" name="colonia" value="" placeholder="Colonia" required />
                                    </div><!-- /.input group-->
                                </div><!-- /.form group colonia-->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-thumb-tack"></i>
                                        </div>
                                        <input type="text" class="form-control" name="calle" value="" placeholder="calle" required />
                                    </div><!-- /.input group-->
                                </div><!-- /.form group calle-->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-tag"></i>
                                        </div>
                                        <input type="text" class="form-control" name="numcasa" value="" placeholder="numero de casa" required />
                                    </div><!-- /.input group -->
                                </div><!-- /.form group numcasa-->
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4">
                                        <div style="align-items: center;">
                                            <button type="submit" name="agregar" class="btn btn-block btn-success">Agregar <i class="fa fa-save"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['agregar'])) {
                        $nombre = $_POST['nombre'];
                        $fechaNac = $_POST['fecha'];
                        $codPost = $_POST['postal'];
                        $telefono = $_POST['telefono'];
                        $correo = $_POST['correo'];
                        $ciudad = $_POST['ciudad'];
                        $colonia = $_POST['colonia'];
                        $calle = $_POST['calle'];
                        $numCas = $_POST['numcasa'];

                        $verificorreo = mysqli_query($con, "SELECT * FROM `clientes` WHERE `correo` LIKE '$correo'");
                        $band = mysqli_num_rows($verificorreo);
                        if ($band >= 1) {
                    ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4> <i class="icon fa fa-check"> Alerta!</i></h4>
                                Correo de usuario existenete,
                            </div>
                            <?php
                        } else {
                            $query = mysqli_query($con, "INSERT INTO `clientes` (`idCliente`, `nombre_completo`, `fechaNac`, `codPos`, `telefono`, `correo`, `ciudad`, `colonia`, `calle`, `num_casa`) 
                            VALUES (NULL, '$nombre', '$fechaNac', '$codPost', '$telefono', '$correo', '$ciudad', '$colonia', '$calle', '$numCas');");

                            if ($query == true) {
                            ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4> <i class="icon fa fa-check">c:</i></h4>
                                    Cliente añadido con exito!
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre cliente</th>
                                    <th>Correo</th>
                                    <th>telefono</th>
                                    <th>Ciudad</th>
                                    <th>Codigo postal</th>
                                    <th>Fecha de nacimiento</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM `clientes`");
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['nombre_completo'] ?></td>
                                        <td><?php echo $row['correo'] ?></td>
                                        <td><?php echo $row['telefono'] ?></td>
                                        <td><?php echo $row['ciudad'] ?></td>
                                        <td><?php echo $row['codPos'] ?></td>
                                        <td><?php echo $row['fechaNac'] ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?php echo $row['idCliente'] ?>">
                                                <button name="editar" type="submit"><i class="fa fa-pencil-square-o"></i> Edit</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre cliente</th>
                                    <th>Correo</th>
                                    <th>telefono</th>
                                    <th>Ciudad</th>
                                    <th>Codigo postal</th>
                                    <th>Fecha de nacimiento</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0
    </div>
    <strong>Frogy_System &copy; Agosto 2023<a href="../contacto.html" target="_blank"> Soporte y contacto</a>.</strong> 
  </footer>
        </div><!-- ./wrapper -->
        <!-- jQuery 2.1.3 -->
        <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src='../plugins/fastclick/fastclick.min.js'></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../dist/js/demo.js" type="text/javascript"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>

    </body>

    </html>
<?php
}
?>