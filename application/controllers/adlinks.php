<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Adlinks extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->model('adlinks_model', 'adlinks');

			$link_url = $this->uri->segment(2);

			//log the ad hit
			$this->adlinks->log($link_url);

			//redirect
			$redirect_url = $this->adlinks->get_redirect_url($link_url);
			redirect($redirect_url);
		}
	}
?>
