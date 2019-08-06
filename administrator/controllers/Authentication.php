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
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm=""');
            header('HTTP/1.0 401 Unauthorized');
            exit;
        } else {
            if(!($_SERVER['PHP_AUTH_USER'] == ADMIN_USER && $this->authentication_service->password_verify($_SERVER['PHP_AUTH_PW'], ADMIN_PASS))){
                header('WWW-Authenticate: Basic realm=""');
                header('HTTP/1.0 401 Unauthorized');
                exit;
            }
        }

    	if($this->authentication_service->is_signed_in() ) {
    	    redirect('admin/dashboard');
    	}
    	
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
    	       redirect('admin/dashboard');
           }
    	} else {
            $this->system_notification->add('Hibás e-mail cím vagy jelszó!',  System_notification::LEVEL_ERROR);
    	    redirect('admin/login');
    	}
    }

    public function sign_out() {
        echo "string";
        // $this->authentication_service->sign_out();
	   // redirect('admin');
    }

}
