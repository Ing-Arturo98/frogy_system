<?php
session_start();

unset($_SESSION['id_usuario']);
unset($_SESSION['nombre']);

session_destroy();

header('Location: ../index.php');
?>