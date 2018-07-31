<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends ACG_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->render('home/index');
	}
}
