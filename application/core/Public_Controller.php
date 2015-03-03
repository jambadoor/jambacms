<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	abstract class Public_Controller extends Base_Controller {
		public function __construct() {
			parent::__construct();

			//all of these belong to the site, set our view_path
			$this->load->set_view_path('site');

			//and the content model, and any other models that all site controllers will use
			$this->load->model('content_model', 'content');

			//global meta tags
			$this->view_data['metas'] = array();

			//global plugins
			$this->view_data['css_plugins'][] = 'semantic-ui/reset.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/site.css';
			$this->view_data['js_plugins'][] = 'jquery/jquery.js';
			$this->view_data['js_plugins'][] = 'semantic-ui/site.js';

			//global stylesheets
			$this->view_data['stylesheets'][] = 'site.css';

			//global scripts
			$this->view_data['scripts'][] = 'site.js';
		}

		public function index() {
			echo "New Public Controller";
		}
	}
?>
