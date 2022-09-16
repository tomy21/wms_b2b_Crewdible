<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>/dist/img/favicon.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <title>BMI Project | Crewdible</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?= base_url() ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- jQuery -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-success navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-danger elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="<?= base_url() ?>/dist/img/logocrew.png" alt="Logo Crewdible" width="100%"
                    style="object-fit:fill;">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>/dist/img/<?= user()->foto; ?>" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= user()->username; ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->

                <?php if (in_groups('admin')) : ?>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-header">Master</li>
                        <li class="nav-item">
                            <a href="<?= site_url('main/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-laptop"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('UploadPo/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-upload"></i>
                                <p>
                                    Upload PO
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Stock/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>
                                    Stock
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Invoice/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Upload Order
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">Warehouse</li>
                        <li class="nav-item">
                            <a href="<?= site_url('Inbound/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>
                                    Inbound Receiving
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('basket/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>
                                    Basket
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Assign/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-cart-arrow-down"></i>
                                <p>
                                    Picklist Assignment
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Picking/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-box"></i>
                                <p>
                                    Picking
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Sorting/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-sort"></i>
                                <p>
                                    Sorting
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Packing/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-square"></i>
                                <p>
                                    Packing
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Handover/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-motorcycle"></i>
                                <p>
                                    Handover
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('ReturnItem/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-file-archive"></i>
                                <p>
                                    Return Order
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">Utility</li>
                        <li class="nav-item">
                            <a href="<?= site_url('Users/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p class="text">Daftar Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Karyawan/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p class="text">Daftar karyawan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('MasterWarehouse/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-industry"></i>
                                <p class="text">Daftar Warehouse</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('laporan/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p class="text">Report</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('login/keluar'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p class="text">Sign Out</p>
                            </a>
                        </li>
                    </ul>
                </nav>

                <?php elseif (in_groups('warehouse')) : ?>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-header">Warehouse</li>
                        <li class="nav-item">
                            <a href="<?= site_url('Stock/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>
                                    Stock
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('basket/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>
                                    Basket
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Assign/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-cart-arrow-down"></i>
                                <p>
                                    Picklist Assignment
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Picking/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-box"></i>
                                <p>
                                    Picking
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Sorting/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-sort"></i>
                                <p>
                                    Sorting
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('Packing/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-square"></i>
                                <p>
                                    Packing
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('ReturnItem/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-file-archive"></i>
                                <p>
                                    Return Order
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Karyawan/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p class="text">Daftar karyawan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('login/keluar'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p class="text">Sign Out</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php elseif (in_groups('seller')) : ?>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?= site_url('main/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-laptop"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('UploadPO/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-upload"></i>
                                <p>
                                    Upload PO
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Stock/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>
                                    Stock
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('invoice/index'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Upload Order
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
                <!-- /.sidebar-menu -->
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <?= $this->renderSection('judul') ?>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <?= $this->renderSection('subjudul') ?>
                <?= $this->renderSection('isi') ?>

                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="https://tomy21.com">
                    Tomy Agung Saputro</a>.</strong>

        </footer>

        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url() ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    // $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= base_url() ?>/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= base_url() ?>/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="<?= base_url() ?>/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= base_url() ?>/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= base_url() ?>/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url() ?>/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url() ?>/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?= base_url() ?>/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url() ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/dist/js/adminlte.js"></script>
    <!-- DataTables  & Plugins -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/plugins/select2/js/select2.full.min.js"></script>
    <script>
    let log_off = new Date();
    log_off.setSeconds(log_off.getSeconds() + 600)
    log_off = new Date(log_off)

    let int_logoff = setInterval(function() {
        let now = new Date();
        if (now > log_off) {
            window.location.assign("<?= base_url() ?>/login/keluar");
            clearInterval(int_logoff);
        }
    }, 30000)


    $('body').on('click', function() {
        log_off = new Date()
        log_off.setSeconds(log_off.getSeconds() + 600)
        log_off = new Date(log_off)
        console.log(log_off)
    })
    </script>


</body>

</html>