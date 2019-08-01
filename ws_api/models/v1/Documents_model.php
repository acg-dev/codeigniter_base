<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Documents_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_file($item_id, $type, $object_type = 'default') {
		$this->db->select('*');
		$this->db->from('documents');
		$this->db->where('item_id', $item_id);
		$this->db->where('item_type', $type);
		$query = $this->db->get();
		if (false === $query) {
			$error = $this->db->error();
			throw new Exception($error['message'], $error['code']);
		}
		
		if($object_type == 'array'){
			if($query->num_rows() > 0){
				return $query->result();
			}
		}else{
			if($query->num_rows() > 1){
				return $query->result();
			}elseif($query->num_rows() > 0){
				return $query->row();
			}
		}

		return false;
	}

	public function get_file_by_id($id) {
		$this->db->select('*');
		$this->db->from('documents');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if (false === $query) {
			$error = $this->db->error();
			throw new Exception($error['message'], $error['code']);
		}
		if($query->num_rows() > 0){
			return $query->row();
		}

		return false;
	}

	public function insert_file($item_id, $item_type, $orig_name, $file_name, $file_type, $file_path) {
		return $this->db->insert('documents', array(
												'item_id' => $item_id,
												'item_type' => $item_type,
												'orig_name' => $orig_name,
												'file_name' => $file_name,
												'file_type' => $file_type,
												'path' => $file_path,
												'create_user_id' => $this->current_user->id,
												'create_user_name' => $this->current_user->display_name,
											));
	}

	public function delete_file($id){
		return $this->db->where('id', $id)->delete('documents');
	}

	public function delete_file_by_offer_id_type($item_id, $item_type){
		return $this->db->where('item_id', $item_id)->where('item_type', $item_type)->delete('documents');
	}

}
