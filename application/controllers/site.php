<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Site extends MY_Controller {

		public function __construct() {
			parent::__construct();

			//get the table names
			$tables = $this->master_model->get_tables();

			//see if there is a user object, MYController creates it if logged in
			if (isset($this->user)) {

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
			}
		
		}

		public function index() {
			print("Index");
			$data = array(
				'metas' => array(),
				'stylesheets' => array(
					'<link rel="stylesheet" href="assets/css/site.css">',
					'<link rel="stylesheet" href="bower_components/semantic-ui/dist/semantic.css">',
				),
				'scripts' => array(
					'<script src="bower_components/jquery/dist/jquery.js"></script>',
					'<script src="bower_components/semantic-ui/dist/semantic.js"></script>',
				),
				'layout' => 'site',
				'page' => 'home'
			);

			$this->load->view('master', $data);
		}

		public function testing() {
			echo "TESTING";
			$this->authentication_model->get_user_object(1); 
		}
	}

?>
