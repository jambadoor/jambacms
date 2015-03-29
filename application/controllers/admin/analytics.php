<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Analytics extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->view_data['tab'] = 'analytics';

			$this->load->model('analytics_model', 'analytics');
		}

		public function index() {
			$this->test_graph();
		}

		public function get_graph_data() {
			$hits_by_month = $this->analytics->get_by_month();
			echo json_encode($hits_by_month);
		}

		public function test_graph() {
			$this->view_data['tab_content'] = 'blocks/test_graph';
			$this->view_data['js_plugins'][] = 'Chart.min.js';
			$this->load->view('master', $this->view_data);
		}

		public function generate_data() {
			$hits = array();
			//we will start with 1000 users
			for ($i = 0; $i < 100; $i++) {
				$ip = rand(0, 100).'.'.rand(0, 100).'.'.rand(0, 100).'.'.(rand(0, 100));
				//and for each of them, we will insert some random days of use into the database
				for ($d = 0; $d < 15; $d++) {
					$date = rand(2014, 2015).'-'.rand(1, 12).'-'.rand(1, 28);
					$start_time = rand(0, 23).':'.rand(0, 59).'-'.rand(0, 59);
					//each day will have a set of hits
					for ($h = 0; $h < 10; $h++) {
						$hit = array(
							'url' => '/articles/'.rand(1, 10).'/'.rand(1, 100),
							'timestamp' => $date.' '.$start_time,
							'ip' => $ip,
							'referrer' => '/',
							'user_agent' => 'LINUX'
						);
						$hits[] = $hit;
					}
				}
			}
			$this->db->insert_batch('analytics', $hits);
			$this->analytics->log($hit);
		}
	}
