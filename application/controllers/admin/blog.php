<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Blog extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('blog_model', 'blog');
			$this->view_data['tab'] = 'blog';

			//check if the user can even view all blogs, but I think everyone can
			if (!$this->user->permissions['blog']['read']) {
				//TODO: we need to send a message to them, or maybe show a disabled tab or something
				redirect('/admin/home');
			}
		}

		public function index() {
			$this->all();
		}

		public function all() {
			$this->view_data['blog_entries'] = $this->blog->get_all_active();
			$this->view_data['tab_content'] = 'blocks/blog_list';
			$this->load->view('master', $this->view_data);
		}

		public function add() {
			if ($this->user->permissions['blog']['create']) {
				$this->view_data['tab_content'] = 'forms/add_blog_entry';

				//tinyeditor
				$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/tinyeditor.css">';
				$this->view_data['scripts'][] = '<script src="/assets/js/tinyeditor.js"></script>';
			} else {
				//TODO: send a message
				$this->view_data['blog_entries'] = $this->blog->get_all_active();
				$this->view_data['tab_content'] = 'blocks/blog_list';
			}

			$this->load->view('master', $this->view_data);
		}

		public function edit($name) {
			$entry = $this->blog->get_by_name($name);
			if ($this->user->permissions['blog']['update'] || $this->user->id == $entry->created_by) {
				$this->view_data['blog_entry'] = $entry;
				$this->view_data['tab_content'] = 'forms/edit_blog_entry';

				//tinyeditor
				$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/tinyeditor.css">';
				$this->view_data['scripts'][] = '<script src="/assets/js/tinyeditor.js"></script>';
			} else {
				//TODO: send message
				$this->view_data['blog_entries'] = $this->blog->get_all_active();
				$this->view_data['tab_content'] = 'blocks/blog_list';
			}

			$this->load->view('master', $this->view_data);
		}

		/*CRUD*/
		public function create() {
			if ($this->user->permissions['blog']['create']) {
				$new_entry = $this->input->post();	
				$new_entry['created_by'] = $this->user->id;
				$this->blog->insert($new_entry);
				redirect('/admin/blog');
			} else {
				//TODO: send message
				redirect('/admin/blog');
			}
		}

		public function del($name) {
			if ($this->user->permissions['blog']['delete'] || $this->user->id == $this->blog->get_by_name($name)->created_by) {
				$this->blog->del($id);
				redirect('/admin/blog');
			} else {
				//send message
				redirect('/admin/blog');
			}
		}	

		public function update($id) {
			if ($this->user->permissions['blog']['update']) {
				$data = $this->input->post();
				$this->blog->update($data);
				redirect('/admin/blog');
			} else {
				//send message
				redirect('/admin/blog');
			}
		}
	}
?>
