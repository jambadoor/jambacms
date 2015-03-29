<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Author: Jason Benford
 * File: ./application/models/analytics_model.php
 * Description: the model for the analytics
 */
	class Analytics_Model extends MY_Model {
		public function __construct() {
			//set the table and construct the parent
			$this->table = 'analytics';
			parent::__construct();
		}

		/*
		 * log a hit
		 */
		public function log($hit = '') {
			if ($hit === '') {
				$this->load->library('user_agent');
				if ($this->agent->is_referral()) {
					$referrer = $this->agent->referrer();
				} else {
					$referrer = 'none';
				}

				$hit = array(
					'url' => $this->uri->uri_string(),
					'timestamp' => date('Y-m-d H:i:s'),
					'ip' => $this->input->ip_address(),
					'referrer' => $referrer,
					'user_agent' => $this->agent->agent_string()
				);
			}
			$this->db->insert('analytics', $hit);
		}

		/*
		 * get all of the hits, probably a bad idea without a limit
		 */
		public function get_all() {
			return $this->_get_all();
		}

		/*
		 * get the number of hits in each month
		 */
		public function get_by_month() {
			$query = $this->db->query(
				'select year(timestamp) as year, month(timestamp) as month, count(id) as total from analytics group by year(timestamp), month(timestamp)');
			$hits = $query->result();
			return $hits;
		}
	}

// End of Analytics_Model class
/* End of file analytics_model.php */
/* Location: ./application/models/analytics_model.php */
