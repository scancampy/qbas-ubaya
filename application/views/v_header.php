<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>QBAS - QR Based Attendance System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('plugins/select2/css/select2.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('css/adminlte.min.css'); ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>


    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url('dashboard'); ?>" class="brand-link">
      <img src="<?php echo base_url('images/qr-code-white.png'); ?>"
           alt="AdminLTE Logo"
           class="brand-image "
           style="opacity: .8">
      <span class="brand-text font-weight-light">QBAS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url('img/user2-160x160.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo character_limiter($user->full_name, 15); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-header">MENU</li>

                <?php if(@$menu_type =='admin') { ?>
        <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" >
              <li class="nav-item">
                <a href="<?php echo base_url('admin/semester'); ?>" class="nav-link <?php if ($this->uri->segment(2) == 'semester') { echo 'active';  } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Semester</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/course'); ?>" class="nav-link <?php if ($this->uri->segment(2) == 'course') { echo 'active';  } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/student'); ?>" class="nav-link <?php if ($this->uri->segment(2) == 'student') { echo 'active';  } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Student</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/lecturer'); ?>" class="nav-link <?php if ($this->uri->segment(2) == 'lecturer') { echo 'active';  } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Lecturer</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('admin/manageclass'); ?>" class="nav-link <?php if ($this->uri->segment(2) == 'manageclass') { echo 'active';  } ?>">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Manage Class
              </p>
            </a>
          </li>
        <?php } else { ?>
         
          <li class="nav-item">
            <a href="<?php echo base_url('dashboard'); ?>" class="nav-link active">
              <i class="nav-icon fas fa-user-check"></i>
              <p>
                Attendances
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('report'); ?>" class="nav-link">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>
                Report
              </p>
            </a>
          </li>
        <?php } ?>
          <li class="nav-item">
            <a href="<?php echo base_url('dashboard/signout'); ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Sign Out
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
