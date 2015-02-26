<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Blog extends Admin_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function index() {
			//load our home tab
			$this->view_data['tab'] = 'blog';
			$this->view_data['tab_content'] = 'blocks/blog';
			$this->load->view('master', $this->view_data);
		}
	}
?>
