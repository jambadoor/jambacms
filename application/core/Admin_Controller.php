<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	abstract class Admin_Controller extends Protected_Controller {

		public function __construct() {
			parent::__construct();

			//trying something out for prettier code
			$this->view_data['indent_level'] = 0;
			//global meta tags
			$this->view_data['metas'] = array();

			$this->view_data['css_plugins'] = array();

			//our fancy new ui class
			$this->load->library('UI');


			//admin js plugins
			$this->view_data['js_plugins'][] = 'jquery/jquery.js';
			$this->view_data['js_plugins'][] = 'semantic-ui/dropdown.js';
			$this->view_data['js_plugins'][] = 'semantic-ui/transition.js';

			//admin stylesheets
			$this->view_data['scripts'][] = 'admin.js';
			$this->view_data['stylesheets'][] = 'admin.css';

			//admin layout globals
			$this->view_data['layout'] = 'admin';
			$this->view_data['page'] = 'dashboard';

			//our user
			$this->view_data['user'] = $this->user;

			//set the view path
			$this->load->set_view_path('admin');
		}

		public function index() {
			echo "New Admin Controller";
		}
	}
?>
