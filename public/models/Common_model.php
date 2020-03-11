<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Common_model extends CI_Model
{
	private $cdb;
	private $results = false;
	private $tables_fields = [];
	public function __construct()
	{
		parent::__construct();
		$this->cdb = $this->db;
	}

	public function set_database($database, $change = true)
	{
		if ($change) {
			$this->cdb = $this->load->database($database . '_' . ENVIRONMENT, true);
			return $this->cdb;
		} else {
			return $this->load->database($database . '_' . ENVIRONMENT, true);
		}
	}

	public function get_database_name($database = false, $change = true)
	{
		if ($database) {
			return $this->set_database($database, $change)->database;
		}

		return $this->cdb->database;
	}

	public function unset_database()
	{
		$this->cdb = $this->db;
	}

	public function check_key($table, $key)
	{
		if (!array_key_exists($table, $this->tables_fields)) {
			$this->tables_fields[$table] = $this->cdb->list_fields($table);
		}

		if (array_key_exists($table, $this->tables_fields) && in_array($key, $this->tables_fields[$table])) {
			return true;
		}

		return false;
	}

	public function get_enum_values($table, $field)
	{
		$type = $this->cdb->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'")->row(0)->Type;
		preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
		$enum = explode("','", $matches[1]);
		return $enum;
	}
	
	/* $re = ['field' => 'id', 'type' => 'object_list'] */
	
	public function select_one($table, $where = false, $order = array(), $limit = false, $fields = '*', $re = false, $callback = false, $group_by = false)
	{
		return $this->select($table, $where, $order, $limit, $fields, $re, $callback, $group_by, true);
	}
	
	public function select($table, $where = false, $order = array(), $limit = false, $fields = '*', $re = false, $callback = false, $group_by = false, $select_one = false)
	{
		$select_results = false;
		$this->cdb->select($fields);
		if (is_string($table)) {
			$this->cdb->from($table);
		} else {
			$this->cdb->from($table['from']);
			if (!empty($table['join'])) {
				foreach ($table['join'] as $key => $join) {
					$this->cdb->join("{$join['table']} $key", $join['where'], !empty($join['type']) ? $join['type'] : false);
				}
			}
		}
		if ($where) {
			foreach ($where as $key => $value) {
				if (preg_match('/\#group\#/', $key)) {
					$this->grouping_where($key, $value);
				} elseif (is_array($value)) {
					$this->cdb->where_in($key, $value);
				} elseif(preg_match('/\#like\#/', $key)) {
					$this->cdb->like(trim(str_replace('#like#', '', $key)), $value);
				} else {
					$this->cdb->where($key, $value);
				}
			}
		}

		if (count($order) == 2) {
			$this->cdb->order_by($order[0], $order[1]);
		}

		if ($group_by) {
			$this->cdb->group_by($group_by);
		}

		if ($limit) {
			$this->cdb->limit($limit);
		}

		$query = $this->cdb->get();

		if ($query->num_rows() > 0) {
			if ($limit == 1) {
				if ($re) {
					$select_results = $query->row()->{$re['field']};
				} else {
					$select_results = $query->row();
				}

				if (!empty($select_results) && !empty($callback)) {
					$this->get_each_child($select_results, $callback);
				}
			} else {
				if ($re) {
					$select_results = [];
					foreach ($query->result() as $row) {
						if ($re['type'] == 'array') {
							$select_results[] = $row->{$re['field']};
						} elseif ($re['type'] == 'array_list') {
							$select_results[$row->{$re['field']}] = $row->{$re['value']};
						} else {
							$select_results[$row->{$re['field']}] = $row;
						}
					}
				} else {
					$select_results = $query->result();
				}

				if (!empty($select_results) && !empty($callback)) {
					$this->get_each_child($select_results, $callback);
				}
			}
		}

		if ($select_one) {
			return $select_results;
		} else {
			$this->results = $select_results;
			return $select_results;
		}
	}

	/* 
	$relations = [['key_field', 'table_key_field']] 
	$re = ['field' => 'id', 'type' => 'object_list']
	*/

	public function get_childrens($name, $table, $relations, $where = [], $order = [], $fields = '*', $re = false, $callback = false, $group_by = false)
	{
		if (is_object($this->results)) {
			$results = [$this->results];
		} else {
			$results = $this->results;
		}

		foreach ($results as $result) {
			$result->{$name} = [];
			$this->cdb->select($fields);
			if (is_string($table)) {
				$this->cdb->from($table);
			} else {
				$this->cdb->from($table['from']);
				if (!empty($table['join'])) {
					foreach ($table['join'] as $key => $join) {
						$this->cdb->join("{$join['table']} $key", $join['where'], !empty($join['type']) ? $join['type'] : false);
					}
				}
			}
			foreach ($relations as $relation) {
				if (count($relation) == 2) {
					$this->cdb->where($relation[1], $result->{$relation[0]});
				}
			}

			if ($where) {
				foreach ($where as $key => $value) {
					if ($key == 'group') {
						if ($value) {
							$this->cdb->group_start();
							if (array_key_exists('or', $value)) {
								foreach ($value['or'] as $group_key => $group_value) {
									$this->cdb->or_where($group_key, $group_value);
								}
							}
							if (array_key_exists('and', $value)) {
								foreach ($value['and'] as $group_key => $group_value) {
									$this->cdb->where_or($group_key, $group_value);
								}
							}
							$this->cdb->group_end();
						}
					} elseif (is_array($value)) {
						$this->cdb->where_in($key, $value);
					} else {
						$this->cdb->where($key, $value);
					}
				}
			}

			if (count($order) == 2) {
				$this->cdb->order_by($order[0], $order[1]);
			}

			if ($group_by) {
				$this->cdb->group_by($group_by);
			}

			$query = $this->cdb->get();

			if ($query->num_rows() > 0) {
				if ($re) {
					$result->{$name} = [];
					foreach ($query->result() as $row) {
						if ($re['type'] == 'array') {
							$result->{$name}[] = $row->{$re['field']};
						} elseif ($re['type'] == 'array_list') {
							$result->{$name}[$row->{$re['field']}] = $row->{$re['value']};
						} else {
							$result->{$name}[$row->{$re['field']}] = $row;
						}
					}
				} else {
					$result->{$name} = $query->result();
				}

				if (!empty($result->{$name}) && !empty($callback)) {
					$this->get_each_child($result->{$name}, $callback);
				}
			}
		}

		return $this->results;
	}

	public function get_datas()
	{
		return $this->results;
	}

	public function get_each_child($datas, $callback)
	{
		if ((!empty($datas) || !empty($this->results)) && !empty($callback)) {
			if (empty($datas)) {
				$datas = $this->results;
			}

			if (is_object($datas)) {
				$callback(0, $datas);
			} else {
				foreach ($datas as $key => $data) {
					$callback($key, $data);
				}
			}
		}
	}

	public function count_row($table, $where = false, $field = 'id', $group_by = false)
	{
		$this->cdb->select("count($field) as ct");
		if (is_string($table)) {
			$this->cdb->from($table);
		} else {
			$this->cdb->from($table['from']);
			if (!empty($table['join'])) {
				foreach ($table['join'] as $key => $join) {
					$this->cdb->join("{$join['table']} $key", $join['where'], !empty($join['type']) ? $join['type'] : false);
				}
			}
		}
		if ($where) {
			foreach ($where as $key => $value) {
				if (preg_match('/\#group\#/', $key)) {
					$this->grouping_where($key, $value);
				} elseif (is_array($value)) {
					$this->cdb->where_in($key, $value);
				} else {
					$this->cdb->where($key, $value);
				}
			}
		}

		
		if ($group_by) {
			$this->cdb->group_by($group_by);
		}

		$query = $this->cdb->get();

		if ($query->num_rows() > 0) {
			return $query->row()->ct;
		}

		return 0;
	}

	public function insert($table, $data)
	{
		$data = (array) $data;
		if (empty($data['create_user_id'])) {
			$data['create_user_id'] = $this->current_user->id;
		}
		if (empty($data['create_timestamp'])) {
			$data['create_timestamp'] = date('Y-m-d H:i:s');
		}
		if (empty($data['last_modification_user_id'])) {
			$data['last_modification_user_id'] = $this->current_user->id;
		}
		if (empty($data['last_modification_timestamp'])) {
			$data['last_modification_timestamp'] = date('Y-m-d H:i:s');
		}

		foreach (array_keys($data) as $key) {
			if (!$this->check_key($table, $key)) {
				unset($data[$key]);
			}
		}
		
		
		if (false === $this->cdb->insert($table, $data)) {
			return false;
		} else {
			return $this->cdb->insert_id();
		}
		return false;
	}
	
	public function insert_batch($table, $data)
	{
		$data = (array) $data;
		foreach ($data as $dkey => $row) {
			$data[$dkey] = $row = (array) $row;
			if (empty($row['create_user_id'])) {
				$data[$dkey]['create_user_id'] = $this->current_user->id;
			}
			if (empty($row['create_timestamp'])) {
				$data[$dkey]['create_timestamp'] = date('Y-m-d H:i:s');
			}
			if (empty($row['last_modification_user_id'])) {
				$data[$dkey]['last_modification_user_id'] = $this->current_user->id;
			}
			if (empty($row['last_modification_timestamp'])) {
				$data[$dkey]['last_modification_timestamp'] = date('Y-m-d H:i:s');
			}
			foreach (array_keys($data[$dkey]) as $key) {
				if (!$this->check_key($table, $key)) {
					unset($data[$dkey][$key]);
				}
			}
		}
		
		if (false === $this->cdb->insert_batch($table, $data)) {
			return false;
		} else {
			return $this->cdb->insert_id();
		}
	}

	public function update($where, $table, $data)
	{
		if (empty($where)) {
			return false;
		}

		foreach ($where as $key => $value) {
			$this->cdb->where($key, $value);
		}

		$data = (array) $data;
		if (empty($data['last_modification_user_id'])) {
			$data['last_modification_user_id'] = $this->current_user->id;
		}
		if (empty($data['last_modification_timestamp'])) {
			$data['last_modification_timestamp'] = date('Y-m-d H:i:s');
		}
		foreach (array_keys($data) as $key) {
			if (!$this->check_key($table, $key)) {
				unset($data[$key]);
			}
		}

		if (false === $this->cdb->update($table, $data)) {
			$error = $this->cdb->error();
			throw new Exception($error['meesage'], $error['code']);
		}

		return true;
	}

	public function delete($where, $table)
	{
		if (empty($where)) {
			return false;
		}

		foreach ($where as $key => $value) {
			$this->cdb->where($key, $value);
		}

		if (false === $this->cdb->delete($table)) {
			$error = $this->cdb->error();
			throw new Exception($error['meesage'], $error['code']);
		}
	}

	public function truncate($table)
	{
		if (false === $this->cdb->truncate($table)) {
			$error = $this->cdb->error();
			throw new Exception($error['meesage'], $error['code']);
		}
	}

	private function grouping_where($key, $value)
	{
		if (is_array($value)) {
			if (preg_match('/\#group\#or/', $key)) {
				$this->cdb->or_group_start();
			} elseif (preg_match('/\#group\#not/', $key)) {
				$this->cdb->not_group_start();
			} elseif (preg_match('/\#group\#ornot/', $key)) {
				$this->cdb->or_not_group_start();
			} else {
				$this->cdb->group_start();
			}

			for ($gi = 0; $gi < count($value); $gi++) {
				if (array_key_exists($gi, array_keys($value)) && preg_match('/\#group\#/', array_keys($value)[$gi])) {
					$this->grouping_where(array_keys($value)[$gi], $value[array_keys($value)[$gi]]);
				}
			}
			if (array_key_exists('or', $value)) {
				foreach ($value['or'] as $group_key => $group_value) {
					$this->cdb->or_where($group_key, $group_value);
				}
			}
			if (array_key_exists('and', $value)) {
				foreach ($value['and'] as $group_key => $group_value) {
					$this->cdb->where($group_key, $group_value);
				}
			}
			$this->cdb->group_end();
		}
	}
}
