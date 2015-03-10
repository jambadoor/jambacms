<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UI_Form {
	var $CI;
	var $html;

	/*
	 * CONSTRUCTOR
	 * set up our ci instance and load in the required semantic files
	 */
	public function __construct() {
		$CI =& get_instance();
		$this->CI =& $CI;
		if (!in_array('semantic-ui/form.css', $CI->view_data['css_plugins'])) $CI->view_data['css_plugins'][] = 'semantic-ui/form.css';
		if (!in_array('semantic-ui/form.js', $CI->view_data['js_plugins'])) $CI->view_data['js_plugins'][] = 'semantic-ui/form.js';
	}

	public function open($config) {


	}
}
?>

