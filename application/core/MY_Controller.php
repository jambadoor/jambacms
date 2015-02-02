<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class MY_Controller extends CI_Controller {
		protected $user; 
		protected $logged_in;
		protected $requires_login = false;
		protected $view_data;
		protected $login_redirect = '/';
		protected $tables;

		public function __construct() {
			parent::__construct();

			$this->logged_in = $this->session->userdata('is_logged_in');

			//check if user is logged in and redirect if not
			if ($this->requires_login) {
				if (!$this->logged_in) {
					redirect($this->login_redirect);
				}
			}

			//set the back flashdata
			$this->session->set_flashdata('back', uri_string());

			//load up our models, manually to give better names
			$this->load->model('authentication_model', 'auth');
			$this->load->model('master_model');
			$this->load->model('users_model', 'users');

			//get the table names
			$this->tables = $this->master_model->get_tables();

			//here we will get the user object if it exists
			if ($this->session->userdata('user_id')) {
				$this->user = $this->auth->get_user_object($this->session->userdata('user_id'));
			}
			//TODO this should be in a config or something, so the end user won't have to mess with this code
			//finish the user object
			if (isset($this->user)) {
				//This is where we will be setting up our permissions for different user types.
				//Currently you have dev, admin, blogger, advertiser, and 'user' types
				$this->user->permissions = array();

				//dev gets all permissions
				if ($this->user->type === 'dev') {
					foreach ($this->tables as $table) {
						$this->user->permissions[$table] = array();
						$this->user->permissions[$table]['create'] = true;
						$this->user->permissions[$table]['read'] = true;
						$this->user->permissions[$table]['update'] = true;
						$this->user->permissions[$table]['delete'] = true;
					}
				}
				//likely so will admin, we will have to figure out the rest as we go.
			}

			//set up our global view data
			$this->view_data = array(
				'metas' => array(),
				'stylesheets' => array(
					'<link rel="stylesheet" href="/bower_components/semantic-ui/dist/semantic.css">'
				),
				'scripts' => array(
					'<script src="/bower_components/jquery/dist/jquery.js"></script>',
					'<script src="/bower_components/semantic-ui/dist/semantic.js"></script>'
				),
				'logged_in' => $this->session->userdata('is_logged_in')
			);

			//and the user if we have it
			if ($this->logged_in) {
				$this->view_data['user'] = $this->user;
			}
		}


		/*---------------------------------------------------------------------------
		 *
		 * BASIC CRUD
		 * 
		 *---------------------------------------------------------------------------*/

		public function add($table, $record) {
			if (!$this->user->permissions[$table]['create']) {
				exit("You don't have permission.");
			} else {
				$this->$table->insert($record);
			}
		}

		public function del($table, $id) {
			if (!$this->user->permissions[$table]['delete']) {
				exit("You don't have permission.");
			}
			$this->$table->del($id);
			redirect($this->session->flashdata('back'));
		}

		public function update($table, $id) {
			$data = $this->input->post();
			if (!$this->user->permissions[$table]['update']) {
				exit("You don't have permission.");
			} else {
				$this->$table->update($id, $data);
			}
			redirect($this->session->flashdata('back'));
		}

		//this will return json
		public function get($table, $id) {
			return;
		}

		//---------------------------------------------------------------------------
		/*
		 * PRIVATE UTILITY FUNCTIONS
		 * -------------------------
		 * ALL OF THIS NEEDS TO BE REWRITTEN TO WORK WITH SEMANTIC UI, BUT IT'S PRETTY CLEVER I GUESS
		 */


		/*
		 * THIS ALL BELONGS SOMEWHERE ELSE, NEEDS TO BE LOOKED THROUGH!!!
		 * Takes every column from the table and creates a form that will create
		 * an update form easily from the table.
		 * The include parameter determines if col_mods are ommitted or exclusively included
		 *---------------------------------------------------------------------------
		private function _update_form_from_table($table, $id, $include=false, $col_mods=array('id', 'user_id', 'video_series_id', 'date_created')) {
			//our db columns
			$db_cols = $this->generic_model->get_cols_from_table($table);

			//see what should be in our cols array
			if (is_array($col_mods)) {
				if ($include) {
					//includes specified
					$cols = $col_mods;
					//check that they are all in db_cols
					foreach ($cols as $col) {
						if (!array_search($col, $db_cols)) {
							exit("$col not in $table");
						}
					}
				} else {
					//omits specified
					$cols = $db_cols;
					foreach ($col_mods as $omit) {
						//get the key of omit
						if (($key = array_search($omit, $cols)) !== false) {
							unset($cols[$key]);
						} else {
						//	exit("$omit was not in $table");
						// we will ignore omits that don't exist in the table
						}
					}
				}
			} else {
				//nothing specified, use all from db_cols
				$cols = $db_cols;
			}

			$form = form_open(base_url()."generic/update/$table/$id");
			foreach ($cols as $col) {
				$data = array('name' => $col);
				$form .= form_input($data, $col);
			}
			$form .= form_submit('', 'something');
				
			$form .= form_close();
			return $form;
		}

		/*
		 * Takes every column from the table and creates a form that will create
		 * an insert form easily from the table.
		 * The include parameter determines is col_mods are ommitted or exclusively included
		 *---------------------------------------------------------------------------/
		private function _create_form_from_table($table, $include=false, $col_mods='') {
			//our db columns
			$db_cols = $this->master->get_cols_from_table($table);

			//see what should be in our cols array
			if (is_array($col_mods)) {
				if ($include) {
					//includes specified
					$cols = $col_mods;
					//check that they are all in db_cols
					foreach ($cols as $col) {
						if (!array_search($col, $db_cols)) {
							exit("$col not in $table");
						}
					}
				} else {
					//omits specified
					$cols = $db_cols;
					foreach ($col_mods as $omit) {
						//get the key of omit
						if (($key = array_search($omit, $cols)) !== false) {
							unset($cols[$key]);
						} else {
						//	exit("$omit was not in $table");
						// we will ignore omits that don't exist in the table
						}
					}
				}
			} else {
				//nothing specified, use all from db_cols
				$cols = $db_cols;
			}

			$form = form_open(base_url()."generic/add/$table");
			foreach ($cols as $col) {
				$data = array('name' => $col);
				$form .= form_input($data, $col);
			}
			$form .= form_submit('', 'something');
				
			$form .= form_close();
			return $form;
		}


		/*
		 * Creates an html table containing all the rows in the table
		 * * Really need to add in omitted/included columns
		 *---------------------------------------------------------------------------/
		private function _create_table_from_table($table, $include=false, $col_mods='') {
			//our db columns
			$db_cols = $this->master_model->get_cols_from_table($table);

			//see what should be in our cols array
			if (is_array($col_mods)) {
				if ($include) {
					//includes specified
					$cols = $col_mods;
					//check that they are all in db_cols
					foreach ($cols as $col) {
						if (!array_search($col, $db_cols)) {
							exit("$col not in $table");
						}
					}
				} else {
					//omits specified
					$cols = $db_cols;
					foreach ($col_mods as $omit) {
						//get the key of omit
						if (($key = array_search($omit, $cols)) !== false) {
							unset($cols[$key]);
						} else {
						//	exit("$omit was not in $table");
						// we will ignore omits that don't exist in the table
						}
					}
				}
			} else {
				//nothing specified, use all from db_cols
				$cols = $db_cols;
			}

			$html = '<table class="table table-hover table-condensed">';
			$html .= "<thead><tr>";
			foreach ($cols as $col) {
				$html .= "<th>$col</th>";
			}
			$html .= "</tr></thead>";
			$html .= "<tbody>";
			foreach ($this->master_model->get_all($table) as $record) {
				$html .= "<tr>";


				foreach ($this->master_model->get($table, $record->id, $cols) as $value) {
					$html .= "<td>$value</td>";
				}

				$html .= "</tr>";
			}
			$html .= "</tbody>";
			$html .= "</table>";

			return $html;
		}

		/*
		 * TESTING
		 /////////////////////////////////////////////////////////////
		//print out the users permissions, just for testing really
		private function _user_permissions($id) {
			foreach ($this->user->permissions as $key=>$value) {
				echo "<h3>$key</h3>";
				foreach ($value as $permission=>$value) {
					echo "<h4>$permission - $value</h4>";
				}
			}
		}*/
	}
?>
