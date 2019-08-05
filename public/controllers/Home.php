<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends ACG_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->set_js('vue/home.js');
		$this->render('home/index');
	}
	public function home()
	{
		echo "2";
		// $this->set_js('vue/home.js');
		// $this->render('home/index');
	}
}
