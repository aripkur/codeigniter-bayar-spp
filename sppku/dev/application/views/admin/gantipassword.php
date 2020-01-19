<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <h2 class="pageheader-title"><?=$title?></h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?=base_url($breadcrumb[1])?>" class="breadcrumb-link"><?=$breadcrumb[0]?></a></li>
                                <li class="breadcrumb-item"><a class="breadcrumb-link">Ganti Password</a> </li>
                            </ol>
                        </nav>
                    </div>
                    <hr>
            <div class="card">
                <h4 class="card-header bg-primary text-white">Edit Password</h4>
                <div class="card-body">
                    <form action="<?=base_url('/admin/akun/updatepassword')?>" method="post">
                        <input type="hidden" name="form-user-id" value="<?=$dataUser->user_id?>">
                        <div class="form-group">
                            <label for="form-user-no-identitas">NIS</label>
                            <input type="text" class="form-control" id="form-user-no-identitas" name="form-user-no-identitas" value="<?=$dataUser->user_no_identitas?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="form-user-nama">Nama siswa</label>
                            <input type="text" class="form-control" id="form-user-nama" name="form-user-nama" value="<?=$dataUser->user_nama?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="form-user-pass">Password Baru</label>
                            <input type="text" class="form-control" id="form-user-pass" name="form-user-pass">
                        </div>
                        <br>
                        <hr>
                        <div class="form-group text-center">
                            <label for="LastName" class="control-label"></label>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>