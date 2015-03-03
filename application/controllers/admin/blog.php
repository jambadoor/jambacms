<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Blog extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('blog_model', 'blog');
			$this->view_data['tab'] = 'blog';
		}

		public function index() {
			//load our home tab
			$this->view_data['blog_entries'] = $this->blog->get_all_active();
			$this->view_data['tab_content'] = 'blocks/blog_list';
			$this->load->view('master', $this->view_data);
		}

		public function add() {
			$this->view_data['tab_content'] = 'forms/add_blog_entry';
			$this->session->set_flashdata('back', '/admin/blog');

			//tinyeditor
			$this->view_data['stylesheets'][] = '<link rel="stylesheet" href="/assets/css/tinyeditor.css">';
			$this->view_data['scripts'][] = '<script src="/assets/js/tinyeditor.js"></script>';

			$this->load->view('master', $this->view_data);
		}

		/*CRUD*/
		public function create() {
			$new_entry = $this->input->post();	
			$this->blog->insert($new_entry);

			redirect('/admin/blog');
		}

		public function del($id) {
			$this->blog->del($id);
			redirect('/admin/blog');
		}	
	}
?>
