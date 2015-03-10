<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Analytics extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->view_data['tab'] = 'analytics';

			$this->load->model('analytics_model', 'analytics');
		}

		public function index() {
			//load our home tab
			$this->view_data['hits'] = $this->analytics->get_all();
			$this->view_data['tab_content'] = 'blocks/hits_list';
			$this->load->view('master', $this->view_data);
		}

		public function generate_data() {
		}
	}
?>
