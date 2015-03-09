<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home extends Public_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('content_model', 'content');
			$this->load->model('blog_model', 'blog');

			$this->view_data['layout'] = 'main';
			$this->view_data['page'] = 'home';

			$this->view_data['css_plugins'][] = 'semantic-ui/menu.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/grid.css';
			
			$this->view_data['site_header'] = $this->content->get_by_name('site-header');
		}

		public function index($category = '', $item = '') {
			$this->view_data['welcome_to_jamba_cms'] = $this->content->get_by_name('welcome-to-jamba-cms');
			$this->view_data['latest_blog_entry'] = $this->blog->get_latest();

			$this->load->view('master', $this->view_data);
		}
	}
?>
