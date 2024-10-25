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