<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends MY_Model{
    protected $_table_name = "tbl_kelas";
	protected $_order_by = "kelas_id";
	protected $_primary_filter = 'intval';
	protected $_primary_key = "kelas_id";

    function __construct()
    {
        parent::__construct();
    }
}