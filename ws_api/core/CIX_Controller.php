<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class CIX_REST_Controller extends REST_Controller {

    public $current_user;

    public function __construct() {
	parent::__construct();
	// $this->current_user = $this->authentication_service->get_current_user();
	$this->resp = new stdClass();

	// if (false === $this->authentication_service->is_signed_in()) {
	// 		echo 'Nincs jogosultságod a művelet végrehajtásához.';
	// 		exit;
	// 	}
    }

}
