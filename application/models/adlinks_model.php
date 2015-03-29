<?php

/*
 * Author: Jason Benford
 * File: ./application/models/adlinks_model.php
 * Description: This is the model for the adlinks table
 */

	class Adlinks_Model extends MY_Model {
		public function __construct() {
			//set the table and then construct run MY_Model->__construct
			$this->table = 'adlinks';
			parent::__construct();
		}

		/*
		 * get all active rows
		 */
		public function get_all_active($cols='') {
			$adlinks = $this->_get_all_active($cols);

			foreach ($adlinks as $key=>$adlink) {
				$query = $this->db->select('first_name, last_name')->where('id', $adlink->created_by)->get('users');
				if ($query->num_rows === 1) {
					$user = $query->result()[0];
					$created_by = $user->first_name." ".$user->last_name;
				} else {
					if ($query->num_rows > 1) {
						show_error(__METHOD__."<br>There is more than one user with the id '{$adlink->created_by}'.");
					}
					if ($query->num_rows === 0) {
						$created_by = 'unknown';
					}
				}

				$adlinks[$key]->created_by_name = $created_by;
				$query = $this->db->where('ad_id', $adlink->id)->count_all_results('adhits');
				$adlinks[$key]->hits = $query;
			}

			return $adlinks;
		}

		/*
		 * get the redirect for the link provided
		 */
		public function get_redirect_url($link_url) {
			$query = $this->db->select('redirect_url')->where('link_url', $link_url)->get($this->table);
			if ($query->num_rows === 1) {
				$redirect_url = $query->result()[0]->redirect_url;
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one adlink with the url '$link_url'.");
				}
				if ($query->num_rows === 0) {
					$redirect_url = '/';
				}
			}
			return $redirect_url;
		}

		/*
		 * get the row from the link_url
		 */
		public function get_by_link_url($link_url) {
			$query = $this->db->where('link_url', $link_url)->get($this->table);
			if ($query->num_rows === 1) {
				$adlink = $query->result()[0];
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one adlink with the url '$link_url'.");
				}
				if ($query->num_rows === 0) {
					show_error(__METHOD__."<br>There is no adlink with the url '$link_url'.");
				}
			}
			return $adlink;
		}

		/*
		 * log a hit to the link_url in the adlink_hits table
		 */
		public function log($link_url) {
			$query = $this->db->where('link_url', $link_url)->get($this->table);
			if ($query->num_rows === 1) {
				$adlink = $query->result()[0];
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one adlink with the url '$link_url'.");
				}
				if ($query->num_rows === 0) {
					$adlink->id = 0;
				}
			}

			$this->load->library('user_agent');
			if ($this->agent->is_referral()) {
				$referrer = $this->agent->referrer();
			} else {
				$referrer = 'none';
			}

			$hit = array(
				'ad_id' => $adlink->id,
				'link_url' => $link_url,
				'timestamp' => date('Y-m-d H:i:s'),
				'ip' => $this->input->ip_address(),
				'referrer' => $referrer
			);

			$this->db->insert('adhits', $hit);
		}
	}

// End of Adlinks_Model class
/* End of file adlinks_model.php */
/* Location: ./application/models/adlinks_model.php */
