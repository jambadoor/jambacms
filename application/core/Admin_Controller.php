<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	abstract class Admin_Controller extends Base_Controller {

		public function __construct() {

			//all admin controllers require login
			$this->requires_login = true;
			$this->login_redirect = 'admin';

			parent::__construct();

			//all admin controllers will have this view_data
			$this->view_data['scripts'][] = '<script src="/assets/js/admin.js"></script>';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/admin.css">';
			$this->view_data['layout'] = 'admin';
			$this->view_data['page'] = 'dashboard';

			//set the view path
			$this->load->set_view_path('admin');
		}
	}
?>
