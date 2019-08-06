<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	/*Leíró oldalak*/ 

class Routes extends ACG_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function redirect_301($routes_redirect_url)
	{
		redirect($routes_redirect_url, 'location', '301');
	}
	
	public function redirect_404()
	{
		$this->set_response(array(), 404, 'Hibás oldal');
	}
}

?>