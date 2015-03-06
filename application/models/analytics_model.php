<?php
	class Analytics_Model extends MY_Model {
		public function __construct() {
			$this->table = 'analytics';
			parent::__construct();
		}

		public function log() {
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

			$this->db->insert('analytics', $hit);
		}

		public function get_all() {
			return $this->_get_all();
		}
	}
?>
