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
  $fecha = date("d-m-Y");
  $id_cliente = $_POST['id_cliente'];
  $nota= mysqli_query($con, "SELECT * FROM `notacompra` ORDER BY `id_nota` DESC LIMIT 1");
  $fila=mysqli_fetch_array($nota);
  $id_nota=$fila['id_nota'];
  $pago = $_POST['pago'];
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="UTF-8">
    <title>Frogy-System N°Nota<?php echo$id_nota; ?></title>
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
      $default = mysqli_query($con, "SELECT * FROM `clientes` WHERE `idCliente` LIKE '$id_cliente'");
      $row = mysqli_fetch_array($default);
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
                        <td><?php echo "$".$total; ?></td>
                      </tr>
                      <?php
                      $iva = ($total * 16) / 100;
                      ?>
                      <tr>
                        <th>IVA (16%)</th>
                        <td><?php echo "$".$iva; ?></td>
                      </tr>
                      <?php
                      $pago_final = $total + $iva;
                      ?>
                      <tr>
                        <th>Pago con </th>
                        <td><?php echo "$".$pago; ?></td>
                      </tr>
                      <?php
                        $x = $pago - $pago_final;
                        $cambio = number_format($x, 2);
                      ?>
                      <tr>
                        <th>Total:</th>
                        <td><?php echo "$".$pago_final ?></td>
                      </tr>
                      <tr>
                        <th>Cambio</th>
                        <td><?php echo "$".$cambio ?></td>
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
  $sqli = mysqli_query($con, "UPDATE `notacompra` SET `total_compra` = '$pago_final', `idCliente` = '$id_cliente' WHERE `notacompra`.`id_nota` = '$id_nota';");
  $query = mysqli_query($con, "DELETE FROM `carrito` WHERE `carrito`.`id_usuario` LIKE $id_usuario");
}
?>