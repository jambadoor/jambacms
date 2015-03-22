<?php
	class Analytics_Model extends MY_Model {
		public function __construct() {
			$this->table = 'analytics';
			parent::__construct();
		}

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

		public function get_all() {
			return $this->_get_all();
		}

		public function get_by_month() {
			$query = $this->db->query(
				'select year(timestamp) as year, month(timestamp) as month, count(id) as total from analytics group by year(timestamp), month(timestamp)');
			$hits = $query->result();
			return $hits;
		}
	}
?>
