<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cookie extends ACG_Controller {

    public function __construct() {
		parent::__construct();
	}

	public function index(){

		if(!empty($this->input_data->raw->role)){
			$this->input->set_cookie('cookie-police', 'true', time() + (60 * 60 * 24 * 10));
			$this->set_response(array('status' => true), 200);
		}else{
			$this->set_response(array('status' => false), 200);
		}
	}
}

?>