<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home extends Public_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('content_model', 'content');
			$this->view_data['content'] = $this->content->get_all_active();

			$this->view_data['css_plugins'][] = 'semantic-ui/grid.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/header.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/table.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/icon.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/accordion.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/divider.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/image.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/form.css';

			$this->view_data['js_plugins'][] = 'semantic-ui/accordion.js';
		}

		public function index() {
			$this->view_data['layout'] = 'one_page';
			$this->view_data['page'] = 'home';

			$this->load->view('master', $this->view_data);
		}

		public function test() {
		}
	}
?>
