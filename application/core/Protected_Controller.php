<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author: Jason Benford
 * File: /application/core/Protected_Controller
 * Description: This is the controller from which all other controllers that require authentication inherit.
 * 	We check if a user is logged in, create the controller's user object if so, otherwise redirect to login.
 * 	TODO: we need to have public protected and admin protected that have different login screens, so rethinking
 * 	the auth controller is probably a good idea.
 */

abstract class Protected_Controller extends Base_Controller {
	protected $user;			//the currently logged in user
	protected $login_redirect;	//after a login, where do we redirect?

	public function __construct() {
		parent::__construct();

		//load up our models with better names
		$this->load->model('authentication_model', 'auth');

		//check if logged in
		if ($this->session->userdata('is_logged_in') === true) {
			//if there is a user_id (always should be if is_logged_in)
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

// End of Protected_Controller class
/* End of file Protected_Controller.php */
/* Location: ./application/core/Protected_Controller.php */
