<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	abstract class Admin_Controller extends Base_Controller {

		public function __construct() {

			//all admin controllers require login
			$this->requires_login = true;
			$this->login_redirect = 'admin';

			parent::__construct();

			//all admin controllers will have this view_data
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/reset.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/site.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/grid.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/menu.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/dropdown.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/icon.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/image.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/form.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/button.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/segment.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/card.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/transition.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/admin.css">';

			$this->view_data['scripts'][] = '<script src="/bower_components/semantic-ui/dist/components/dropdown.js"></script>';
			$this->view_data['scripts'][] = '<script src="/bower_components/semantic-ui/dist/components/form.js"></script>';
			$this->view_data['scripts'][] = '<script src="/bower_components/semantic-ui/dist/components/transition.js"></script>';
			$this->view_data['scripts'][] = '<script src="/assets/js/admin.js"></script>';

			$this->view_data['layout'] = 'admin';
			$this->view_data['page'] = 'dashboard';

			//set the view path
			$this->load->set_view_path('admin');
		}
	}
?>
