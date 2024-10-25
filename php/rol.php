<?php
include("conexion.php");
$con = conectar();

if(isset($_POST['cambio'])){
    $id = $_POST['id'];
    $rol = $_POST['rol'];

    if($rol == 'admin'){
        $query = mysqli_query($con, "UPDATE `usuarios` SET `rol` = 'vendedor' WHERE `usuarios`.`id_usuario` = $id;");
        header("Location: ../public/configuracion.php");
    }else{
        $query = mysqli_query($con, "UPDATE `usuarios` SET `rol` = 'admin' WHERE `usuarios`.`id_usuario` = $id;");
        header("Location: ../public/configuracion.php");
    }
}
?>