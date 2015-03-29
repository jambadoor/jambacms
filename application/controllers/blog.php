<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Blog extends Public_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('content_model', 'content');
			$this->load->model('blog_model', 'blog');

			$this->view_data['layout'] = 'main';
			$this->view_data['page'] = 'blog';

			$this->view_data['css_plugins'][] = 'semantic-ui/menu.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/grid.css';
		}

		public function index() {
			$this->view_data['site_header'] = $this->content->get_by_name('site-header');
			$this->view_data['blog_entries'] = $this->blog->get_all_active();
			$this->load->view('master', $this->view_data);
		}
	}
