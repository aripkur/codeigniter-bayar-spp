<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url()?>/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?= base_url()?>/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url()?>/assets/costum/css/style.css">
    <link rel="stylesheet" href="<?= base_url()?>/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
              <h2>Login</h2>
              <?=$this->session->flashdata('pesan');?>
          </div>
            <div class="card-body">
                <form action="<?=base_url('auth')?>" method="post">
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="no_identitas" name="no_identitas" type="number" placeholder="NIK/NIS" value="<?= set_value('no_identitas');?>" autocomplete="off">
                        <?= form_error('no_identitas', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="password_login" name="password_login" type="password" placeholder="Password">
                        <?= form_error('password_login', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Masuk</button>
                </form>
            </div>
        </div>
        <table class="table table-bordered text-center bg-light">
            <tr>
                <th  colspan="2">DEMO</th>
            </tr>
            <tr>
                <th>NIK/NIS</th>
                <th>Password</th>
            </tr>
            <tr>
                <td>11111</td>
                <td>admin</td>
            </tr>
            <tr>
                <td>190100</td>
                <td>siswaa</td>
            </tr>
        </table>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="<?= base_url()?>/assets/vendor/jquery/jquery.js"></script>
    <script src="<?= base_url()?>/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>