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
?>
    <!DOCTYPE html>
    <html>
    <?php include("../admin/head.php"); ?>
    <body class="skin-blue">
        <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Welcome <?php $query=mysqli_query($con, "SELECT * FROM usuarios WHERE `id_usuario` LIKE '$id_usuario'");
                    $x= mysqli_fetch_array($query);
                    echo$x['nombre']; ?></small>
                </h1>
                <!-- Etiquetas para mostrar la "navegación"-->
                <ol class="breadcrumb">
                    <li><a href="../public/inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard</a></li>
                </ol>
            </section>
            <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">

          <div class="col-lg-6 col-xs-12">
            <!--  Notas de venta (crear, mostrar, modificar, eliminar) -->
            <div class="small-box bg-green" style="height: 250px; border-radius: 30px;">
              <div class="inner">
                <?php
                $query=mysqli_query($con, "SELECT * FROM notacompra");
                $con1=mysqli_num_rows($query);
                ?>
                <h3 style="margin: 15px 0px 0px 10px; font-size: 300%;"><?php echo$con1 ?></h3>
                <p style="margin-left:10px; font-size: 150%;">Ventas realizadas</p>
                <h1 style="font-size: 450%; margin: -25px 0px 0px 10px;"><strong>Ventas</strong></h1>
              </div>
              <div class="icon">
                <i class="ion ion-bag" style="scale: 200%; margin: 85px;"></i>
              </div>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-6 col-xs-12">
            <!--Inventario, crear, mostrar, modificar, eliminar. -->
            <div class="small-box bg-yellow" style="height: 250px; border-radius: 30px;">
              <div class="inner">
                <?php
                $query2=mysqli_query($con, "SELECT * FROM productos");
                $con2=mysqli_num_rows($query2);
                ?>
                <h3 style="margin: 15px 0px 0px 10px; font-size: 300%;"><?php echo$con2 ?> pzs</h3>
                <p style="margin-left:10px; font-size: 150%;">Productos existentes</p>
                <h1 style="font-size: 450%; margin: -25px 0px 0px 10px;"><strong>Productos</strong></h1>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars" style="scale: 200%; margin: 85px;"></i>
              </div>
            </div>

          </div><!-- ./col -->
          <div class="col-lg-6 col-xs-12">
            <!-- CLIENTES administrar su información (crear, mostrar, modificar, eliminar) -->
            <div class="small-box bg-aqua" style="height: 250px; border-radius: 30px;">
              <div class="inner">
              <?php
                $query3=mysqli_query($con, "SELECT * FROM clientes");
                $con3=mysqli_num_rows($query3);
                ?>
                <h3 style="margin: 15px 0px 0px 10px; font-size: 300%;"><?php echo$con3 ?></h3>
                <p style="margin-left:10px; font-size: 150%;">Clientes registrados</p>
                <h1 style="font-size: 450%; margin: -25px 0px 0px 10px;"><strong>Clientes</strong></h1>
              </div>
              <div class="icon">
                <i class="ion ion-person-add" style="scale: 200%; margin: 85px;"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-6 col-xs-12">
            <!-- REPORTES DE VENTAS (crear, mostrar, modificar, eliminar) -->
            <div class="small-box bg-red" style="height: 250px; border-radius: 30px;">
            <?php
            $ingresos = 0;
            $sql=mysqli_query($con, "SELECT * FROM notacompra");
            while($col=mysqli_fetch_array($sql)){
                $gan = $col['total_compra'];
                $ingresos += $gan;
            }
            $ganancias = number_format($ingresos, 2);
            ?>
              <div class="inner">
                <h3 style="margin: 15px 0px 0px 10px; font-size: 300%;"><?php echo"$".$ganancias ?></h3>
                <p style="margin-left:10px; font-size: 150%;">Ingresos generales</p>
                <h1 style="font-size: 450%; margin: -25px 0px 0px 10px;"><strong>Ingresos</strong></h1>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph" style="scale: 200%; margin: 85px;"></i>
              </div>
            </div>
          </div><!-- ./col -->
        </div><!-- /.row -->
            </section>
        </div><!-- /.content-wrapper -->
        </div><!-- /.wrapper -->
        <?php include("../admin/footer.php"); ?>
    </body>
    </html>
<?php
}
?>