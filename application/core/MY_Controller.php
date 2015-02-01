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

			$this->load->helper('form');

			$this->logged_in = $this->session->userdata('is_logged_in');

			//check if user is logged in and redirect if not
			if ($this->requires_login) {
				if (!$this->logged_in) {
					redirect($this->login_redirect);
				}
			}

			//load up our models, manually to give better names
			$this->load->model('authentication_model', 'auth');
			$this->load->model('master_model');
			//get the table names
			$this->tables = $this->master_model->get_tables();

			//here we will get the user object if it exists
			if ($this->session->userdata('user_id')) {
				$this->user = $this->auth->get_user_object($this->session->userdata('user_id'));
			}

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

			if ($this->logged_in) {
				$this->view_data['user'] = $this->user;
			}
		}


		/*---------------------------------------------------------------------------
		 *
		 * BASIC CRUD
		 * 
		 *---------------------------------------------------------------------------*/

		protected function add($table, $row) {
			if (!$this->user->permissions[$table]['create']) {
				exit("You don't have permission.");
			} else {
				$this->master_model->insert($table, $row);
			}
		}

		protected function del($table, $id) {
			if (!$this->user->permissions[$table]['delete']) {
				exit("You don't have permission.");
			}
			$this->generic_model->del($table, $id);
			redirect("/generic");
		}

		protected function update($table, $id, $data) {
			if (!$this->user->permissions[$table]['update']) {
				exit("You don't have permission.");
			} else {
				$this->master_model->update($table, $id, $data);
			}
		}

		//this will return json for ajax or whatever
		protected function get($table, $id) {
			return;
		}

		//---------------------------------------------------------------------------
		/*
		 * PRIVATE UTILITY FUNCTIONS
		 * -------------------------
		 * ALL OF THIS NEEDS TO BE REWRITTEN TO WORK WITH SEMANTIC UI, BUT IT'S PRETTY CLEVER I GUESS
		 */


		/*
		 * Takes every column from the table and creates a form that will create
		 * an update form easily from the table.
		 * The include parameter determines if col_mods are ommitted or exclusively included
		 *---------------------------------------------------------------------------*/
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
		 *---------------------------------------------------------------------------*/
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
		 *---------------------------------------------------------------------------*/
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
		 */////////////////////////////////////////////////////////////
		//print out the users permissions, just for testing really
		private function _user_permissions($id) {
			foreach ($this->user->permissions as $key=>$value) {
				echo "<h3>$key</h3>";
				foreach ($value as $permission=>$value) {
					echo "<h4>$permission - $value</h4>";
				}
			}
		}
	}
?>
