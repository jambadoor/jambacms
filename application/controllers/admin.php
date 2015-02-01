<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin extends MY_Controller {

		public function __construct() {
			//we have some setup to do, these come before construct because construct uses them
			$this->requires_login = true;
			$this->login_redirect = "/auth/login/admin";

			//call our parent constructor
			parent::__construct();


			//load up our models (auth and master are already loaded)
			$this->load->model('users_model', 'users');


			//here is our controller-wide view_data
			$this->view_data['layout'] = 'site';
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/admin.css">';
			$this->view_data['scripts'][] = '<script src="/assets/js/admin.js"></script>';
			$this->view_data['page'] = 'dashboard';
		}
		 
		public function index() {
			$this->home();
		}


		/*---------------------------------------------------------------------------
		 *
		 * THESE ARE OUR TABS
		 * 
		 *---------------------------------------------------------------------------*/ 
		public function home() {
			//set up our view_data
			$this->view_data['tab'] = 'home';
			$this->load->view('master', $this->view_data);
		}

		public function users($content = 'list') {
			$this->view_data['tab'] = 'users';

			if ($content === 'list') {
				$this->view_data['tab_content'] = 'tabs/users';
				$users = $this->users->get_all();
				foreach ($users as $user) {
					$this->view_data[$user->type.'s'][] = $user;
				}
			}

			if ($content === 'add') {
				$this->view_data['tab_content'] = 'forms/add_user';
				$this->session->flashdata('back', '/admin/users');
			}

			if ($content === 'add_success') {
				$this->load->view('messages/add_user_success');
			}

			if ($content === 'uploading') {
				$this->load->view('messages/creating_user');
			}

			$this->load->view('master', $this->view_data);
		}

		public function blog() {
			$this->view_data['tab'] = 'blog';
			$this->load->view('master', $this->view_data);
		}

		public function forum() {
			$this->view_data['tab'] = 'forum';
			$this->load->view('master', $this->view_data);
		}

		public function metrics() {
			$this->view_data['tab'] = 'metrics';
			$this->load->view('master', $this->view_data);
		}

		public function ads() {
			$this->view_data['tab'] = 'ads';
			$this->load->view('master', $this->view_data);
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
			if (!$this->auth->username_available($new_user['username'])) {
				//handle this better
				exit("Username already taken");
			}

			//we will create the user in the db, all but the image_url
			$new_user['password'] = sha1($new_user['password']);
			$new_user['date_created'] = date('Y-m-d');
			$new_user['last_login'] = date('Y-m-d H:i:s');
			$new_user['created_by'] = $this->user->id;
			$this->users->insert($new_user);

			//then get the id
			$new_user['id'] = $this->users->get_id($new_user['username']);

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
				//update the db with the url and go back
				$this->users->update($new_user['id'], array('image_url' => $new_user['id']."-001.png"));
				redirect($this->session->flashdata('back'));
			}
		}

	}
?>
