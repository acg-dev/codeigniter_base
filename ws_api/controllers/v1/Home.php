<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CIX_REST_Controller {

    public function __construct() {
		parent::__construct();
	}

	public function home_get(){
		$this->resp->status = new stdClass();
		$this->resp->status->code = CIX_REST_Controller::HTTP_OK;
		// $this->resp->status->code = CIX_REST_Controller::HTTP_BAD_REQUEST;
		// $this->resp->status->message = 'hiba';
			$this->resp->data = true;
		
		$this->set_response($this->resp, $this->resp->status->code);
	}
}

?>