<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(['Kelas_model']);
        $this->load->library(['ceklogin']);

        $this->ceklogin->cek_login();
    }

    public function index()
    {
        $data['title'] = "Data Kelas";
        $data['breadcrumb'] = ['Data Kelas', 'admin/kelas'];
        $data['dataKelas'] = $this->Kelas_model->get();

        $header['user'] = $this->session->userdata;
        $header['title'] = "Data Kelas";
        $this->load->view('admin/header', $header);
        $this->load->view('admin/kelas', $data);
        $this->load->view('admin/footer');
    }

    public function tambah(){
        $post = $this->input->post(NULL,TRUE);

        if(isset($post)){
            $data['kelas_kode'] = $post['form-kelas-nama'];
            $data['kelas_nama'] = $post['form-kelas-nama'];

            if($this->Kelas_model->insert($data) > 0){
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil tambah Data !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/kelas');
            }else{
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal tambah Data !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('admin/kelas');
            }
        }
    }

    public function hapus($id)
    {
        if($this->Kelas_model->delete($id) > 0){
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil Hapus Data !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/kelas');
        }else{
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal Hapus Data !</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('admin/kelas');
        }
    }
}