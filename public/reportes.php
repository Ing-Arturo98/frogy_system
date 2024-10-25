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
  <?php include("../admin/head.php"); ?>

  <body class="skin-blue">
    <div class="wrapper">
      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Reportes
            <small>Ventas</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Reportes</a></li>
          </ol>
        </section>

        <div class="row">
          <div class="col-lg-3"></div>
          <div class="col-lg-4">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              Reporte de 1 día
            </a>
            <div class="collapse" id="collapseExample">
              <div class="well">
                Selecciona la fecha del reporte que nesesitas
                <form action="" method="post">
                <div class="form-group">
                  <label>Fecha del dia</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="dia" class="form-control" pattern="\d{2}-\d{2}-\d{4}" title="Por favor ingresa una fecha en formato DD-MM-YYYY"/>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                  <div class="box-footer">
                    <button type="submit" name="reporte_dia" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
              Reporte de 1 o mas días
            </a>
            <div class="collapse" id="collapseExample2">
              <div class="well">
                Selecciona las del lapso de tiempo que nesesitas
                <form action="" method="post">
                <div class="form-group">
                  <label>Fecha del dia inicio</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="dia_inicio" class="form-control" pattern="\d{2}-\d{2}-\d{4}" title="Por favor ingresa una fecha en formato DD-MM-YYYY"/>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                  <div class="form-group">
                  <label>Fecha del dia final</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="dia_final" class="form-control" pattern="\d{2}-\d{2}-\d{4}" title="Por favor ingresa una fecha en formato DD-MM-YYYY"/>
                    </div><!-- /.input group -->
                  </div><!-- /.form group -->
                  <div class="box-footer">
                    <button type="submit" name="reporte_semana" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-1"></div>
        </div>
        <?php
        //este codigo solo se mostrara si el cliente es buscado por su correo y encontrado con exito//
        if (isset($_POST['reporte_dia'])) {
          date_default_timezone_set('America/Cancun');
          $fecha_reporte = date("d-m-Y");
          $fecha = $_POST['dia'];
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
                            if($id_c <= '0'){
                              ?>
                              <p><b>Venta cancelada</b></p>
                              <?php
                            }else{
                            $cliente = mysqli_query($con, "SELECT * FROM `clientes` WHERE `idCliente` LIKE '$id_c'");
                            $cli = mysqli_fetch_array($cliente);
                            echo$cli['nombre_completo'];
                            }
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
                        <th>Generado el día: <?php echo$fecha_reporte ?></th>
                        <td>$<?php echo number_format($total,2); ?></td>
                      </tr>
                    </table>
                  </div>
                </div><!-- /.col -->
              </div><!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-xs-12">
                  <form action="print_report.php" method="post" target="_blank">
                    <input type="hidden" name="fecha" value="<?php echo$fecha ?>">
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
              <p style="color: white;">Fecha invalida</p>
            </div>
          <?php
          }
        } elseif(isset($_POST['reporte_semana'])) {
          $fecha_reporte = date("d/m/y");
          $fecha_1 = $_POST['dia_inicio'];
          $fecha_2 = $_POST['dia_final'];
          $query = mysqli_query($con, "SELECT * FROM `notacompra` WHERE `fecha_hr` >= '$fecha_1' AND `fecha_hr` <= '$fecha_2'");
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
                        <th>Generado el día: <?php echo$fecha_reporte ?></th>
                        <td>$<?php echo number_format($total,2); ?></td>
                      </tr>
                    </table>
                  </div>
                </div><!-- /.col -->
              </div><!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-xs-12">
                  <form action="print_report.php" method="post" target="_blank">
                    <input type="hidden" name="fecha" value="<?php echo$fecha ?>">
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
              <p style="color: white;">Fecha invalida</p>
            </div>
          <?php
          }
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