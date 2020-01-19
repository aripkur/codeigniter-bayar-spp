<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['Siswa_model', 'Bayar_model']);
        $this->load->library(['ceklogin']);

        $this->ceklogin->cek_login();
    }

    public function index()
    {
        $dataSession = $this->session->userdata;
        $data['siswa'] = $this->Siswa_model->get_by(['siswa_no_identitas' => $dataSession['user_no_identitas']], 1, NULL, TRUE, NULL);
        $data['bayar'] = $this->Bayar_model->jointabelwhere(['tbl_siswa.siswa_no_identitas' => $dataSession['user_no_identitas']]);

        $header['user'] = $this->session->userdata;
        $header['title'] = "Dashboard";

        $this->load->view('siswa/header', $header);
        $this->load->view('siswa/index', $data);
        $this->load->view('siswa/footer');
    }
}