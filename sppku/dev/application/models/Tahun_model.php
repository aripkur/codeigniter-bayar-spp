<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun_model extends MY_Model{
    protected $_table_name = "tbl_tahun";
	protected $_order_by = "tahun_kode";
	protected $_primary_filter = 'intval';
	protected $_primary_key = "tahun_kode";

    function __construct()
    {
        parent::__construct();
    }
}