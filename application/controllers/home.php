<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home extends Public_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('content_model', 'content');
			$this->view_data['content'] = $this->content->get_all();

			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/reset.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/site.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/grid.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/header.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/table.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/icon.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/accordion.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/divider.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/image.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/form.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/site.css">';


			$this->view_data['scripts'][] = '<script src="/bower_components/semantic-ui/dist/components/site.js"></script>';
			$this->view_data['scripts'][] = '<script src="/bower_components/semantic-ui/dist/components/accordion.js"></script>';

			$this->view_data['scripts'][] = '<script src="/assets/js/site.js"></script>';
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
