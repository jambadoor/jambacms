<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	abstract class Admin_Controller extends Base_Controller {

		public function __construct() {

			//all admin controllers require login
			$this->requires_login = true;
			$this->login_redirect = 'admin';

			parent::__construct();

			//all admin controllers will have this view_data
			$this->view_data['css_plugins'][] = 'semantic-ui/reset.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/site.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/grid.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/menu.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/dropdown.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/icon.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/image.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/form.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/button.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/segment.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/card.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/transition.css';

			$this->view_data['stylesheets'][] = 'admin.css';

			$this->view_data['js_plugins'][] = 'semantic-ui/dropdown.js';
			$this->view_data['js_plugins'][] = 'semantic-ui/form.js';
			$this->view_data['js_plugins'][] = 'semantic-ui/transition.js';

			$this->view_data['scripts'][] = 'admin.js';

			$this->view_data['layout'] = 'admin';
			$this->view_data['page'] = 'dashboard';

			//set the view path
			$this->load->set_view_path('admin');
		}
	}
?>
