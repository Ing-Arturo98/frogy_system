<?php
include("conexion.php");
$con = conectar();

if(isset($_POST['actualizar'])){
    $id = $_POST['id_usuario'];
    $name = $_POST['nombre'];
    $user = $_POST['user'];
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $tel = $_POST['telefono'];
    $rol = $_POST['rol'];

    $query = mysqli_query($con, "UPDATE `usuarios` SET `nombre` = '$name', `nombre_usuario` = '$user', `contraseña` = '$pass', `rol` = '$rol', `correo` = '$email', `telefono` = '$tel' WHERE `usuarios`.`id_usuario` = $id;");

    header("Location: ../public/configuracion.php");

}
