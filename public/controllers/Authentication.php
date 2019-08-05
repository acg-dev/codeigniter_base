<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends ACG_Controller {

    public function __construct() {
    	parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        $this->show_login_form();
    }

    public function show_login_form() {
    	if($this->authentication_service->is_signed_in() ) {
    	    redirect('dashboard');
    	}
    	
        $this->set_data('get_params', $this->input->get(NULL, True));
        $this->render('login', 'auth');
    }

    public function sign_in() {
    	$email = $this->input->post('email');
    	$pwd = $this->input->post('pwd');
    	
        $user = $this->user_model->get_by_email($email);

    	if (true === $this->authentication_service->sign_in($pwd, $user)) {
            $get_params = $this->input->get(NULL, True);
            if($get_params['route']){
                $route = $get_params['route'];
                unset($get_params['route']);

                if(count($get_params) > 0){
                    $get_params = '?' . http_build_query($get_params);
                }else{
                    $get_params = '';
                }

                redirect($route . $get_params);
            }else{
    	       redirect('dashboard');
           }
    	} else {
            $this->system_notification->add('Hibás e-mail cím vagy jelszó!',  System_notification::LEVEL_ERROR);
    	    redirect('login');
    	}
    }

    public function sign_out() {
        $this->authentication_service->sign_out();
	   redirect('login');
    }

}
