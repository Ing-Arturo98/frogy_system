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
            Inventario
            <small>Productos</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="../public/inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Inventario</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <?php
              if (isset($_POST['editar'])) {
              ?>
                <div class="box">
                  <div class="box-header">
                    <?php
                    $id = $_POST['id'];
                      $query = mysqli_query($con, "SELECT * FROM `productos` WHERE `idProducto` LIKE '$id';");
                      $row=mysqli_fetch_array($query);
                    ?>
                      <form action="../php/actualizar.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo$id ?>">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-tag"></i>
                          </div>
                          <input type="text" class="form-control" name="nombre" value="<?php echo$row['nombre'] ?>" placeholder="Nombres del producto" required />
                        </div><!-- /.input group -->
                      </div><!-- /.form group nombre-->
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-bookmark"></i>
                          </div>
                          <select class="form-control" name="categoria" required>
                            <?php
                              $id_categoria = $row['categoria'];
                              $sqli = mysqli_query($con, "SELECT * FROM `categoria` WHERE `id_categoria` LIKE '$id_categoria'");
                              $col = mysqli_fetch_array($sqli);
                            ?>
                            <option value="" selected disabled><?php echo$col['nombre_categoria'] ?></option>
                            <?php
                            $cat = mysqli_query($con, "SELECT * FROM `categoria` WHERE `estatus` LIKE 'activo'");
                            while ($col = mysqli_fetch_array($cat)) {
                            ?>
                              <option value="<?php echo $col['id_categoria'] ?>"><?php echo $col['nombre_categoria'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div><!-- /.input group -->
                      </div><!-- /.form group categoria -->
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-money"></i>
                          </div>
                          <input type="number" class="form-control" name="precio" value="<?php echo$row['precio'] ?>" id="miInput" step="0.01" placeholder="Precio" required />
                        </div><!-- /.input group -->
                      </div><!-- /.form group precio -->
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-picture-o"></i>
                          </div>
                          <input type="file" id="exampleInputFile" class="form-control" name="img" required>
                        </div>
                        <p class="help-block">Al editar el contenido de un producto es nesesario actualizar la fotografia del producto</p>
                      </div><!-- form group img -->
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-tasks"></i>
                          </div>
                          <select class="form-control" name="estatus" required>
                            <option value="" selected disabled><?php echo$row['estatus'] ?></option>
                            <option value="disponible">Disponible</option>
                            <option value="escaso">Escaso</option>
                            <option value="agotado">Agotado</option>
                          </select>
                        </div><!-- /.input group estatus-->
                      </div><!-- /.form group -->
                      <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-2">
                          <div>
                            <button type="submit" name="actualizar_producto" class="btn btn-success">Actualizar <i class="fa fa-save"></i></button>
                          </div>
                      </form>
                        </div>
                        <div class="col-lg-3">
                          <a href="data.php" class="btn btn-default">Cancelar</a>
                        </div>
                        <div class="col-lg-3"></div>
                      </div>
                    
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <div class="container">
                    <div class="row">
                      <div class="col-xs-10">
                        <h3 class="box-title">Tabla general de productos</h3>
                      </div>
                      <div class="col-xs-1">
                        <div style="margin: 0px 0px 0px 40px;">
                          <button class="btn btn-success" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-plus"></i>
                          </button>
                        </div>
                      </div>
                    </div>

                  </div>

                </div><!-- /.box-header -->

                <div class="collapse" id="collapseExample">
                  <div class="well">
                    <form action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-tag"></i>
                          </div>
                          <input type="text" class="form-control" name="nombre" value="" placeholder="Nombres del producto" required />
                        </div><!-- /.input group nombre-->
                      </div><!-- /.form group -->
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-bookmark"></i>
                          </div>
                          <select class="form-control" name="categoria" required>
                            <option value="" selected disabled>categoria</option>
                            <?php
                            $cat = mysqli_query($con, "SELECT * FROM `categoria` WHERE `estatus` LIKE 'activo'");
                            while ($col = mysqli_fetch_array($cat)) {
                            ?>
                              <option value="<?php echo $col['id_categoria'] ?>"><?php echo $col['nombre_categoria'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div><!-- /.input group -->
                      </div><!-- /.form group categoria -->
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-money"></i>
                          </div>
                          <input type="number" class="form-control" name="precio" value="" id="miInput" step="0.01" placeholder="Precio" required />
                        </div><!-- /.input group -->
                      </div><!-- /.form group precio -->
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-picture-o"></i>
                          </div>
                          <input type="file" id="exampleInputFile" class="form-control" name="img">
                        </div>
                        <p class="help-block">Selecciona la imagen adecuada a tu producto</p>
                      </div><!-- form group img -->
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-tasks"></i>
                          </div>
                          <select class="form-control" name="estatus" required>
                            <option value="" selected disabled>Estatus</option>
                            <option value="disponible">Disponible</option>
                            <option value="escaso">Escaso</option>
                            <option value="agotado">Agotado</option>
                          </select>
                        </div><!-- /.input group estatus-->
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
                  </div>
                </div>
                <?php
                if (isset($_POST['agregar'])) {
                  $nombre = $_POST['nombre'];
                  $categoria = $_POST['categoria'];
                  $precio = $_POST['precio'];
                  $estatus = $_POST['estatus'];
                  $img = $_FILES['img'];
                  $directorioDestino = "../img/productos";
                  $tmp_name = $img['tmp_name'];

                  $img_file = $img['name'];
                  $img_type = $img['type'];
                  //L funcion strops busca dentro del arreglo el tipo de archivo y al encontrar un tipo de archivo dej 
                  //iniciar el proceso de insertar a la base de datos, en caso de ser un tipo de datos no permitido
                  //la condicion no se cumplira y no se agregar a la base de datos
                  if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") ||
                    strpos($img_type, "jpg") || strpos($img_type, "png")))) {
                    //si se cumple el tipo de archivo se realiza la operacion
                    $destino = $directorioDestino . '/' . $img_file;
                    mysqli_query($con, "INSERT INTO `productos` (`idProducto`, `nombre`, `categoria`, `precio`, `estatus`, `img`) VALUES (NULL, '$nombre', '$categoria', '$precio', '$estatus', '$destino');");
                    (move_uploaded_file($tmp_name, $destino));
                  } else {
                ?>
                    <div class="alert alert-info alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-info"></i> Alerta!</h4>
                      Tipo de archivo no disponible
                    </div>
                <?php
                  }
                }
                ?>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th><i class="fa fa-picture-o"></i></th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Estatus</th>
                        <th>Editar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = mysqli_query($con, "SELECT * FROM `productos`");
                      while ($row = mysqli_fetch_array($query)) {
                        $estatus = $row['estatus'];
                        $num_categoria = $row['categoria'];
                      ?>
                        <tr>
                          <td><img src="<?php echo $row['img'] ?>" alt="Imagen 1" height="15px" style="cursor: pointer;"></td>
                          <td><?php echo $row['nombre'] ?></td>
                          <td>
                            <?php
                            $sql = mysqli_query($con, "SELECT * FROM `categoria` WHERE `id_categoria` = $num_categoria");
                            $col = mysqli_fetch_array($sql);
                            echo $col['nombre_categoria']
                            ?>
                          </td>
                          <td><?php echo $row['precio'] ?></td>
                          <td>
                            <?php
                            if ($estatus == 'disponible') {
                            ?>
                              <span class="label label-success">Disponible</span>
                            <?php
                            } elseif ($estatus == 'agotado') {
                            ?>
                              <span class="label label-danger">Agotado</span>
                            <?php
                            } elseif ($estatus == 'escaso') {
                            ?>
                              <span class="label label-warning">Escaso</span>
                            <?php
                            }
                            ?>
                          </td>
                          <td>
                            <form action="" method="post">
                              <input type="hidden" name="id" value="<?php echo $row['idProducto'] ?>">
                              <button name="editar" type="submit"><i class="fa fa-pencil-square-o"></i> Edit</button>
                            </form>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Estatus</th>
                        <th>Editar</th>
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