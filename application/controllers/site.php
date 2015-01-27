<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Site extends MY_Controller {

		public function __construct() {
			parent::__construct();

			//probably need to move this stuff to MY_Controller
			//see if there is a user object, MYController creates it if logged in
			if ($this->logged_in) {
				//get the table names
				$tables = $this->master_model->get_tables();

				//This is where you will be setting up your permissions for different user types.
				//Currently you have dev, admin, blogger, advertiser, and user types.
				$this->user->permissions = array();

				//dev gets all permissions
				if ($this->user->type == 'dev') {
					foreach ($tables as $table) {
						$this->user->permissions[$table] = array();
						$this->user->permissions[$table]['create'] = true;
						$this->user->permissions[$table]['read'] = true;
						$this->user->permissions[$table]['update'] = true;
						$this->user->permissions[$table]['delete'] = true;
					}
				}
				//likely so will admin, we will have to figure out the rest as we go.
			}

			//customize our view_data for this controller
			$this->view_data['layout'] = 'site';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/site.css">';
		}

		public function index() {
			$this->view_data['page'] = 'home';

			$this->load->view('master', $this->view_data);
		}

		public function testing() {
			$user = $this->authentication_model->get_user_object(1); 
		}
	}

?>
