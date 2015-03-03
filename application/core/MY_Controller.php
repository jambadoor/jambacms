<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author: Jason Benford
 * File: /application/core/MY_Controller
 * Description: The lowest level application controller, from which all others will inherit.
 * 	Multiple layers of inheritence is supported.
 */
abstract class Base_Controller extends CI_Controller {
	protected $logged_in = false;		//if anyone is logged in
	protected $user = false;			//the currently logged in user
	protected $requires_login = false;	//if you are required to be logged in to access this controller
	protected $view_data = array();		//all of the data that we are passing into the view(s)
	protected $login_redirect = '/';	//after we log in, where do we go?

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
		$this->view_data['metas'] = array();
		$this->view_data['scripts'] = array();
		$this->view_data['logged_in'] = $this->logged_in;
		$this->view_data['user'] = $this->user;

		$this->view_data['css_plugins'][] = 'semantic-ui/reset.css';
		$this->view_data['css_plugins'][] = 'semantic-ui/site.css';

		$this->view_data['js_plugins'][] = 'jquery/jquery.js';
		$this->view_data['js_plugins'][] = 'semantic-ui/site.js';
	}

}
// End of Base_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
?>
