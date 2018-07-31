<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class System_notification {
	
	const LEVEL_INFO = 'INFO';
	const LEVEL_WARNING = 'WARNING';
	const LEVEL_ERROR = 'ERROR';
	const LEVEL_SUCCESS = 'SUCCESS';
	const LEVEL_CUSTOM = 'CUSTOM';
	
	private $predefined_notifications = array();
	private $loaded_notifications = array();
	private $session;
	
	public function __construct() {
		$this->session = &get_instance()->session;
		if( null !== $this->session->flashdata('system_notification') ) {
			$this->loaded_notifications = unserialize($this->session->flashdata('system_notification'));
		}
	}
	
	public function add( $message , $level ) {
		$item = new System_notification_item( $message , $level );
		$this->predefined_notifications[] = $item;
		$this->update_session($this->predefined_notifications);
	}
	
	public function get_all() {
		return $this->loaded_notifications;
	}
	
	public function has_notification_to_show() {
		return ( 0 < count($this->loaded_notifications));
	}
	
	public function update_session() {
		$this->session->set_flashdata('system_notification',serialize($this->predefined_notifications));
	}
	
	public function render() {
		if(empty($this->loaded_notifications))
			return false;

		$output_html = array();
		$output_html[self::LEVEL_CUSTOM] = new stdClass();
		$output_html[self::LEVEL_SUCCESS] = new stdClass();
		$output_html[self::LEVEL_ERROR] = new stdClass();
		$output_html[self::LEVEL_WARNING] = new stdClass();
		$output_html[self::LEVEL_INFO] = new stdClass();

		foreach( $this->loaded_notifications as $noti ) {
			$output_html[$noti->level]->messages[] = $noti->message;
		}

		return $output_html;
	}

	public function get_level(){
		foreach( $this->loaded_notifications as $noti ) {
			return $noti->level;
		}		
	}
	
}

class System_notification_item {
	public $level;
	public $message;
	public function __construct( $message = null , $level = null ) {
		$this->message = ( null === $message ) ? '' : $message;
		$this->level = ( null === $level ) ? System_notification::LEVEL_INFO : $level ;
	}
}