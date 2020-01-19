<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulan_model extends MY_Model{
    protected $_table_name = "tbl_bulan";
	protected $_order_by = "bulan_kode";
	protected $_primary_filter = 'intval';
	protected $_primary_key = "bulan_kode";

    function __construct()
    {
        parent::__construct();
    }
}