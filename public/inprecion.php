<?php
//una vez logueado, correctamente, cada pagina debera contar con el apartado de session_start() de esta manera los datos del usuario podran ser usuados con las variables de $_SESSION[''];
session_start();
$id_usuario = $_SESSION['id_usuario'];
include("../php/conexion.php");
$con = conectar();
/*caso contrario, si un susuario quiere ingresar a la pagina sin loguearse escribiendo la url la condicion if no lo dejara
de esta manera la condicion dice si el susuario es diferente a la sesion iniciada entonces te regreso al login, 
para eso se utiliza el !issets de esta manera el usuario tiene que iniciar sesion para poder ingresar y ver que hay dentro 
de el punto e venta*/
if (!isset($_SESSION['id_usuario'])) {
  header("Location: ../index.php");
} else {
  date_default_timezone_set('America/Cancun');
  $fecha_hora = date("d-m-Y");
  $sqli = mysqli_query($con, "INSERT INTO `notacompra` (`id_nota`, `fecha_hr`, `total_compra`, `idCliente`, `id_vendedor`) VALUES (NULL, '$fecha_hora', '0', '0', '$id_usuario');");
  $nota = mysqli_query($con, "SELECT * FROM `notacompra` ORDER BY `id_nota` DESC LIMIT 1");
  $fila = mysqli_fetch_array($nota);

  $fecha = date("d-m-Y");
  $usuario = mysqli_query($con, "SELECT * FROM `usuarios` WHERE `id_usuario` LIKE '$id_usuario'");
  $user = mysqli_fetch_array($usuario);
  $nombre = $user['nombre'];
  $name_user = $user['nombre_usuario'];
  $rol = $user['rol'];
  $pago = $_POST['pago'];
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="UTF-8">
    <title>Frogy_System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
  folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="../plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <!-- datatables -->
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" href="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
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

  <body class="skin-blue">
    <div class="wrapper">
      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Nota
            <small>#cliente</small>
          </h1>
          <ol class="breadcrumb">
            <li>
              <!-- Small modal -->
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm">Cancelar venta</button>
            </li>
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>
<br>

        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <form action="../php/cancelar_v.php" method="post">
                
                <input type="hidden" name="id_nota" value="<?php echo$fila['id_nota'] ?>">
                <input type="hidden" name="id_usuario" value="<?php echo$id_usuario ?>">
                <div class="form-group">
                  <h3><i class="fa fa-user"></i> <label>Password administracion</label></h3>
                  <div class="input-group" style="padding: 10px 10px 10px 10px;">
                    <div class="input-group-addon">
                      <i class="fa fa-lock"></i>
                    </div>
                    <input type="password" class="form-control" name="contra" placeholder="contraseña" required/>
                  </div><!-- /.input group -->
                </div><!-- /.form group nombre-->
                <div style="text-align: center;">
                <button type="submit" name="cancelar" class="btn btn-warning">Cancelar</button>
                </div>

              </form>
            </div>
          </div>
        </div>
        <?php
        //este codigo solo se mostrara si el cliente es buscado por su correo y encontrado con exito//
        if (isset($_POST['correo'])) {
          $id_cliente = $_POST['id_cliente'];
          $query = mysqli_query($con, "SELECT * FROM `clientes` WHERE `idCliente` LIKE '$id_cliente'");
          $num = mysqli_num_rows($query);
          if ($num >= 1) {
            $row = mysqli_fetch_array($query);
        ?>
            <section class="invoice">
              <!-- title row -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">
                    <img src="../img/icon/logo_cara.png" height="80px"><img src="../img/text/frogy_logoBLANCO.png" height="30px">
                    <small class="pull-right">Fecha: <?php echo $fecha ?></small>
                  </h2>
                </div><!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  De
                  <address>
                    <strong>Administracion</strong><br>
                    Av. Gobernadores #107<br>
                    San Francisco de Campeche<br>
                    Telefono: (981) 117 81 53<br />
                    Correo: FrogySistem@gmail.com
                  </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Para
                  <address>
                    <strong><?php echo $row['nombre_completo']; ?></strong><br>
                    Ciudad: <?php echo $row['ciudad']; ?><br>
                    Direccion: <?php echo $row['colonia'] . " " . $row['calle'] . " " . $row['num_casa']; ?><br>
                    Telefono: <?php echo $row['telefono']; ?><br />
                    Correo: <?php echo $row['correo']; ?>
                  </address>
                </div><!-- /.col -->

                <div class="col-sm-4 invoice-col">
                  <b>Datos de compra #1FS10<?php echo $fila['id_nota'] ?>
                  </b><br />
                  <br />
                  <b>Pago día:</b> <?php echo $fecha ?><br />
                </div><!-- /.col -->
              </div><!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Foto</th>
                        <th>Producto</th>
                        <th>Serie</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $total = 0;
                      $carrito = mysqli_query($con, "SELECT * FROM `carrito` WHERE `id_usuario` LIKE '$id_usuario'");
                      while ($x = mysqli_fetch_array($carrito)) {
                        $id_producto = $x['id_producto'];
                      ?>
                        <tr>
                          <td><?php $sql = mysqli_query($con, "SELECT * FROM `productos` WHERE `idProducto` LIKE '$id_producto'");
                              $pro = mysqli_fetch_array($sql);
                              ?><img src="<?php echo $pro['img'] ?>" height="50px"></td>
                          <td><?php $sql = mysqli_query($con, "SELECT * FROM `productos` WHERE `idProducto` LIKE '$id_producto'");
                              $pro = mysqli_fetch_array($sql);
                              echo $pro['nombre']; ?></td>
                          <td>#1FS10<?php echo $x['id_producto'] ?></td>
                          <td><?php $sql = mysqli_query($con, "SELECT * FROM `productos` WHERE `idProducto` LIKE '$id_producto'");
                              $pro = mysqli_fetch_array($sql);
                              echo $pro['precio']; ?></td>
                        </tr>
                      <?php
                        $precio = $pro['precio'];
                        $total += number_format($precio, 2);
                      }
                      ?>
                    </tbody>
                  </table>
                </div><!-- /.col -->
              </div><!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">
                </div><!-- /.col -->
                <div class="col-xs-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal sin IVA:</th>
                        <td><?php echo "$" . $total; ?></td>
                      </tr>
                      <?php
                      $iva = ($total * 16) / 100;
                      ?>
                      <tr>
                        <th>IVA (16%)</th>
                        <td><?php echo "$" . $iva; ?></td>
                      </tr>
                      <?php
                      $pago_fianal = $total + $iva;
                      ?>
                      <tr>
                        <th>Pago con </th>
                        <td><?php echo "$" . $pago; ?></td>
                      </tr>
                      <?php
                      $x = $pago - $pago_fianal;
                      $cambio = number_format($x, 2);
                      ?>
                      <tr>
                        <th>Total:</th>
                        <td><?php echo "$" . $pago_fianal ?></td>
                      </tr>
                      <tr>
                        <th>Cambio</th>
                        <td><?php echo "$" . $cambio ?></td>
                      </tr>
                    </table>
                  </div>
                </div><!-- /.col -->
              </div><!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-xs-12">
                  <form action="invoice-print.php" method="post" target="_blank">
                    <input type="hidden" name="pago" value="<?php echo $pago ?>">
                    <input type="hidden" name="id_nota" value="<?php $fila['id_nota'] ?>">
                    <input type="hidden" name="id_cliente" value="<?php echo $id_cliente ?>">
                    <button type="submit" name="imprimir" target="_blank" class="mostrar" id="boton1" onclick="mostrarOcultarBotones()"><i class="fa fa-print"></i> Imprimir</button>
                  </form>
                  <a href="inicio.php" style="display:none; color:black;" class="btn btn-default" id="boton2" onclick="redireccionar()"><i class="fa fa-home" style="border: 1px black solid; margin: 5px 5px 5px 5px;">Inicio</i></a>
                </div>
              </div>
            </section><!-- /.content -->
          <?php
          } else {
          ?>
            <div class="alert alert-danger alert-dismissable">
              <h4><i class="icon fa fa-ban"></i>Ups!!</h4>
              <p style="color: white;">Cliente no encontrado</p>
            </div>
          <?php
          }
        } else {
          ?>
          <!-- Formulario mostrado por defecto en caso de no estar registrado como cliente -->
          <?php
          $default = mysqli_query($con, "SELECT * FROM `clientes` WHERE `idCliente` LIKE 2");
          $row = mysqli_fetch_array($default);
          $id_cliente = $row['idCliente']
          ?>
          <section class="invoice">
            <!-- title row -->
            <div class="row">
              <div class="col-xs-12">
                <h2 class="page-header">
                  <img src="../img/icon/logo_cara.png" height="80px"><img src="../img/text/frogy_logoBLANCO.png" height="30px">
                  <small class="pull-right">Fecha: <?php echo $fecha ?></small>
                </h2>
              </div><!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                De
                <address>
                  <strong>Administracion</strong><br>
                  Av. Gobernadores #107<br>
                  San Francisco de Campeche<br>
                  Telefono: (981) 117 81 53<br />
                  Correo: FrogySistem@gmail.com
                </address>
              </div><!-- /.col -->
              <div class="col-sm-4 invoice-col">
                Para
                <address>
                  <strong><?php echo $row['nombre_completo']; ?></strong><br>
                  Ciudad: <?php echo $row['ciudad']; ?><br>
                  Direccion: <?php echo $row['colonia']; ?><br>
                  Telefono: <?php echo $row['telefono']; ?><br />
                  Correo: <?php echo $row['correo']; ?>
                </address>
              </div><!-- /.col -->

              <div class="col-sm-4 invoice-col">
                <b>Datos de compra #1FS10<?php echo $fila['id_nota'] ?>
                </b><br />
                <br />
                <b>Pago día:</b> <?php echo $fecha ?><br />
              </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Producto</th>
                      <th>Serie</th>
                      <th>Description</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $total = 0;
                    $carrito = mysqli_query($con, "SELECT * FROM `carrito` WHERE `id_usuario` LIKE '$id_usuario'");
                    while ($x = mysqli_fetch_array($carrito)) {
                      $id_producto = $x['id_producto'];
                    ?>
                      <tr>
                        <td><?php $sql = mysqli_query($con, "SELECT * FROM `productos` WHERE `idProducto` LIKE '$id_producto'");
                            $pro = mysqli_fetch_array($sql);
                            ?><img src="<?php echo $pro['img'] ?>" height="50px"></td>
                        <td><?php $sql = mysqli_query($con, "SELECT * FROM `productos` WHERE `idProducto` LIKE '$id_producto'");
                            $pro = mysqli_fetch_array($sql);
                            echo $pro['nombre']; ?></td>
                        <td>#1FS10<?php echo $x['id_producto'] ?></td>
                        <td><?php $sql = mysqli_query($con, "SELECT * FROM `productos` WHERE `idProducto` LIKE '$id_producto'");
                            $pro = mysqli_fetch_array($sql);
                            echo $pro['precio']; ?></td>
                      </tr>
                    <?php
                      $precio = $pro['precio'];
                      $total += number_format($precio, 2);
                    }
                    ?>
                  </tbody>
                </table>
              </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-xs-6">
              </div><!-- /.col -->
              <div class="col-xs-6">
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">Subtotal sin IVA:</th>
                      <td><?php echo "$" . $total; ?></td>
                    </tr>
                    <?php
                    $iva = ($total * 16) / 100;
                    ?>
                    <tr>
                      <th>IVA (16%)</th>
                      <td><?php echo "$" . $iva; ?></td>
                    </tr>
                    <?php
                    $pago_fianal = $total + $iva;
                    ?>
                    <tr>
                      <th>Total:</th>
                      <td><?php echo "$" . $pago_fianal ?></td>
                    </tr>
                    <tr>
                      <th>Pago con </th>
                      <td><?php echo "$" . $pago; ?></td>
                    </tr>
                    <?php
                    $x = $pago - $pago_fianal;
                    $cambio = number_format($x, 2);
                    ?>
                    <tr>
                      <th>Cambio</th>
                      <td><?php echo "$" . $cambio ?></td>
                    </tr>
                  </table>
                </div>
              </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-xs-12">
                <form action="invoice-print.php" method="post" target="_blank">
                  <input type="hidden" name="pago" value="<?php echo $pago ?>">
                  <input type="hidden" name="id_nota" value="<?php $fila['id_nota'] ?>">
                  <input type="hidden" name="id_cliente" value="<?php echo $id_cliente ?>">
                  <button type="submit" name="imprimir" target="_blank" class="mostrar" id="boton1" onclick="mostrarOcultarBotones()"><i class="fa fa-print"></i> Imprimir</button>
                </form>
                <a href="inicio.php" style="display:none; color:black;" class="btn btn-default" id="boton2" onclick="redireccionar()"><i class="fa fa-home">Inicio</i></a>
              </div>
            </div>
          </section><!-- /.content -->
        <?php
        }
        ?>
        <!-- Main content -->
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
    </div>
    <script>
      function mostrarOcultarBotones() {
        var boton1 = document.getElementById('boton1');
        var boton2 = document.getElementById('boton2');

        if (boton1.style.display === 'none') {
          boton1.style.display = 'block';
          boton2.style.display = 'none';
        } else {
          boton1.style.display = 'none';
          boton2.style.display = 'block';
        }
      }

      function redireccionar() {
        window.location.href = 'inicio.php';
      }
    </script>
    <?php include("../admin/footer.php"); ?>
  </body>

  </html>
<?php
}
?>