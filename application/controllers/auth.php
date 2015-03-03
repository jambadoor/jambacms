<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Auth extends Public_Controller {
		public function __construct() {
			parent::__construct();
			$this->view_data['content'] = $this->content->get_all();
		}

		public function index() {
		}

		//our login page
		public function login($redirect='admin') {
			//put the redirect in flashdata
			$this->session->set_flashdata('redirect', $redirect);

			//load up the view_data
			$this->view_data['layout'] = 'home';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/reset.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/site.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/bower_components/semantic-ui/dist/components/form.css">';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/admin.css">';
			$this->view_data['scripts'][] = '<script src="/assets/js/admin.js"></script>';
			$this->view_data['page'] = 'form';
			$this->view_data['form'] = 'login';

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
				$userdata['user_id'] = $this->users->get_id($username);
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
