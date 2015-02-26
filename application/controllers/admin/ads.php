<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Ads extends Admin_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function index() {
			//load our home tab
			$this->view_data['tab'] = 'ads';
			$this->view_data['tab_content'] = 'blocks/ads';
			$this->load->view('master', $this->view_data);
		}
	}
?>
