<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication_service {

    protected $session;
    protected $default_user = array(
	'id' => null,
	'email' => null,
	'display_name' => 'Vendég',
	'role' => 'GUEST',
	'signed_in' => false
    );

    public function __construct() {
	$this->session = &get_instance()->session;
	if (null === $this->session->userdata('current_user')) {
	    $this->session->set_userdata('current_user', (object) $this->default_user);
	}
    }

    public function is_signed_in() {
	return $this->get_session()->signed_in;
    }

    public function sign_in($password, $user, $use_pwd_verify = false) {
	if (false === $use_pwd_verify) {
	    $retval = ( md5($password) == $user->md5_password );
	} else {
	    $retval = password_verify($password, $user->password);
	}
	if (true === $retval) {
	    $user->signed_in = true;
	    $this->save_session($user);
	}
	return $retval;
    }

    public function sign_out() {
	$this->session->unset_userdata('current_user');
	$this->session->sess_destroy();
	return true;
    }

    public function save_session($user) {
	$this->session->set_userdata('current_user', (object) $user);
    }

    public function get_session() {
	return $this->session->userdata('current_user');
    }

    public function get_current_user() {
	return $this->get_session();
    }

    public function is_quest() {
	return !($this->is_signed_in());
    }

    public function encrypt_paddword($pwd) {
	$encrypted_pwd = password_hash($pwd, PASSWORD_DEFAULT);
	return $encrypted_pwd;
    }

}
