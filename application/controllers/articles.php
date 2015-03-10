<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Articles extends Public_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('articles_model', 'articles');

			$this->view_data['layout'] = 'main';

			$this->view_data['css_plugins'][] = 'semantic-ui/menu.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/grid.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/segment.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/list.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/breadcrumb.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/icon.css';

			
			$this->view_data['site_header'] = $this->articles->get_by_name('site-header');
		}

		public function index() {
			$this->view();
		}

		public function view ($category = '', $name = '') {
			$this->view_data['categories'] = $this->articles->get_categories();

			if ($name === '') {
				//if there is nothing supplied
				if ($category === '') {
					//load up the list of all content
					$this->view_data['article'] = $this->articles->get_latest();
					$this->view_data['articles'] = $this->articles->get_by_category();
				//if there is a category supplied
				} else {
					$this->view_data['article'] = $this->articles->get_latest($category);
					$this->view_data['articles'][$category] = $this->articles->get_by_category($category);
				}
			} else {
				//if everything is supplied
				$this->view_data['article'] = $this->articles->get_by_category($category, $name);
				$this->view_data['articles'][$category] = $this->articles->get_by_category($category);
			} 
			$this->view_data['page'] = 'article';

			$this->load->view('master', $this->view_data);
		}
	}
?>
