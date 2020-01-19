<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['Siswa_model', 'Bayar_model', 'Kelas_model','User_model']);
        $this->load->helper(['form','string']);
        $this->load->library(['ceklogin']);

        $this->ceklogin->cek_login();
    }

    public function index()
    {
        $dataKelas = $this->Bayar_model->get_list_kelas();
        $opt = array('' => 'Semua Kelas','7' => 'Semua Kelas 7', '8' => 'Semua kelas 8', '9' => 'Semua kelas 9');
        foreach ($dataKelas as $rowdataKelas) {
             $opt[$rowdataKelas] = $rowdataKelas;
        }

        $optstatusakun = array('' => 'Semua Status Akun','aktif' => 'Status Aktif', 'belum' => 'Status Belum Aktif');

        $data['form_kelas'] = form_dropdown('',$opt,'','id="cari-kelas-kode" class="form-control"');
        $data['form_status_akun'] = form_dropdown('',$optstatusakun,'','id="cari-status-akun" class="form-control"');
        $data['title'] = "Manajemen Akun";
        $data['breadcrumb'] = ['Manajemen Akun', 'admin/akun'];

        $header['user'] = $this->session->userdata;
        $header['title'] = "Manajemen Akun";
        $this->load->view('admin/header', $header);
        $this->load->view('admin/akun', $data);
        $this->load->view('admin/footer');
    }

    public function ajax_dataakun()
    {
        $dataSiswa = $this->Siswa_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($dataSiswa as $rowdataSiswa) {
            $no++;

            $siswa_id = $rowdataSiswa->siswa_id;
            $gantipassword = base_url('admin/akun/gantipassword/').$rowdataSiswa->siswa_no_identitas;
            $editnonaktifkan = base_url('admin/akun/edit/n/').$siswa_id;
            $editaktifkan = base_url('admin/akun/edit/a/').$siswa_id;
            $status_akun = $rowdataSiswa->siswa_status_akun == "aktif" ? "Aktif" : "Belum Aktif";
            $kelas = $rowdataSiswa->siswa_status == "belum" ? $rowdataSiswa->siswa_kelas : "Alumni";
            $link = $rowdataSiswa->siswa_status_akun == "aktif" ? '<a href="'.$editnonaktifkan.'" class="btn btn-warning btn-sm">Matikan Akun</a> <a href="'.$gantipassword.'" class="btn btn-info btn-sm">Ganti Password</a>' : '<a href="'.$editaktifkan.'" class="btn btn-success btn-sm">Aktifkan</a>';
            

            $row = array();
            $row[] = $rowdataSiswa->siswa_no_identitas;
            $row[] = $rowdataSiswa->siswa_nama;
            $row[] = $kelas;
            $row[] = $status_akun;
            $row[] = $link;
 
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

    public function edit($jenis = NULL, $id = NULL){
        if(($id != NULL) && ($jenis != NULL) && ($jenis == "n")){
            $data =['siswa_status_akun' => 'belum'];
            $where = ['siswa_id' => $id];
            $tambahUser = 0;
            $dataSiswa = $this->Siswa_model->get($id, TRUE);
            $eksekusi = $this->Siswa_model->update($data, $where);
        }else if(($id != NULL) && ($jenis != NULL) && ($jenis == "a")){
            $data =['siswa_status_akun' => 'aktif'];
            $where = ['siswa_id' => $id];
            $tambahUser = 1;
            $dataSiswa = $this->Siswa_model->get($id, TRUE);
            $eksekusi = $this->Siswa_model->update($data, $where);
        }else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Update Data ! Data tidak ditemukan</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/akun');
        }
        
        

        if(($eksekusi['status'] == "sukses") && ($tambahUser == 1)){
            $pass = random_string('alnum', 6);

            $cekuser_id = $this->User_model->count(['user_no_identitas' => $dataSiswa->siswa_no_identitas]);
            if($cekuser_id > 0){
                $data = [
                    'user_status_akun' => 'aktif'
                ];
                $where = ['user_no_identitas' => $dataSiswa->siswa_no_identitas];
                $eks = $this->User_model->update($data, $where);
                if ($eks['status'] == "sukses"){
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil Mengaktifkan Akun [ NIS = '.$dataSiswa->siswa_no_identitas.' ] !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('admin/akun');
                }else{
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Mengaktifkan Akun !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('admin/akun');
                }
            }else{
                $data = [
                    'user_no_identitas' => $dataSiswa->siswa_no_identitas,
                    'user_nama' => $dataSiswa->siswa_nama,
                    'user_password' =>password_hash($pass, PASSWORD_DEFAULT),
                    'user_group' => 'siswa',
                    'user_status_akun' => 'aktif'
                ];
                $id = $this->User_model->insert($data);
                if ($id > 0){
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil Mengaktifkan Akun [ NIS = '.$dataSiswa->siswa_no_identitas.'- Password = '.$pass.' ] !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('admin/akun');
                }else{
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Mengaktifkan Akun !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('admin/akun');
                }
            }
        }else if(($eksekusi['status'] == "sukses") && ($tambahUser == 0)){
            $data = [
                'user_status_akun' => 'belum'
            ];
            $where = ['user_no_identitas' => $dataSiswa->siswa_no_identitas];
            $eks = $this->User_model->update($data, $where);
            if ($eks['status'] == "sukses"){
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil Mematikan Akun [ NIS = '.$dataSiswa->siswa_no_identitas.' ] !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/akun');
            }else{
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Mematikan Akun !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/akun');
            }
           
        }else{
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Mengaktifkan Akun !'.$eksekusi['keterangan'].'</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/akun');
        }

    }

    public function gantipassword($nis = NULL){
        if($nis != NULL){
            $user = $this->User_model->get_by(['user_no_identitas' => $nis], 1, NULL, TRUE, NULL);
            if($user != NULL){

                $data['dataUser'] = $user;
                $data['title'] = "Manajemen Akun";
                $data['breadcrumb'] = ['Manajemen Akun', 'admin/akun'];
                $header['user'] = $this->session->userdata;
                $header['title'] = "Edit Password";

                $this->load->view('admin/header', $header);
                $this->load->view('admin/gantipassword', $data);
                $this->load->view('admin/footer');
            }
        }
        
    }

    public function updatepassword(){
        $post = $this->input->post(NULL, TRUE);

        if(isset($post)){
            $data =[
                'user_password' => password_hash($post['form-user-pass'], PASSWORD_DEFAULT)
            ];

            $where = ['user_id' => $post['form-user-id']];

            $eksekusi = $this->User_model->update($data, $where);
            if($eksekusi['status'] == "sukses"){
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil Update Data [ NIS = '.$post['form-user-no-identitas'].' - Password Baru = '.$post['form-user-pass'].' ] !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/akun');
            }else if($eksekusi['status'] == "gagal"){
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Update Data !'.$eksekusi['keterangan'].'</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/akun');
            }
        }
    }
}