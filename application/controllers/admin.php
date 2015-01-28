<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends MY_Controller {

		public function __construct() {
			$this->requires_login = true;
			$this->login_redirect="/admin/login";

			parent::__construct();

			//see if there is a user object, MYController creates it if logged in
			if (isset($this->user)) {
				//get the table names
				$tables = $this->master_model->get_tables();

				//This is where you will be setting up your permissions for different user types.
				//Currently you have dev, admin, blogger, advertiser, and user types.
				$this->user->permissions = array();

				//dev gets all permissions
				if ($this->user->type == 'dev') {
					foreach ($tables as $table) {
						$this->user->permissions[$table] = array();
						$this->user->permissions[$table]['create'] = true;
						$this->user->permissions[$table]['read'] = true;
						$this->user->permissions[$table]['update'] = true;
						$this->user->permissions[$table]['delete'] = true;
					}
				}
			}
			//likely so will admin, we will have to figure out the rest as we go.

			//here is our customized view_data
			$this->view_data['layout'] = 'site';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/admin.css">';
			$this->view_data['scripts'][] = '<script src="/assets/js/admin.js"></script>';
		}
		 
		//This will load up our dashboard, after that everything should be ajax
		public function index() {
			//set up our view_data for the dashboard
			$this->view_data['page'] = 'dashboard';
			$users = $this->master_model->get_all('users');
			foreach ($users as $user) {
				$this->view_data[$user->type.'s'][] = $user;
			}
			$this->load->view('master', $this->view_data);
		}


		/*---------------------------------------------------------------------------
		 *
		 * THESE ARE FOR LOADING HTML VIA AJAX
		 *
		 *---------------------------------------------------------------------------*/
		public function home() {
			$this->load->view('tabs/home');
		}

		public function users($action = 'list') {
			if ($action === 'list') {
				$users = $this->master_model->get_all('users');
				foreach ($users as $user) {
					$data[$user->type.'s'][] = $user;
				}
				$data['user'] = $this->user;
				$this->load->view('tabs/users', $data);
				return;
			}

			if ($action === 'add') {
				$this->load->view('forms/add_user');
				return;
			}

			if ($action === 'add_success') {
				$this->load->view('messages/add_user_success');
			}

			if ($action === 'uploading') {
				$this->load->view('messages/creating_user');
			}

		}

		public function blog() {
			$this->load->view('tabs/blog');
		}

		public function forum() {
			$this->load->view('tabs/forum');
		}

		public function metrics() {
			$this->load->view('tabs/metrics');
		}

		public function ads() {
			$this->load->view('tabs/ads');
		}

		/*---------------------------------------------------------------------------
		 * 
		 * SOME SPECIALIZED CRUD
		 *
		 *---------------------------------------------------------------------------*/
		public function add_user() {
			//get the post data
			$new_user = $this->input->post();
			//TODO: sanitize it
			//check that the username isn't taken
			if (!$this->authentication_model->username_available($new_user['username'])) {
				exit("Username already taken");
			}

			//we will create the user in the db, all but the image_url
			$new_user['password'] = sha1($new_user['password']);
			$new_user['date_created'] = date('Y-m-d');
			$new_user['last_login'] = date('Y-m-d H:i:s');
			$this->add('users', $new_user);

			//then get the id
			$new_user['id'] = $this->authentication_model->get_user_id($new_user['username']);

			//send the user a message about that and that image is uploading
			$this->view_data['page'] = 'uploading';
			$this->load->view('master', $this->view_data);
			$CI =& get_instance();
			$CI->output->_display();

			//upload the file
			//codeigniter upload library stuff
			$upload_config = array(
				'upload_path' => './assets/img/avatars/',
				'file_name' => $new_user['id']."-001.png",
				'allowed_types' => 'png',
				'max_size' => '250'
			);
			$this->load->library('upload', $upload_config);
			if (!$this->upload->do_upload('photo')) {
				//we really need to handle this better, but for now, we will just do this.
				exit('The upload failed');
			} else {
				//update the db with the url
				$this->update('users', $new_user['id'], array('image_url' => $new_user['id']."-001.png"));
			}

			//and redirect to the users tab with a message
			redirect('/admin/users');

			//TODO: Implement data sanitization

		}
	}
?>
