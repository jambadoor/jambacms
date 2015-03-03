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
					$user->permissions[$table]['create'] = false;
					$user->permissions[$table]['read'] = false;
					$user->permissions[$table]['update'] = false;
					$user->permissions[$table]['delete'] = false;
				}

				//then explicitly define permissions for each table and type
				//tedious, but currently necessary.
				switch ($user->type) {
					//dev and admin get all access to everything
					case 'dev':
					case 'admin':
						foreach ($user->permissions as $table_permissions) {
							foreach ($table_permissions as $permission) {
								$permission = true;
							}
						}
						break;
					//bloggers can create blogs
					case 'blogger':
						$user->permissions['blog']['create'] = true;
						$user->permissions['blog']['read'] = true;
						break;
					case 'advertiser':
						break;
					case 'user': 
						$user->permissions['blog']['read'] = true;
						break;
					default:
						break;
				}
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

		function get_user_id($username) {
			$query = $this->db->select('id')->where('username', $username)->get('users');
			if ($query->num_rows === 1) {
				return $query->result()[0]->id;
			}
		}
	}
?>
