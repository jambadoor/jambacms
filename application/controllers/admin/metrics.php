
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Metrics extends Admin_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function index() {
			//load our home tab
			$this->view_data['tab'] = 'metrics';
			$this->view_data['tab_content'] = 'blocks/metrics';
			$this->load->view('master', $this->view_data);
		}
	}
?>
