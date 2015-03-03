<?php
	class Users_Model extends MY_Model {

		public function __construct() {
			$this->table = 'users';

			parent::__construct();
		}

		public function get_all() {
			$users = $this->db->where('active', 1)->get($this->table)->result();
			
			foreach ($users as $user) {
				unset($user->password);
			}

			return $users;
		}

		public function get_id($username) {
			$query = $this->db->where('username', $username)->select('id')->get($this->table);

			if ($query->num_rows === 1) {
				return $query->result()[0]->id;
			} else {
				exit("Either 0 or more than one results with that id");
			}
		}
	}
?>
