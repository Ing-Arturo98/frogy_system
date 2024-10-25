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
                    Ventas
                    <small>#</small>
                </h1>
                <!-- Etiquetas para mostrar la "navegación"-->
                <ol class="breadcrumb">
                    <li><a href="../public/inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="../public/ventas.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <section class="col-lg-7 connectedSortable">
                    </section>
                    <section class="col-lg-5 connectedSortable">
                    </section>
                </div>
            </section>
        </div><!-- /.content-wrapper -->
        </div><!-- /.wrapper -->
        <?php include("../admin/footer.php"); ?>
    </body>
    </html>
<?php
}
?>