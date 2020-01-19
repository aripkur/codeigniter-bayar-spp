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
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <h4 class="card-header bg-primary text-white">Tambah Kelas</h4>
                        <div class="card-body">
                            <form action="<?=base_url('admin/kelas/tambah')?>" method="post">
                                <div class="form-group">
                                    <label for="form-kelas-nama">Nama Kelas</label>
                                    <input type="text" class="form-control" name="form-kelas-nama" id="form-kelas-nama" placeholder="Contoh : 7A/8A/9A">
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            
        <?=$this->session->flashdata('pesan')?>
            <div class="card">
                <h4 class="card-header bg-primary text-white">Data Kelas </h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <thead>
                                <?php $i=1; foreach ($dataKelas as $rowKelas) : ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$rowKelas->kelas_nama?></td>
                                        <td><a href="<?=base_url('admin/kelas/hapus/')?><?=$rowKelas->kelas_id?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus ?');">Hapus</a></td>
                                    </tr>
                                <?php $i++; endforeach ?>
                                
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>