<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
	parent::__construct();
    }

    public function get_by_email($email) {
		$result = $this->db->select('*')
					   	   ->from('admin_users')
					   	   ->where('email', $email)
					   	   ->limit(1)
					   	   ->get();
		if($result->num_rows() > 0){
			return $result->row();
		}

		return false;
    }
}
