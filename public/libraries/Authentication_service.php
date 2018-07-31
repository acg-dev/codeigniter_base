<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication_service {

    protected $session;
    protected $CI;
    protected $default_user = array(
    	'id' => null,
    	'email' => null,
    	'display_name' => 'Vendég',
    	'role' => 'GUEST',
    	'signed_in' => false
    );

    public function __construct() {
		$this->CI = & get_instance();
		$this->session = $this->CI->session;
		if (null === $this->session->userdata('current_user')) {
		    $this->session->set_userdata('current_user', (object) $this->default_user);
		}
    }


    public function is_signed_in() {
		return $this->get_current_user()->signed_in;
    }

    public function check_signed_in(){
    	if(!$this->get_current_user()->signed_in){
    		$this->CI->system_notification->add('Az oldal megtekintéséhez be kell lépni!', System_notification::LEVEL_ERROR);
    		$get_params = $this->CI->input->get(NULL, True);
    		$get_params['route'] = $this->CI->uri->uri_string(); 
    		redirect('belepes'. '?' . http_build_query($get_params));
        }
    }

    public function sign_in($password, $user) {
	    if(!empty($user) && $this->password_verify($password, $user->password)){
            unset($user->password);
            $this->save_session($user);
            return true;
        }

        return false;
    }

    public function sign_out() {
		$this->session->unset_userdata('current_user');
		$this->session->sess_destroy();
		return true;
    }

    private function save_session($user) {
		$this->session->set_userdata('current_user', (object) $user);
    }

    public function get_current_user() {
		return $this->session->userdata('current_user');
    }

    public function encrypt_password($pwd) {
        return password_hash($pwd, PASSWORD_BCRYPT);
    }

    public function password_verify($pwd, $hash) {
		return password_hash($pwd, $hash);
    }
}
