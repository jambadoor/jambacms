<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author: Jason Benford
 * File: /application/core/Protected_Controller
 * Description: require login, permission, no view_data
 * 
 */
abstract class Protected_Controller extends Base_Controller {
	protected $user;			//the currently logged in user
	protected $login_redirect;	//after a login, where do we redirect?

	public function __construct() {
		parent::__construct();

		//load up our models, manually to give better names
		$this->load->model('authentication_model', 'auth');

		//if so, load up the user
		if ($this->session->userdata('is_logged_in') === true) {
			//if there is a user_id
			if (!empty($this->session->userdata('user_id'))) {
				//get the user
				$this->user = $this->auth->get_user_object($this->session->userdata('user_id'));
			} else {
				exit("The session user_id doesn't exist.");
			}
		} else {
			//if we aren't logged in, redirect
			//TODO: send a message via flashdata
			redirect('/auth/login/'.$this->login_redirect);
		}
	}
}
