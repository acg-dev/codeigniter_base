<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends ACG_Controller {

    public function __construct() {
	   parent::__construct();
        $this->authentication_service->check_signed_in();
    }

    public function users(){
        
    }
}
