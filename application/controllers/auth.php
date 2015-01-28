<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Auth extends MY_Controller {

		public function index() {
			echo "auth controller";
		}

		public function login() {
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
				redirect("/");
			}
		}

		public function logout() {
			$this->session->sess_destroy();
			redirect('/');
		}
	}
?>
