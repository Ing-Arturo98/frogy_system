<?php
include("conexion.php");
$con = conectar();

if (isset($_POST['btn'])) {
    $id = $_POST['id'];
    $estatus = $_POST['btn'];

    if ($estatus == 'Disponible') {
        $query = mysqli_query($con, "UPDATE `productos` SET `estatus` = 'escaso' WHERE `productos`.`idProducto` LIKE $id;");
    } elseif ($estatus == 'Escaso') {
        $query = mysqli_query($con, "UPDATE `productos` SET `estatus` = 'agotado' WHERE `productos`.`idProducto` LIKE $id;");
    } elseif ($estatus == 'Agotado') {
        $query = mysqli_query($con, "UPDATE `productos` SET `estatus` = 'disponible' WHERE `productos`.`idProducto` LIKE $id;");
    }

    header("Location: ../public/productos.php");
}
