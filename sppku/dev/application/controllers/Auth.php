<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['User_model']);
        $this->load->library(['form_validation','ceklogin']);

        $this->ceklogin->cek_login();
    }

    
    public function index(){
        $this->form_validation->set_rules('no_identitas', 'No Identitas', 'trim|required', ['required' => 'Masukan no identitas dengan benar']);
        $this->form_validation->set_rules('password_login', 'Password', 'trim|required', ['required' => 'Masukan password']);
        if($this->form_validation->run() === FALSE){
            $this->load->view('login');
        }else{
            $this->_login();
        }
    }

    private function _login()
    {
        $post = $this->input->post(NULL,TRUE);
        if(isset($post['no_identitas'])){
            $dataUser = $this->User_model->get_by(['user_no_identitas' => $post['no_identitas']], 1, NULL,TRUE);
            if($dataUser){
                if ($dataUser->user_status_akun ==  "aktif") {
                    if(password_verify($post['password_login'], $dataUser->user_password)){
                        $sessData = [
                            'user_nama' => $dataUser->user_nama,
                            'user_no_identitas' =>$dataUser->user_no_identitas,
                            'login' => TRUE,
                            'user_group' => $dataUser->user_group,
                            'status_akun' => $dataUser->user_status_akun
                        ];
                        $this->session->set_userdata($sessData);
    
                        if($dataUser->user_group == "admin"){
                            redirect('admin/dashboard');
                        }else if($dataUser->user_group == "siswa"){
                            redirect('siswa/dashboard');
                        }
                    }else{
                        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert"> Gagal Masuk! Password salah.</div>');
                        redirect('auth');
                    }
                }else{
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert"> Gagal Masuk! Status akun non aktif, Hubungi admin !.</div>');
                    redirect('auth');
                }
                
            }else{
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert"> Gagal Masuk! No identitas belum terdaftar.</div>');
                redirect('auth');
            }
        }
    }
    public function logout(){
        $this->session->unset_userdata('user_nama');
        $this->session->unset_userdata('user_group');
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('user_no_identitas');
        $this->session->unset_userdata('status_akun');
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"> Berhasil keluar...</div>');
        redirect('auth');
        
    }
    public function tesdaftar(){
        $data['user_no_identitas'] = 1112;
        $data['user_nama'] = "Kurniawan Arif";
        $data['user_password'] = password_hash("admin", PASSWORD_DEFAULT) ;
        $data['user_group'] = "admin";
        $this->User_model->insert($data);
    }
    
}
