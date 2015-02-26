<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home extends Public_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('content_model', 'content');
			$this->view_data['layout'] = 'home';
			$this->view_data['content'] = $this->content->get_all();
		}

		public function index() {
			$this->view_data['page'] = 'home';

			$this->load->view('master', $this->view_data);
		}
	}
?>
