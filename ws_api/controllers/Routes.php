<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Routes extends CIX_REST_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index_get()
	{
		echo '';
	}
	
	public function redirect_301_get($id)
	{
		redirect('404', 'ncurses_refresh(ch)');
	}
	
	public function redirect_404_get()
	{
		echo '404';
	}
	
}

?>