<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bayar extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(['Bayar_model','Inputdata_model','Bulan_model','Tahun_model','Siswa_model']);
        $this->load->helper(['form']);
        $this->load->library(['pdf', 'ceklogin']);

        $this->ceklogin->cek_login();
    }

    public function index(){
        $dataKelas = $this->Bayar_model->get_list_kelas();
        $databulan = $this->Bayar_model->get_list_bulan();
        $datatahun = $this->Bayar_model->get_list_tahun();
        
        $opt = array('' => 'Semua Kelas');
        foreach ($dataKelas as $rowdataKelas) {
             $opt[$rowdataKelas] = $rowdataKelas;
        }

        $optBulan = ['' =>'Semua Bulan'];
        for($i=1; $i <= count($databulan); $i++){
            $optBulan[$i] = $databulan[$i];
        }

        $optTahun = ['' =>'Semua Tahun'];
        for($i=1; $i <= count($datatahun); $i++){
            $optTahun[$i] = $datatahun[$i];
        }

        $ambilStatusbayar = $this->Bayar_model->get_status_bayar();
        for ($i=0; $i < 3 ; $i++) { 
           $dataStatusbayar[$i]['bulan'] = $this->Bulan_model->get($ambilStatusbayar[$i]['bulan'],TRUE);
           $dataStatusbayar[$i]['tahun'] = $this->Tahun_model->get($ambilStatusbayar[$i]['tahun'], TRUE);
           $dataStatusbayar[$i]['lunas'] = $ambilStatusbayar[$i]['lunas'];
           $dataStatusbayar[$i]['belum lunas'] = $ambilStatusbayar[$i]['belum lunas'];
        }
        
        $data['status_bayar'] = $dataStatusbayar;
        $data['form_bulan'] = form_dropdown('',$optBulan,'','id="cari-bulan-kode" class="form-control"');
        $data['form_kelas'] = form_dropdown('',$opt,'','id="cari-kelas-kode" class="form-control"');
        $data['form_tahun'] = form_dropdown('',$optTahun,'','id="cari-tahun-kode" class="form-control"');
        $data['title'] = "Data Bayar";
        $data['breadcrumb'] = ['Data Bayar', 'admin/bayar'];
       
        $header['user'] = $this->session->userdata;
        $header['title'] = "Data Bayar";
        $this->load->view('admin/header', $header);
        $this->load->view('admin/bayar', $data);
        $this->load->view('admin/footer');
    }

    
    public function tes()
    {
        //$this->Bayar_model->get_status_bayar();
        $this->Inputdata_model->data_bayar();
    }
    public function ajax_databayar()
    {
        $dataBayar = $this->Bayar_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($dataBayar as $rowdataBayar) {
            $no++;

            $edit = base_url('admin/bayar/edit/').$rowdataBayar->bayar_id;
            $cetak = base_url('admin/bayar/cetak/').$rowdataBayar->bayar_id;
            $status_bayar = $rowdataBayar->status_bayar == "lunas" ? "LUNAS" : "BELUM LUNAS";
            $tanggal_bayar = $rowdataBayar->status_bayar == "lunas" ? $rowdataBayar->tanggal_bayar : "-";
            $aksi = $rowdataBayar->status_bayar == "lunas" ? "<a href='".$edit."' class='btn btn-danger btn-sm mr-2'>Ganti Status Bayar</a> <a href='".$cetak."' class='btn btn-success btn-sm' target='_blank'>Cetak Kuitansi</a>" : "<a href='".$edit."' class='btn btn-danger btn-sm float-left ml-3'>Ganti Status Bayar</a>";

            $row = array();
            $row[] = $rowdataBayar->siswa_no_identitas;
            $row[] = $rowdataBayar->siswa_nama;
            $row[] = $rowdataBayar->siswa_kelas;
            $row[] = $rowdataBayar->bulan_nama;
            $row[] = $rowdataBayar->tahun_nama;
            $row[] = $status_bayar;
            $row[] = $tanggal_bayar;
            $row[] = $aksi;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Bayar_model->count_all(),
                        "recordsFiltered" => $this->Bayar_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    

    public function edit($id = NULL){

        if($id != NULL){
            $statusBayar = $this->Bayar_model->get($id, TRUE);
            if ($statusBayar != NULL) {
                $dataSiswa = $this->Siswa_model->get($statusBayar->siswa_id, TRUE);

                $data['status_bayar'] = $statusBayar->status_bayar == "lunas" ? "belum" : "lunas";
                $data['tanggal_bayar'] = date("d-m-Y");
                $where = ['bayar_id' => $id];

                $eksekusi = $this->Bayar_model->update($data, $where);
                if($eksekusi['status'] == "sukses"){
                     $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil Update Data ['.$dataSiswa->siswa_no_identitas.' - '.$dataSiswa->siswa_nama.' - '.$dataSiswa->siswa_kelas.']!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('admin/bayar');
                }else if($eksekusi['status'] == "gagal"){
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Update Data !'.$eksekusi['keterangan'].'</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('admin/bayar');
                }
            }
        }else{
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Update Data ! Data tidak ditemukan</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/bayar');
        }
    }

    public function cetak($id){
        $data = $this->Bayar_model->jointabel($id);
        $tanggalSekarang = 'Tgl : '.date("d-m-Y");
        //var_dump($data);die;
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
     
        $pdf->AddPage('');
        
        $pdf->Write(10, $tanggalSekarang, '', 0, 'R', true, 0, false, false, 0);
        $pdf->SetFont('times', 'B|U', 14);
        $pdf->Write(10, 'Bukti Pambayaran SPP', '', 0, 'C', true, 0, false, false, 0);
        
        $pdf->SetFont('times', '', 12);

        $tabel = '
        <table>
        
              <tr>
                    <td> </td>
                    <td></td>
                    <td></td>
              </tr>
              <tr>
                    <td>Telah diterima uang sebesar  </td>
                    <td width="2%">:</td>
                    <td> <b> Rp. 200.000 </b> </td>
              </tr>
              <tr>
                    <td>Guna membayar SPP bulan </td>
                    <td>:</td>
                    <td> <b>'.$data->bulan_nama.' '.$data->tahun_nama.' </b></td>
              </tr>
              <br>
              <tr>
                <td>Dari : </td>
              </tr>
              <tr>
                    <td width="10%"><b>NIS </b></td>
                    <td><b>:</b></td>
                    <td> '.$data->siswa_no_identitas.' </td>
              </tr>
              <tr>
                    <td><b>Nama </b></td>
                    <td><b>:</b></td>
                    <td> '.$data->siswa_nama.'</td>
              </tr>
              <tr>
                    <td><b>Kelas </b></td>
                    <td><b>:</b></td>
                    <td> '.$data->siswa_kelas.' </td>
              </tr>
        </table>
        ';
       $pdf->writeHTML($tabel);
       $pdf->Write(20, 'Petugas Administrasi', '', 0, 'R', true, 0, false, false, 0);
       $pdf->Write(40, 'Balmon          ', '', 0, 'R', true, 0, false, false, 0);
        $pdf->Output('file-pdf-codeigniter.pdf', 'I');    
    }
}