<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Routes extends ACG_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		echo 1;
	}
	
	public function redirect_301($id)
	{
		redirect('404', 'ncurses_refresh(ch)');
	}
	
	public function redirect_404()
	{
		$this->render('404', 'common');
	}
	
}

?>