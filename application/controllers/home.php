<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home extends Public_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('articles_model', 'articles');

			$this->view_data['layout'] = 'main';
			$this->view_data['page'] = 'home';

			$this->view_data['site_header'] = $this->articles->get_by_name('site-header');
		}

		public function index($category = '', $item = '') {
			$this->view_data['welcome_to_jamba_cms'] = $this->articles->get_by_name('welcome-to-jamba-cms');

			$this->load->view('master', $this->view_data);
		}

	}
