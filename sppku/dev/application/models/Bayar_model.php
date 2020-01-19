<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bayar_model extends MY_Model{
    protected $_table_name = "tbl_bayar";
	protected $_order_by = "bayar_id";
	protected $_primary_filter = 'intval';
    protected $_primary_key = "bayar_id";
    
    protected $column_order = [null, 'siswa_no_identitas', 'bulan_id', 'tahun_id', 'status_bayar', 'tanggal_bayar'];
    protected $column_search  = ['siswa_no_identitas', 'bulan_id', 'tahun_id', 'status_bayar', 'tanggal_bayar'];
    protected $order   = array('tahun_id' => 'desc');

    function __construct()
    {
        parent::__construct();
    }

    	// DATATABLE SERVERSIDE
        //var $column_order = array(null, 'FirstName','LastName','phone','address','city','country'); //set column field database for datatable orderable
       // var $column_search = array('FirstName','LastName','phone','address','city','country'); //set column field database for datatable searchable 
        //var $order = array('id' => 'asc'); // default order 

        public function jointabel($id =NULL)
        {
            if($id != NULL){
                $this->db->select('*');
                $this->db->from($this->_table_name);
                $this->db->join('tbl_siswa','tbl_siswa.siswa_id=tbl_bayar.siswa_id');
                $this->db->join('tbl_bulan','tbl_bulan.bulan_kode=tbl_bayar.bulan_id');
                $this->db->join('tbl_tahun','tbl_tahun.tahun_kode=tbl_bayar.tahun_id');
                $this->db->where('tbl_bayar.bayar_id',$id);
                $query = $this->db->get();
                return $query->row();
            }else{
                return FALSE;
            }
            
        }
        public function jointabelwhere($where =NULL)
        {
            if($where != NULL){
                $this->db->select('*');
                $this->db->from($this->_table_name);
                $this->db->join('tbl_siswa','tbl_siswa.siswa_id=tbl_bayar.siswa_id');
                $this->db->join('tbl_bulan','tbl_bulan.bulan_kode=tbl_bayar.bulan_id');
                $this->db->join('tbl_tahun','tbl_tahun.tahun_kode=tbl_bayar.tahun_id');
                $this->db->where($where);
                $this->db->order_by('tbl_bayar.tahun_id','desc');
                $this->db->order_by('tbl_bayar.bulan_id','desc');
                $query = $this->db->get();
                return $query->result();
            }else{
                return FALSE;
            }
            
        }
     
        public function join_count($where)
        {
                $this->db->select('*');
                $this->db->from($this->_table_name);
                $this->db->join('tbl_siswa','tbl_siswa.siswa_id=tbl_bayar.siswa_id');
                $this->db->join('tbl_bulan','tbl_bulan.bulan_kode=tbl_bayar.bulan_id');
                $this->db->join('tbl_tahun','tbl_tahun.tahun_kode=tbl_bayar.tahun_id');
                $this->db->where('tbl_siswa.siswa_status','belum');
                $this->db->where($where);
		        return $this->db->count_all_results();
           
            
        }
        private function _get_datatables_query()
        {
             
            //add custom filter here
            
            $this->db->select('*');
            $this->db->from($this->_table_name);
            $this->db->join('tbl_siswa','tbl_siswa.siswa_id=tbl_bayar.siswa_id');
            $this->db->join('tbl_bulan','tbl_bulan.bulan_kode=tbl_bayar.bulan_id');
            $this->db->join('tbl_tahun','tbl_tahun.tahun_kode=tbl_bayar.tahun_id');
            $this->db->where('tbl_siswa.siswa_status', 'belum');

            if($this->input->post('carinis'))
            {
                $this->db->like('tbl_siswa.siswa_no_identitas', $this->input->post('carinis'));
            }
            if($this->input->post('carikelas'))
            {
                $this->db->where('tbl_siswa.siswa_kelas', $this->input->post('carikelas'));
            }
            if($this->input->post('caribulan'))
            {
                $this->db->where('tbl_bayar.bulan_id', $this->input->post('caribulan'));
            }
            if($this->input->post('caritahun'))
            {
                $this->db->where('tbl_bayar.tahun_id', $this->input->post('caritahun'));
            }
            
            
     

            $i = 0;
         
            foreach ($this->column_search as $item) // loop column 
            {
                if($_POST['search']['value']) // if datatable send POST for search
                {
                     
                    if($i===0) // first loop
                    {
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
     
                    if(count($this->column_search) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }
             
            if(isset($_POST['order'])) // here order processing
            {
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order))
            {
                $order = $this->order;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
     
        public function get_datatables()
        {
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
     
        public function count_filtered()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
     
        public function count_all()
        {
            $this->db->from($this->_table_name);
            return $this->db->count_all_results();
        }
     
        public function get_list_bulan()
        {
            $this->db->select(['bulan_kode','bulan_nama']);
            $this->db->from('tbl_bulan');
            $this->db->order_by('bulan_kode','asc');
            $query = $this->db->get();
            $result = $query->result();

            $dataBulan = array();
            foreach ($result as $row) 
            {
                $dataBulan[$row->bulan_kode] = $row->bulan_nama;
            }
            return $dataBulan;
        }
        public function get_list_kelas()
        {
            $this->db->select('kelas_nama');
            $this->db->from('tbl_kelas');
            $this->db->order_by('kelas_id','asc');
            $query = $this->db->get();
            $result = $query->result();

            $dataKelas = array();
            foreach ($result as $row) 
            {
                $dataKelas[] = $row->kelas_nama;
            }
            return $dataKelas;
        }
        public function get_list_tahun()
        {
            $this->db->select(['tahun_kode','tahun_nama']);
            $this->db->from('tbl_tahun');
            $this->db->order_by('tahun_kode','asc');
            $query = $this->db->get();
            $result = $query->result();

            $dataTahun = array();
            foreach ($result as $row) 
            {
                $dataTahun[$row->tahun_kode] = $row->tahun_nama;
            }
            return $dataTahun;
        }

        private function _tahun_kode($tahun)
        {

            $this->db->select('tahun_kode');
            $this->db->from('tbl_tahun');
            $this->db->where('tahun_nama', $tahun);
            $query = $this->db->get();
            return $query->row();
        }

        private function _ambil_total_tahun(){
            $this->db->from('tbl_tahun');
		    return $this->db->count_all_results();
        }

        public function get_status_bayar(){
            
            $bulanSekarang =(int)date("m");
            $tahunKode = $this->_tahun_kode((int)date("Y"));
            $ambilTahunkode = intval($tahunKode->tahun_kode);

            if($bulanSekarang == 2) //FEBRUARI
            {
        
                for($i=0;$i <= 2; $i++)
                {
                     
                    if($i == 2){
                        $dataBulanid = $bulanSekarang + 10;
                        $dataTahunid = $ambilTahunkode - 1;

                        $whereLunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'lunas'];
                        $whereBelumlunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'belum'];
                        $statusBayar[$i]['lunas'] = $this->join_count($whereLunas);
                        $statusBayar[$i]['belum lunas'] = $this->join_count($whereBelumlunas);
                        $statusBayar[$i]['bulan'] = $dataBulanid;
                        $statusBayar[$i]['tahun'] = $dataTahunid;
                        
                    }else{
                        $dataBulanid = $bulanSekarang -$i;
                        $dataTahunid = $ambilTahunkode;

                        $whereLunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'lunas'];
                        $whereBelumlunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'belum'];
                        $statusBayar[$i]['lunas'] = $this->join_count($whereLunas);
                        $statusBayar[$i]['belum lunas'] = $this->join_count($whereBelumlunas);
                        $statusBayar[$i]['bulan'] = $dataBulanid;
                        $statusBayar[$i]['tahun'] = $dataTahunid;
                        
                    }
                }
            }

            else if($bulanSekarang == 1) //Januari
            {

                for($i=0;$i <= 2; $i++)
                {
                     
                    if($i == 0){
                        $dataBulanid = 1;
                        $dataTahunid = $ambilTahunkode;

                        $whereLunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'lunas'];
                        $whereBelumlunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'belum'];
                        $statusBayar[$i]['lunas'] = $this->join_count($whereLunas);
                        $statusBayar[$i]['belum lunas'] = $this->join_count($whereBelumlunas);
                        $statusBayar[$i]['bulan'] = $dataBulanid;
                        $statusBayar[$i]['tahun'] = $dataTahunid;
                        

                    }else{                  
                        $dataBulanid = ($bulanSekarang -$i) + 12;
                        $dataTahunid = $ambilTahunkode - 1;

                        $whereLunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'lunas'];
                        $whereBelumlunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'belum'];
                        $statusBayar[$i]['lunas'] = $this->join_count($whereLunas);
                        $statusBayar[$i]['belum lunas'] = $this->join_count($whereBelumlunas);
                        $statusBayar[$i]['bulan'] = $dataBulanid;
                        $statusBayar[$i]['tahun'] = $dataTahunid;
                        
                    }
                }
            }else{

                for($i=0;$i <= 2; $i++)
                {
                        $dataBulanid = $bulanSekarang - $i;
                        $dataTahunid = $ambilTahunkode;

                        $whereLunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'lunas'];
                        $whereBelumlunas =['tbl_bayar.tahun_id' => $dataTahunid, 'tbl_bayar.bulan_id' => $dataBulanid, 'tbl_bayar.status_bayar' => 'belum'];
                        $statusBayar[$i]['lunas'] = $this->join_count($whereLunas);
                        $statusBayar[$i]['belum lunas'] = $this->join_count($whereBelumlunas);
                        $statusBayar[$i]['bulan'] = $dataBulanid;
                        $statusBayar[$i]['tahun'] = $dataTahunid;
                        
                }
            }
            return $statusBayar;
        }
}