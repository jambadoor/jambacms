<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Users extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->view_data['tab'] = 'users';
			$this->load->model('users_model', 'users');

			//check if the user can even view all users
			if (!$this->user->permissions['users']['read']) {
				//TODO: we need to send a message to them, or maybe show a disabled tab or something
				redirect('/admin/home');
			}
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
			if ($this->user->permissions['users']['create']) {
				$this->view_data['tab_content'] = 'forms/add_user';
				$this->session->set_flashdata('back', '/admin/users');
			} else {
				$this->view_data['tab_content'] = 'blocks/users_list';
				//TODO: send a message with it
			}

			$this->load->view('master', $this->view_data);
		}

		public function edit($user_id) {
			//if user can edit any user or is trying to edit his own profile
			if ($this->user->permissions['users']['update'] || $this->user->id == $user_id) {
				$this->view_data['tab_content'] = 'forms/edit_user';
				$this->view_data['edited_user'] = $this->users->get_by_id($user_id);
				$this->session->set_flashdata('back', '/admin/users');
			} else {
				$this->view_data['tab_content'] = 'blocks/users_list';
				//TODO: send a message
			}

			$this->load->view('master', $this->view_data);
		}

		/*---------------------------------------------------------------------------
		 * 
		 * CRUD
		 *
		 *---------------------------------------------------------------------------*/
		public function create() {
			//if they have permission
			if ($this->user->permissions['users']['create']) {
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

				//redirect($this->session->flashdata('back'));
			} else {
				//TODO: send a message
				redirect ('/admin/users');
			}
		}

		public function update($id) {
			//if they have permission for all or are updating their own profile
			if ($this->user->permissions['users']['update'] || $this->user->id == $id) {
				$data = $this->input->post();
				$data['password'] = sha1($data['password']);
				if (!$this->user->permissions['users']['update']) {
					exit("You don't have permission.");
				} else {
					$this->users->update($id, $data);
				}

				redirect($this->session->flashdata('back'));
			} else {
				//TODO: send a message
				redirect('/admin/users');
			}
		}

		public function del($id) {
			if ($this->user->permissions['users']['delete']) {
				$this->users->del($id);
				redirect('admin/users');
			} else {
				//TODO: send a message
				redirect('/admin/users');
			}
		}
	}
?>
