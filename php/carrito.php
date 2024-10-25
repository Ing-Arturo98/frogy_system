<?php
include("../php/conexion.php");
$con = conectar();
if(isset($_POST['xcarrito'])){
    $id = $_POST['id'];

    $query = mysqli_query($con, "DELETE FROM `carrito` WHERE `carrito`.`id_carrito` LIKE $id");

    header("Location: ../public/inicio.php");
}
if(isset($_POST['acarrito'])){
    $id_usuario = $_POST['id_usuario'];
    $id_producto = $_POST['id_producto'];

    $query = mysqli_query($con, "INSERT INTO `carrito` (`id_producto`, `id_usuario`, `id_carrito`) VALUES ('$id_producto', '$id_usuario', NULL);");

    header("Location: ../public/inicio.php");
}
if(isset($_POST['limpiar'])){
    $id = $_POST['id_usuario'];

    $query = mysqli_query($con, "DELETE FROM `carrito` WHERE `carrito`.`id_usuario` LIKE $id");

    header("Location: ../public/inicio.php");
}
?>