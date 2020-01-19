<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends MY_Model{
    protected $_table_name = "tbl_siswa";
	protected $_order_by = "siswa_id";
	protected $_primary_filter = 'intval';
    protected $_primary_key = "siswa_id";
    
    protected $column_order = [null, 'siswa_no_identitas', 'siswa_nama', 'siswa_kelas', 'siswa_jenis_kelamin', 'siswa_status','siswa_status_akun'];
    protected $column_search  = ['siswa_no_identitas', 'siswa_nama', 'siswa_kelas', 'siswa_jenis_kelamin', 'siswa_status','siswa_status_akun'];
    protected $order   = array('siswa_no_identitas' => 'desc');

    function __construct()
    {
        parent::__construct();
    }

    	// DATATABLE SERVERSIDE
        //var $column_order = array(null, 'FirstName','LastName','phone','address','city','country'); //set column field database for datatable orderable
       // var $column_search = array('FirstName','LastName','phone','address','city','country'); //set column field database for datatable searchable 
        //var $order = array('id' => 'asc'); // default order 
     
        private function _get_datatables_query()
        {
             
            //add custom filter here
            
            if($this->input->post('carinis'))
            {
                $this->db->like('siswa_no_identitas', $this->input->post('carinis'));
            }
            if($this->input->post('carikelas'))
            {
                $this->db->like('siswa_kelas', $this->input->post('carikelas'));
            }
            if($this->input->post('caristatusakun'))
            {
                $this->db->where('siswa_status_akun', $this->input->post('caristatusakun'));
            }
            if($this->input->post('carisiswajeniskelamin'))
            {
                $this->db->like('siswa_jenis_kelamin', $this->input->post('carisiswajeniskelamin'));
            }
            if($this->input->post('carisiswastatus'))
            {
                $this->db->like('siswa_status', $this->input->post('carisiswastatus'));
            }
            $this->db->from($this->_table_name);
            
            
     

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

        public function nis_terakhir()
        {
            $this->db->select('siswa_no_identitas');
            $this->db->order_by('siswa_no_identitas',"desc")->limit(1);
            $this->db->limit(1);
            $query = $this->db->get('tbl_siswa');
            $result = $query->row();

            if( $result == NULL){
                return 0;
            }else{
                return $result;
            }
           
        }
}