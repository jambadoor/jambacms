<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Adlinks extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('adlinks_model', 'adlinks');
			$this->view_data['tab'] = 'adlinks';

			//check if the user can even view all blogs, but I think everyone can
			if (!$this->user->permissions['adlinks']['read'] && !$this->user->permissions['adhits']['read']) {
				//TODO: we need to send a message to them, or maybe show a disabled tab or something
				redirect('/admin/home');
			}
		}

		public function index() {
			//load our home tab
			$this->view_data['tab_content'] = 'blocks/adlink_list';
			$this->view_data['adlinks'] = $this->adlinks->get_all_active();
			$this->load->view('master', $this->view_data);
		}

		//forms
		public function add() {
			if ($this->user->permissions['adlinks']['create']) {
				$this->view_data['tab_content'] = 'forms/add_adlink';
			} else {
				//TODO: send a message
				$this->view_data['tab_content'] = 'blocks/adlink_list';
				$this->view_data['adlinks'] = $this->adlinks->get_all_active();
			}

			$this->load->view('master', $this->view_data);
		}

		public function edit($link_url) {
			$adlink = $this->adlinks->get_by_link_url($link_url);
			if ($this->user->permissions['adlinks']['update'] || $this->user->id == $adlink->created_by) {
				$this->view_data['adlink'] = $adlink;
				$this->view_data['tab_content'] = 'forms/edit_adlink';
			} else {
				//TODO: send message
				$this->view_data['tab_content'] = 'blocks/adlink_list';
				$this->view_data['adlinks'] = $this->adlinks->get_all_active();
			}

			$this->load->view('master', $this->view_data);
		}

		//CRUD
		public function create() {
			if ($this->user->permissions['adlinks']['create']) {
				$adlink = $this->input->post();	
				$adlink['created_by'] = $this->user->id;
				$adlink['date_created'] = date('Y-m-d');
				$adlink['active'] = 1;
				$this->adlinks->insert($adlink);
				redirect('/admin/adlinks');
			} else {
				//TODO: send message
				redirect('/admin/adlinks');
			}
		}

		public function update($link_url) {
			if ($this->user->permissions['adlinks']['update']) {
				$adlink = $this->input->post();
				$this->adlinks->update($this->adlinks->get_by_link_url($link_url)->id, $adlink);
				redirect('/admin/adlinks');
			} else {
				//send message
				redirect('/admin/adlinks');
			}
		}

		public function del($link_url) {
			$adlink = $this->adlinks->get_by_link_url($link_url);
			if ($this->user->permissions['adlinks']['delete'] || $this->user->id == $adlink->created_by) {
				$this->adlinks->del($adlink->id);
				redirect('/admin/adlinks');
			} else {
				//send message
				redirect('/admin/adlinks');
			}
		}
	}
?>
