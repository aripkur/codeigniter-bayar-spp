<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ceklogin 
{

    function cek_login(){
        $_this =& get_instance();

        $user_session = $_this->session->userdata;
        
        if($_this->uri->segment(1) == 'auth' || $_this->uri->segment(1) == 'login' ){
            if(isset($user_session['login']) && $user_session['login'] == TRUE && $user_session['status_akun'] == 'aktif'  && $user_session['user_group'] == 'admin'){
                redirect(base_url('admin/dashboard'));
            }
            else if(isset($user_session['login']) && $user_session['login'] == TRUE && $user_session['status_akun'] == 'aktif'  && $user_session['user_group'] == 'siswa'){
                redirect(base_url('siswa/dashboard'));
            }
        }
        else if($_this->uri->segment(1) == 'admin'){
            if(!isset($user_session['login']) || $user_session['status_akun'] != 'aktif'  || $user_session['user_group'] != 'admin'){
                $_this->session->sess_destroy();
                redirect(base_url('auth'));
            }
            else if(isset($user_session['login']) && $user_session['status_akun'] == 'aktif'  && $user_session['user_group'] == 'siswa'){
                redirect(base_url('siswa/dashboard'));
            }
        }
        else if($_this->uri->segment(1) == 'siswa'){
            if(!isset($user_session['login']) || $user_session['status_akun'] != 'aktif'  || $user_session['user_group'] != 'siswa'){
                $_this->session->sess_destroy();
                redirect(base_url('auth'));
            }
            else if(isset($user_session['login']) && $user_session['status_akun'] == 'aktif'  && $user_session['user_group'] == 'admin'){
                redirect(base_url('admin/dashboard'));
            }
        }
    }
}