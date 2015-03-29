<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class User extends Admin_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function index() {
			//load our home tab
			$this->view_data['tab'] = 'user';
			$this->view_data['tab_content'] = 'forms/edit_user';
			$this->view_data['edited_user'] = $this->user;
			$this->load->view('master', $this->view_data);
		}
	}
