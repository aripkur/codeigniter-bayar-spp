<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['Siswa_model', 'Bayar_model', 'Kelas_model', 'Bulan_model', 'Tahun_model']);
        $this->load->library(['ceklogin']);

        $this->ceklogin->cek_login();
    }

    public function index()
    {

        $data['total_siswa'] = $this->Siswa_model->count();
        $data['total_bayar'] = $this->Bayar_model->count();
        $data['total_kelas'] = $this->Kelas_model->count();
        $data['siswa_kelas_7'] = $this->Siswa_model->countLike(['siswa_kelas'=> "7",'siswa_status'=> "belum"]);
        $data['siswa_kelas_8'] = $this->Siswa_model->countLike(['siswa_kelas'=> "8", 'siswa_status'=> "belum"]);
        $data['siswa_kelas_9'] = $this->Siswa_model->countLike(['siswa_kelas'=> "9", 'siswa_status'=> "belum"]);
        $data['siswa_alumni'] = $this->Siswa_model->count(['siswa_status'=> "lulus"]);
        $data['siswa_akun_aktif'] = $this->Siswa_model->count(['siswa_status_akun'=> "aktif"]);
        $data['siswa_akun_belum'] = $this->Siswa_model->count(['siswa_status_akun'=> "belum"]);
        $data['total_kelas'] = $this->Kelas_model->count();

        $ambilStatusbayar = $this->Bayar_model->get_status_bayar();
        for ($i=0; $i < 3 ; $i++) { 
           $dataStatusbayar[$i]['bulan'] = $this->Bulan_model->get($ambilStatusbayar[$i]['bulan'],TRUE);
           $dataStatusbayar[$i]['tahun'] = $this->Tahun_model->get($ambilStatusbayar[$i]['tahun'], TRUE);
           $dataStatusbayar[$i]['lunas'] = $ambilStatusbayar[$i]['lunas'];
           $dataStatusbayar[$i]['belum lunas'] = $ambilStatusbayar[$i]['belum lunas'];
        }

        $data['status_bayar'] = $dataStatusbayar;
        $data['title'] = "Dashboard";
        $data['breadcrumb'] = ['Dashboard', 'admin/dashboard'];

        $header['user'] = $this->session->userdata;
        $header['title'] = "Dashboard";
        $this->load->view('admin/header', $header);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer');
    }
}