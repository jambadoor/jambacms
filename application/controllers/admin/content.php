<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Content extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->view_data['tab'] = 'content';
			$this->load->model('content_model', 'content');

			//check for permission to view
			if (!$this->user->permissions['content']['read']) {
				redirect('/admin');
			}
		}

		public function index() {
			$this->view();
		}

		public function view() {
			$this->view_data['content_sections'] = $this->content->get_all_active();
			$this->view_data['tab_content'] = 'blocks/content_list';

			$this->load->view('master', $this->view_data);
		}

		public function edit($name) {
			$section = $this->content->get_by_name($name);

			//if user has permission or is creator
			if ($this->user->permissions['content']['update'] || $this->user->id == $section->created_by) {
				$this->view_data['content_section'] = $section;
				$this->view_data['tab_content'] = 'forms/edit_content';

				//tinyeditor
				$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/tinyeditor.css">';
				$this->view_data['scripts'][] = '<script src="/assets/js/tinyeditor.js"></script>';
			} else {
				$this->view_data['tab_content'] = 'blocks/content_list';
			}

			$this->load->view('master', $this->view_data);
		}

		public function add() {
			if ($this->user->permissions['content']['create']) {
				$this->view_data['tab_content'] = 'forms/add_content';
				$this->session->set_flashdata('back', '/admin/users');

				//tinyeditor
				$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/tinyeditor.css">';
				$this->view_data['scripts'][] = '<script src="/assets/js/tinyeditor.js"></script>';
			} else {
				$this->view_data['tab_content'] = 'blocks/content_list';
			}

			$this->load->view('master', $this->view_data);
		}

		/*CRUD*/
		public function create() {
			if ($this->user->permissions['content']['create']) {
				$new_content = $this->input->post();	
				$this->content->insert($new_content);
				redirect('/admin/content/view');
			} else {
				//TODO: send a message
				redirect('/admin/content');
			}
		}

		public function del($id) {
			if ($this->user->permissions['content']['delete']) {
				$this->content->del($id);
				redirect('/admin/content');
			} else {
				//TODO: send a message
				redirect('/admin/content');
			}
		}

		public function update($name) { 
			$record = $this->input->post();
			
			if ($this->user->permissions['content']['update'] || $this->user->id == $record->created_by) {
				$id = $this->content->get_id($name);
				$this->content->update($id, $record);
				redirect('/admin/content/view');
			} else {
				//TODO: send message
				redirect('/admin/content');
			}
		}
	}
?>
