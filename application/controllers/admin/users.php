<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Users extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->view_data['tab'] = 'users';
		}

		public function index() {
			$this->all();
		}

		public function all() {
			$this->view_data['tab_content'] = 'blocks/users_list';
			$users = $this->users->get_all_active();

			foreach ($users as $user) {
				$this->view_data[$user->type.'s'][] = $user;
			}

			$this->load->view('master', $this->view_data);
		}

		public function add() {
			$this->view_data['tab_content'] = 'forms/add_user';
			$this->session->set_flashdata('back', '/admin/users');

			$this->load->view('master', $this->view_data);
		}

		public function edit($user_id) {
			$this->view_data['tab_content'] = 'forms/edit_user';
			$this->view_data['edited_user'] = $this->users->get_by_id($user_id);
			$this->session->set_flashdata('back', '/admin/users');

			$this->load->view('master', $this->view_data);
		}

		/*---------------------------------------------------------------------------
		 * 
		 * CRUD
		 *
		 *---------------------------------------------------------------------------*/
		public function create() {
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
			if (isset($this->input->post()['photo'])) {
				$upload_config = array(
					'upload_path' => './assets/img/avatars/',
					'file_name' => $new_user['id']."-001.png",
					'allowed_types' => 'png|jpg|gif',
					'max_size' => '250'
				);
				$this->load->library('upload', $upload_config);
				if (!$this->upload->do_upload('photo')) {
					//we really need to handle this better, but for now, we will just do this.
					print_r($this->upload->display_errors());
				} else {
					//update the db with the url and go back
					$this->users->update($new_user['id'], array('image_url' => $new_user['id']."-001.png"));
				}
			}

			redirect($this->session->flashdata('back'));
		}

		public function update($id) {
			$data = $this->input->post();
			$data['password'] = sha1($data['password']);
			if (!$this->user->permissions['users']['update']) {
				exit("You don't have permission.");
			} else {
				$this->users->update($id, $data);
			}

			redirect($this->session->flashdata('back'));
		}

		public function del($id) {
			$this->users->del($id);
			redirect($this->session->flashdata('back'));
		}


		/*---------------------------------------------------------------------------
		 *
		 * TESTING FUNCTIONS
		 *
		 *---------------------------------------------------------------------------*/
		public function test_notifications() {
			$this->view_data['notifications'] = array();
			$this->view_data['notifications'][] = array(
				'view' => 'error',
				'data' => array()
			);
			$this->view_data['tab'] = 'ads';
			$this->view_data['tab_content'] = 'tabs/ads';
			$this->load->view('master', $this->view_data);
		}
	}

?>
