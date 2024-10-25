<?php
//una vez logueado, correctamente, cada pagina debera contar con el apartado de session_start() de esta manera los datos del usuario podran ser usuados con las variables de $_SESSION[''];
session_start();
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
    <?php include("../admin/head.php"); ?>

    <body class="skin-blue">
        <div class="wrapper">
            <!-- barra superior con links de css ubicada en carpeta admin para modificaciones -->
            <?php include("../admin/header.php"); ?>

            <!-- Columna lateral izquierda. contiene el logo y la barra lateral -->
            <?php include("../admin/menu.php"); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        INVENTARIO
                        <small>Configuracion</small>
                    </h1>
                    <!-- Etiquetas para mostrar la "navegación"-->
                    <ol class="breadcrumb">
                        <li><a href="../public/inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    </ol>
                </section>
                
            </div><!-- /.row -->
        </div>
        </div><!-- /.box -->

        </section><!-- right col -->
        </div><!-- /.row (main row) -->

        </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include("../admin/footer.php"); ?>
    </body>

    </html>
<?php
}
?>