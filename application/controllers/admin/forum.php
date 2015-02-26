
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Forum extends Admin_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function index() {
			//load our home tab
			$this->view_data['tab'] = 'forum';
			$this->view_data['tab_content'] = 'blocks/forum';
			$this->load->view('master', $this->view_data);
		}
	}
?>
