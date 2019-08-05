<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_by_email($email, $is_delete = 0) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('is_delete', $is_delete);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}
		return false;
	}
}
