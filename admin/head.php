<?php
$usuario = mysqli_query($con, "SELECT * FROM `usuarios` WHERE `id_usuario` LIKE '$id_usuario'");
$user = mysqli_fetch_array($usuario);
$nombre = $user['nombre'];
$name_user = $user['nombre_usuario'];
$rol = $user['rol'];
?>

<head>
  <meta charset="UTF-8">
  <title>Frogy_System</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
  <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- FontAwesome 4.3.0 -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons 2.0.0 -->
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. Choose a skin from the css/skins 
  folder instead of downloading all of them to reduce the load. -->
  <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link href="../plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
  <!-- Morris chart -->
  <link href="../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
  <!-- jvectormap -->
  <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
  <!-- Date Picker -->
  <link href="../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
  <!-- Daterange picker -->
  <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
  <!-- bootstrap wysihtml5 - text editor -->
  <link href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
  <!-- datatables -->
  <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" href="text/css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<header class="main-header">
  <!-- Logo -->
  <a href="../public/inicio.php" class="logo"><img src="../img/text/frogy_logoBLANCO.png" height="30px"></a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <!-- Cuenta de usuario-->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="../img/icon/LOGO_frogy.png" class="user-image" alt="User Image" />
            <span class="hidden-xs"><?php echo $nombre ?></span>
          </a>
          <ul class="dropdown-menu">

            <!-- aqui va el modal con la foto del usuario -->
            <li class="user-header">
              <img src="../img/icon/LOGO_frogy.png" class="img-circle" alt="User Image" />
              <p>
                <?php echo $name_user ?>
                <small>@Miembro desde 2023</small>
              </p>
            </li>

            <!-- aquí se pueden incluir la configuracion del user y el sing out-->
            <li class="user-footer">
              <?php
              if ($rol == 'admin') {
              ?>
                <div class="pull-left">
                  <a href="../public/configuracion.php" class="btn btn-default btn-flat">Add user</a>
                </div>
              <?php
              }
              ?>
              <div class="pull-right">
                <a href="../php/logout.php" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<aside class="main-sidebar">
  <section class="sidebar">
    <!-- Panel de usuario de la barra lateral: se puede cambiar la foto y el nombre con
            variables según la sesion iniciada desde php¿-->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="../img/icon/LOGO_frogy.png" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p><?php echo $name_user ?></p>
        <!--Como un plus se le puede agregar el ID de User-->
        <a href="#"><i class="fa fa-circle text-success"></i> ID USER: 01000<?php echo $id_usuario ?></a>
      </div>
    </div>

    <!-- menú de navegación/qw barra lateral -->
    <ul class="sidebar-menu">
      <?php
      if ($rol == 'admin') {
      ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="../public/dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="../public/ventas.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
            <li><a href="../public/data.php"><i class="fa fa-circle-o"></i> Inventario</a></li>
            <li><a href="../public/clientes.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
            <li><a href="../public/reportes.php"><i class="fa fa-circle-o"></i> Reportes</a></li>
            <li><a href="../public/categorias.php"><i class="fa fa-circle-o"></i> Categorias</a></li>
          </ul>
        </li>
      <?php
      }
      ?>
      <li class="treeview">
        <!-- Interfaces -->
        <a href="../public/inicio.php">
          <i class="fa fa-desktop"></i> <span>Home</span>
        </a>
      </li>
      <li class="treeview">
        <a href="../public/clientes.php">
          <i class="ion ion-person-add"></i> <span>Agregar cliente</span>
        </a>
      </li>
      <li class="treeview">
        <a href="../public/productos.php">
          <i class="ion ion-ios-pricetag-outline"></i> <span>Productos</span>
        </a>
      </li>
      <li class="treeview">
        <a href="../public/reportes.php">
          <i class="fa fa-bar-chart-o"></i> <span>Reportes</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>