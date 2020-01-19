<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inputdata_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    private function _total_tahun(){
        $this->db->from('tbl_tahun');
		return $this->db->count_all_results();
    }
    private function _ambil_tahun($tahun){
       // $idTerakhir = $this->_total_tahun();

        $this->db->select('tahun_kode');
        $this->db->from('tbl_tahun');
        $this->db->where('tahun_nama', $tahun);
        $query = $this->db->get();
        return $query->row();
    }
    public function data_bayar()
    {
        $this->db->select('siswa_id');
        $this->db->from('tbl_siswa');
        $this->db->where('siswa_status', 'belum');
        $query = $this->db->get();
        $dataSiswa = $query->result();

        $kodeTahun = $this->_ambil_tahun((int)date("Y"));
        //$kodeTahun = $dataTahun->tahun_nama == (int)date("Y") ? $dataTahun->tahun_kode : 0;
        
        if(date("d") == 3 )
        {
            for($i=0;$i < count($dataSiswa); $i++)
            {
                $data[$i]['siswa_id'] = (int)$dataSiswa[$i]->siswa_id;
                $data[$i]['bulan_id'] = (int)date("m");
                $data[$i]['tahun_id'] = (int)$kodeTahun->tahun_kode;
                $data[$i]['status_bayar'] = "belum";
                $data[$i]['tanggal_bayar'] = date("d-m-Y");
            }
            
            $this->db->insert_batch('tbl_bayar', $data);
        }
    }

    public function input_tahun()
    {
        //$dataTahun = $this->_ambil_tahun();
        if((date("d") == 1) && date("m") == 1)
        {
            $data = [
                    'tahun_nama' => (int)date("Y")
            ];
            $this->db->set($data);
			$this->db->insert('tbl_tahun');
        }
        else{
            return FALSE;
        }
    }
}