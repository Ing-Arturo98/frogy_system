<?php
session_start();
$zonaHorariaGalapagos = new DateTimeZone("Pacific/Galapagos"); // Zona Horaria de las Islas Galápagos
$horaDeseada = new DateTime("17:12", $zonaHorariaGalapagos);
$formato = "Y-m-d H:i:s"; // Formato de fecha y hora (Año-Mes-Día Hora:Minutos:Segundos)
$horaFormateada = $horaDeseada->format($formato);

include("conexion.php");
$con = conectar();
if(isset($_POST['total_carrito'])){
    $id_cliente = $_POST['id_cliente'];
    $total = $_POST['total'];

    $query = mysqli_query($con, "INSERT INTO `notacompra` (`idNota`, `fecha_hr`, `idCliente`, `total`) VALUES (NULL, '$horaFormateada', '$id_cliente', '$total');");

    header("Location: ../public/inprecion.php");
}
?>