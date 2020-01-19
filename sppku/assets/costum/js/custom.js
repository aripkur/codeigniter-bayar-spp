var urle = window.location.href;
$(document).ready(function() {

if(urle === "http://localhost/sppku/admin/bayar"){
    urle = "http://localhost/sppku/admin/bayar";
}else if(urle === "http://localhost/sppku/admin/siswa"){
    urle = "http://localhost/sppku/admin/siswa";
}

    // HALAMAN ADMIN/SISWA
    table1 = $('#tableSiswa').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": urle +"/ajax_datatable",
            "type": "POST",
            "data": function ( data ) {
                data.carikelas = $('#cari-kelas-kode').val();
                data.carisiswastatus = $('#cari-siswa-status').val();
                data.carisiswajeniskelamin = $('#cari-siswa-jenis-kelamin').val();
                data.carinis = $('#cari-siswa-nis').val();
            }
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0, 1, 2, 3, 4, 5 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
    $('#btn-filter').click(function(){ //button filter event click
        table1.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table1.ajax.reload();  //just reload table
    });
    $('#tambahSiswa').on('click', function(){
        $('#siswaModal').modal({
             backdrop: 'static',
             keyboard: false
         });
         $('.modal-body form').attr('action', urle+'/tambah');
         $('.modal-body form')[0].reset();
        $.ajax({
            url: urle+'/ambildatakelas',
            method: 'get',
            dataType: 'json',
            success: function (data) {
                var html= "";
                data.forEach(function(rowData) {
                    html += "<option id=form-siswa-kelas' value='"+rowData.kelas_kode+"'>"+rowData.kelas_nama+"</option>"
                });
                
                $('#form-siswa-kelas').html(html);
            }
        }); 
    });

    $('#generateNIS').click(function(){ 
        $.ajax({
            url: urle+'/ambil_id',
            method: 'get',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if(data == 0){
                    var d = new Date();
                    var n = d.getFullYear().toString().substr(-2);
                    var nis = n + "0000" + (parseInt(data) +1).toString();
                }else{
                    var nis= parseInt(data.siswa_no_identitas) +1;
                }
                 $('#form-siswa-nis').val(nis);
            }
        });
    });



    // =============Halaman Bayar==============
    table2 = $('#tableBayar').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": urle +"/ajax_databayar",
            "type": "POST",
            "data": function ( data ) {
                data.carikelas = $('#cari-kelas-kode').val();
                data.caribulan = $('#cari-bulan-kode').val();
                data.caritahun = $('#cari-tahun-kode').val();
                data.carinis = $('#cari-siswa-nis').val();
            }
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0, 1, 2, 3, 4, 5, 6, 7 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
    $('#btn-filter').click(function(){ //button filter event click
        table2.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table2.ajax.reload();  //just reload table
    });

    // ===================== HALAMAN AKUN
    table3 = $('#tableAkun').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": urle +"/ajax_dataakun",
            "type": "POST",
            "data": function ( data ) {
                data.carikelas = $('#cari-kelas-kode').val();
                data.caristatusakun = $('#cari-status-akun').val();
                data.carinis = $('#cari-siswa-nis').val();
            }
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0, 1, 2, 3, 4 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
    $('#btn-filter').click(function(){ //button filter event click
        table3.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table3.ajax.reload();  //just reload table
    });
    $('#gantipass').click(function(){ 

        console.log("asda");
        var id =$(this).data('id');
        var nama =$(this).data('nama');
        $('.modal-body form #form-user-no-identitas').val(id);
        $('#form-user-nama').val(nama);
    });

});