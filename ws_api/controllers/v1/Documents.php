<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends CIX_REST_Controller {

    public function __construct() {
		parent::__construct();
		$this->load->model(array('v1/documents_model'));
    }

    public function get_by_id_get( $id) {
		$this->resp->status_code = CIX_REST_Controller::HTTP_OK;
		$this->resp->data = $this->documents_model->get_file_by_id($id);
		$this->set_response($this->resp, CIX_REST_Controller::HTTP_OK);
    }

    public function get_by_item_id_get( $item_id, $item_type, $object_type = 'default') {
		$this->resp->status_code = CIX_REST_Controller::HTTP_OK;
		$this->resp->data = $this->documents_model->get_file($item_id, $item_type, $object_type);
		$this->set_response($this->resp, CIX_REST_Controller::HTTP_OK);
    }

    public function get_by_id_file_get($id) {
		$file = $this->documents_model->get_file_by_id($id);
		if($file){
			$this->load->helper('file_upload');
			download_file(app_url('documents') . $file->path . '/' . $file->file_name, $file->orig_name, $file->file_type);
		}else{
			echo "Fájl nem található";
		}
    }

    public function get_by_item_id_file_get( $item_id, $item_type) {
		$file = $this->documents_model->get_file($item_id, $item_type);
		if($file && !is_array($file)){
			$this->load->helper('file_upload');
			download_file(app_url('documents') . $file->path . '/' . $file->file_name, $file->orig_name, $file->file_type);
		}else{
			echo "Fájl nem található";
		}
		
    }

    public function upload_file_post($type_id, $type, $path) {
		$this->resp->status = new stdClass();
		
		$this->load->helper('file_upload');
		if(!($file = uploadFile('file', $path, 'jpg|png|jpeg|pdf|xls|xlsx|ppt|pptx|doc|docx', 20480))){
			$this->resp->status->code = CIX_REST_Controller::HTTP_BAD_REQUEST;
			$this->resp->status->message = 'A fájl feltöltése nem lehetséges!';
			$this->set_response($this->resp, $this->resp->status->code);
			exit;
		}

		$this->load->model(array('v1/documents_model'));
		$this->documents_model->insert_file($type_id, $type, $file->orig_name, $file->file_name, $file->file_type, $file->file_web_path);
		
		if(preg_match('/offer/', $type)){
			$this->load->model('v1/offer_model');
			$offer_id = explode('-', $type_id);
			if($offer = $this->offer_model->get_by_variation_id($offer_id[0], $offer_id[1])){
				$this->change_log($offer->job_id, $offer->variation_id,  $offer->name .' variációhoz ' . $file->file_name . ' fájlt töltöttek fel.');
			}
		}	
		
		$this->resp->status->code = CIX_REST_Controller::HTTP_OK;
		$this->resp->status->message = 'Sikeres művelet';
		$this->resp->data = $this->documents_model->get_file($type_id, $type, 'array');
		$this->set_response($this->resp, $this->resp->status->code);
	}

	public function remove_file_delete($id){
		$this->resp->status = new stdClass();
		if($file = $this->documents_model->get_file_by_id($id)){
			$this->documents_model->delete_file($id);
			unlink(UPLOAD_DOCUMENTS_ROOT . $file->path . $file->file_name);

			$this->resp->data = $this->documents_model->get_file($file->item_id, $file->item_type, 'array');
			$this->resp->status->code = CIX_REST_Controller::HTTP_OK;
			$this->resp->status->message = 'Sikeres művelet';
		}else{
			$this->resp->status->code = CIX_REST_Controller::HTTP_BAD_REQUEST;
			$this->resp->status->message = 'A fájl nem található!';
		}
		$this->set_response($this->resp, $this->resp->status->code);
	}
}