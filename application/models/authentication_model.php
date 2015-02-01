<?php
	class Authentication_Model extends CI_Model {

		public function __construct() {
			parent::__construct();

		}

		function valid_login($username, $password) {
			$query = $this->db->query("SELECT * FROM users WHERE username='$username' AND password='$password'");

			return ($query->num_rows == 1);
		}

		function get_user_object($id) {
			$query = $this->db->query("SELECT * FROM users WHERE id='$id'");
			
			if ($query->num_rows == 1) {
				$user = $query->result()[0];			

				//get rid of the password so we can send through http
				unset($user->password);

				return $user;
			} else {
				return null;
			}
		}

		function username_available($username) {
			$query = $this->db->query("SELECT (id) FROM users WHERE username='$username'");
			return ($query->num_rows === 0);
		}
	}
?>
