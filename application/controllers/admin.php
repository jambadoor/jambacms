<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends MY_Controller {

		public function __construct() {
			$this->requires_login = true;

			parent::__construct();
		}
		 
		public function index() {
			echo "Admin Controller";
		}
	
	}
?>
