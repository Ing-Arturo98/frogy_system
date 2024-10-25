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
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="UTF-8">
    <title>AdminLTE 2 | Invoice</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <?php
      $fecha_reporte = date("Y-m-d");
      $fecha = $_POST['fecha'];
      $query = mysqli_query($con, "SELECT * FROM `notacompra` WHERE `fecha_hr` LIKE '$fecha'");
      $num = mysqli_num_rows($query);
      if ($num >= 1) {
      ?>
      <section class="invoice">
        <!-- title row -->
        <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">
                    <img src="../img/icon/logo_cara.png" height="80px"><img src="../img/text/frogy_logoBLANCO.png" height="30px">
                    <small class="pull-right">Fecha: <?php echo $fecha_reporte ?></small>
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
              </div><!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#nota</th>
                        <th>Fecha de la venta</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $total = 0;
                      while ($row=mysqli_fetch_array($query)) {
                        $id_c=$row['idCliente'];
                        $id_v=$row['id_vendedor'];
                      ?>
                        <tr>
                          <td>#1FS10<?php echo$row['id_nota'] ?></td>
                          <td><?php echo$row['fecha_hr'] ?></td>
                          <td>
                            <?php
                            $sqli=mysqli_query($con, "SELECT * FROM `clientes` WHERE `idCliente` LIKE '$id_c'");
                            $v=mysqli_fetch_array($sqli);
                            echo$v['nombre_completo']
                            ?>
                          </td>
                          <td>
                            <?php
                            $sqli2=mysqli_query($con, "SELECT * FROM `usuarios` WHERE `id_usuario` LIKE '$id_v'");
                            $v=mysqli_fetch_array($sqli2);
                            echo$v['nombre']
                            ?>
                          </td>
                          <td><?php echo "$". number_format($row['total_compra'],2) ?></td>
                        </tr>
                      <?php
                        $precio = $row['total_compra'];
                        $total += $precio;
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
                        <th>Generado el día: <?php echo$fecha ?></th>
                        <td>$<?php echo number_format($total,2); ?></td>
                      </tr>
                    </table>
                  </div>
                </div><!-- /.col -->
              </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- ./wrapper -->
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
  </body>

  </html>
<?php
}
}
?>