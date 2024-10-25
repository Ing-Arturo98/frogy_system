 <?php
/*sesion_start(), nos ayuda a guardar y recuperar datos de una sesion a traves de las
cookies  un identificador de sesion en un URL*/
session_start();
//agrego la conexxion de base de datos atraves de un include y con la variable $con;
include("php/conexion.php");
$con = conectar();
/*condicion para verificar que la sesion este iniciada, en este pequeña linea, la condicion le hace saber al servidor
que si hay una sesion habilitada, no me dejara visualizar nada en el login, no importa si se escribe en la url, directamente 
me enviara a la pagina de inicio*/
if (isset($_SESSION['id_usuario'])) {
    header("Location: public/inicio.php");
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Frogy_System</title>
        <link rel="stylesheet" href="css/login/style.css">
    </head>
    <body>
        <!-- Form-->
        <div class="form">
            <div class="form-toggle"></div>
            <div class="form-panel one">
                <div class="form-header">
                    <h1>Account Login</h1>
                </div>
                <div class="form-content">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="username">Correo</label>
                            <input id="username" type="gmail" name="usuario" required="required" />
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input id="password" type="password" name="password" required="required" />
                        </div>
                        <div class="form-group">
                            <label class="form-remember">
                                <input type="checkbox" />Recuerdame
                        </div>
                        <div class="form-group">
                            <button type="submit" name="ingresar">Log In</button>
                        </div>
                    </form>
                </div><br>
                <?php
                /*codigo para verificar al usuario con el login, y para iniciar sesion con las variables de $_SESSION['']*/
                if (isset($_POST['ingresar'])) {
                    $usuario = $_POST['usuario'];
                    $pass = $_POST['password'];

                    $query = mysqli_query($con, "SELECT * FROM `usuarios` WHERE `correo` LIKE '$usuario' AND `contraseña` LIKE '$pass'");
                    $contar = mysqli_num_rows($query);
                    //la consulta SQL solo debe mostrar un resultado, ya que al ser un login, no hay datos iguales 2 veces, 
                    if ($contar  == 1) {
                        /*el ciclo while me esta mstrando el arreglo de datos que se encuentran dentro de la consulta SQL
                        con la condicion de que tienen que coincidir los datos de nombre y contraseña*/
                        while ($row = mysqli_fetch_array($query)) {

                            if ($correo = $row['correo'] && $pass = $row['contraseña']) {
                                /*Si la condicion se cumplio el usuario ingresara al punto de venta a travez de un header("Location") 
                                y a su vez le estoy declarando todas las variables de $_SESSION[''] que estoy por usar, es decir 
                                el arreglo de los datos del usuario que ingreso*/
                                $_SESSION['id_usuario'] = $row['id_usuario'];
                                $_SESSION['nombre'] = $row['nombre'];
                                $_SESSION['correo'] = $row['correo'];
                                $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                                $_SESSION['contraseña'] = $row['contraseña'];
                                $_SESSION['rol'] = $row['rol'];
                                
                                if($_SESSION['rol'] == 'admin'){
                                header("Location: public/Dashboard.php");
                                }else{
                                    header("Location: public/inicio.php");
                                }
                            }
                        }
                    } else {
                    //si el login de los datos fue error se mostrar el mensage siguiente
                ?>
                <center>
                    <p style="background-color: rgb(206, 0, 0); color:white; padding: 1rem 1rem; margin: 5px 10px; border-radius: 5px;">Usuario inexistente, verifique sus datos ingresados</p>
                </center>
                <?php
                        header("Refresh: 2; url= index.php");
                    }
                }
                ?>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
<?php
}
?>
</html>