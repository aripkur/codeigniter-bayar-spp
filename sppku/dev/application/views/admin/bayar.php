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
                <?php for ($i=0; $i < 3 ; $i++) { ?>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="card">
                            <h4 class="card-header bg-primary text-white"><?=$status_bayar[$i]['bulan']->bulan_nama." - ".$status_bayar[$i]['tahun']->tahun_nama?></h4>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th>LUNAS</th>
                                            <th>BELUM LUNAS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td><?=$status_bayar[$i]['lunas']?></td>
                                            <td><?=$status_bayar[$i]['belum lunas']?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            
            
        <?=$this->session->flashdata('pesan')?>
            <div class="card">
                <h4 class="card-header bg-primary text-white">Data Bayar</h4>
                <div class="card-body">
                    <div class="table-responsive">
                    <form id="form-filter">
                                <div class="row"> 
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 p-auto">
                                        <input type="text" id="cari-siswa-nis" class="form-control" placeholder="Cari NIS ..">
                                    </div>
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 p-auto">
                                        <?php echo $form_kelas; ?>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 p-auto">
                                        <?php echo $form_bulan; ?>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 p-auto">
                                        <?php echo $form_tahun; ?>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <label for="LastName" class="control-label"></label>
                                        <button type="button" id="btn-filter" class="btn btn-primary">Tampilkan</button>
                                        <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                                </div>
                            </form>
                            <hr>
                        <table id="tableBayar" class="table table-striped table-bordered first text-center">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Status Bayar</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
