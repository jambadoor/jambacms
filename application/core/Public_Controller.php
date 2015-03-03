<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	abstract class Public_Controller extends Base_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->set_view_path('site');
			$this->load->model('content_model', 'content');
		}
	}
?>
