<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Analytics extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->view_data['tab'] = 'analytics';

			$this->load->model('analytics_model', 'analytics');
		}

		public function index() {
			//load our home tab
			$this->view_data['hits'] = $this->analytics->get_all();
			$this->view_data['tab_content'] = 'blocks/hits_list';
			$this->load->view('master', $this->view_data);
		}

		public function test() {
			$response = http_get("http://jambacms/home");
			echo $response;
			/*
			$dom = new DOMDocument("1.0", "UTF-8");
			$dom->load($response);
			 */
			print_r($dom);



			/*
			for ($i = 0; $i < 1000; $i++) {
				$num_pages = rand(3, 15);
				$ip = "".rand(0, 200).".".rand(0, 50).".".rand(0, 50).".".rand(0, 50);
				for ($j = 0; $j < $num_pages; $j++) {
					echo $ip."<br>";
					
				}
			}
			 */
		}
	}
?>
