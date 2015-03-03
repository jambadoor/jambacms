<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Auth extends Public_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model('authentication_model', 'auth');
		}

		public function index() {
		}

		//our login page
		public function login($redirect='admin') {
			//put the redirect in flashdata
			$this->session->set_flashdata('redirect', $redirect);

			//load up the view_data
			$this->view_data['layout'] = 'home';
			$this->view_data['page'] = 'form';
			$this->view_data['form'] = 'login';

			//some plugins
			$this->view_data['css_plugins'][] = 'semantic-ui/form.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/grid.css';

			$this->view_data['js_plugins'][] = 'semantic-ui/form.js';

			//and the view
			$this->load->view('master', $this->view_data);
		}

		public function authenticate() {
			$username = $this->input->post('username');
			$password = sha1($this->input->post('password'));

			//check if valid
			if ($this->auth->valid_login($username, $password)) {
				//if so, log the user in!
				$userdata = array();
				$userdata['user_id'] = $this->auth->get_user_id($username);
				$userdata['is_logged_in'] = true;

				//give the session the data
				$this->session->set_userdata($userdata);

				redirect($this->session->flashdata('redirect'));
			} else {
				redirect('auth/login'.$this->login_redirect);
			}
		}

		public function logout() {
			$this->session->sess_destroy();
			redirect('/auth/login');
		}
	}
?>
