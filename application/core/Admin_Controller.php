<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author: Jason Benford
 * File: /application/core/Admin_Controller.php
 * Description: All of the admin dashboard controllers inherit from this.
 * 	We load up all of our stylesheets and stuff
 */
	abstract class Admin_Controller extends Protected_Controller {

		public function __construct() {
			$this->login_redirect = 'admin';

			parent::__construct();

			//global meta tags
			$this->view_data['metas'] = array();

			//admin css plugins
			$this->view_data['css_plugins'][] = 'semantic-ui/semantic.min.css';

			//admin js plugins
			$this->view_data['js_plugins'][] = 'jquery/jquery.js';
			$this->view_data['js_plugins'][] = 'semantic-ui/semantic.min.js';

			//admin scripts
			$this->view_data['scripts'][] = 'admin.js';

			//admin stylesheets
			$this->view_data['stylesheets'][] = 'admin.css';

			//admin layout globals
			$this->view_data['layout'] = 'admin';
			$this->view_data['page'] = 'dashboard';

			//our user
			$this->view_data['user'] = $this->user;

			//set the view path
			$this->load->set_view_path('admin');
		}

		//just in case somebody makes a new Admin_Controller and uses it before putting anything in it
		public function index() {
			echo "New Admin Controller";
		}
	}

// End of Admin_Controller class
/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */
