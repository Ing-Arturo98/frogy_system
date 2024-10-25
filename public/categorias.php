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
                        categorias
                        <small>#</small>
                    </h1>
                    <!-- Etiquetas para mostrar la "navegación"-->
                    <ol class="breadcrumb">
                        <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Categorias</a></li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <section class="col-lg-6 connectedSortable">
                            <?php
                            if(isset($_POST['editar'])){
                                $id = $_POST['id'];
                                $x=mysqli_query($con, "SELECT * FROM `categoria` WHERE `id_categoria` = $id");
                                $row=mysqli_fetch_array($x);
                                ?>
                                <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">Editar categoria</h3>
                                </div>
                                <div class="box-body">
                                    <form action="../php/actualizar.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo$id ?>">
                                        <!-- phone mask -->
                                        <div class="form-group">
                                            <label>Nombre:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-tags"></i>
                                                </div>
                                                <input type="text" name="nombre" value="<?php echo$row['nombre_categoria'] ?>" class="form-control" required />
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->

                                        <div class="row">
                                            <div class="col-lg-3">
                                            <button type="submit" name="actualizar" class="btn btn-success"><i class="fa fa-refresh"></i> Actualizar</button>
                                            </div>
                                            </form>
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-3">
                                            <a href="categorias.php" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</a>
                                            </div>
                                            <div class="col-lg-3"></div>
                                        </div>
                            </div><!-- /.box-body -->
                                <?php
                            }else{
                            ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Agregar categoria</h3>
                                </div>
                                <div class="box-body">
                                    <form action="" method="post">
                                        <!-- phone mask -->
                                        <div class="form-group">
                                            <label>Nombre:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-tags"></i>
                                                </div>
                                                <input type="text" name="nombre" class="form-control" required />
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->

                                        <!-- phone mask -->
                                        <div class="form-group">
                                            <label>Estatus:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-unsorted"></i>
                                                </div>
                                                <select name="estatus" class="form-control" required>
                                                    <option value="" disabled selected></option>
                                                    <option value="activo">Activo</option>
                                                    <option value="inactivo">Inactivo</option>
                                                </select>
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->

                                        <div">
                                            <button type="submit" name="agregar" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Agregar</button>
                                        </div>
                                </form>
                            </div><!-- /.box-body -->
                            <?php
                            if(isset($_POST['agregar'])){
                                $name = $_POST['nombre'];
                                $estatus = $_POST['estatus'];
                                $sql=mysqli_query($con, "INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `estatus`) VALUES (NULL, '$name', '$estatus');");
                            }
                            }
                            ?>
                        </section>
                        <section class="col-lg-6 connectedSortable">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Tabla de categorias</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre categoria</th>
                                                <th>Estatus</th>
                                                <th style="width: 30px;">Editar</th>
                                                <th style="width: 30px;">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($con, "SELECT * FROM categoria");
                                            while ($row = mysqli_fetch_array($query)) {
                                                $estatus = $row['estatus'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['id_categoria'] ?></td>
                                                    <td><?php echo $row['nombre_categoria'] ?></td>
                                                    <td style="width: 30px;">
                                                        <?php
                                                        if ($estatus == 'activo') {
                                                        ?>
                                                            <form action="../php/actualizar.php" method="post">
                                                                <input type="hidden" name="id" value="<?php echo $row['id_categoria'] ?>">
                                                                <input type="hidden" name="estatus" value="activo">
                                                                <button type="submit" name="btn" class="btn btn-block btn-success btn-xs">Activo</button>
                                                            </form>
                                                        <?php
                                                        } elseif ($estatus == 'inactivo') {
                                                        ?>
                                                            <form action="../php/actualizar.php" method="post">
                                                                <input type="hidden" name="id" value="<?php echo $row['id_categoria'] ?>">
                                                                <input type="hidden" name="estatus" value="inactivo">
                                                                <button type="submit" name="btn" class="btn btn-block btn-danger btn-xs">Inactivo</button>
                                                            </form>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="align-items: center;">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="id" value="<?php echo $row['id_categoria'] ?>">
                                                            <button type="submit" name="editar" class="btn btn-default"><i class="fa fa-edit"></i></button>
                                                        </form>
                                                    </td>
                                                    <td style="align-items: center;">
                                                        <form action="../php/actualizar.php" method="post">
                                                            <input type="hidden" name="id" value="<?php echo $row['id_categoria'] ?>">
                                                            <button type="submit" name="borrar" class="btn btn-default"><i class="fa fa-trash-o"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
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