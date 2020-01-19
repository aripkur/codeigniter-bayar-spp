<div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h4 class="card-header bg-primary text-white">Detail Siswa </h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first text-center">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?=$siswa->siswa_no_identitas?></td>
                                    <td><?=$siswa->siswa_nama?></td>
                                    <td><?=$siswa->siswa_kelas?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h4 class="card-header bg-primary text-white">Pembayaran SPP</h4>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first text-center">
                            <thead>
                                <tr>
                                    <th width="10%">N0</th>
                                    <th>Bulan - Tahun</th>
                                    <th>Status Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($bayar as $rowBayar) :?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$rowBayar->bulan_nama." - ".$rowBayar->tahun_nama?></td>
                                    <td><?=$rowBayar->status_bayar?></td>
                                </tr>
                                <?php $i++; endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>