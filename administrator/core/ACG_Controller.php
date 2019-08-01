<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ACG_Controller extends CI_Controller {

    protected $data;
    protected $cookie_police;
    public $current_user;

    public function __construct() {
        parent::__construct();

        $this->current_user = $this->authentication_service->get_current_user();

        $this->data = new stdClass();
        $this->data->meta = array();
        $this->data->appis = array();
        $this->data->css_files = array();
        $this->data->js_files = array();
        $this->data->output = array();

        $this->read_global();
    }

    protected function render($page_template = '', $base = 'pages') {
        
        $base_data = array(
            'css_files' => $this->data->css_files,
            'js_files' => $this->data->js_files,
            'header' => $this->current_user->signed_in ? $this->load->view('common/header', $this->data, true) : '',
            'notification_html' => $this->load->view('widgets/modals/system_notifications', array('notifications' =>$this->system_notification->render(), 'level' => $this->system_notification->get_level()), true),
            'content' => $this->current_user->signed_in ? $this->load->view('common/body_frame', array( 'content' => $this->load->view($base .'/'. $page_template, $this->data->output, true)), true) : $this->load->view($base .'/'. $page_template, $this->data->output, true),
            'modals' => $this->modal->render(),
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
                if(is_object($value)){
                    $this->set_css($value->name, $value->key, $value->path);
                }else{
                    $this->set_css($value);
                }
            }
        }
        
        if(!empty($global['js'])){
            foreach ($global['js'] as $value) {
                if(is_object($value)){
                    $this->set_js($value->name, $value->key, $value->path);
                }else{
                    $this->set_js($value);
                }
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
                $value = (!empty($path)) ? $path . $value : base_url() . 'assets/admin/js/' . $value;
            }

            $value = str_replace(':base_url', base_url(), $value);

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

            $value = str_replace(':base_url', base_url(), $value);

            if(!empty($key)){
                $this->data->css_files[$key] = $value;
            }else{
                $this->data->css_files[] = $value;
            }
        }
    }

    protected function set_breadcrumb($title, $url = ''){
        if(!empty($title)){
            $this->data->breadcrumbs[] = (object) array('title' => $title, 'url' => $url);
        }
    }

   
    protected function set_view($name, $type, $variable_name = ''){
        if(!empty($name) && !empty($type)){
            if(empty($variable_name)){
                $variable_name = explode('/', $name);
                $variable_name = end($variable_name);
            }
            $this->data->views[$type][] = (object) array('name' => $name, 'variable_name' => $variable_name);
        }
    }

    protected function set_data($key, $value = ''){
        if(!empty($key)){
            $this->data->output[$key] = $value;
        }
    }

    public function get_data(){
        return $this->data->output;
    }


    protected function render_view($view){
        if(!empty($view)){
            return $this->load->view('pages/' . $view, $this->data->output, true);
        }      
        return false;
    }
}
