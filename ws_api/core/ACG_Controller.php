<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ACG_Controller extends CI_Controller {
	public $current_language = null;
    public $currency = null;
    public $languages = null;
    public $current_user;
    protected $response;

    protected $_supported_formats = [
            'json' => 'application/json',
            'array' => 'application/json',
            'csv' => 'application/csv',
            'html' => 'text/html',
            'jsonp' => 'application/javascript',
            'php' => 'text/plain',
            'serialized' => 'application/vnd.php.serialized',
            'xml' => 'application/xml'
        ];

    protected $http_code = array(
        // Informational

        100 => 'HTTP CONTINUE',
        101 => 'HTTP SWITCHING PROTOCOLS',
        102 => 'HTTP PROCESSING',            // RFC2518

        // Success

        /**
         * The request has succeeded
         */
        200 => 'HTTP OK',

        /**
         * The server successfully created a new resource
         */
        201 => 'HTTP CREATED',
        202 => 'HTTP ACCEPTED',
        203 => 'HTTP NON AUTHORITATIVE INFORMATION',

        /**
         * The server successfully processed the request, though no content is returned
         */
        204 => 'HTTP NO CONTENT',
        205 => 'HTTP RESET CONTENT',
        206 => 'HTTP PARTIAL CONTENT',
        207 => 'HTTP MULTI STATUS',          // RFC4918
        208 => 'HTTP ALREADY REPORTED',      // RFC5842
        226 => 'HTTP IM USED',               // RFC3229

        // Redirection

        300 => 'HTTP MULTIPLE CHOICES',
        301 => 'HTTP MOVED PERMANENTLY',
        302 => 'HTTP FOUND',
        303 => 'HTTP SEE OTHER',

        /**
         * The resource has not been modified since the last request
         */
        304 => 'HTTP NOT MODIFIED',
        305 => 'HTTP USE PROXY',
        306 => 'HTTP RESERVED',
        307 => 'HTTP TEMPORARY REDIRECT',
        308 => 'HTTP PERMANENTLY REDIRECT',  // RFC7238

        // Client Error

        /**
         * The request cannot be fulfilled due to multiple errors
         */
        400 => 'HTTP BAD REQUEST',

        /**
         * The user is unauthorized to access the requested resource
         */
        401 => 'HTTP UNAUTHORIZED',
        402 => 'HTTP PAYMENT REQUIRED',

        /**
         * The requested resource is unavailable at this present time
         */
        403 => 'HTTP FORBIDDEN',

        /**
         * The requested resource could not be found
         *
         * Note: This is sometimes used to mask if there was an UNAUTHORIZED (401) or
         * FORBIDDEN (403) error, for security reasons
         */
        404 => 'HTTP NOT FOUND',

        /**
         * The request method is not supported by the following resource
         */
        405 => 'HTTP METHOD NOT ALLOWED',

        /**
         * The request was not acceptable
         */
        406 => 'HTTP NOT ACCEPTABLE',
        407 => 'HTTP PROXY AUTHENTICATION REQUIRED',
        408 => 'HTTP REQUEST TIMEOUT',

        /**
         * The request could not be completed due to a conflict with the current state
         * of the resource
         */
        409 => 'HTTP CONFLICT',
        410 => 'HTTP GONE',
        411 => 'HTTP LENGTH REQUIRED',
        412 => 'HTTP PRECONDITION FAILED',
        413 => 'HTTP REQUEST ENTITY TOO LARGE',
        414 => 'HTTP REQUEST URI TOO LONG',
        415 => 'HTTP UNSUPPORTED MEDIA TYPE',
        416 => 'HTTP REQUESTED RANGE NOT SATISFIABLE',
        417 => 'HTTP EXPECTATION FAILED',
        418 => 'HTTP I AM A TEAPOT',                                               // RFC2324
        422 => 'HTTP UNPROCESSABLE ENTITY',                                        // RFC4918
        423 => 'HTTP LOCKED',                                                      // RFC4918
        424 => 'HTTP FAILED DEPENDENCY',                                           // RFC4918
        425 => 'HTTP RESERVED FOR WEBDAV ADVANCED COLLECTIONS EXPIRED PROPOSAL',   // RFC2817
        426 => 'HTTP UPGRADE REQUIRED',                                            // RFC2817
        428 => 'HTTP PRECONDITION REQUIRED',                                       // RFC6585
        429 => 'HTTP TOO MANY REQUESTS',                                           // RFC6585
        431 => 'HTTP REQUEST HEADER FIELDS TOO LARGE',                             // RFC6585

        // Server Error

        /**
         * The server encountered an unexpected error
         *
         * Note: This is a generic error message when no specific message
         * is suitable
         */
        500 => 'HTTP INTERNAL SERVER ERROR',

        /**
         * The server does not recognise the request method
         */
        501 => 'HTTP NOT IMPLEMENTED',
        502 => 'HTTP BAD GATEWAY',
        503 => 'HTTP SERVICE UNAVAILABLE',
        504 => 'HTTP GATEWAY TIMEOUT',
        505 => 'HTTP VERSION NOT SUPPORTED',
        506 => 'HTTP VARIANT ALSO NEGOTIATES EXPERIMENTAL',                        // RFC2295
        507 => 'HTTP INSUFFICIENT STORAGE',                                        // RFC4918
        508 => 'HTTP LOOP DETECTED',                                               // RFC5842
        510 => 'HTTP NOT EXTENDED',                                                // RFC2774
        511 => 'HTTP NETWORK AUTHENTICATION REQUIRED',
    );

    public function __construct() {
		parent::__construct();

		$this->response = new stdClass();
		$this->response->format = $this->detect_output_format();
		
		$this->load_language();
	    $this->set_currency();

	// $this->current_user = $this->authentication_service->get_current_user();

	// if (false === $this->authentication_service->is_signed_in()) {
	// 		echo 'Nincs jogosultságod a művelet végrehajtásához.';
	// 		exit;
	// 	}

    }

    public function set_response($data, $http_code, $message = ''){
    	ob_start();
        if ($http_code !== NULL){
            $http_code = (int) $http_code;
        }

        $output = NULL;
        if(empty($message)){
        	$message = $this->http_code[$http_code];
        }

        $data = array('status' => array('code' => $http_code, 'message' => $message), 'data' => $data);

        if ($data === NULL && $http_code === NULL){
            $http_code = 404;
        }elseif ($data !== NULL){
            if (method_exists($this->format, 'to_' . $this->response->format)){
                // Set the format header
                $this->output->set_content_type($this->_supported_formats[$this->response->format], strtolower($this->config->item('charset')));
                $output = $this->format->factory($data)->{'to_' . $this->response->format}();

                // An array must be parsed as a string, so as not to cause an array to string error
                // Json is the most appropriate form for such a data type
                if ($this->response->format === 'array'){
                    $output = $this->format->factory($output)->{'to_json'}();
                }
            }else{
                // If an array or object, then parse as a json, so as to be a 'string'
                if (is_array($data) || is_object($data)){
                    $data = $this->format->factory($data)->{'to_json'}();
                }

                // Format is not supported, so output the raw data as a string
                $output = $data;
            }
        }

        // If not greater than zero, then set the HTTP status code as 200 by default
        // Though perhaps 500 should be set instead, for the developer not passing a
        // correct HTTP status code
        $http_code > 0 || $http_code = 200;

        $this->output->set_status_header($http_code, $message);
        
        // Output the data
        $this->output->set_output($output);

        ob_end_flush();
    }

    protected function detect_output_format()
    {
        // Get the HTTP_ACCEPT server variable
        $http_accept = $this->input->server('HTTP_ACCEPT');

        // Otherwise, check the HTTP_ACCEPT server variable
        if ($http_accept !== NULL)
        {
            // Check all formats against the HTTP_ACCEPT header
            foreach (array_keys($this->_supported_formats) as $format)
            {
                // Has this format been requested?
                if (strpos($http_accept, $format) !== FALSE)
                {
                    if ($format !== 'html' && $format !== 'xml')
                    {
                        // If not HTML or XML assume it's correct
                        return $format;
                    }
                    elseif ($format === 'html' && strpos($http_accept, 'xml') === FALSE)
                    {
                        // HTML or XML have shown up as a match
                        // If it is truly HTML, it wont want any XML
                        return $format;
                    }
                    else if ($format === 'xml' && strpos($http_accept, 'html') === FALSE)
                    {
                        // If it is truly XML, it wont want any HTML
                        return $format;
                    }
                }
            }
        }

        // Obtain the default format from the configuration
        return $this->get_default_output_format();
    }

    protected function get_default_output_format()
    {
        $default_format = (string) $this->config->item('api_default_format');
        return $default_format === '' ? 'json' : $default_format;
    }












    protected function load_language() {
        $this->languages = $this->config->item('languages');
        $current_language = $this->config->item('application_default_language_key');
        // Ha többnyelvű az oldal
        if( $this->session->userdata('current_language')){
        	$current_language = $this->session->userdata('current_language');
        }

        $this->current_language = $this->languages[$current_language];

        $this->lang->load('global', $this->current_language['folder']);
    }

    protected function set_currency() {
        if( null === $this->session->userdata('currency') ) {
            $this->session->set_userdata('currency',$this->config->item('currencies')[$this->config->item('application_default_currency_key')]);
        }
        $this->currency = $this->session->userdata('currency');
    }
}
