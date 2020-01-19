<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{
	protected $_table_name;
	protected $_order_by;
	protected $_order_by_type;
	protected $_primary_filter = 'intval';
	protected $_primary_key;


	function __construct(){
		parent::__construct();
	}

	public function insert($data,$batch=FALSE){
		if($batch == TRUE){
			$this->db->insert_batch($this->_table_name, $data);
		}
		else{
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			$id = $this->db->insert_id();
			return $id;
		}
	}

	public function update($data,$where=array()){
		$this->db->set($data);
		$this->db->where($where);
		$this->db->update($this->_table_name);
		if (!$this->db->affected_rows()) {
			$result =['status' =>'gagal', 'keterangan' =>' Database Error!'] ;
		} else {
			$result = ['status' =>'sukses', 'keterangan' =>''];
		}
		return $result;
	}	

	public function get($id=NULL,$single=FALSE){
		if($id != NULL){
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->where($this->_primary_key,$id);
			$method = 'row';
		}

		else if($single == TRUE){
			$method = 'row';
		}

		else{
			$method = 'result';
		}

		if($this->_order_by_type){
			$this->db->order_by($this->_order_by,$this->_order_by_type);
		}
		else{
			$this->db->order_by($this->_order_by);
		}

		return $this->db->get($this->_table_name)->$method();
	}

	public function get_by($where = NULL, $limit = NULL, $offset = NULL, $single = FALSE, $select = NULL){
		if($select != NULL){
			$this->db->select($select);
		}

		if($where){
			$this->db->where($where);
		}

		if(($limit) && ($offset)){
			$this->db->limit($limit,$offset);
		}
		else if($limit){
			$this->db->limit($limit);
		}

		return $this->get(NULL,$single);
	}

	public function delete($id){
		$filter = $this->_primary_filter;
		$id = $filter($id);

		if(!$id){
			return FALSE;
		}

		$this->db->where($this->_primary_key,$id);
		$this->db->limit(1);
		$this->db->delete($this->_table_name);
		if (!$this->db->affected_rows()) {
			$result =['status' =>'gagal', 'keterangan' =>'Database Error! ['.$this->_primary_key.' => '.$id.' Tidak ditemukan pada tabel '.$this->_table_name.']'] ;
		} else {
			$result = ['status' =>'sukses', 'keterangan' =>''];
		}
		return $result;
		
	}
	public function count($where = NULL){
		if($where){
			$this->db->where($where);
		}

		$this->db->from($this->_table_name);
		return $this->db->count_all_results();
	}
	public function countLike($where = NULL){
		if($where){
			$this->db->like($where);
		}

		$this->db->from($this->_table_name);
		return $this->db->count_all_results();
	}


}