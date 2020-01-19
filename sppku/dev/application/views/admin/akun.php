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
                <?=$this->session->flashdata('pesan')?>
            <div class="card">
                <h4 class="card-header bg-primary text-white">Data Akun Siswa</h4>
                <div class="card-body">
                    <div class="table-responsive">
                    <form id="form-filter" class="mt-2">
                                <div class="row"> 
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 p-auto">
                                    <label for="cari-siswa-nis">NIS :</label>
                                        <input type="text" id="cari-siswa-nis" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-4 col-md-12 col-sm-12 p-auto">
                                        <label for="cari-kelas-kode">Kelas :</label>
                                        <?php echo $form_kelas; ?>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-12 col-sm-12 p-auto">
                                        <label for="cari-status-akun">Status Akun :</label>
                                        <?php echo $form_status_akun; ?>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <label for="LastName" class="control-label"></label>
                                        <button type="button" id="btn-filter" class="btn btn-primary">Tampilkan</button>
                                        <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                                </div>
                            </form>
                            <hr>
                        <table id="tableAkun" class="table table-striped table-bordered first text-center">
                            <thead>
                                <tr>
                                    <th width="15%">NIS</th>
                                    <th width="30%">Nama</th>
                                    <th width="10%">Kelas</th>
                                    <th width="15%">Status Akun</th>
                                    <th width="30%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>