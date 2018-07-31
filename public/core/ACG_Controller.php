<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ACG_Controller extends CI_Controller {

    protected $data;
    protected $cookie_police;
    protected $current_user;

    public function __construct() {
        parent::__construct();

        $this->current_user = $this->authentication_service->get_current_user();

        $this->read_global();
        $this->data = new stdClass();
        $this->data->modals = new stdClass();

        $this->data->meta = array();
        $this->data->appis = array();
        $this->data->css_files = array();
        $this->data->js_files = array();
        $this->data->output = array();

        if($this->input->cookie('cookie-police', TRUE) && $this->input->cookie('cookie-police', TRUE) == 'true')
            $this->cookie_police = true;
        else
            $this->cookie_police = false;

    }

    protected function render($page_template = '', $base = 'pages') {
        
        $base_data = array(
            'page_id' => strtolower($this->router->class),
            'meta' => !empty($this->data->meta) ? $this->data->meta : false,
            'appis' => $this->data->appis,
            'css_files' => $this->data->css_files,
            'js_files' => $this->data->js_files,
            'header' => $this->load->view('common/header', $this->data, true),
            'notification_html' => $this->load->view('widgets/modals/system_notifications', array('notifications' =>$this->system_notification->render(), 'level' => $this->system_notification->get_level()), true),
            'content' => $this->load->view($base .'/'. $page_template, $this->data->output, true),
            'cookie_police' => (!$this->cookie_police)? $this->load->view('common/cookie_police', $this->data, true) : false,
            'footer' => $this->load->view('common/footer', $this->data, true),
        );

        $this->load->view('common/main', $base_data);
    }

    private function read_global(){
        $global = $this->config->item('global');
        if(!empty($global['meta'])){
            foreach ($global['meta'] as $key => $value) {
                $this->set_meta($key, $value);
            }
        }
        if(!empty($global['css'])){
            foreach ($global['css'] as $value) {
                $this->set_css($value);
            }
        }
        
        if(!empty($global['js'])){
            foreach ($global['js'] as $value) {
                $this->set_js($value);
            }
        }

        if(!empty($global['appis'])){
            foreach ($global['appis'] as $key => $value) {
                if (!empty($key) && !empty($value)) {
                    $this->data->appis[$key] = $value;
                }
            }
        }
    }

    protected function set_js($value = '', $key = '', $path = false){
        if(!empty($value)){
            if(!preg_match("/http|www|\/\//", $value)){
                $value = (!empty($path)) ? $path . $value : base_url() . 'js/' . $value;
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
                $value = (!empty($path)) ? $path . $value : base_url() . 'css/' . $value;
            }

            if(!empty($key)){
                $this->data->css_files[$key] = $value;
            }else{
                $this->data->css_files[] = $value;
            }
        }
    }

    protected function set_meta($key, $value) {
        if (!empty($key) && !empty($value)) {
            $this->data->meta[$key] = $value;
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
