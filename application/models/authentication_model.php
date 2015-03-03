<?php
	class Authentication_Model extends CI_Model {

		public function __construct() {
			parent::__construct();

		}

		function get_user_object($id) {
			$query = $this->db->where('id', $id)->get('users');
			
			if ($query->num_rows == 1) {
				$user = $query->result()[0];			

				//get rid of the password so we can send through http
				unset($user->password);

				return $user;
			} else {
				return null;
			}
		}

		function valid_login($username, $password) {
			$query = $this->db->where('username', $username)->where('password', $password)->where('active', 1)->get('users');

			return ($query->num_rows === 1);
		}


		function username_available($username) {
			$query = $this->db->where('username', $username)->get('users');

			return ($query->num_rows === 0);
		}
	}
?>
