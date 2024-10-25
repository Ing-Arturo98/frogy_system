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
            Ventas
          </h1>
          <ol class="breadcrumb">
            <li><a href="../public/inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Ventas</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <div class="container">
                    <div class="row">
                      <div class="col-xs-10">
                        <h3 class="box-title">Tabla de registro de ventas general</h3>
                      </div>
                    </div>

                  </div>

                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Vendedor</th>
                        <th>Cliente</th>
                        <th>Total venta</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = mysqli_query($con, "SELECT * FROM `notacompra`");
                      while ($row = mysqli_fetch_array($query)) {
                        $id_nota = $row['id_nota'];
                        $id_cliente = $row['idCliente'];
                        $id_vendedor = $row['id_vendedor'];
                      ?>
                        <tr>
                          <td>#1FS10<?php echo$id_nota ?></td>
                          <td><?php echo$row['fecha_hr'] ?></td>
                          <td>
                            <?php
                            $vendedor = mysqli_query($con, "SELECT * FROM `usuarios` WHERE `id_usuario` LIKE '$id_vendedor'");
                            $c=mysqli_fetch_array($vendedor);
                            echo$c['nombre'];
                            ?>
                          </td>
                          <td>
                            <?php
                            if($id_cliente <= '0'){
                              ?>
                              <p><b>Venta cancelada</b></p>
                              <?php
                            }else{
                            $cliente = mysqli_query($con, "SELECT * FROM `clientes` WHERE `idCliente` LIKE '$id_cliente'");
                            $cli = mysqli_fetch_array($cliente);
                            echo$cli['nombre_completo'];
                            }
                            ?>
                          </td>
                          <td>$<?php echo$row['total_compra'] ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Vendedor</th>
                        <th>Cliente</th>
                        <th>Total venta</th>
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
    <script>
      function redondear() {
        var input = document.getElementById("miInput");

        if (input.value !== "") {
          var numero = parseFloat(input.value);
          var numeroRedondeado = numero.toFixed(2);
          input.value = numeroRedondeado;
        }
      }
    </script>
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