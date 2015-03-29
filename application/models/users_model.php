<?php
	class Users_Model extends MY_Model {

		public function __construct() {
			$this->table = 'users';

			parent::__construct();
		}

		public function get_all_active() {
			$users = $this->_get_all_active();
			
			foreach ($users as $user) {
				unset($user->password);
			}

			return $users;
		}

		public function get_by_id($id) {
			$user = $this->_get_by_id($id);
			unset($user->password);
			return $user;
		}


		public function get_id($username) {
			$query = $this->db->where('username', $username)->select('id')->get($this->table);

			if ($query->num_rows === 1) {
				return $query->result()[0]->id;
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one user with the username '$username'.");
				}
				if ($query->num_rows === 0) {
					show_error(__METHOD__."<br>There is no user with the username '$username'.");
				}
			}
		}
	}
