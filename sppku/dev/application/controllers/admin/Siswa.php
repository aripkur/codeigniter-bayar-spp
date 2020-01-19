<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(['Siswa_model','Kelas_model']);
        $this->load->helper(['form']);
        $this->load->library(['ceklogin']);

        $this->ceklogin->cek_login();
    }

    public function index(){
        $dataKelas = $this->Siswa_model->get_list_kelas();
        
        $opt = array('' => 'Semua Kelas');
        foreach ($dataKelas as $rowdataKelas) {
             $opt[$rowdataKelas] = $rowdataKelas;
        }
 
        $data['form_kelas'] = form_dropdown('',$opt,'','id="cari-kelas-kode" class="form-control"');
        $data['title'] = "Data Siswa";
        $data['breadcrumb'] = ['Data Siswa', 'admin/siswa'];

        $header['user'] = $this->session->userdata;
        $header['title'] = "Data Siswa";
        $this->load->view('admin/header', $header);
        $this->load->view('admin/siswa', $data);
        $this->load->view('admin/footer');
    }
    public function tambah(){
        $post = $this->input->post(NULL,TRUE);

        if(isset($post)){
            $data['siswa_no_identitas'] = $post['form-siswa-nis'];
            $data['siswa_nama'] = $post['form-siswa-nama'];
            $data['siswa_jenis_kelamin'] = $post['form-siswa-jenis-kelamin'];
            
            $data['siswa_kelas'] = $post['form-siswa-kelas'];
            $data['siswa_status'] = 'belum';
            $data['siswa_status_akun'] = 'belum';

            if($this->Siswa_model->insert($data) > 0){
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil tambah Data !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/siswa');
            }else{
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal tambah Data !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/siswa');
            }
        }
    }

    public function ambildatakelas(){
        $dataKelas = $this->Kelas_model->get();
        echo json_encode($dataKelas);
    }

    public function ajax_datatable()
    {
        $dataSiswa = $this->Siswa_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($dataSiswa as $rowdataSiswa) {
            $no++;

            $siswa_id = $rowdataSiswa->siswa_id;
            $hapus = base_url('admin/siswa/hapus/').$siswa_id;
            $edit = base_url('admin/siswa/edit/').$siswa_id;
            $jenis_kelamin = $rowdataSiswa->siswa_jenis_kelamin == "L" ? "Laki-laki" : "Perempuan";
            $status_kelulusan = $rowdataSiswa->siswa_status == "lulus" ? "Lulus" : "Belum Lulus";
            $kelas = $rowdataSiswa->siswa_status == "belum" ? $rowdataSiswa->siswa_kelas : "-";
            //$status_akun = $rowdataSiswa->siswa_status_akun == "aktif" ? "Aktif" : "Belum Aktif";
            

            $row = array();
            $row[] = $rowdataSiswa->siswa_no_identitas;
            $row[] = $rowdataSiswa->siswa_nama;
            $row[] = $kelas;
            $row[] = $jenis_kelamin;
            $row[] = $status_kelulusan;
            $row[] = '<a href="'.$edit.'" class="btn btn-warning btn-sm">Edit</a>  <a href="'.$hapus.'" class="btn btn-danger btn-sm" onClick="return confirm('."'"."Semua data pembayaran (".$rowdataSiswa->siswa_no_identitas." - ".$rowdataSiswa->siswa_nama.") juga akan terhapus. "."Yakin ingin menghapus ?"."'".');">Hapus</a> ';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Siswa_model->count_all(),
                        "recordsFiltered" => $this->Siswa_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ambil_id(){
        $nis_terakhir = $this->Siswa_model->nis_terakhir();
        //var_dump($nis_terakhir);die;
        echo json_encode($nis_terakhir);
    }

    public function tes_tambah(){
        for ($i=0; $i < 100 ; $i++) { 
            $data[$i] = [
                'siswa_no_identitas' =>190301 +$i,
                'siswa_nama' => 'Arif Kurniawan'.$i,
                'siswa_kelas' => '-',
                'siswa_jenis_kelamin' => "L",
                'siswa_status' => "lulus",
                'siswa_status_akun' => "belum"
            ];
        }
        $this->Siswa_model->insert($data, TRUE);
    }
    public function edit($id=NULL){
        if($id != NULL){
            $data['siswarow'] = $this->Siswa_model->get($id, TRUE);
            if($data['siswarow'] != NULL){
                $kelas = $this->Kelas_model->get();

                $options = [];
                foreach($kelas as $kelasrow){
                    $options[$kelasrow->kelas_kode] = $kelasrow->kelas_kode;
                }
                $selected = $data['siswarow']->siswa_kelas;
                $data['kelas'] = form_dropdown('form-siswa-kelas', $options, $selected, 'id="form-siswa-kelas" class="form-control"');
    
                $data['title'] = "Data Siswa";
                $data['breadcrumb'] = ['Data Siswa', 'admin/siswa'];
                $header['user'] = $this->session->userdata;
                $header['title'] = "Edit Data Siswa";
                $this->load->view('admin/header', $header);
                $this->load->view('admin/siswaedit', $data);
                $this->load->view('admin/footer');
            }
            else{
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Update Data ! Data siswa tidak ditemukan</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/siswa');
            }
        }
    }

    public function update(){
        $post = $this->input->post(NULL, TRUE);

        if(isset($post)){
            $data['siswa_nama'] = $post['form-siswa-nama'];
            $data['siswa_jenis_kelamin'] = $post['form-siswa-jenis-kelamin'];
            if ($post['form-siswa-status'] == "lulus") {
                $data['siswa_kelas'] = "-";
            }else{
                $data['siswa_kelas'] = $post['form-siswa-kelas'];
            }
            $data['siswa_status'] = $post['form-siswa-status'];

            $where = ['siswa_id' => $post['form-siswa-id']];
            $dataSiswa = $this->Siswa_model->get($post['form-siswa-id'], TRUE);

            if($data != NULL){
                $eksekusi = $this->Siswa_model->update($data, $where);
                if($eksekusi['status'] == "sukses"){
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil Update Data [ NIS = '.$dataSiswa->siswa_no_identitas.' ] !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('admin/siswa');
                }else if($eksekusi['status'] == "gagal"){
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Update Data !'.$eksekusi['keterangan'].'</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('admin/siswa');
                }
            }
        }
    }
    public function hapus($id){
        $data = $this->Siswa_model->get($id, TRUE);
        if ($data != NULL){
            $eksekusi = $this->Siswa_model->delete($id);
            if($eksekusi['status'] == "sukses"){
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil Hapus Data ['.$data->siswa_no_identitas.' - '.$data->siswa_nama.' - '.$data->siswa_kelas.']!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/siswa');
            }else if($eksekusi['status'] == "gagal"){
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Hapus Data !'.$eksekusi['keterangan'].'</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/siswa');
            } 
        }
        else{
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Hapus Data ! Data siswa tidak ditemukan</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/siswa');
        }
         
    }

    public function tes(){
        var_dump($this->Siswa_model->nis_terakhir());die;
    }
}