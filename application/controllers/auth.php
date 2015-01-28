<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Auth extends MY_Controller {
		public function __construct() {

			parent::__construct();
		}

		public function index() {
			echo "auth controller";
		}

		//our login page
		public function login($message = '') {
			$this->view_data['layout'] = 'site';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/admin.css">';
			$this->view_data['scripts'][] = '<script src="/assets/js/admin.js"></script>';
			$this->view_data['page'] = 'form';
			$this->view_data['form'] = 'login';
			$this->load->view('master', $this->view_data);
		}

		public function authenticate() {
			$username = $this->input->post('username');
			$password = sha1($this->input->post('password'));

			echo $username." ".$password;

			//check if valid
			if ($this->authentication_model->valid_login($username, $password)) {
				//if so, log the user in!
				$userdata = array();
				$userdata['user_id'] = $this->authentication_model->get_user_id($username);
				$userdata['is_logged_in'] = true;

				$this->session->set_userdata($userdata);
				redirect("admin");
			} else {
				redirect("/admin/login/retry");
			}
		}

		public function logout() {
			$this->session->sess_destroy();
			redirect('/auth/login');
		}
	}
?>
