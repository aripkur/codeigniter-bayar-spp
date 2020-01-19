<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <h2 class="pageheader-title"><?=$title?></h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?=base_url($breadcrumb[1])?>" class="breadcrumb-link"><?=$breadcrumb[0]?></a></li>
                                <li class="breadcrumb-item"><a class="breadcrumb-link">Siswa Edit</a> </li>
                            </ol>
                        </nav>
                    </div>
                    <hr>
            <div class="card">
                <h4 class="card-header bg-primary text-white">Edit Data Siswa</h4>
                <div class="card-body">
                    <form action="<?=base_url('admin/siswa/update')?>" method="post">
                        <input type="hidden" name="form-siswa-id" value="<?=$siswarow->siswa_id?>">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 p-auto">
                            <label for="form-siswa-nama">Nama siswa</label>
                            <input type="text" class="form-control" id="form-siswa-nama" name="form-siswa-nama" value="<?=$siswarow->siswa_nama?>" required>
                        </div>
                        <div class="form-group col-lg-4 col-md-12 col-sm-12 p-auto">
                            <label for="form-siswa-jenis-kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="form-siswa-jenis-kelamin" name="form-siswa-jenis-kelamin">
                                <?php
                                    if($siswarow->siswa_jenis_kelamin == "L"){
                                        $jeniskelamin = "<option id='form-siswa-jenis-kelamin' value='L' selected>Laki - laki</option>
                                        <option id='form-siswa-jenis-kelamin' value='P'>Perempuan</option>";

                                        echo $jeniskelamin;
                                    }else{
                                        $jeniskelamin = "<option id='form-siswa-jenis-kelamin' value='L' >Laki - laki</option>
                                        <option id='form-siswa-jenis-kelamin' value='P' selected>Perempuan</option>";
                                        echo $jeniskelamin;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-md-12 col-sm-12 p-auto">
                            <label for="form-siswa-kelas">Kelas</label>
                            <!-- <select class="form-control" id="form-siswa-kelas" name="form-siswa-kelas"> -->
                                <?=$kelas?>
                            <!-- </select> -->
                        </div>
                        <div class="form-group col-lg-4 col-md-12 col-sm-12 p-auto">
                            <label for="form-siswa-status">Status Kelulusan</label>
                            <select class="form-control" id="form-siswa-status" name="form-siswa-status">
                            <?php
                                    if($siswarow->siswa_status == "lulus"){
                                        $status_lulus = "<option id='form-siswa-status' value='lulus' selected>Sudah Lulus</option>
                                        <option id='form-siswa-status' value='belum'>Belum Lulus</option>";

                                        echo $status_lulus;
                                    }else{
                                        $status_lulus = "<option id='form-siswa-status' value='lulus' >Sudah Lulus</option>
                                        <option id='form-siswa-status' value='belum' selected>Belum Lulus</option>";
                                        echo $status_lulus;
                                    }
                                ?>
                            </select>
                        </div>
                        <br>
                        <hr>
                        <div class="form-group text-center">
                            <label for="LastName" class="control-label"></label>
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>