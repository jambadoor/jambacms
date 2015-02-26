<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home extends Admin_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function index() {
			//load our home tab
			$this->view_data['tab'] = 'home';
			$this->view_data['tab_content'] = 'blocks/home';
			$this->load->view('master', $this->view_data);
		}
	}
?>
