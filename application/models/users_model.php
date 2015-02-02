<?php
	class Users_Model extends MY_Model {

		public function __construct() {
			$this->table = 'users';

			parent::__construct();
		}

		public function get_all() {
			$users = $this->db->query("SELECT * FROM users WHERE active=1")->result();
			
			foreach ($users as $user) {
				unset($user->password);
			}

			return $users;
		}

		public function get_id($username) {
			$query = $this->db->query("SELECT (id) FROM users WHERE username='$username'");

			if ($query->num_rows === 1) {
				return $query->result()[0]->id;
			} else {
				exit("Either 0 or more than one results with that id");
			}
		}

		public function soft_delete($id) {
			$query = $this->db->query("UPDATE users SET active=0 WHERE id=$id");
			//some kind of error handling
		}

		public function get($id) {
			$query = $this->db->query("SELECT * FROM users WHERE id=$id");
			if ($query->num_rows === 1) {
				$user = $query->result()[0];
				unset($user->password);
			} else {
				exit("Either 0 or more than one results with that id");
			}
			return $user;
		}
	}
?>
