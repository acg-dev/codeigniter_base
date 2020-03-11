<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Documents extends ACG_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('v1/documents_model'));
		$this->permission_service->set('logged');
	}

	public function get_by_id($id)
	{
		$this->set_response($this->documents_model->get_file_by_id($id), 200);
	}

	public function get_by_item_id($item_id, $item_type, $object_type = 'default')
	{
		$this->set_response($this->documents_model->get_file($item_id, $item_type, $object_type), 200);
	}

	public function get_by_id_file($id)
	{
		$file = $this->documents_model->get_file_by_id($id);
		if ($file) {
			$this->load->helper('file_upload');
			download_file(app_url('documents') . $file->path . '/' . $file->file_name, $file->orig_name, $file->file_type);
		} else {
			echo "Fájl nem található";
		}
	}

	public function get_by_item_id_file($item_id, $item_type)
	{
		$file = $this->documents_model->get_file($item_id, $item_type);
		if ($file && !is_array($file)) {
			$this->load->helper('file_upload');
			download_file(app_url('documents') . $file->path . '/' . $file->file_name, $file->orig_name, $file->file_type);
		} else {
			echo "Fájl nem található";
		}
	}

	public function upload_file($type_id, $type, $path)
	{
		$this->load->helper('file_upload');
		if (($file = uploadFile('file', $path, 'JPG|jpg|png|jpeg|pdf|svg', 20480)) && !$file->status) {
			$this->set_response('', 400, $file->message);
			exit;
		}

		$this->load->model(array('v1/documents_model'));
		$this->documents_model->insert_file($type_id, $type, $file->orig_name, $file->file_name, $file->file_type, $file->file_web_path);

		$this->set_response($this->documents_model->get_file($type_id, $type, 'array'), 200);
	}

	public function remove_file($id, $type = false){
		$this->remove_files($id, $type);
	}

	public function remove_files($id, $type = false)
	{
		if ($type) {
			$files = $this->documents_model->get_file($id, $type, 'array');
		} else {
			$files = [$this->documents_model->get_file_by_id($id)];
		}
		if ($files) {
			foreach ($files as $file) {
				$this->documents_model->delete_file($file->id);
				unlink(UPLOAD_DOCUMENTS_ROOT . $file->path . $file->file_name);
			}
			$this->set_response($this->documents_model->get_file($file->item_id, $file->item_type, 'array'), 200);
		} else {
			$this->set_response('', 200);
		}
	}
}
