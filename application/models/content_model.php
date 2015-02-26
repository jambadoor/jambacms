<?php
	class Content_Model extends MY_Model {
		public function __construct() {
			$this->table = 'content';
			parent::__construct();
		}

		public function get($name) {
			$query = $this->db->query("SELECT * FROM $this->table WHERE name='$name'");
			if ($query->num_rows === 1) {
				return $query->result()[0];
			} else {
				exit("Couldn't retrieve.");
			}
		}

		public function get_id($name) {
			$query = $this->db->query("SELECT id FROM $this->table WHERE name='$name'");
			if ($query->num_rows === 1) {
				return $query->result()[0]->id;
			} else {
				exit("Couldn't retrieve");
			}
		}

		public function get_all() {
			$query = $this->db->query("SELECT * FROM $this->table");
			$content_by_name = array();
			foreach ($query->result() as $result) {
				$content_by_name[$result->name] = $result;
			}

			return $content_by_name;
		}
	}
?>
