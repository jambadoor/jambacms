<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author: Jason Benford
 * File: /application/core/MY_Loader.php
 * Description: An extension of CI_Loader for additional functionality
 */

	class MY_Loader extends CI_Loader {
		public function __construct() {
			parent::__construct();
		}

		//so we can easily use different view folders for different controllers
		public function set_view_path($view_path) {
			$this->_ci_view_paths = array(APPPATH.'views/'.$view_path.'/'	=> TRUE);
		}
	}

// End of MY_Loader class
/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */
