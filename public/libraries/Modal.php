<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Modal {
	private $CI;
	private $modals = array();
	
	public function __construct() {
		$this->CI = & get_instance();
	}
	
	public function init($id) {
		$this->modals[$id] = new stdClass();
		$this->modals[$id]->id = $id;
		$this->modals[$id]->title = '';
		$this->modals[$id]->body = '';
		$this->modals[$id]->footer = '';
		$this->modals[$id]->size = '';
	}
	public function add( $id, $title, $path, $body, $footer = '', $size = '') {
		if(!array_key_exists($id, $this->modals)){
			$this->init($id);
		}

		$this->modals[$id]->title = $title;
		$this->modals[$id]->body = $this->CI->load->view('pages/' . $path . $body, array('data' => $this->CI->get_data()), true);
		if(!empty($footer)){
			$this->modals[$id]->footer = $this->CI->load->view('pages/' . $path . $footer, array('data' => $this->CI->get_data()), true);
		}
		if(!empty($size)){
			$this->modals[$id]->size = $size;
		}
	}
	
	public function render() {
		$modals = '';
		if(!empty($this->modals)){
			foreach ($this->modals as $modal_id => $modal) {
				$modals .= $this->CI->load->view('widgets/modals/modal', $modal, true);
			}
		}

		return $modals;
	}
	
	public function remove() {
		unset($this->modals[$id]);
	}
}