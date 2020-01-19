<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <h2 class="pageheader-title"><?=$title?></h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url($breadcrumb[1])?>" class="breadcrumb-link"><?=$breadcrumb[0]?></a> </li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"></a> </li>
                        </ol>
                    </nav>
                </div>
                <hr>
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-inline-block">
                                <h5 class="text-muted">Total Data Siswa</h5>
                                <h2 class="mb-0"> <?=$total_siswa?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                <i class="fa fa-users fa-fw fa-sm text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-inline-block">
                                <h5 class="text-muted">Total Data Bayar</h5>
                                <h2 class="mb-0">  <?=$total_bayar?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                <i class="fa fa-donate fa-fw fa-sm text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-inline-block">
                                <h5 class="text-muted">Total Data Kelas</h5>
                                <h2 class="mb-0">  <?=$total_kelas?></h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                <i class="fa fa-home fa-fw fa-sm text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h4 class="card-header bg-primary text-white">Resume Data Siswa </h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered first text-center">
                                    <tbody>
                                        <tr>
                                            <th colspan="2">Kelas</th>
                                        </tr>
                                        <tr>
                                            <th width=15%>Kelas 7</th>
                                            <td><?=$siswa_kelas_7?></td>
                                        </tr>
                                        <tr>
                                            <th>Kelas 8</th>
                                            <td><?=$siswa_kelas_8?></td>
                                        </tr>
                                        <tr>
                                            <th>Kelas 9</th>
                                            <td><?=$siswa_kelas_9?></td>
                                        </tr>
                                        <tr>
                                            <th>Alumni</th>
                                            <td><?=$siswa_alumni?></td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td><?=$total_siswa?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <table class="table table-bordered first text-center">
                                    <tbody>
                                        <tr>
                                            <th colspan="2">Status Akun</th>
                                        </tr>
                                        <tr>
                                            <th width=30%>Aktif</th>
                                            <td><?=$siswa_akun_aktif?></td>
                                        </tr>
                                        <tr>
                                            <th>Belum Aktif</th>
                                            <td><?=$siswa_akun_belum?></td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td><?=$total_siswa?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h4 class="card-header bg-primary text-white">Resume Data Bayar </h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <?php for ($i=0; $i < 3 ; $i++) { ?>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                    <table class="table table-bordered first text-center">
                                    <tbody>
                                        <tr>
                                            <th colspan="2"><?=$status_bayar[$i]['bulan']->bulan_nama." - ".$status_bayar[$i]['tahun']->tahun_nama?></th>
                                        </tr>
                                        <tr>
                                            <th width=30%>Lunas</th>
                                            <th width=30%>Belum Lunas</th>
                                        </tr>
                                        <tr>
                                            <td><?=$status_bayar[$i]['lunas']?></td>
                                            <td><?=$status_bayar[$i]['belum lunas']?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"> Total = <?=$total_siswa - $siswa_alumni?></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>