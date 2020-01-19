<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model{
    protected $_table_name = "tbl_user";
	protected $_order_by = "user_id";
	protected $_primary_filter = 'intval';
	protected $_primary_key = "user_id";

    function __construct()
    {
        parent::__construct();
    }
}