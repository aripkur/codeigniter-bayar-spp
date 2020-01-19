<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inputdata extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Inputdata_model');
    }

    public function databayar(){
      $this->Inputdata_model->input_tahun();
      $this->Inputdata_model->data_bayar();
    }
}