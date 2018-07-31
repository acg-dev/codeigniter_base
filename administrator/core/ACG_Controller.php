<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ACG_Controller extends CI_Controller {

    protected $data;
    protected $cookie_police;
    protected $current_user;

    public function __construct() {
        parent::__construct();

        $this->current_user = $this->authentication_service->get_current_user();

        $this->data = new stdClass();
        $this->data->modals = new stdClass();

        $this->data->css_files = array();
        $this->data->js_files = array();
        $this->data->output = array();
    }

    protected function render($page_template = '', $base = 'pages') {
        
        $base_data = array(
            'css_files' => $this->data->css_files,
            'js_files' => $this->data->js_files,
            'header' => $this->current_user->signed_in ? $this->load->view('common/header', $this->data, true) : '',
            'notification_html' => $this->load->view('widgets/modals/system_notifications', array('notifications' =>$this->system_notification->render(), 'level' => $this->system_notification->get_level()), true),
            'content' => $this->current_user->signed_in ? $this->load->view('common/body_frame', array( 'content' => $this->load->view($base .'/'. $page_template, $this->data->output, true)), true) : $this->load->view($base .'/'. $page_template, $this->data->output, true),
            'footer' => $this->load->view('common/footer', $this->data, true),
        );

        $this->load->view('common/main', $base_data);
    }


    protected function set_js($value = '', $key = '', $path = false){
        if(!empty($value)){
            if(!preg_match("/http|www|\/\//", $value)){
                $value = (!empty($path)) ? $path . $value : base_url() . 'assets/admin/js/' . $value;
            }

            if(!empty($key)){
                $this->data->js_files[$key] = $value;
            }else{
                $this->data->js_files[] = $value;
            }
        }
    }

    protected function set_css($value, $key = '', $path = false){
        if(!empty($value)){
            if(!preg_match("/http|www|\/\//", $value)){
                $value = (!empty($path)) ? $path . $value : base_url() . 'assets/admin/css/' . $value;
            }

            if(!empty($key)){
                $this->data->css_files[$key] = $value;
            }else{
                $this->data->css_files[] = $value;
            }
        }
    }

    protected function set_data($key, $value = ''){
        if(!empty($key)){
            $this->data->output[$key] = $value;
        }
    }


    protected function render_view($view){
        if(!empty($view)){
            return $this->load->view('pages/' . $view, $this->data->output, true);
        }      
        return false;
    }
}
