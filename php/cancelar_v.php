<?php
include("conexion.php");
$con= conectar();
if(isset($_POST['cancelar'])){
    $pass= $_POST['contra'];
    $id_nota = $_POST['id_nota'];

    $query = mysqli_query($con, "SELECT * FROM `usuarios` WHERE `contraseña` LIKE '$pass' AND `rol` LIKE 'admin'");
    $band = mysqli_num_rows($query);
    header("Location: ../public/inicio.php");
    if($band >= 1){
        $sqli = mysqli_query($con, "DELETE FROM `notacompra` WHERE `notacompra`.`id_nota` LIKE '$id_nota'");
        header("Location: ../public/inicio.php");
    }
}
?>