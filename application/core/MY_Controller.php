<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application Base Controller
 *
 * The common shared code for all application controllers should be placed here.
 * NOTE: If you're using Modular Extensions and you want the HMVC feature in place,
 * you need to alter this to extend MX_Controller instead of CI_Controller.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Jason Benford
 */

abstract class Base_Controller extends CI_Controller {
	//here is some stuff that every controller should have
	protected $logged_in = false;	//if anyone is logged in
	protected $user = false;	//the currently logged in user
	protected $requires_login = false;	//if you are required to be logged in to access this controller
	protected $view_data;	//all of the data that we are passing into the view(s)
	protected $login_redirect = '/';	//after we log in, where do we go?
	protected $tables = false;	//an array of the names of the tables in the db

	public function __construct() {
		parent::__construct();

		//load up our models, manually to give better names
		$this->load->model('master_model');
		$this->load->model('authentication_model', 'auth');
		$this->load->model('users_model', 'users');

		//get the table names
		$this->tables = $this->master_model->get_tables();

		//check if we are logged in
		$this->logged_in = $this->session->userdata('is_logged_in');
		//if so, load up the user
		if ($this->logged_in === true) {

			//if there is a user_id
			if (!empty($this->session->userdata('user_id'))) {
				//get the user
				$this->user = $this->auth->get_user_object($this->session->userdata('user_id'));

				//set up our permissions table
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
				
				//put that user in the view_data
				$this->view_data['user'] = $this->user;
			} else {
				exit("The session user_id doesn't exist.");
			}
		} else {
			//if we aren't logged in and we need to be, redirect
			if ($this->requires_login) {
				//TODO: send a message via flashdata
				redirect('/auth/login');
			}
		}


		//set the back flashdata, handy when submitting forms, I guess
		$this->session->set_flashdata('back', uri_string());

		//the view_data that all controllers need
		$this->view_data = array();
		$this->view_data['metas'] = array();
		$this->view_data['stylesheets'] = array('<link rel="stylesheet" href="/bower_components/semantic-ui/dist/semantic.css">');
		$this->view_data['scripts'] = array();
		$this->view_data['scripts'][] = '<script src="/bower_components/jquery/dist/jquery.js"></script>';
		$this->view_data['scripts'][] = '<script src="/bower_components/semantic-ui/dist/semantic.js"></script>';
		$this->view_data['logged_in'] = $this->logged_in;
		$this->view_data['user'] = $this->user;
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
// End of Base_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
?>
