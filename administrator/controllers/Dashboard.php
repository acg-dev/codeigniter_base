<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends ACG_Controller {

    public function __construct() {
	   parent::__construct();
        $this->authentication_service->check_signed_in();
    }

    public function index(){
    	$array = array(
    				'header' => array(),
    				'body' => array(),
    				);
    	$this->set_data('array', $array);
        $this->render('dashboard/index');
    }
}
