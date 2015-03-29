<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author: Jason Benford
 * File: /application/core/Public_Controller.php
 * Description: currently the top layer for all public controllers, no permissions or session stuff at all.
 * We basically just set up the view data that all public controllers will use, and log our hit in the analytics table
 */

	abstract class Public_Controller extends Base_Controller {
		protected view_data = array();	//this will contain all of the data that we pass to our views

		public function __construct() {
			parent::__construct();

			//because we have different views and assets for the two sides, we set our view_path using our cool extended loader
			$this->load->set_view_path('site');

			//global meta tags
			//TODO: get a list of needed metas to put in here.
			$this->view_data['metas'] = array();

			//global plugins, path relative to /plugins
			$this->view_data['css_plugins'][] = 'semantic-ui/semantic.min.css';
			$this->view_data['js_plugins'][] = 'jquery/jquery.js';
			$this->view_data['js_plugins'][] = 'semantic-ui/semantic.min.js';

			//global stylesheets, path relative to /assets/css
			$this->view_data['stylesheets'][] = 'site.css';

			//global scripts, path relative to /assets/js
			$this->view_data['scripts'][] = 'site.js';

			//log the hit in our db
			$this->load->model('analytics_model', 'analytics');
			$this->analytics->log();
		}

		// Just in case somebody creates an empty controller class and tries to visit it
		public function index() {
			echo "New Public Controller";
		}
	}

// End of Public_Controller class
/* End of file Public_Controller.php */
/* Location: ./application/core/Public_Controller.php */
