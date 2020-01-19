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
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h4 class="card-header bg-primary text-white">Tampilkan Berdasarkan</h4>
                        <div class="card-body">
                            <form id="form-filter">
                                <div class="row">
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 p-auto">
                                        <input type="text" id="cari-siswa-nis" class="form-control" placeholder="Cari NIS ..">
                                    </div> 
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 p-auto">
                                        <?php echo $form_kelas; ?>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 p-auto">
                                        <select class="form-control" id="cari-siswa-jenis-kelamin">
                                            <option id="cari-siswa-jenis-kelamin" value="">Semua Jenis Kelamin</option>
                                            <option id="cari-siswa-jenis-kelamin" value="L">Laki-laki</option>
                                            <option id="cari-siswa-jenis-kelamin" value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 p-auto">
                                        <select class="form-control" id="cari-siswa-status">
                                            <option id="cari-siswa-status" value="">Semua Status Kelulusan</option>
                                            <option id="cari-siswa-status" value="lulus">Lulus</option>
                                            <option id="cari-siswa-status" value="belum">Belum lulus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <label for="LastName" class="control-label"></label>
                                        <button type="button" id="btn-filter" class="btn btn-primary">Tampilkan</button>
                                        <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            
        <?=$this->session->flashdata('pesan')?>
            <div class="card">
                <h4 class="card-header bg-primary text-white">Data Siswa <button id="tambahSiswa" class="btn btn-dark float-right"  data-toggle="modal" data-target="#siswaModal">Tambah Data</button></h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableSiswa" class="table table-striped table-bordered first text-center">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status Kelulusan</th>
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
 <!-- Modal -->
 <div class="modal fade" id="siswaModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="ModalLabel">Tambah Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?=base_url('/admin/siswa/tambah')?>" method="post">
            <input type="hidden" name="form-siswa-id" id="form-siswa-id">
                <div class="form-group">
                    <label for="form-siswa-nis">NIS</label>
                    <div class="row">
                        <input type="text" class="form-control col-6 ml-3" id="form-siswa-nis" name="form-siswa-nis">
                        <button id="generateNIS" class="btn btn-warning btn-sm col-5 ml-2">Generate NIS</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="form-siswa-nama">Nama siswa</label>
                    <input type="text" class="form-control" id="form-siswa-nama" name="form-siswa-nama" required>
                </div>
                <div class="form-group">
                    <label for="form-siswa-jenis-kelamin">Jenis Kelamin</label>
                    <div class="row">
                        <select class="form-control col-6 ml-3" id="form-siswa-jenis-kelamin" name="form-siswa-jenis-kelamin">
                            <option id="form-siswa-jenis-kelamin" value="L">Laki-laki</option>
                            <option id="form-siswa-jenis-kelamin" value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="form-siswa-kelas">Kelas</label>
                    <div class="row">
                        <select class="form-control col-6 ml-3" id="form-siswa-kelas" name="form-siswa-kelas">
                            <option id="form-siswa-kelas" value="">Load Data ...</option>
                        </select>
                    </div>
                </div>
            

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Tambah Data</button>
      </div>
      </form>
    </div>
  </div>
</div>
