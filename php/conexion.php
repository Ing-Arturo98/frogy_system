<?php
     function conectar(){
        $localhost = "localhost";
        $user = "root";
        $pass = "";
        $bd = "frogy";

       $conexion = mysqli_connect($localhost, $user, $pass, $bd);

       return $conexion;

     }
?>