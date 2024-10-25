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
                        Nuevo usuario
                        <small><?php echo $name_user ?></small>
                    </h1>
                    <!-- Etiquetas para mostrar la "navegación"-->
                    <ol class="breadcrumb">
                        <li><a href="../public/inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="../public/configuracion.php"><i class="fa fa-circle-o"></i> Configuraciones</a></li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <section class="col-lg-5 connectedSortable">
                            <?php
                            if (isset($_POST['editar'])) {
                                $id = $_POST['id'];
                                $query = mysqli_query($con, "SELECT * FROM `usuarios` WHERE `id_usuario` LIKE '$id'");
                                $r = mysqli_fetch_array($query);
                            ?>
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">Editar usuario</h3>
                                    </div>
                                    <div class="box-body">
                                        <form action="../php/edicion.php" method="post">
                                            <input type="hidden" name="id_usuario" value="<?php echo $r['id_usuario'] ?>">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="nombre" value="<?php echo $r['nombre'] ?>" placeholder="Nombres y apellidos" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="user" value="<?php echo $r['nombre_usuario'] ?>" placeholder="Nombre de usuario" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa  fa-lock"></i>
                                                    </div>
                                                    <input type="password" class="form-control" name="password" value="<?php echo $r['contraseña'] ?>" placeholder="Contraseña" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-google-plus"></i>
                                                    </div>
                                                    <input type="email" class="form-control" name="email" value="<?php echo $r['correo'] ?>" placeholder="Email" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="telefono" value="<?php echo $r['telefono'] ?>" placeholder="telefono" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-tags"></i>
                                                    </div>
                                                        <select name="rol" class="form-control" required>
                                                            <option value="" selected disabled><?php echo$r['rol'] ?></option>
                                                            <option value="admin">Administrador</option>
                                                            <option value="vendedor">Vendedor</option>
                                                        </select>
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="row">
                                                <div class="col-lg-3"></div>
                                                <div class="col-lg-3">
                                                    <div style="align-items: center;">
                                                        <button type="submit" name="actualizar" class="btn btn-block btn-warning">Actualizar</button>
                                                    </div>
                                                </form>
                                                </div>
                                                <div class="col-lg-3">
                                                    <a href="configuracion.php" class="btn btn-block btn-default">Cancelar</a>
                                                </div>
                                                <div class="col-lg-3"></div>
                                            </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            <?php
                            } else {
                            ?>
                                <div class="box box-success">
                                    <div class="box-header">
                                        <h3 class="box-title">Agregar usuario</h3>
                                    </div>
                                    <div class="box-body">
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="nombre" value="" placeholder="Nombres y apellidos" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="user" value="" placeholder="Nombre de usuario" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa  fa-lock"></i>
                                                    </div>
                                                    <input type="password" class="form-control" name="password" value="" placeholder="Contraseña" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-google-plus"></i>
                                                    </div>
                                                    <input type="email" class="form-control" name="email" value="" placeholder="Email" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="telefono" value="" placeholder="telefono" required />
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-tags"></i>
                                                    </div>
                                                    <select class="form-control" name="rol" required>
                                                        <option value="" selected disabled>Rol</option>
                                                        <option value="admin">Administrador</option>
                                                        <option value="vendedor">Vendedor</option>
                                                    </select>
                                                </div><!-- /.input group -->
                                            </div><!-- /.form group -->
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
                                    </div><!-- /.box-body -->
                                    <?php
                                    if (isset($_POST['agregar'])) {
                                        $name = $_POST['nombre'];
                                        $user = $_POST['user'];
                                        $pass = $_POST['password'];
                                        $email = $_POST['email'];
                                        $tel = $_POST['telefono'];
                                        $rol = $_POST['rol'];

                                        $sql = mysqli_query($con, "SELECT * FROM `usuarios` WHERE `correo` LIKE '$email'");
                                        $num = mysqli_num_rows($sql);
                                        if ($num >= 1) {
                                    ?>
                                            <a href="configuracion.php">
                                            <div class="callout callout-warning">
                                                <h4>Ups!</h4>
                                                <p><b>error 505</b> El correo ingresado ya existe en la base de datos de los usuarios, verifique la información</p>
                                            </div>
                                            </a>
                                    <?php
                                        }else{
                                        $query = mysqli_query($con, "INSERT INTO `usuarios` (`id_usuario`, `nombre`, `nombre_usuario`, `contraseña`, `rol`, `correo`, `telefono`) 
                                        VALUES (NULL, '$name', '$user', '$pass', '$rol', '$email', '$tel');");
                                        }
                                    }
                                    ?>
                                </div><!-- /.box -->
                            <?php
                            }
                            ?>
                        </section>
                        <section class="col-lg-7 connectedSortable">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Bordered Table</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="height: 30px;"><i class="fa fa-lock"></i></th>
                                            <th>usuario</th>
                                            <th>Nombre</th>
                                            <th>correo</th>
                                            <th>telefono</th>
                                            <th style="width: 40px"><span>Actualizar</span></th>
                                            <th style="width: 40px"><span>Borrar</span></th>
                                        </tr>
                                        <?php
                                        $u = mysqli_query($con, "SELECT * FROM usuarios");
                                        while ($row = mysqli_fetch_array($u)) {
                                            $rol = $row['rol'];
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                        if($rol == 'admin'){
                                                            ?>
                                                                <button style="background-color: green; border: none; color:white; border-radius:4px;"><i class="fa fa-user"></i></button>
                                                            <?php
                                                        }
                                                        if($rol == 'vendedor'){
                                                            ?>
                                                                <button style="background-color: blue; border: none; color:white; border-radius:4px;"><i class="fa fa-users"></i></button>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $row['nombre_usuario'] ?></td>
                                                <td><?php echo $row['nombre'] ?></td>
                                                <td><?php echo $row['correo'] ?></td>
                                                <td><?php echo $row['telefono'] ?></td>
                                                <td>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="id" value="<?php echo $row['id_usuario'] ?>">
                                                        <button type="sumbit" name="editar" class="btn btn-block btn-warning btn-xs"><span class="badge bg-yellow"><i class="fa fa-eraser"></i></span></button></form>
                                                </td>
                                                <td>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="id" value="<?php echo $row['id_usuario'] ?>">
                                                        <button type="sumbit" name="borrar" class="btn btn-block btn-danger btn-xs"><span class="badge bg-red"><i class="fa fa-trash-o"></i></span></button></form>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                    <?php
                                    if (isset($_POST['borrar'])) {
                                        $id = $_POST['id'];
                                        $query = mysqli_query($con, "DELETE FROM usuarios WHERE `usuarios`.`id_usuario` LIKE '$id'");
                                    }
                                    ?>
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