<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	
	public function get_enum_values( $table, $field ){
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

    public function select( $table, $where = false, $order = array(), $limit = false ) {
    	$this->db->select();
    	$this->db->from($table);
    	if($where){
	    	foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}

		if(count($order) == 2){
			$this->db->order_by($order[0], $order[1]);
		}

		if($limit){
			$this->db->limit($limit);
		}

		$query = $this->db->get();

		if($query->num_rows() > 0){
			if($limit == 1){
				return $query->row();
			}else{
				return $query->result();
			}
		}

		return false;

		
	}

    public function insert( $table, $data ) {
		if( false === $this->db->insert($table, $data) ) {
			return false;
		}else{
			return $this->db->insert_id();
		}
	}

	public function update($where, $table, $data ) {
		if(empty($where)){
			return false;
		}

		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}

		if( false === $this->db->update($table, $data) ) {
			$error = $this->db->error();
			throw new Exception($error['meesage'],$error['code']);
		}

		return true;
	}

	public function delete($where, $table) {
		if(empty($where)){
			return false;
		}

		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}

		if( false === $this->db->delete($table) ) {
			$error = $this->db->error();
			throw new Exception($error['meesage'],$error['code']);
		}
	}
}