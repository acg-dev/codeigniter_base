<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {
	private $cdb;
	public function __construct() {
		parent::__construct();
		$this->cdb = $this->db;
	}

	public function set_database($database){
		$this->cdb = $this->load->database($database . '_' . ENVIRONMENT, true);
		return $this->cdb;
	}

	public function get_database_name($database = false){
		if($database){
			$cdb = $this->load->database($database . '_' . ENVIRONMENT, true);
			return $cdb->database;
		}
		
		return $this->cdb->database;
	}

	public function unset_database(){
		$this->cdb = $this->db;
	}
	
	public function get_enum_values( $table, $field ){
        $type = $this->cdb->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

    public function select( $table, $where = false, $order = array(), $limit = false, $fields = '*', $is_re = false) {
    	$this->cdb->select($fields);
    	$this->cdb->from($table);
    	if($where){
	    	foreach ($where as $key => $value) {
	    		if(is_array($value)){
					$this->cdb->where_in($key, $value);
	    		}else{
					$this->cdb->where($key, $value);
	    		}
			}
		}

		if(count($order) == 2){
			$this->cdb->order_by($order[0], $order[1]);
		}

		if($limit){
			$this->cdb->limit($limit);
		}

		$query = $this->cdb->get();

		if($query->num_rows() > 0){
			if($limit == 1){
				return $query->row();
			}else{
				if($is_re){
					$items = array();
					foreach ($query->result() as $row) {
						$items[$row->id] = $row;
					}
					return $items;
				}else{					
					return $query->result();
				}
			}
		}

		return false;

		
	}

    public function insert( $table, $data ) {
		if( false === $this->cdb->insert($table, $data) ) {
			return false;
		}else{
			return $this->cdb->insert_id();
		}
	}

	public function update($where, $table, $data ) {
		if(empty($where)){
			return false;
		}

		foreach ($where as $key => $value) {
			$this->cdb->where($key, $value);
		}

		if( false === $this->cdb->update($table, $data) ) {
			$error = $this->cdb->error();
			throw new Exception($error['meesage'],$error['code']);
		}

		return true;
	}

	public function delete($where, $table) {
		if(empty($where)){
			return false;
		}

		foreach ($where as $key => $value) {
			$this->cdb->where($key, $value);
		}

		if( false === $this->cdb->delete($table) ) {
			$error = $this->cdb->error();
			throw new Exception($error['meesage'],$error['code']);
		}
	}
}