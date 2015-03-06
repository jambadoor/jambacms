<?php
	class Authentication_Model extends CI_Model {

		public function __construct() {
			parent::__construct();

		}

		function get_user_object($id) {
			$query = $this->db->where('id', $id)->get('users');
			
			if ($query->num_rows === 1) {
				$user = $query->result()[0];			

				//get rid of the password so we can send through http
				unset($user->password);

				//make an array of all table names in db
				$table_objs = $this->db->query("SHOW TABLES")->result();
				$tables = array();
				foreach ($table_objs as $table_obj) {
					$table_name = $table_obj->{"Tables_in_".$this->db->database};
					$tables[] = $table_name;
				}

				//create empty permissions table
				//everyone can read things they created, this read is actually "read all"
				//same for update and delete, for now
				$user->permissions = array();
				foreach ($tables as $table) {
					$user->permissions[$table] = array();
					$user->permissions[$table]['create'] = FALSE;
					$user->permissions[$table]['read'] = FALSE;
					$user->permissions[$table]['update'] = FALSE;
					$user->permissions[$table]['delete'] = FALSE;
				}

				//then explicitly define permissions for each table and type
				//tedious, but currently necessary.
				switch ($user->type) {
					//dev and admin get all access to everything
					case 'dev':
						foreach ($user->permissions as $table => $permissions) {
							foreach($user->permissions[$table] as $permission => $value) {
								$user->permissions[$table][$permission] = TRUE;
							}
						}
						break;
					case 'admin':
						$user->permissions['users']['create'] = TRUE;
						$user->permissions['users']['read'] = TRUE;
						$user->permissions['blog']['create'] = TRUE;
						$user->permissions['blog']['read'] = TRUE;
						$user->permissions['blog']['update'] = TRUE;
						$user->permissions['content']['create'] = TRUE;
						$user->permissions['content']['read'] = TRUE;
						$user->permissions['content']['update'] = TRUE;
						$user->permissions['adlinks']['create'] = TRUE;
						$user->permissions['adlinks']['read'] = TRUE;
						$user->permissions['adlinks']['update'] = TRUE;
						break;
					//bloggers can create blogs
					case 'blogger':
						$user->permissions['blog']['create'] = TRUE;
						$user->permissions['blog']['read'] = TRUE;
						break;
					case 'advertiser':
						break;
					case 'user': 
						$user->permissions['blog']['read'] = TRUE;
						break;
					default:
						break;
				}

				return $user;
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one user with the id '$id'.");
				}
				if ($query->num_rows === 0) {
					show_error(__METHOD__."<br>There is no user with the id '$id'.");
				}
			}
		}

		function valid_login($username, $password) {
			$query = $this->db->where('username', $username)->where('password', $password)->where('active', 1)->get('users');
			if ($query->num_rows === 1) {
				$this->db->where('username', $username)->update('users', array('last_login' => date('Y-m-d H:i:s')));
				return true;
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one user with the id '$id'.");
				}
				if ($query->num_rows === 0) {
					return false;
				}
			}
		}

		function username_available($username) {
			$query = $this->db->where('username', $username)->get('users');

			return ($query->num_rows === 0);
		}

		function get_user_id($username) {
			$query = $this->db->select('id')->where('username', $username)->get('users');
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
?>
