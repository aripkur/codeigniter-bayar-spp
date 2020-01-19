<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - <?=$title?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?=base_url()?>/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>/assets/costum/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/datatables/dataTables.bootstrap4.min.css">
    
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
         <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
         <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="../index.html">SPP KU</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top mr-2">
                        <li class="nav-item"> </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><div class="user-avatar-md rounded-circle bg-dark text-center"> <p class="d-block mt-1"><?=strtoupper(substr($user['user_nama'], 0, 1)) ?></p> </div></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"><?=$user['user_nama']?></h5>
                                </div>
                                <a class="dropdown-item" href="<?=base_url('logout')?>"><i class="fas fa-power-off mr-2"></i>Keluar</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
      <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="<?=base_url('admin/dashboard')?>">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item ">
                                <a class="nav-link" href="<?=base_url('admin/dashboard')?>"><i class="fas fa-fw fa-warehouse"></i>Dashboard</a>
                            </li>
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="<?=base_url('admin/akun')?>"><i class="fas fa-fw fa-address-book"></i>Manajemen Akun</a>
                            </li>
                            <li class="nav-divider">
                                Master Data
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url('admin/siswa')?>"><i class="fas fa-fw fa-users"></i>Data Siswa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url('admin/kelas')?>"><i class="fas fa-fw fa-home"></i>Data Kelas</a>
                            </li>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url('admin/bayar')?>"><i class="fas fa-fw fa-donate"></i>Data Bayar</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">