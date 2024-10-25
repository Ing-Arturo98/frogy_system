<?php
include("conexion.php");
$con = conectar();
if (isset($_POST['agregar'])) {
  $id = $_POST['id'];
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
    mysqli_query($con, "UPDATE `productos` SET `nombre` = '$nombre', `categoria` = '$categoria', `precio` = '$precio', `estatus` = '$estatus', `img` = '$destino' WHERE `productos`.`idProducto` = $id;");
    (move_uploaded_file($tmp_name, $destino));
?>
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-info"></i> Aviso!</h4>
      Producto actualizado con exito
    </div>
  <?php
  } else {
  ?>
    <div class="alert alert-warning alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-info"></i> Alerta!</h4>
      Tipo de archivo no disponible
    </div>
  <?php
  }
}
if (isset($_POST['actualizar_cliente'])) {
  $id = $_POST['id'];
  $nombre = $_POST['nombre'];
  $fechaNac = $_POST['fecha'];
  $codPost = $_POST['postal'];
  $telefono = $_POST['telefono'];
  $correo = $_POST['correo'];
  $ciudad = $_POST['ciudad'];
  $colonia = $_POST['colonia'];
  $calle = $_POST['calle'];
  $numCas = $_POST['numcasa'];

  $query = mysqli_query($con, "UPDATE `clientes` SET `nombre_completo` = '$nombre', `fechaNac` = '$fechaNac', `codPos` = '$codPost', `telefono` = '$telefono', `correo` = '$correo', `ciudad` = '$ciudad', `colonia` = '$colonia', `calle` = '$calle', `num_casa` = '$numCas' WHERE `clientes`.`idCliente` LIKE '$id';");

  if ($query) {
  ?>
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4> <i class="icon fa fa-check">c:</i></h4>
      Datos del cliente actualizados con exito
    </div>
  <?php
    header("Location: ../public/clientes.php");
  } else {
  ?>
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4> <i class="icon fa fa-check"> Alerta!</i></h4>
      Algo salio mal al actualizar los datos
    </div>
  <?php
  }
}

if (isset($_POST['btn'])) {
  $id = $_POST['id'];
  $estatus = $_POST['estatus'];
  if ($estatus == 'activo') {
    $query = mysqli_query($con, "UPDATE `categoria` SET `estatus` = 'inactivo' WHERE `categoria`.`id_categoria` = '$id';");
    header("Location: ../public/categorias.php");
  } elseif ($estatus == 'inactivo') {
    $query = mysqli_query($con, "UPDATE `categoria` SET `estatus` = 'activo' WHERE `categoria`.`id_categoria` = '$id';");
    header("Location: ../public/categorias.php");
  }
}

if (isset($_POST['borrar'])) {
  $id = $_POST['id'];
  $query = mysqli_query($con, "DELETE FROM categoria WHERE `categoria`.`id_categoria` = '$id'");
  header("Location: ../public/categorias.php");
}

if (isset($_POST['actualizar'])) {
  $id = $_POST['id'];
  $name = $_POST['nombre'];
  $sql = mysqli_query($con, "UPDATE `categoria` SET `nombre_categoria` = '$name' WHERE `categoria`.`id_categoria` = '$id';");
  header("Location: ../public/categorias.php");
}

if (isset($_POST['actualizar_producto'])) {
  $id = $_POST['id'];
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
    mysqli_query($con, "UPDATE `productos` SET `nombre` = '$nombre', `categoria` = '$categoria', `precio` = '$precio', `estatus` = '$estatus', `img` = '$destino' WHERE `productos`.`idProducto` = '$id';");
    (move_uploaded_file($tmp_name, $destino));

    header("Location: ../public/data.php");
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