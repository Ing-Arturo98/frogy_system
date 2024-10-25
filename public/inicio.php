<?php
//una vez logueado, correctamente, cada pagina debera contar con el apartado de session_start() de esta manera los datos del usuario podran ser usuados con las variables de $_SESSION[''];
session_start();
include("../php/conexion.php");
$con = conectar();
$id_usuario = $_SESSION['id_usuario'];
/*caso contrario, si un usuario quiere ingresar a la pagina sin loguearse escribiendo la url la condicion if no lo dejara
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
      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Comercialización
            <small>Punto de venta</small>
          </h1>
          <!-- Etiquetas para mostrar la "navegación"-->
          <ol class="breadcrumb">
            <li><a href="../public/inicio.php"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>

        <!-- Cajas de acciones: cajas con color y -->
        <section class="content">
          <!-- Small boxes (Stat box) -->

          <!-- Main row -->
          <div class="row">
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-7 connectedSortable">
              <!-- caja AZUL de categorias -->
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                  <!-- Botones de minimizar o cerrar la ventana -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->

                  <i class="glyphicon glyphicon-copy"></i>
                  <h3 class="box-title">
                    Productos
                  </h3>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-lg-10">
                        <form action="" method="post" class="sidebar-form">
                          <div class="input-group">
                            <input type="text" name="buscador" class="form-control" placeholder="Nombre de producto" required />
                            <span class="input-group-btn">
                              <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                          </div>
                        </form>
                      </div>
                      <div class="col-lg-1">
                        <form action="inicio.php" class="sidebar-form">
                          <button href="" class="btn btn-flat"><i class="fa fa-fw fa-eraser"></i></button>
                        </form>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-10">
                        <form action="" method="post" class="sidebar-form" style="border: none;">
                          <div class="input-group">
                            <select class="form-control" required name="id_categoria">
                              <option value="" disabled selected>Busca por categoria</option>
                              <?php
                              $query = mysqli_query($con, "SELECT * FROM `categoria` WHERE `estatus` LIKE 'activo'");
                              while ($row = mysqli_fetch_array($query)) {
                              ?>
                                <option value="<?php echo $row['id_categoria'] ?>"><?php echo $row['nombre_categoria'] ?></option>
                              <?php
                              }
                              ?>
                            </select>
                            <span class="input-group-btn">
                              <button type="submit" name="select" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                          </div>
                        </form>
                      </div>
                    </div>
                    <?php
                    if (isset($_POST['select'])) {
                      $categoria = $_POST['id_categoria'];
                      // Limpia la entrada de l usuario para evitar inyeccion SQL
                      $categoria = mysqli_real_escape_string($con, $categoria);
                      $sql = mysqli_query($con, "SELECT * FROM `productos` WHERE `estatus` != 'agotado' AND `categoria` LIKE '$categoria'");
                      // cuenta el numero de columnas encontradas
                      $cont = mysqli_num_rows($sql);
                      // Condiciono la busqueda para cuando el resultado tenga mas de 1 columna
                      if ($cont >= 1) {
                    ?>
                        <pre style="background-color: white;">
                        <div style="height: 200px;">
                        <table id="example2" class="table table-bordered table-hover" style="color: black;">
                        <thead>
                          <tr>
                            <th><i class="fa fa-picture-o"></i></th>
                            <th>Nombre </th>
                            <th>Categoria</th>
                            <th>precio</th>
                            <th></th>
                          </tr>
                        </thead>
                        <?php
                        while ($row = mysqli_fetch_array($sql)) {
                          $id_categoria = $row['categoria']
                        ?>
                          <tbody>
                            <tr>
                            <td><img src="<?php echo $row['img'] ?>" alt="Imagen 1" height="20px" width="20px" style="cursor: pointer;"></td>
                            <td><?php echo $row['nombre'] ?></td>
                              <td><?php $query = mysqli_query($con, "SELECT * FROM `categoria` WHERE id_categoria LIKE $id_categoria");
                                  $col = mysqli_fetch_array($query);
                                  echo $col['nombre_categoria'] ?></td>
                              <td><?php echo "$" . $row['precio'] ?></td>
                              <td><form action="../php/carrito.php" method="post"><input type="hidden" name="id_producto" value="<?php echo $row['idProducto'] ?>"><input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>"><button type="submit" name="acarrito"><i class="fa fa-shopping-cart"></i> Agregar</button></form></td>
                            </tr>
                          </tbody>
                        <?php
                        }
                        ?>
                        </table>
                        </div>
                    </pre>
                      <?php
                      } else {
                      ?>
                        <div class="alert alert-danger alert-dismissable">
                          <h4><i class="icon fa fa-ban"></i>Ups!!</h4>
                          <p style="color: white;">Categoria vacia</p>
                        </div>
                      <?php
                      }
                    } elseif (isset($_POST['search'])) {
                      $buscador = $_POST['buscador'];
                      // Limpia la entrada del usuario para evitar ataques de inyección SQL
                      $buscador = mysqli_real_escape_string($con, $buscador);
                      // Divide la cadena de búsqueda en palabras separadas por espacios
                      $palabras = explode(" ", $buscador);
                      // Crea la consulta SQL utilizando sentencias preparadas para cada palabra de búsqueda
                      $consulta = "SELECT * FROM `productos` WHERE 1=0"; // Agregar "1=0" para no obtener resultados si no hay palabras clave
                      foreach ($palabras as $palabra) {
                        $consulta .= " OR `nombre` LIKE ? AND `estatus` != 'agotado'";
                      }
                      // Prepara la consulta SQL
                      $stmt = mysqli_prepare($con, $consulta);
                      // Vincula las palabras clave a la consulta SQL con los caracteres de comodín (%)
                      $busqueda = '%' . implode('%', $palabras) . '%';
                      mysqli_stmt_bind_param($stmt, str_repeat('s', count($palabras)), ...array_fill(0, count($palabras), $busqueda));
                      // Ejecuta la consulta SQL preparada
                      mysqli_stmt_execute($stmt);
                      // Obtiene los resultados
                      $resultados = mysqli_stmt_get_result($stmt);
                      $num = mysqli_num_rows($resultados);
                      if ($num >= 1) {
                      ?>
                        <pre class='prettyprint'>
                        <div style="height: 200px;">
                        <table id="example2" class="table table-bordered table-hover" style="color: black;">
                        <thead>
                          <tr>
                            <th><i class="fa fa-picture-o"></i></th>
                            <th>Nombre </th>
                            <th>Categoria</th>
                            <th>precio</th>
                            <th></th>
                          </tr>
                        </thead>
                        <?php
                        while ($row = mysqli_fetch_array($resultados)) {
                          $id_categoria = $row['categoria']
                        ?>
                          <tbody>
                          <tr>
                            <td><img src="<?php echo $row['img'] ?>" alt="Imagen 1" height="15px" style="cursor: pointer;"></td>
                            <td><?php echo $row['nombre'] ?></td>
                              <td><?php $query = mysqli_query($con, "SELECT * FROM `categoria` WHERE id_categoria LIKE $id_categoria");
                                  $col = mysqli_fetch_array($query);
                                  echo $col['nombre_categoria'] ?></td>
                              <td><?php echo "$" . $row['precio'] ?></td>
                              <td><form action="../php/carrito.php" method="post"><input type="hidden" name="id_producto" value="<?php echo $row['idProducto'] ?>"><input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>"><button type="submit" name="acarrito"><i class="fa fa-shopping-cart"></i> Agregar</button></form></td>
                            </tr>
                          </tbody>
                        <?php
                        }
                        ?>
                        </table>
                        </div>
                        </pre>
                      <?php
                      } else {
                      ?>
                        <div class="alert alert-danger alert-dismissable">
                          <h4><i class="icon fa fa-ban"></i>Ups!!</h4>
                          <p style="color: white;">Producto no encontrado</p>
                        </div>
                      <?php
                      }
                    } else {
                      $pro = mysqli_query($con, "SELECT * FROM `productos` WHERE `estatus` != 'agotado'");
                      ?>
                      <pre style="background-color: white;">
                        <div style="height: 200px;">
                        <table id="example2" class="table table-bordered table-hover" style="color: black;">
                        <thead>
                          <tr>
                            <th><i class="fa fa-picture-o"></i></th>
                            <th>Nombre </th>
                            <th>Categoria</th>
                            <th>precio</th>
                            <th></th>
                          </tr>
                        </thead>
                        <?php
                        while ($row = mysqli_fetch_array($pro)) {
                          $id_categoria = $row['categoria'];
                        ?>
                          <tbody>
                            <tr>
                            <td><img src="<?php echo $row['img'] ?>" alt="Imagen 1" height="15px" style="cursor: pointer;"></td>
                            <td><?php echo $row['nombre'] ?></td>
                              <td><?php $query = mysqli_query($con, "SELECT * FROM `categoria` WHERE id_categoria LIKE '$id_categoria'");
                                  $col = mysqli_fetch_array($query);
                                  echo $col['nombre_categoria'] ?></td>
                              <td><?php echo "$" . $row['precio'] ?></td>
                              <td><form action="../php/carrito.php" method="post"><input type="hidden" name="id_producto" value="<?php echo $row['idProducto'] ?>"><input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>"><button type="submit" name="acarrito"><i class="fa fa-shopping-cart"></i> Agregar</button></form></td>
                            </tr>
                          </tbody>
                        <?php
                        }
                        ?>
                        </table>
                        </div>
                    </pre>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
              <!-- /.box -->
            </section>
            <!-- Left col -->
            <section class="col-lg-5 connectedSortable">
              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header" style="background-color: white;">
                  <!-- Botones de minimizar o cerrar la ventana -->
                  <div class="pull-right box-tools">
                    <form action="../php/carrito.php" method="post">
                      <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                      <button type="submit" name="limpiar" class="btn btn-primary btn-sm pull-right">Vaciar <i class="fa fa-trash-o"></i></button>
                    </form>
                  </div>
                  <i class=""></i>
                  <h3 class="box-title" style="color: black;">
                    Ventas
                  </h3>
                  <div class="box-body">
                    <div class="row" style="color: black;">
                      <div class="col-lg-1"></div>
                      <div class="col-lg-10">
                        <?php
                        // mostramos los producto agregados al carrito con la instruccion sql y el ciclo while
                        $carrito = mysqli_query($con, "SELECT * FROM `carrito` WHERE id_usuario LIKE '$id_usuario'");
                        // verificamos que exista mas de un resultado
                        $x = mysqli_num_rows($carrito);
                        if ($x >= 1) {
                          $total = 0;
                        ?>
                          <form id="searchForm" method="post" class="sidebar-form">
                            <div class="input-group">
                              <input type="text" name="buscador" class="form-control" placeholder="Correo de cliente" required />
                              <span class="input-group-btn">
                                <button id='search-btn' type='submit' name='correo' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                          </form>
                          <div class="box">

                            <table class="table table-bordered">
                              <tbody>
                                <tr>
                                  <th style="width: 350px;">Nombre</th>
                                  <th>Precio</th>
                                  <th></th>
                                </tr>
                                <?php
                                //muestra los productos dentrode la ventana carrito, se actualiza conforme se agregar productos al carrito
                                while ($col = mysqli_fetch_array($carrito)) {
                                  $id_producto = $col['id_producto'];
                                  $id_usuario = $col['id_usuario'];
                                ?>
                                  <tr>
                                    <td><?php $sql = mysqli_query($con, "SELECT * FROM `productos` WHERE `idProducto` LIKE '$id_producto'");
                                        $pro = mysqli_fetch_array($sql);
                                        echo $pro['nombre']; ?></td>
                                    <td><?php $sql = mysqli_query($con, "SELECT * FROM `productos` WHERE `idProducto` LIKE '$id_producto'");
                                        $pro = mysqli_fetch_array($sql);
                                        echo $pro['precio']; ?></td>
                                    <td>
                                      <form action="../php/carrito.php" method="post"><input type="hidden" name="id" value="<?php echo $col['id_carrito'] ?>"><input type="submit" name="xcarrito" value="x"></form>
                                    </td>
                                  </tr>
                                <?php
                                  $precio = $pro['precio'];
                                  $total += number_format($precio, 2);
                                  $iva = ($total * 16) / 100;
                                  $paga= $total + $iva;
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                          <table class="table table-bordered">
                            <tr>
                              <tbody>
                                <th style="width: 250px;">
                                  <h5>Precio sin iva</h5>
                                  <h5>IVA</h5>
                                  <h5>Total</h5>
                                </th>
                                <th>
                                  <h5><i class="fa fa-usd"></i> <?php echo $total; ?></h5>
                                  <h5><i class="fa fa-usd"></i> <?php echo $iva; ?></h5>
                                  <h5><i class="fa fa-usd"></i> <?php echo $paga; ?></h5>
                                </th>
                              </tbody>
                            </tr>
                          </table>
                          <div class="row">

                            <?php
                            if (isset($_POST['correo'])) {
                              $buscador = $_POST['buscador'];
                              // Limpia la entrada del usuario para evitar ataques de inyección SQL
                              $buscador = mysqli_real_escape_string($con, $buscador);
                              // Divide la cadena de búsqueda en palabras separadas por espacios
                              $palabras = explode(" ", $buscador);
                              // Crea la consulta SQL utilizando sentencias preparadas para cada palabra de búsqueda
                              $resultados = mysqli_query($con, "SELECT * FROM `clientes` WHERE `correo` LIKE '$buscador'");
                              // Obtiene los resultados
                              $num = mysqli_num_rows($resultados);
                              if ($num >= 1) {
                                $row = mysqli_fetch_array($resultados);
                                $id_cliente = $row['idCliente'];
                            ?>
                                <div class="col-lg-8">
                                  <form action="inprecion.php" method="post">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-money"></i>
                                        </div>
                                        <input type="number" class="form-control" name="pago" step="0.01" placeholder="Recibí" min="<?php echo$paga; ?>" required />
                                      </div><!-- /.input group -->
                                    </div><!-- /.form group precio -->
                                </div>
                                <div class="col-lg-4">
                                  <input type="hidden" name="id_cliente" value="<?php echo $id_cliente ?>">
                                  <button type="submit" name="correo" class="btn btn-block btn-success">Pagar</button>
                                  </form>
                                <?php
                              } else {
                                ?>
                                </div>
                                <div class="col-lg-12">
                                  <a href="inicio.php" class="btn btn-block btn-danger">Inexistente</a>
                                <?php
                              }
                            } else {
                                ?>
                                </div>
                                <div class="col-lg-8">
                                  <form action="inprecion.php" method="post">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-money"></i>
                                        </div>
                                        <input type="number" class="form-control" name="pago" step="0.01" placeholder="Recibí" min="<?php echo$paga; ?>" required />
                                      </div><!-- /.input group -->
                                    </div><!-- /.form group precio -->
                                </div>
                                <div class="col-lg-4">
                                  <button type="submit" name="total_carrito" class="btn btn-block btn-primary">Pagar</button>
                                  </form>
                                <?php
                              }
                                ?>
                                </div>
                          </div><!-- /.box -->
                        <?php
                        } else {
                        ?>
                          <div style="text-align: center;">
                            <h3><i class="fa fa-folder-open-o"></i> Vacio</h3>
                          </div>
                      </div>
                    <?php
                        }
                    ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->

                  <i class="fa fa-map-marker"></i>
                  <h3 class="box-title">
                  Vista Previa del Producto
                  </h3>
                </div>
                <div class="box-body">
                  <div style="height: 285px; width: 100%;">

                    <div id="imagen-grande-container">
                      <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                          <img id="imagen-grande" src="../dist/img/azul.png" alt="Imagen grande" width="280px" height="280px" style="border-radius: 10px;">
                        </div>
                        <div class="col-lg-2"></div>
                      </div>
                    </div>

                  </div>
                </div><!-- /.box-body-->
              </div>
            </section><!-- /.Left col -->
          </div><!-- /.col -->

        </section><!-- right col -->
      </div><!-- /.row (main row) -->
    </div><!-- /.content-wrapper -->

    <?php include("../admin/footer.php"); ?>
    <script>
      // Obtener la referencia al contenedor grande de imagen
      const imagenGrandeContainer = document.getElementById('imagen-grande-container');

      // Obtener todas las imágenes pequeñas dentro de la tabla
      const imagenesPequenas = document.querySelectorAll('table img');

      // Agregar un evento de clic a cada imagen pequeña
      imagenesPequenas.forEach(imagen => {
        imagen.addEventListener('click', () => {
          // Obtener la ruta de la imagen grande desde el atributo src de la imagen pequeña
          const rutaImagenGrande = imagen.src;

          // Mostrar la imagen grande en el contenedor grande
          document.getElementById('imagen-grande').src = rutaImagenGrande;

          // Hacer visible el contenedor grande de la imagen
          imagenGrandeContainer.style.display = 'block';
        });
      });

      // Ocultar el contenedor grande de imagen al hacer clic fuera de él
      imagenGrandeContainer.addEventListener('click', () => {
        imagenGrandeContainer.style.display = 'none';
      });
    </script>
  </body>

  </html>
<?php
}
?>